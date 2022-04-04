@extends('layouts.app')

                            @section('content')
                                <div class="container-fluid">

                                    <!-- start page title -->
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="page-title-box d-flex align-items-center justify-content-between">
                                                <h4 class="mb-0 font-size-18">*</h4>

                                                <div class="page-title-right">
                                                    <ol class="breadcrumb m-0">
                                                        <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboard</a></li>
                                                        <li class="breadcrumb-item active">Printing Modules</li>
                                                    </ol>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- end page title -->

                                    <!-- end row -->

                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="card">
                                                <div class="card-body">
                                                    <h4 class="card-title mb-4">Printing Modules</h4>
                                                    @if(isset($printingModules) && $printingModules->count()>0)
                                                        <div class="table-responsive">
                                                            <table class="table table-centered table-nowrap mb-0 table-bordered">
                                                                <thead class="thead-light">
                                                                <tr>
                                                                    <th style="width: 20px;">
                                                                        <div class="custom-control custom-checkbox">
                                                                            <input type="checkbox" class="custom-control-input" id="customCheck1">
                                                                            <label class="custom-control-label" for="customCheck1">&nbsp;</label>
                                                                        </div>
                                                                    </th>
                                                                    <th>ID</th>
                                                                    <th>Name</th>
                                                                    <th>Parent</th>
                                                                    <th>Category</th>
                                                                    <th>Status</th>
                                                                    <th>View Details</th>
                                                                </tr>
                                                                </thead>
                                                                <tbody>

                                                                @foreach($printingModules as $module)
                                                                    <tr>
                                                                        <td><div class="custom-control custom-checkbox"><input type="checkbox" class="custom-control-input" id="customCheck2"><label class="custom-control-label" for="customCheck2">&nbsp;</label></div></td>
                                                                        <td><a href="javascript: void(0);" class="text-body font-weight-bold">#{{ $module->id }}</a> </td>
                                                                        <td>{{ $module->module_name }}</td>
                                                                        <td>{{ ($module->parent)?:'---' }}</td>
                                                                        <td>{{ $module->category->category_name }}</td>
                                                                        <td><span class="badge badge-pill badge-soft-success font-size-12">{{ $module->active }}</span></td>
                                                                        <td><!-- Button trigger modal --><button type="button" class="btn btn-primary btn-sm btn-rounded waves-effect waves-light" data-toggle="modal" data-target=".exampleModal{{ $module->id }}">Edit</button></td>
                                                                    </tr>

                                                                    <!-- Modal -->
                                                                    <div class="modal fade exampleModal{{ $module->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                                        <div class="modal-dialog modal-dialog-centered" role="document">
                                                                            <div class="modal-content">
                                                                                <div class="modal-header">
                                                                                    <h5 class="modal-title" id="exampleModalLabel">Edit Printing Module</h5>
                                                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                                        <span aria-hidden="true">&times;</span>
                                                                                    </button>
                                                                                </div>
                                                                                <div class="modal-body">
                                                                                    <p class="mb-2">Id: <span class="text-primary">#{{ $module->id }}</span></p>
                                                                                    <div class="card">
                                                                                        <div class="card-body">
                                                                                            <div class="msg hidden"></div>
                                                                                            <div class="alert alert-danger print-error-msg hideError" style="display:none; ">
                                                                                                <ul style="list-style: none;"></ul>
                                                                                            </div>
                                                                                            {!! Form::open([
                                                                                            'route'        => ['printing-modules.update', 'printing_module' => $module->id],
                                                                                            'method'       => 'PATCH',
                                                                                            'autocomplete' => 'off',
                                                                                            'class'        => 'ajax-form-hsk',
                                                                                            'files'        => 'true',
                                                                                            'redirectTo'   => route('printing-modules.index'),
                                                                                            ]) !!}

                                                                                            <div class="form-group mb-4">
                                                                                                <label class="control-label">Category ID</label>
                                                                                                {{ Form::select('category',$categoryOptions,$module->category_id, ['class' => 'form-control show-tick']) }}
                                                                                            </div>

                                                                                            <div class="form-group">
                                                                                                <label for="formrow-firstname-input">Module Name</label>
                                                                                                {{ Form::text('module_name',$module->module_name, ['class' => 'form-control' , 'placeholder'=>'Enter Category Name']) }}
                                                                                            </div>

                                                                                            <div class="form-group mb-4">
                                                                                                <label class="control-label">Parent  (Optional)</label>
                                                                                                {{ Form::select('parent', $moduleOptions,$module->parent_id, ['class' => 'form-control show-tick']) }}
                                                                                            </div>

                                                                                            <div class="form-group mb-4">
                                                                                                <label>Status</label>
                                                                                                {{ Form::select('status', statusOptions(),$module->active, ['class' => 'form-control show tick' ]) }}
                                                                                            </div>
                                                                                            <div class="form-group mb-4">
                                                                                                <button class="btn btn-primary" type="submit">Save</button>
                                                                                            </div>
                                                                                            {{ Form::close() }}
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="modal-footer">
                                                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <!-- end modal -->
                                                                @endforeach

                                                                </tbody>
                                                            </table>
                                                        </div>
                                                @endif
                                                <!-- end table-responsive -->
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- end row -->
                                </div>
                                <!-- container-fluid -->
                            @endsection

                            @section('scripts')
                                <script src="{{ asset('assets/js/ajax-class-form-hs.js') }}"></script>
    @endsection
