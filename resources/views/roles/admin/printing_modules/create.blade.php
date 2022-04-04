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
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Printing Modules</a></li>
                            {{--                            <li class="breadcrumb-item active">Add Category</li>--}}
                        </ol>
                    </div>

                </div>
            </div>
        </div>
        <!-- end page title -->

        <div class="row">
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title mb-4">List</h4>

                        @include('componants.ajax-hs')

                        {!! Form::open([
                          'route'        => 'printing-modules.store',
                          'method'       => 'POST',
                          'autocomplete' => 'on',
                          'id'           => 'ajax-form-hsk',
                          'files'        => 'true',
                          'redirectTo'   => route('printing-modules.index'),
                          ]) !!}


                        <div class="form-group mb-4">
                            <label class="control-label">Category ID</label>
                            {{ Form::select('category',$categoryOptions, null, ['class' => 'form-control show-tick']) }}
                        </div>

                        <div class="form-group">
                            <label for="formrow-firstname-input">Module Name</label>
                            {{ Form::text('module_name', null, ['class' => 'form-control' , 'placeholder'=>'Enter Category Name']) }}
                        </div>

                        <div class="form-group mb-4">
                            <label class="control-label">Parent  (Optional)</label>
                            {{ Form::select('parent', $moduleOptions, null, ['class' => 'form-control show-tick']) }}
                        </div>



                        <div class="form-group mb-4">
                            <button class="btn btn-primary" type="submit">Save</button>
                        </div>

                        {{ Form::close() }}
                    </div>
                </div>
            </div>

        </div>
        <!-- end row -->



    </div> <!-- container-fluid -->



@endsection
@section('scripts')
    <script src="{{ asset('assets/js/hs.js') }}"></script>
@endsection
