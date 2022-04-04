@extends('layouts.app')

@section('styles')
    <style>
        .cselect{border-color: #fff;color: black;}
    </style>
@endsection
@section('content')

    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-flex align-items-center justify-content-between">
                    <h4 class="mb-0 font-size-18">Projects List</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Projects</a></li>
                            <li class="breadcrumb-item active">Projects List</li>
                        </ol>
                    </div>

                </div>
            </div>
        </div>
        <!-- end page title -->

        @include('componants.success')
        <div class="row">
            <div class="col-lg-12">
                <div class="">
                    <div class="table-responsive">
                        <table class="table project-list-table table-nowrap table-centered table-borderless">
                            <thead>
                            <tr>
                                <th scope="col" style="width: 100px">#</th>
                                <th scope="col">Client Name</th>
                                <th scope="col">Due Date</th>
                                <th scope="col">Status</th>
                                <th scope="col">Designer</th>
                                <th scope="col">File</th>
                                <th scope="col">Action</th>
                            </tr>
                            </thead>
                            <tbody>

                            @if(isset($orders) && $orders->count()>0)
                                @foreach($orders as $order)
                                    <tr>
                                        <td>#{{ $order->id }}</td>
                                        <td>
                                            <h5 class="text-truncate font-size-14"><a href="#" class="text-dark">{{ $order->name }}</a></h5>
                                        </td>
                                        <td>{{dateHuman($order->created_at)}}</td>
                                        <td>
                                            {{ Form::select('status',OrderStatusOptions(),$order->status, ['class'=>'cselect ','disabled']) }}
                                        </td>

                                        <td>
                                            <div class="team">
                                                <a href="javascript: void(0);" class="team-member d-inline-block" data-toggle="tooltip" data-placement="top" title="" data-original-title="Daniel Canales">
                                                    <img src="{{ asset('assets/images/users/avatar-2.jpg') }}" class="rounded-circle avatar-xs m-1" alt="">
                                                    {{ $order->user->name }}
                                                </a>
                                            </div>
                                        </td>
                                        <td>
                                            @if($order->file)
                                                <a target="_blank" class="btn  btn-sm btn-outline-primary" href="{{ asset('uploads/order_documents/'.$order->file) }}"> <i class="fa fa-download" aria-hidden="true"></i> Download</a>
                                            @else
                                                <p>---</p>
                                            @endif
                                        </td>
                                        <td>
                                            @if($order->printed_by==null)
                                            <div class="btn-group btn-group-sm mt-2" role="group" aria-label="Basic example">
                                                <a href="{{ route('order.show',$order->id) }}"  class="btn btn-outline-warning"><i class="fa fa-eye" aria-hidden="true"></i> Details</a>
                                                <button type="button" class="btn btn-outline-primary printman" id="{{$order->id}}"    onclick=" confirm('Make sure Order Printed? if you mark it printed this is not more shown in above the list.')">Mark As Printed</button>
                                            </div>
                                            @else
                                                    <span class="badge badge-success">{!! $order->printed_by !!}</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!-- end row -->

        {{--    <div class="row">
                <div class="col-12">
                    <div class="text-center my-3">
                        <a href="javascript:void(0);" class="text-success"><i class="bx bx-loader bx-spin font-size-18 align-middle mr-2"></i> Load more </a>
                    </div>
                </div> <!-- end col-->
            </div>
            <!-- end row -->--}}

    </div> <!-- container-fluid -->


    <!-- /.modal start -->
    {{--            <button type="button" class="btn btn-primary waves-effect waves-light" data-toggle="modal" data-target=".bs-example-modal-center">Center modal</button>--}}

    <div class="modal fade bs-example-modal-center" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title mt-0">Upload File </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body order_file_upload">

                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->


    <script type="text/javascript">
        $(document).ready(function () {
            $(".printman").click(function(e){
                e.preventDefault();

                var _token    = $('meta[name="csrf-token"]').attr('content')
                var order_id  =  $(this).attr("id");


                $.ajax({
                    type: "POST",
                    url: '{{ route('order.print.by') }}',
                    data: {_token:_token,order_id:order_id},
                    success: function(data) {
                        if($.isEmptyObject(data.error)){
                         alert(data.success);
                            window.setTimeout(function () {
                                location.reload()
                            }, 100);
                        }else{
                            //   printErrorMsg(data.error);
                            //  $("#hideError").fadeOut(5000);
                        }
                    }
                });
            });
        });
    </script>




@endsection


