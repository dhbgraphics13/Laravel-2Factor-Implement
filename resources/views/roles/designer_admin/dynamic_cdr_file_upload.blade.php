 <div class="card">
                    <div class="card-body">

                        <!-- start validation messages -->
                        <div class="hidden alert alert-success" id="msg"></div>
                        <div id="hideError" class="alert alert-danger print-error-msg" style="display:none; ">
                            <ul style="list-style: none;"></ul>
                        </div>
                        <!--end  validation messages -->


                         @if( Auth::User()->isDesigner())

                        {!! Form::open([
                                                   'route'        => ['order.printable.file.upload', 'orderId' => $orderID],
                                                   'method'       => 'POST',
                                                   'autocomplete' => 'off',
                                                   'id'           => 'ajax-docs',
                                                   'files'        => 'true',
                                                   'redirectTo'   => route('home'),
                                                   ]) !!}
                         @endif

                           @if( Auth::User()->isAdmin())

                                                 {!! Form::open([
                                                                            'route'        => ['order.printable.file.upload', 'orderId' => $orderID],
                                                                            'method'       => 'POST',
                                                                            'autocomplete' => 'off',
                                                                            'id'           => 'ajax-docs',
                                                                            'files'        => 'true',
                                                                            'redirectTo'   => route('orders.index'),
                                                                            ]) !!}
                                                  @endif



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

                    </div>
                </div>


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
