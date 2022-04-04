@extends('layouts.app')
@section('styles')
    <style>
        .remove{
            border-radius:4px !important;
            color:#fff;
            background-color:red !important;
            width:22px;
            height:22px;
            font-size:12px;
        }
    </style>
    <link href="{{ asset('assets/libs/bootstrap-datepicker/css/bootstrap-datepicker.min.css') }}" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="{{ asset('assets/libs/@chenfengyuan/datepicker/datepicker.min.css') }}">

    <script src="{{ asset('assets/libs/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}"></script>
    <script src="{{ asset('assets/libs/bootstrap-colorpicker/js/bootstrap-colorpicker.min.js') }}"></script>
    <script src="{{ asset('assets/libs/@chenfengyuan/datepicker/datepicker.min.js') }}"></script>
@endsection
@section('content')

    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-flex align-items-center justify-content-between">
                    <h4 class="mb-0 font-size-18">Form Elements</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Forms</a></li>
                            <li class="breadcrumb-item active">Form Elements</li>
                        </ol>
                    </div>

                </div>
            </div>
        </div>


    <!-- end page title -->


        {{ Form::open(['url' => route('order.update', ['orderId' => $order->id]),
                                                  'data-method' => 'POST',
                                                  'id' => 'dhb-ajax-form',
                                                  'files' => true,
                                                  'data-redirect' => route('orders.index')
                                                  ])
                                              }}


        <div class="row">

            <div class="col-xl-6">
                <div class="card">
                    <div class="card-body">

                        <h4 class="card-title">Client Information</h4>
                        <p class="card-title-desc">Here are examples of <code>.form-control</code> applied to each
                            textual HTML5 <code>&lt;input&gt;</code> <code>type</code>.</p>

                        <div class="form-group row">
                            <label for="name" class="col-md-2 col-form-label">Name</label>
                            <div class="col-md-10" id="wrapper_name">
                                {{ Form::text('name',$order->name, ['class' => 'form-control' , 'placeholder'=>'Enter Name']) }}
                                @if($errors->has('name'))
                                    <div class="error">{{ $errors->first('name') }}</div>
                                @endif
                                @error('name')
                                <span>{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="email" class="col-md-2 col-form-label">Email</label>
                            <div class="col-md-10" id="wrapper_email">
                                {{ Form::text('email',$order->email, ['class' => 'form-control' , 'placeholder'=>'Enter Email']) }}
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="phone" class="col-md-2 col-form-label">Phone</label>
                            <div class="col-md-10 " id="wrapper_phone">
                                {{ Form::text('phone',$order->phone, ['class' => 'form-control' , 'placeholder'=>'Enter Phone']) }}
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="address" class="col-md-2 col-form-label">Address</label>
                            <div class="col-md-10" id="wrapper_address">
                                {{ Form::textarea('address',$order->address, ['class' => 'form-control' ,'rows'=>'2', 'placeholder'=>'Enter Address']) }}
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
                            <label for="designer_name" class="col-md-2 col-form-label">Designer Name</label>
                            <div class="col-md-10" id="wrapper_designer_name">
                                {{ Form::select('designer_name',$designerOptions,$order->user_id, ['class' => 'form-control']) }}
                            </div>
                        </div>

                        {{--  <div class="form-group row">
                            <label for="ready_for_print" class="col-md-2 col-form-label">Ready For Print</label>
                            <div class="col-md-10" id="wrapper_ready_for_print">
                                {{ Form::select('ready_for_print',yesNoOptions(),null, ['class' => 'form-control']) }}
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="printed_by" class="col-md-2 col-form-label">Printed By</label>
                            <div class="col-md-10" id="wrapper_printed_by">
                                {{ Form::text('printed_by','Arshdeep Rayat', ['class' => 'form-control' , 'placeholder'=>'Printed By']) }}
                            </div>
                        </div>--}}

                        <div class="form-group row">
                            <label for="payment_method" class="col-md-2 col-form-label">Payment Method</label>
                            <div class="col-md-10" id="wrapper_payment_method">
                                {{ Form::select('payment_method',paymentOptions(),$order->payment_method, ['class' => 'form-control']) }}
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="payment_method" class="col-md-2 col-form-label">Due Date </label>
                            <div class="col-md-10" id="wrapper_payment_method">
                                <div class="input-group">
                                    <input type="text" class="form-control" placeholder="dd M, yyyy" data-date-format="dd M, yyyy"
                                           data-provide="datepicker" name="due_date" autocomplete="off" value="{{inputFormat($order->due_date)}}">
                                    <div class="input-group-append">
                                        <span class="input-group-text"><i class="mdi mdi-calendar"></i></span>
                                    </div>
                                </div><!-- input-group -->
                            </div>
                        </div>


                        <div class="form-group row">
                            <label for="payment_method" class="col-md-2 col-form-label">Total Price</label>
                            <div class="col-md-10" id="wrapper_payment_method">
                                {{ Form::text('total_price',$order->total_price, ['class' => 'form-control']) }}

                        </div>
                        </div>

                    </div>
                </div>
            </div> <!-- end col -->

        </div>
        <!-- end row -->

        <!-- dynamic -->

        <div class="dynamic" id="dynamic_field">

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
                                          {!! Form::select('just_dummy[]',$categoryOptions,$detail->category_id, ['class' => 'form-control category' ,'disabled'=>'disabled']) !!}
                                          <input type="hidden" name="category[]" value="{{$detail->category_id}}" />
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

                                                  <div class="col-xl-3 col-sm-6" style="box-shadow: 2px 2px 2px 2px #eeeeee;">
                                                      <div class="mt-4">
                                                          <div class="custom-control custom-checkbox custom-checkbox-outline custom-checkbox-primary mb-3">
                                                              <label><input type="checkbox"  name="printing_modules{{$module->category_id }}[]"  value="{{ $module->id }}" @if(arrayInList($detail_modules ,$module->id)) checked @endif>  {{$module->module_name }}</label>
                                                              {{--<input type="checkbox"
                                                                     class="custom-control-input"
                                                                     name="printing_modules{{$module->category_id }}[]"
                                                                     id="printing_modules{{$module->id}}"
                                                                     value="{{ $module->id }}"
                                                                     @if(arrayInList($detail_modules ,$module->id)) checked @endif >
                                                              <label class="custom-control-label" for="printing_modules{{$module->id}}"> {{$module->module_name }}</label>--}}
                                                          </div>
                                                      </div>



                                                      @if(isset($module['children']) && is_array($module['children'])  && count($module['children']) > 0)
                                                          @foreach($module['children'] as $child)
                                                              <div class="mt-2" style="padding-left: 15px;" >
                                                                  <div class="custom-control custom-checkbox custom-checkbox-outline custom-checkbox-primary mb-3">
                                                                      <label><input type="checkbox"  name="printing_modules{{$module->category_id }}[]"  value="{{ $child->id }}" @if(arrayInList($detail_modules ,$child->id)) checked @endif>  {{$child->module_name }}</label>

                                                                      {{--<input type="checkbox"
                                                                             class="custom-control-input"
                                                                             name="printing_modules{{$module->category_id }}[]"
                                                                             id="printing_modules{{$child->id}}"
                                                                             value="{{ $child->id }}"
                                                                             @if(arrayInList($detail_modules ,$child->id)) checked @endif
                                                                      >
                                                                      <label class="custom-control-label text-info" for="printing_modules{{$child->id}}" style="font-weight: normal;">{{$child->module_name }}  (child)</label>--}}
                                                                  </div>
                                                              </div>
                                                          @endforeach
                                                      @endif
                                                  </div>


                                              @endforeach
                                          @endif
                                      </div>
                                  </div>

                              </div>

                              <div class="dynamic_modules_looprow{{$detail->id}}">

                             </div>

                              <div class=" row">
                                  <div class="col-xl-3 mt-2" >
                                      <div class="form-group">
                                          <label>Quantity</label>
                                          {!! Form::number('quantity[]',$detail->quantity??'0', ['min' => '0','class' => 'form-control']) !!}
                                      </div>
                                  </div>


                                  <div class="col-xl-3 mt-2" >
                                      <div class="form-group">
                                          <label>Price</label>
                                          {!! Form::text('price[]',$detail->price??'0', ['min' => '0','class' => 'form-control']) !!}
                                      </div>
                                  </div>

                                  <div class="col-xl-6 mt-2" >
                                      <div class="form-group">
                                          <label>Size</label>
                                          <div class=" input-group"  >
                                              {{ Form::text('width[]',$detail->size_width??'0', ['min' => '0','class' => 'form-control','placeholder'=>'width']) }}
                                              {{ Form::text('height[]',$detail->size_height??'0', ['min' => '0','class' => 'form-control','placeholder'=>'height']) }}
                                          </div>
                                      </div>
                                  </div>
                              </div>

                              <div class="row" id="loop">
                              <div class="col-xl-12" >
                                  <div class="form-group">
                                      <label  class="label mt-2"  id="wrapper_details">Details</label>
                                      {{ Form::textarea('details[]',$detail->details??null, ['class' => 'form-control' ,'rows'=>'2', 'placeholder'=>'Enter Details']) }}
                                  </div>
                              </div>
                              </div>
                          </div>
                      </div>
                  </div>
              </div>
                @endforeach
                @endif
        </div>

        <div class="row mb-4">
            <div class="col-xl-12">
                <button type="button" name="add" id="add" class="add-new-btn btn btn-success float-right">Add Row</button>
            </div>
        </div>

        <!-- end row -->
        <div class="row ">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="form-group mb-4">
                            <button class="btn btn-primary float-right" type="submit">Save Changes</button>
                            <a href="{{ route('orders.index') }}" class="btn btn-danger float-right" >Cancel</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- end row -->
        {{ Form::close() }}
    </div> <!-- container-fluid -->




    <script type="text/javascript">
        $(document).ready(function () {
            var i = 1;

            $('#add').click(function () {
                i++;


                $('#dynamic_field').append('' +
                    '<div id="row' + i + '" class="dynamic-added height-light-div">' +
                    '<div class="row">' +
                    '<button type="button" name="remove" id="' + i + '" class="remove btn_remove float-right">X</button>' +
                    '<div class="col-lg-12">' +
                    '<div class="card">' +
                    '<div class="card-body">' +
                    '<div class=" row">' +
                    '<div class="col-xl-4 mt-2" >' +
                    '<div class="form-group">' +
                    '<label>Choose Category </label>' +
                    '<select class="form-control category" name="category[]" id="row' + i + '" >' +
                    '<option value="" >-- Select --</option>' +
                    ' @foreach($categories as $category)' +
                    '<option value="{{ $category->id }}" >' +
                    '{{ $category->category_name }}' +
                    '</option>' +
                    '@endforeach' +
                    '</select>' +
                    '</div>' +
                    '</div>' +
                    '</div>' +
                    '<div  class="dynamic_modules_looprow' + i + '">' +
                    '</div>' +
                    '<div class=" row">' +
                    '<div class="col-xl-3 mt-2" >' +
                    '<div class="form-group">' +
                    '<label>Quantity</label>' +
                    '{!! Form::number('quantity[]', '0', ['min' => '0','class' => 'form-control']) !!}' +
                    '</div>' +
                    '</div>' +
                    '<div class="col-xl-3 mt-2" >' +
                    '<div class="form-group">' +
                    '<label>Price</label>' +
                    '{!! Form::text('price[]','0', ['min' => '0','class' => 'form-control']) !!}' +
                    '</div>' +
                    '</div>' +
                    '<div class="col-xl-6 mt-2" >' +
                    '<div class="form-group">' +
                    '<label>Size</label>' +
                    '<div class=" input-group"  >' +
                    '{{ Form::number('width[]',null, ['min' => '0','class' => 'form-control','placeholder'=>'width']) }}' +
                    '{{ Form::number('height[]',null, ['min' => '0','class' => 'form-control','placeholder'=>'height']) }}' +
                    '</div>' +
                    '</div>' +
                    '</div>' +
                    '</div>' +
                    '<div class="row" id="loop">' +
                    '<div class="col-xl-12" >' +
                    '<div class="form-group">' +
                    '<label  class="label mt-2"  id="wrapper_details">Details</label>' +
                    '{{ Form::textarea('details[]',null, ['class' => 'form-control' ,'rows'=>'2', 'placeholder'=>'Enter Details']) }}' +
                    '</div>' +
                    '</div>' +
                    '</div>' +
                    '</div>' +
                    '</div>' +
                    '</div>' +
                    '</div>' +
                    '</div>');
            });



            //********************** on click generate new in put//
            $(document).on('click', '.btn_remove', function ()
            {
                var button_id = $(this).attr("id");
                $('#row' + button_id + '').remove();
            });
        });
        //********************* end code there ****************/
    </script>


    <script type="text/javascript">
         $(document).on('change','.category',function() {
            // $(".category").change(function(){
            var _token    = $("input[name='_token']").val();
            var category_id  = $(this).val();
            var rid  =  $(this).attr("id");

            //alert(rid);

            $.ajax({
                type: "POST",
                url: '{{ route('get.modules.by.cat.id') }}',
                data: {_token:_token, category_id:category_id},
                success: function(data) {
                    if($.isEmptyObject(data.error)){
                        //let html = data.options;
                        var html = data.options;
                        //  alert(html);
                        if(rid!==''){
                            $('.dynamic_modules_loop'.concat(rid)).html(html);
                        }else{
                            $('.dynamic_modules_loop').html(html);
                        }



                    }else{
                        printErrorMsg(data.error);
                        $("#hideError").fadeOut(5000);
                    }
                }
            });
            // });
        });
    </script>


@endsection
@section('scripts')

    <script type="text/javascript">

        $(document).ready(function () {

            let dhbAjaxForm = $('#dhb-ajax-form'), submitBtn, formData = new FormData(), redirectTo = '';
            if (dhbAjaxForm.length > 0) {
                submitBtn = dhbAjaxForm.find('button[type="submit"]');
                $('body').on('submit', '#dhb-ajax-form', function (e) {
                    e.preventDefault();
                    submitBtn.html("Saving please wait... <i class=\"fa fa-cog fa-spin fa-ax fa-fw\"></i>");
                  //  submitBtn.attr('disabled', 'disabled');
                    formData.append('form-data', $(this).serialize());
                    redirectTo = $(this).data('redirect');
                    $.ajax({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        method: $(this).data('method'),
                        url: $(this).attr('action'),
                        data: formData,
                        context: this,
                        dataType: 'json',
                        success: function (response) {
                            submitBtn.html("Save changes");
                            submitBtn.removeAttr('disabled');
                            if (response.status === false) {
                                // resetFile();
                                //   formData.set('files[]', null);
                                let errors = response.errors, elem;
                                $('p.error').remove();
                                errors.forEach((res) => {
                                    let ar = res.key.split('.');
                                    if (ar.length > 0) {
                                        elem = $('#wrapper_' + ar[0]);
                                    } else {
                                        elem = $('#wrapper_' + res.key);
                                    }
                                    if (elem && elem.length > 0) {
                                        $(elem).children('p').remove();
                                        $("<p class='error'>" + res.error + "</p>").appendTo(elem);
                                    }
                                });
                            } else {
                                window.location.href = redirectTo;
                                //alert(response.status);
                            }
                        },
                        complete: function () {
                            $(this).data('requestRunning', false);
                        },
                        processData: false,
                        contentType: false,
                    });
                });
            }
        });

    </script>

    {{--    <script src="{{ asset('assets/js/hs.js') }}"></script>--}}
@endsection
