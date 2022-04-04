@extends('layouts.app')
@section('content')

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <div class="container-fluid">
        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-flex align-items-center justify-content-between">
                    <h4 class="mb-0 font-size-18">OrderID#{{($order->id)??null}} </h4>
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Orders</a></li>
                            <li class="breadcrumb-item ">Show</li>
                            <li class="breadcrumb-item active">#{{($order->id)??null}}</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">

            <div class="col-xl-6">
                <div class="card">
                    <div class="card-body">

                        <h4 class="card-title">Client Information</h4>
                        <p class="card-title-desc">Here are examples of <code>.form-control</code> applied to each
                            textual HTML5 <code>&lt;input&gt;</code> <code>type</code>.</p>

                        <div class="form-group row">
                            <label for="name" class="col-md-2 col-form-label">Name</label>
                            <div class="col-md-10" >
                                {{ Form::text('name',$order->name, ['class' => 'form-control-sm' ]) }}
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="email" class="col-md-2 col-form-label">Email</label>
                            <div class="col-md-10" >
                                {{ Form::text('email',$order->email, ['class' => 'form-control-sm']) }}
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="phone" class="col-md-2 col-form-label">Phone</label>
                            <div class="col-md-10 ">
                                {{ Form::text('phone',$order->phone,  ['class' => 'form-control-sm']) }}
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="address" class="col-md-2 col-form-label">Address</label>
                            <div class="col-md-10" >
                              <p>{{$order->address}}</p>
                            </div>
                        </div>

                    </div>
                </div>
            </div> <!-- end col -->

            <div class="col-xl-6">
                <div class="card">
                    <div class="card-body">

                        <h4 class="card-title">Client Information</h4>
                        <p class="card-title-desc">Here are examples of <code>.form-control</code> applied to each
                            textual HTML5 <code>&lt;input&gt;</code> <code>type</code>.</p>

                        <div class="form-group row">
                            <label  class="col-md-2 col-form-label">Designer Name</label>
                            <div class="col-md-10" >
                                {{ Form::select('designer_name',$designerOptions,$order->user_id, ['class' => 'form-control-sm']) }}
                            </div>
                        </div>

                        <div class="form-group row">
                            <label  class="col-md-2 col-form-label">Ready For Print</label>
                            <div class="col-md-10" >
                                {{ Form::select('ready_for_print',yesNoOptions(),$order->ready_for_print, ['class' => 'form-control-sm']) }}
                            </div>
                        </div>

                        <div class="form-group row">
                            <label  class="col-md-2 col-form-label">Printed By</label>
                            <div class="col-md-10" >
                                {{ Form::text('printed_by',$order->printed_by, ['class' => 'form-control-sm']) }}
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="payment_method" class="col-md-2 col-form-label">Payment Method</label>
                            <div class="col-md-10">
                                {{ Form::select('payment_method',paymentOptions(),$order->payment_method, ['class' => 'form-control-sm']) }}
                            </div>
                        </div>

                    </div>
                </div>
            </div> <!-- end col -->

        </div>
        <!-- end row -->



            @if($order->orderDetails->count() > 0)
                @foreach($order->orderDetails as $detail)
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class=" row">
                                        <div class="col-xl-4 mt-2" >
                                            <div class="form-group">
                                                <label>Choose Category </label>
                                                {!! Form::select('just_dummy[]',$categoryOptions,$detail->category_id, ['class' => 'form-control-sm category' ,'disabled'=>'disabled']) !!}
                                            </div>
                                        </div>
                                    </div>

                                @php
                                    $detail_modules = unserialize($detail->printing_modules);
                                    $printing_modules = getPrintingModulesNonArray($detail->category_id);
                                @endphp

                                <!--  dynamic view render here by using ajax -->
                                    <div class="row">
                                        <div class="col-xl-2 col-sm-12">
                                            <label  class="label">Choose Printing Modules</label>
                                        </div>

                                        <div class="col-xl-10 col-sm-12">
                                            <div class="row">

                                                @if(count($printing_modules) > 0)
                                                    @foreach($printing_modules as $module)

                                                        <div class="col-xl-2 col-sm-6" >
                                                            <div class="mt-4">
                                                                <p>@if(arrayInList($detail_modules ,$module->id))  <i class="fa fa-check-square-o" style="font-size:16px;color:green"></i> @else <i class="fa fa-close" style="font-size:20px;color:red"></i> @endif  {{$module->module_name }}</p>
                                                            </div>

                                                            @if(isset($module['children']) && is_array($module['children'])  && count($module['children']) > 0)
                                                                @foreach($module['children'] as $child)
                                                                    <div class="mt-2" style="padding-left: 15px;" >

                                                                             <p>@if(arrayInList($detail_modules ,$child->id)) <i class="fa fa-chevron-circle-right" aria-hidden="true" style="font-size:16px;color:green;"></i>  @else  <i class="fa fa-check-square-o" style="font-size:20px;color:red"></i>@endif  {{$child->module_name }}</p>

                                                                    </div>
                                                                @endforeach
                                                            @endif
                                                        </div>
                                                    @endforeach
                                                @endif
                                            </div>
                                        </div>

                                    </div>

                                    <div class=" row">
                                        <div class="col-xl-2 mt-2" >
                                            <label>Quantity :</label>
                                      <p> {{$detail->quantity??'0'}}</p>
                                        </div>

                                        <div class="col-xl-4 mt-2" >
                                            <label>Size : </label>
                                                <p>  {{'width '.$detail->size_width??'0'}} {{ '* Height '. $detail->size_height??'0' .'inches' }}</p>
                                        </div>
                                    </div>

                                    <div class="row" id="loop">
                                        <div class="col-xl-12" >
                                            <div class="form-group">
                                                <label  class="label mt-2"  id="wrapper_details">Details</label>
                                                <p>{{$detail->details??'---'}}</p>
                                      </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            @endif



    @if( Auth::User()->isDesigner())
      <!-- end row -->
        <div class="row ">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">

                        <!-- start validation messages -->
                        <div class="hidden alert alert-success" id="msg"></div>
                        <div id="hideError" class="alert alert-danger print-error-msg" style="display:none; ">
                            <ul style="list-style: none;"></ul>
                        </div>
                        <!--end  validation messages -->


                        {!! Form::open([
                                                   'route'        => ['order.printable.file.upload', 'orderId' => $order->id],
                                                   'method'       => 'POST',
                                                   'autocomplete' => 'off',
                                                   'id'           => 'ajax-docs',
                                                   'files'        => 'true',
                                                   'redirectTo'   => route('home'),
                                                   ]) !!}



                        <div class="progress mb-4">
                            <div class="progress-bar progress-bar-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100" style=""> </div>
                        </div>

                        <div class="form-group mb-4">
                            <label class="control-label">Choose Document</label>
                            {{ Form::file('file', null, ['class' => 'form-control']) }}
                        </div>


                        <div class="form-group mb-4">
                            <label class="control-label">Comment (optional)</label>
                            {{ Form::textarea('comment',null, ['class' => 'form-control','rows'=>'2','placeholder'=>'comment (Optional)']) }}
                        </div>


                        <br>
                        <div class="form-group mb-4">
                            <button class="btn btn-primary" type="submit">Upload</button>
                        </div>

                        {{ Form::close() }}
                        {{--<div class="form-group mb-4">
                            <button class="btn btn-primary float-right" type="submit">Save Changes</button>
                        </div>--}}
                    </div>
                </div>
            </div>
        </div>
        <!-- end row -->

    </div> <!-- container-fluid -->



    <script>
        $(document).ready(function(){
            function ErrorMsg (msg) {
                $('#ajax-docs').find(':submit').val("Submit")
                $('#ajax-docs').find(':submit').removeAttr('disabled', 'disabled');

                $(".print-error-msg").find("ul").html('');
                $(".print-error-msg").css('display','block');
                $.each( msg, function( key, value ) {
                    $(".print-error-msg").find("ul").append('<li>'+value+'</li>');
                });
            }

            function progress_bar_process(percentage, timer,redirectTo)
            {
                $('.progress-bar').css('width', percentage + '%');
                if(percentage === 100)
                {
                    $("#msg").removeClass('hidden');
                    $("#msg").html('File Upload Successfully.');
                    setTimeout(function(){
                        window.location.href = redirectTo
                    },2000);

                }
            }

            $('#ajax-docs').on('submit', function(event) {
                event.preventDefault();

                var formData = $(this).serialize(); // form data as string
                var formAction = $(this).attr('action'); // form handler url
                var formMethod = $(this).attr('method'); // GET, POST
                var redirectTo  = $(this).attr('redirectTo'); // GET, POST

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({
                    url: formAction,
                    method: formMethod,
                    cache: false,
                    data:new FormData(this),
                    dataType:'JSON',
                    contentType: false,
                    processData: false,

                    success: function(data) {
                        if($.isEmptyObject(data.error)){

                            var percentage = 0;
                            var timer = setInterval(function(){
                                percentage = percentage + 25;
                                progress_bar_process(percentage, timer ,redirectTo);
                            },100);
                            /* $("#msg").html(data.success);
                             $('.print-error-msg').addClass('hidden');

                             $("#msg").removeClass('hidden').addClass('alert alert-success');*/
                            $('.print-error-msg').addClass('hidden').fadeOut(100);
                            // $('.print-error-msg').addClass('hidden');
                        }
                        else{
                            ErrorMsg(data.error);
                        }
                    }
                });
            });
        });
    </script>

    @endif
@endsection
