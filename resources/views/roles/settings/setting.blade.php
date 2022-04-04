@extends('layouts.app')

@section('content')
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-flex align-items-center justify-content-between">
                    <h4 class="mb-0 font-size-18">Settings</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Home</a></li>
                              <li class="breadcrumb-item active">Settings</li>
                        </ol>
                    </div>

                </div>
            </div>
        </div>
        <!-- end page title -->

        <!-- end row -->

        <div class="row">

            <div class="col-lg-6">
                <div class="card">
                    <div class="card-body">



                        <!-- Nav tabs -->
                        <ul class="nav nav-tabs" role="tablist"  id="myTab">
                            <li class="nav-item">
                                <a class="nav-link active" data-toggle="tab" href="#home" role="tab">
                                    <span class="d-block d-sm-none"><i class="fas fa-home"></i></span>
                                    <span class="d-none d-sm-block">Profile</span>
                                </a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link" data-toggle="tab" href="#settings" role="tab">
                                    <span class="d-block d-sm-none"><i class="fas fa-cog"></i></span>
                                    <span class="d-none d-sm-block">Change Password</span>
                                </a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link" data-toggle="tab" href="#twofactor" role="tab">
                                    <span class="d-block d-sm-none"><i class="fas fa-cog"></i></span>
                                    <span class="d-none d-sm-block">Manage Two Factor</span>
                                </a>
                            </li>

                        </ul>

                        <!-- Tab panes -->
                        <div class="tab-content p-3 text-muted">

                            @include('componants.success')
                            @include('componants.danger')
                            <div class="tab-pane active" id="home" role="tabpanel">
                                <div class="card">
                                    <div class="card-body">

                                        {!! Form::open([ 'route'=> 'profile.update', 'method'=> 'POST']) !!}

                                      {{--  <div class="form-group row mb-4">
                                            <label for="horizontal-firstname-input" class="col-sm-3 col-form-label">Username</label>
                                            <div class="col-sm-9">
                                                {{ Form::text('username',Auth::user()->username, ['class' => 'form-control' ,'id'=>'horizontal-username-input']) }}
                                                @error('username')
                                                <p class="text-danger">{{$message}}</p>
                                                @enderror
                                            </div>
                                        </div>--}}

                                        <div class="form-group row mb-4">
                                            <label for="horizontal-firstname-input" class="col-sm-3 col-form-label">First Name</label>
                                            <div class="col-sm-9">
                                                {{ Form::text('name',Auth::user()->name, ['class' => 'form-control' ,'id'=>'horizontal-firstname-input']) }}
                                                @error('name')
                                                <p class="text-danger">{{$message}}</p>
                                                @enderror
                                            </div>
                                        </div>



                                        <div class="form-group row mb-4">
                                            <label for="horizontal-email-input" class="col-sm-3 col-form-label" name="email">Email</label>
                                            <div class="col-sm-9">
                                                {{ Form::text('email',Auth::user()->email, ['class' => 'form-control' ,'id'=>'horizontal-firstname-input']) }}
                                                @error('email')
                                                <p class="text-danger">{{$message}}</p>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="form-group row justify-content-end">
                                            <div class="col-sm-9">
                                                <div>
                                                    <button type="submit" class="btn btn-primary w-md">Save Changes</button>
                                                </div>
                                            </div>
                                        </div>
                                        {{ Form::close() }}
                                    </div>
                                </div>
                            </div>

                            <div class="tab-pane" id="settings" role="tabpanel">
                                <div class="card">
                                    <div class="card-body">

                                        {!! Form::open([ 'route'=> 'password.change', 'method'=> 'POST']) !!}

                                        <div class="form-group row mb-4">
                                            <label for="horizontal-firstname-input" class="col-sm-3 col-form-label">Current Password</label>
                                            <div class="col-sm-9">
                                                {{ Form::text('current_password', null, ['class' => 'form-control' ,'id'=>'horizontal-firstname-input']) }}
                                                @error('current_password')
                                                <p class="text-danger">{{$message}}</p>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="form-group row mb-4">
                                            <label for="horizontal-email-input" class="col-sm-3 col-form-label" name="email">New Password</label>
                                            <div class="col-sm-9">
                                                {{ Form::text('new_password', null, ['class' => 'form-control' ,'id'=>'horizontal-firstname-input']) }}
                                                @error('new_password')
                                                <p class="text-danger">{{$message}}</p>
                                                @enderror
                                            </div>
                                        </div>


                                        <div class="form-group row justify-content-end">
                                            <div class="col-sm-9">
                                                <div>
                                                    <button type="submit" class="btn btn-primary w-md">Update Password</button>
                                                </div>
                                            </div>
                                        </div>

                                        {{ Form::close() }}
                                    </div>
                                </div>
                            </div>

                            <div class="tab-pane" id="twofactor" role="tabpanel">
                                        <div class="card">
                                            <div class="card-body">
                                                               <p >Two Factor @if(Auth::user()->two_factor=='Y') <div class="alert alert-success" role="alert">Enabled</div>
                                                               @else  <div class="alert alert-warning" role="alert">Disabled</div>
                                                               @endif
                                                               </p>

                                                {!! Form::open([ 'route'=> '2fa.status', 'method'=> 'POST']) !!}
                                                <div class="form-inline mb-4">
                                                <div class="input-group">
                                                    {{ Form::select('two_factor',yesNoOptions(),Auth::user()->two_factor, ['class' => ' form-control']) }}
                                                    <button type="submit" class="btn btn-outline-primary w-md">Save Changes</button>
                                                </div>
                                                </div>
                                                {{ Form::close() }}
                                            </div>
                                        </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

        </div>
        <!-- end row -->
    </div>
    <!-- container-fluid -->


    <script>
        $(document).ready(function(){
            $('a[data-toggle="tab"]').on('show.bs.tab', function(e) {
                localStorage.setItem('activeTab', $(e.target).attr('href'));
            });
            var activeTab = localStorage.getItem('activeTab');
            if(activeTab){
                $('#myTab a[href="' + activeTab + '"]').tab('show');
            }
        });
    </script>

@endsection
