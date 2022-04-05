@extends('layouts.app')
@section('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="{{ asset('assets/dhb/chat_div/chat.css') }}">
    <script src="{{ asset('assets/dhb/chat_div/chat.js') }}"></script>
    @endsection
@section('content')


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
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="invoice-title">
                            <h4 class="float-right font-size-16">Order # {{$order->id}}</h4>
                            <div class="mb-4">
                                <img src="{{ asset('images/logo.png') }}" alt="logo" height="40"/>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-sm-6">
                                <address>
                                    <strong>Billed To:</strong><br>
                                    {{ $order->name??'---' }}<br>
                                    {{ $order->phone??'---' }}<br>
                                    {{ $order->email??'---' }}<br>
                                    {{ $order->address??'---' }}
                                </address>
                            </div>
                           <div class="col-sm-6 text-sm-right">
                                <address class="mt-2 mt-sm-0">
                                    <strong>Shipped To:</strong><br>
                                    {{ $order->name??'---' }}<br>
                                    {{ $order->phone??'---' }}<br>
                                    {{ $order->email??'---' }}<br>
                                    {{ $order->address??'---' }}
                                </address>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6 mt-3">
                                <address>
                                    <strong>Payment Method:</strong><br>
                                    {{ $order->payment_method }}
                                </address>
                            </div>
                            <div class="col-sm-6 mt-3 text-sm-right">
                                <address>
                                    <strong>Order Date:</strong><br>
                                    {{ inputFormat($order->created_at) }}<br><br>
                                </address>
                            </div>
                        </div>
                        <div class="py-2 mt-3">
                            <h3 class="font-size-15 font-weight-bold">Order summary</h3>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-nowrap">
                                <thead>
                                <tr>
                                    <th style="width: 70px;">No.</th>
                                    <th>Item</th>
                                    @if( Auth::User()->isAdmin() || Auth::User()->isManager())
                                    <th class="text-right">Price</th>
                                        @endif
                                </tr>
                                </thead>
                                <tbody>
                                @if($order->orderDetails->count() > 0)
                                    @php $i = 1; @endphp
                                    @foreach($order->orderDetails as $detail)

                                        @php
                                            $detail_modules = unserialize($detail->printing_modules);
                                            $printing_modules = getPrintingModulesNonArray($detail->category_id);
                                        @endphp

                                <tr style="box-shadow: 7px 3px 0px 0px #7eb0ec;background: #eeeeee59;">
                                    <td>{{ $i++ }}</td>
                                    <td> <b>{{ $detail->category->category_name }}</b>

                                        @if(count($printing_modules) > 0)
                                            <hr>
                                            @foreach($printing_modules as $module)
                                                 @if(arrayInList($detail_modules ,$module->id))
                                                    <span style="padding-left: 15px;" class="mb-2">  <i class="fa fa-check-square-o" style="font-size:16px;color:#004fab"></i> {{$module->module_name }}  </span>
                                                @endif

                                                   @if(isset($module['children']) && is_array($module['children'])  && count($module['children']) > 0)

                                                        @foreach($module['children'] as $child)
                                                             @if(arrayInList($detail_modules ,$child->id))
                                                            <span> <i class="fa fa-check-square-o" style="font-size:14px;color:#004fab"></i>  {{$child->module_name }} (child)</span>
                                                             @endif
                                                        @endforeach

                                                        @endif
                                            @endforeach

                                        @endif
                                        <hr>

                                        @if( Auth::User()->isAdmin() || Auth::User()->isManager())
                                        <span><b>Quantity :</b> {{  $detail->quantity }} </span>
                                        <span><b>Price :</b> {{  '$'.deciamlRoundOff($detail->price,2) }} </span>
                                        <span><b>Size :</b> {{  'width : '.$detail->size_width }}</span>
                                            @endif
                                    </td>
                                    @if( Auth::User()->isAdmin() || Auth::User()->isManager())
                                    <td class="text-right">{{ '$'.deciamlRoundOff($detail->price,2) }}</td>
                                        @endif
                                </tr>

                                    @endforeach
                                @endif

                                @if( Auth::User()->isAdmin() || Auth::User()->isManager())
                                <tr>
                                    <td colspan="2" class="border-0 text-right">
                                        <strong>Total</strong></td>
                                    <td class="border-0 text-right"><h4 class="m-0">{{ '$'.deciamlRoundOff($order->total_price,2) }}</h4></td>
                                </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                        @if( Auth::User()->isAdmin() || Auth::User()->isManager())
                        <div class="d-print-none">
                            <div class="float-right">
                                <a href="javascript:window.print()" class="btn btn-success waves-effect waves-light mr-1"><i class="fa fa-print"></i></a>
                                <a href="{{ route('orders.index') }}" class="btn btn-primary w-md waves-effect waves-light">back</a>
                            </div>
                        </div>
                            @endif
                    </div>
                </div>
            </div>
        </div>
        <!-- end row -->





        @auth
          @if(Auth::User()->isadmin() || Auth::User()->isDesigner())
                <div class="round hollow text-center">
                    <a href="#" id="popup" ><span class="glyphicon glyphicon-comment"></span> Open in chat </a>
                </div>

                <div class=" popupchat popup-box chat-popup shedow">
                    <div class="popup-head">
                        {{'Order # ' .$order->id }} Live Chat
                    </div>

                    <div class="popup-messages scrollable-element">
                        <div class="btn-footer">


                            <div class="conversation" >

                                {!! $contents !!}

                            </div>  <!-- use for icon 1 -->
                            <div id="end"></div>
                        </div>  <!--end of <div class="btn-footer"> -->
                        <div class="popup-messages-footer pt-2">
                            {!! Form::open([
                                                          'route'        => 'order.chat',
                                                          'method'       => 'POST',
                                                          'autocomplete' => 'on',
                                                          'id'           => 'ajax-chat-form',
                                                          'files'        => 'true',
                                                          'redirectTo'   => route('home'),
                                                          ]) !!}

                            <textarea name="text" class="form-control"  placeholder="Type a message..."  rows="2"  id="txt"></textarea>
                            <input name="order_id" type="hidden" value="{{ $order->id }}">
                            <div class="btn-footer">
                                {{-- <button class="bg_none"><i class="glyphicon glyphicon-film"></i> </button>
                                 <button class="bg_none"><i class="glyphicon glyphicon-camera"></i> </button>
                                 <button class="bg_none"><i class="glyphicon glyphicon-paperclip"></i> </button>--}}
                                <button class="bg_none pull-right" type="submit" id="myBtn"><i class="fa fa-telegram" aria-hidden="true"></i> </button>
                                {{ Form::close() }}
                            </div>

                        </div>
                    </div>





                    <script type="text/javascript">
                        $(document).ready(function () {


                            $('#ajax-chat-form').on('submit', function(event) {
                                event.preventDefault();
                                //$(".btn-hsk").html("Sending please wait... <i class=\"fa fa-cog fa-spin fa-ax fa-fw\"></i>");
                                //$(".btn-hsk").addClass('disable');

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

                                            var html = data.options;
                                            $("#txt").val("");

                                            $('.conversation').html(html);
                                            $('.scrollable-element').animate({
                                                scrollTop: $("#end").offset().top
                                            }, 500);

                                        }
                                        else{

                                        }
                                    }
                                });
                            });
                        });
                    </script>


                    <script>


                        $(document).ready(function() {
                            var _token = $("input[name='_token']").val();
                            var order_id = {{$order->id}};
                            var interval = 15000;
                            function doAjax() {
                                $.ajax({
                                    type: "POST",
                                    url: '{{ route('sync.chat') }}',
                                    data: {_token: _token,order_id: order_id},
                                    success: function (data)
                                    {
                                        var html = data.options;
                                        $('.conversation').html(html);
                                        $('.scrollable-element').animate({
                                            scrollTop: $("#end").offset().top
                                        }, 500);

                                    },
                                    complete: function (data) {
                                        // Schedule the next

                                        setTimeout(doAjax, interval);

                                    }
                                });
                            }
                            setTimeout(doAjax, interval);
                        });

                    </script>
    @endif
       @endauth

@endsection
