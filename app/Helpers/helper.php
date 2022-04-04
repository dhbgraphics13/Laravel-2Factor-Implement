<?php

use App\Models\Category;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

function trimStr5($string)
{
    return $result = substr($string, 0, -5);
}

function randomName($length=null)
{
    $str = Str::random($length);
    return Str::lower($str);
}

function getFormData($request)
{
    $inputs = [];
    $data = $request->all();
    parse_str($data['form-data'], $inputs);
    return $inputs;
}


function parseErrorMessagesForAjaxForm($validator)
{
    $errors = [];

    if($validator->errors()->getMessages()) {
        foreach($validator->errors()->getMessages() as $key => $value) {
            $errors[] =  $value[0];

        }
    }
    return $errors;
}


function jsonErrors($errors)
{
    $err = [];
    if(count($errors) > 0) {
        foreach($errors as $key => $error) {
            $err[$key] = $error;
        }
    }
    echo json_encode(['status' => false, 'errors' => $err]);
}


function generateValidationErrorsForAjaxSubmit($errors, $validationError = true)
{
    $response = [];
    $errors = ($validationError == true) ? $errors->getMessages() : $errors;
    if(count($errors) > 0) {
        foreach($errors as $key => $error) {
            $response[] = [
                'key' => $key,
                'error' => $error[0]
            ];
        }
    }

    return $response;
}





function getPrintingModulesNonArray($categoryID)
{
    $result = [];
    $modules = \App\Models\PrintingModule::where('category_id',$categoryID)->where('active', 'Y')->get([
        'id',
        'module_name',
        'parent_id',
        'category_id'
    ]);

    if($modules->count() > 0) {
        $result = buildTreeNonArray($modules);
    }
    return $result;
}


function buildTreeNonArray( $elements, $parentId = 0) {
    $branch = [];
    foreach ($elements as $element) {
        if ($element['parent_id'] == $parentId) {
            $children = buildTreeNonArray($elements, $element['id']);
            if ($children) {
                $element['children'] = $children;
            }
            $branch[] = $element;
        }
    }
    return $branch;
}





function generateRandomName($length = 16)
{
    return bin2hex(openssl_random_pseudo_bytes($length));
}

function fileRandomName($length = 30)
{
    return Str::random($length);
}

function statusOptions()
{
    return [
        'N'  => 'Disable',
        'Y'  => 'Active',
    ];
}

function yesNoOptions()
{
    return [
        'N'  => 'No',
        'Y'  => 'Yes',
    ];
}

function userRoles()
{
    return [
        'P'  => 'Print Man',
        'D'  => 'Designer',
        'M'  => 'Manager',
    ];
}




function unSlug($var = null)
{
    return str_replace('-', ' ', $var);
}

function makeSlug($var)
{
    //return Str::slug($var);
    $var = Str::lower($var);
    return Str::slug($var, '-');
}


function strLimit($string = null, $length = null)
{
    return Str::limit($string, $length, ' ...');
}


function dateFormat($date, $format = 'Y-m-d')
{
    return date($format, strtotime($date));
}


function inputFormat($date, $format = 'd M, Y')
{
    return date($format, strtotime($date));
}

function dateTimeFormat($date, $format = 'Y-m-d H:i:s')
{
    return date($format, strtotime($date));
}


function dateHuman($date, $format = 'F j, Y')
{
    return date($format, strtotime($date));
}

function timeHuman($time, $format = 'H:i A')
{
    return date($format, strtotime($time));
}

function dateTimeHuman($date, $format = 'M j, Y H:i A')
{
    return date($format, strtotime($date));
}

function appointmentOptions()
{
    return [
        'Y'  => 'Approved',
        'N'  => 'Waiting',
    ];
}


function sizes(){

    return [
        null  => '-- Select Item Size --',
        'small'  => 'Small',
        'medium'  => 'Medium',
        'large'  => 'Large',
        'x-large'  => 'X-Large',
    ];
}

function sizeSmallString($string)
{
    if($string==''){
        return ' ';
    }elseif ($string=="small"){
        return 'S';
    }elseif ($string=="medium"){
        return 'M';
    }elseif ($string=="large"){
        return 'L';
    }elseif ($string=="x-large"){
        return 'XL';
    }else{
        return null;
    }
}


function undoSerialize($val1,$val2,$val3)
{
    $arr1= unserialize($val1);
    $arr2= unserialize($val2);
    $arr3= unserialize($val3);
    //$var =array_merge($arr1,$arr2,$arr3);
    $coll1 = collect(array_filter($arr1));
    $coll2 = collect(array_filter($arr2));
    $coll3 = collect(array_filter($arr3));

    $data2 = [];
    foreach ($arr1 as $key => $val) {
        $data2[] = [
            'size'    => $val,
            'price'     => $arr2[$key],
            'size_in_inches'     => $arr3[$key]
        ];
    }
    return  collect($data2);
}

function firstCapital($str)
{
    return Str::ucfirst($str);
}


function paymentOptions()
{
    return [
        ''         => '-- Select --',
        'Cash'         => 'Cash',
        'Credit Card'  => 'Credit Card',
        'Debit Card'   => 'Debit Card',
    ];
}

function arrayInList($array , $id)
{
    $collection = collect($array);

    if($collection->contains($id))
    {
        return true;
    }
}



function deciamlRoundOff($decimal, $number)
{
   return number_format($decimal, $number);
}


function OrderStatusOptions() {
    return [
     //   null   => '-- select status --',
        '1'    => 'Designing',
        '2'    => 'Approved',
        '3'    => 'Printing',
        '4'  => 'Ready for Pickup',
        '5' => 'Picked Up',
        '0'    => 'Canceled',
    ];
}


