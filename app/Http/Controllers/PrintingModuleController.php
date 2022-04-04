<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\PrintableModuleView;
use App\Models\PrintingModule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PrintingModuleController extends Controller
{
    private $_printingModule;

    public function __construct(PrintingModule $printingModule)
    {
        $this->_printingModule = $printingModule;
    }

    public function index()
    {
        $printingModules = PrintableModuleView::orderBy('id', 'desc')->paginate(20);
        $moduleOptions = $this->_printingModule->printingModuleOptions();
        $categoryOptions = (new Category)->categoryOptions();
        return view('roles.admin.printing_modules.list', compact('printingModules','moduleOptions','categoryOptions'));
    }


    public function create()
    {
        $moduleOptions = $this->_printingModule->printingModuleOptions();
        $categoryOptions = (new Category)->categoryOptions();
        return view('roles.admin.printing_modules.create', compact('moduleOptions','categoryOptions'));
    }


    public function store(Request $request)
    {
        if(!$request->ajax()) {
            abort('404');
        }

        $validator = Validator::make($request->all(), [
            // 'module_name' => 'required|max:255|unique:printing_modules',
            'module_name' => 'required|max:255',
            'category' => 'required|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()->all()]);
        } else {

            $data = [
                'module_name'  =>  $request->module_name,
                'category_id'  =>  $request->category,
                'parent_id'    =>  $request->parent,
            ];

            $this->_printingModule->store($data);
            return response()->json(['success' => 'Create Successfully.']);
        }
    }



    public function show(PrintingModule $printingModule)
    {
        // not in use
    }


    public function edit(PrintingModule $printingModule)
    {
        // not in use
    }


    public function update(Request $request, PrintingModule $printingModule)

     {
         if(!$request->ajax()) {
             abort('404');
         }

         $validator = Validator::make($request->all(), [
             // 'module_name' => 'required|max:255|unique:categories,module_name,'.$category->id.',id',
             'module_name' => 'required|max:255',
             'category' => 'required|max:255',
         ]);

         if ($validator->fails()) {
             return response()->json(['error' => $validator->errors()->all()]);
         } else {

             $data = [
                 'module_name'  =>  $request->module_name,
                 'category_id'    =>  $request->category,
                 'parent_id'      =>  $request->parent,
                 'active'         =>  ($request->has('status')) ? $request->status : 'N',
             ];

             $this->_printingModule->store($data , $printingModule->id);
             return response()->json(['success' => 'Update Successfully.']);
         }
     }


    public function destroy(PrintingModule $printingModule)
    {
        //
    }
}
