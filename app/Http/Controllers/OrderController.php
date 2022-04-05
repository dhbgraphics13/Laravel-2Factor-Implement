<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Chat;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;


class OrderController extends Controller
{

    private $_order;
    public function __construct(Order $order)
    {
        $this->_order = $order;
    }
    public function index()
    {
        $orders = Order::orderBy('id','desc')->get();
        return view('roles.admin.orders.list', compact('orders'));
    }

    public function create()
    {
        $designerOptions = (new User)->designerOptions();
        $categories = Category::orderBy('id','asc')->get();
      //  $categoryOptions = (new Category)->categoryOptions();
        return view('roles.admin.orders.create',compact('designerOptions','categories'));
    }

    public function store(Request $request)
    {
        $inputs = getFormData($request);

        $validator = Validator::make($inputs, [
            'name'            => 'required|max:255',
            'phone'           => 'required|regex:/^[0-9]{10,15}+$/',
            'email'           => 'required|email|max:255',
            'address'         => 'required|max:255',
            'designer_name'   => 'required|max:255',
            'payment_method'  => 'required|max:255',
        ]);

        if ($validator->fails()) {
            $errors = generateValidationErrorsForAjaxSubmit($validator->errors());
            return jsonErrors($errors);
        }

        $data = [
            'name'             => $inputs['name'],
            'phone'            => $inputs['phone'],
            'email'            => $inputs['email'],
            'address'          => $inputs['address'],
            'user_id'          => $inputs['designer_name'],
            'payment_method'   => $inputs['payment_method'],
            'due_date'         => dateFormat($inputs['due_date']),
        ];

        $orderId =  $this->_order->store($data); //save data in Orders table
        if(isset($inputs['category']))
        {
            foreach ($inputs['category'] as $key => $val) {
                $data2[] = [
                    'order_id'            => $orderId,
                    'category_id'         => $val,
                    'printing_modules'    => serialize($inputs['printing_modules'.$val])?? null,
                    'details'             => $inputs['details'][$key]?? null,
                    'quantity'            => $inputs['quantity'][$key]?? null,
                    'size_width'          => $inputs['width'][$key]?? null,
                    'size_height'         => $inputs['height'][$key]?? null,
                    'price'               => $inputs['price'][$key],
                ];
            }
            if(count($data2)>0){
                (new OrderDetail())->saveMultiple($data2);
                $total =  (float) array_sum(array_column($data2, 'price'));
                $this->_order->store(['total_price'=>$total],$orderId); //save data in Orders table
            }
        }

        Session::flash('success', 'Order has been created successfully.');
        return response()->json([
            'status' => true
        ]);
    }


    public function show($orderID)
    {
        $order = Order::findOrFail($orderID);
        $chats = Chat::where('order_id',$orderID)->orderBy('id','asc')->get();
        $view = View::make('chat.chat_inner', ['chats' => $chats]);
        $contents = $view->render();

        $designerOptions = (new User)->designerOptions();
        $categoryOptions = (new Category)->categoryOptions();
        return view('roles.admin.orders.show',compact('designerOptions','categoryOptions','order','contents'));
    }


    public function edit(Order $order)
    {
        $designerOptions = (new User)->designerOptions();
        $categories = Category::orderBy('id','asc')->get();
        $categoryOptions = (new Category)->categoryOptions();
        return view('roles.admin.orders.edit',compact('designerOptions','categories','categoryOptions','order'));
    }

    public function update(Request $request, $orderId)
    {
        $inputs = getFormData($request);

        $validator = Validator::make($inputs, [
            'name'            => 'required|max:255',
            'phone'           => 'required|regex:/^[0-9]{10,15}+$/',
            'email'           => 'required|email|max:255',
            'address'         => 'required|max:255',
            'designer_name'   => 'required|max:255',
            'payment_method'  => 'required|max:255',
        ]);

        if ($validator->fails()) {
            $errors = generateValidationErrorsForAjaxSubmit($validator->errors());
            return jsonErrors($errors);
        }

        $data = [
            'name'             => $inputs['name'],
            'phone'            => $inputs['phone'],
            'email'            => $inputs['email'],
            'address'          => $inputs['address'],
            'user_id'          => $inputs['designer_name'],
            'payment_method'   => $inputs['payment_method'],
            'due_date'         => dateFormat($inputs['due_date']),
        ];

          $this->_order->store($data,$orderId); //save data in Orders table

        if(isset($inputs['category']))
        {
            foreach ($inputs['category'] as $key => $val) {
                $data2[] = [
                    'order_id'            => $orderId,
                    'category_id'         => $val,
                    'printing_modules'    => serialize($inputs['printing_modules'.$val])?? null,
                    'details'             => $inputs['details'][$key]?? null,
                    'quantity'            => $inputs['quantity'][$key]?? null,
                    'size_width'          => $inputs['width'][$key]?? null,
                    'size_height'         => $inputs['height'][$key]?? null,
                    'price'               => $inputs['price'][$key]?? null,
                ];
            }
            if(count($data2)>0)
            {
                $order_details = OrderDetail::where('order_id', $orderId)->get(['id']);
                (new OrderDetail)->destroy($order_details->toArray()); //destroy exist data
                (new OrderDetail())->saveMultiple($data2);//save new data
            }

            $total =  (float) array_sum(array_column($data2, 'price'));
            $this->_order->store(['total_price'=>$total],$orderId); //update data in Orders table
        }

        Session::flash('success', 'Order has been Update successfully.');
        return response()->json([
            'status' => true
        ]);
    }


    public function destroy(Order $order)
    {

        $Path = public_path('uploads/order_documents/'. $order->file);
        if(file_exists($Path)){
            @unlink($Path);
        }

        $order->delete();
        return redirect()->back()->with('success', 'Order has been deleted successfully.');
    }



    public function getFileUploadFormByOrderId(Request $request)
    {
            $view = View::make('roles.designer_admin.dynamic_cdr_file_upload', ['orderID' => $request->order_id]);
            $contents = $view->render();
            return response()->json(['options'=>$contents]);
    }

    public function orderDocumentUpload(Request $request,$orderId)
    {
        $validator = Validator::make($request->all(), [
            'comment'=> 'nullable|max:1000',
          //'file'=> 'required|file|mimes:cdr,jpeg,png,jpg,doc,docx,pdf|max:size:20000',
           'file'=> 'required|file|mimes:zip,jpeg,png,jpg,doc,docx,pdf|max:size:20000',
        ]);

        if ($validator->fails())
        {
            return response()->json(['error' => $validator->errors()->all()]);
        }
        else {

            if ($request->hasFile('file'))
            {
              /*  $size = $request->file->getSize();

                if($size >= 9242880)
                {
                    return response()->json(['error' => 'File is too large. Please choose the file of less size.']);
                }*/

                $file = $request->file;
                $upload_path = public_path('uploads/order_documents');
               // $originalName = $file->getClientOriginalName();
                $extension = $file->getClientOriginalExtension();
                $fileName = $orderId.'_'.generateRandomName('2') . '.' . $extension;
                $request->file->move($upload_path, $fileName);

                $data = [
                    'file'                    => $fileName,
                    'file_print_instructions' => $request->comment,
                    'uploaded_by'             => Auth::user()->name. '('.Auth::user()->username.')',
                    'file_uploader_id'        => Auth::user()->id,
                ];
                (new Order)->store($data,$orderId);
                return response()->json(['success'=>'File Upload Successfully']);
            }
        }
    }



    public function orderStatusChange(Request $request)
    {
        if($request->has('order_id')) {
            $model= Order::where('id' , $request->order_id)->firstOrFail();
            $model->status = $request->status;
            $model->update();
            if($request->status==0){
                return response()->json(['success' => ['Order Cancelled'] ]);
            }if($request->status==1){
                return response()->json(['success' => ['Order Set Under Design'] ]);
            }if($request->status==2){
                return response()->json(['success' => ['Order set Approved'] ]);
            }if($request->status==3){
                return response()->json(['success' => ['Order set Printing'] ]);
            }if($request->status==4){
                return response()->json(['success' => ['Order set Ready for Pickup'] ]);
            }if($request->status==5){
                return response()->json(['success' => ['Order set pickedUp'] ]);
            }
        }
    }




public function orderPrintBy (Request $request)
{
    $mytime = Carbon::now();
    $data = [
        'printed_by' => 'Order Printed - print by <br>' . Auth::user()->name. '('.Auth::user()->username.') <br>'.' on '.dateTimeHuman($mytime),
    ];
    (new Order)->store($data,$request->order_id);
    return response()->json(['success'=>'Update Successfully']);
}

public function orderFileDelete (Request $request)
{
     $orderID = $request->order_id;
     $order = Order::findOrFail($orderID);

    $Path = public_path('uploads/order_documents/'. $order->file);
    if(file_exists($Path)){
        @unlink($Path);
    }

    $data = [
        'file'                    =>null,
        'file_print_instructions' =>null,
        'uploaded_by'             =>null,
        'file_uploader_id'        =>null,
    ];
    (new Order)->store($data,$orderID);
    return response()->json(['success'=>'File removed Successfully']);
}

}
