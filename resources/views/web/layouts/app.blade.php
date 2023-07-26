<!DOCTYPE html>
<html lang="zxx">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <!-- Title -->
    <title>{{ env('APP_NAME') }} - @yield('title') </title>
    <!-- Bootstrap css -->
    <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet" />
    <!-- animate css -->
    <link href="{{ asset('assets/css/animate.min.css') }}" rel="stylesheet" />
    <!-- Fontawesome css -->
    <link href="{{ asset('assets/css/all.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/css/bootstrap-icons.css') }}" rel="stylesheet" />
    <!-- owl.carousel css -->
    <link href="{{ asset('assets/css/owl.carousel.min.css') }}" rel="stylesheet" />
    <!-- owl.theme.default css -->
    <link href="{{ asset('assets/css/owl.theme.default.min.css') }}" rel="stylesheet" />
    <!-- navber css -->
    <link href="{{ asset('assets/css/navber.css') }}" rel="stylesheet" />
    <!-- meanmenu css -->
    <link href="{{ asset('assets/css/meanmenu.css') }}" rel="stylesheet" />
    <!-- Style css -->
    <link href="{{ asset('assets/css/style.css') }}" rel="stylesheet" />
    <!-- Responsive css -->
    <link href="{{ asset('assets/css/responsive.css') }}" rel="stylesheet" />

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.13.2/themes/base/jquery-ui.min.css" />
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('assets/img/favicon.png') }}">
    @stack('header')
    <style>
        .ui-menu .ui-menu-item-wrapper {
            position: relative;
            padding: 0 !important;
        }
        ul.ui-menu{
            width: 350px !important;
            max-height: 500px;
            overflow: auto;
        }
        .ui-menu-item{
            height: 55px;
        }
        .ui-state-active:hover{
            background:transparent;
            color: black;
            border:transparent;
        }
        .ui-menu-item-wrapper> .row{
            margin-left:0;
            margin-right:0
        }
        .ui-state-active>.row:hover div{
            background: #1fba71;
        }
    </style>
</head>


<body>
    <!-- preloader Area -->
    <div class="preloader">
        <div class="d-table">
            <div class="d-table-cell">
                <div class="lds-spinner">
                    <div></div>
                    <div></div>
                    <div></div>
                    <div></div>
                    <div></div>
                    <div></div>
                    <div></div>
                    <div></div>
                    <div></div>
                    <div></div>
                    <div></div>
                    <div></div>
                </div>
            </div>
        </div>
    </div>
    <!-- preloader Area -->
    <div class="ajaxloader" style="display:none;">
        <div class="d-table">
            <div class="d-table-cell">
                <div class="lds-spinner">
                    <div></div>
                    <div></div>
                    <div></div>
                    <div></div>
                    <div></div>
                    <div></div>
                    <div></div>
                    <div></div>
                    <div></div>
                    <div></div>
                    <div></div>
                    <div></div>
                </div>
            </div>
        </div>
    </div>
    <!-- Header Area -->
    @include('web.includes.header')
    <!-- /Header Area -->

    <!-- page content -->
    @yield('content')
    <!-- /page content -->
    <!-- The Modal -->
    <div class="modal common_author" id="common_author-forms">
        <div class="modal-dialog">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">login your account</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <!-- Modal body -->
                <div class="modal-body">
                    <!-- Form Area -->
                    <section id="theme_search_form_tour">
                        <div class="container">
                            <div class="">
                                <div class="">
                                    <div class="">
                                        <div class="theme_common_author_form_tabbtn">
                                            <ul class="nav nav-tabs" role="tablist">
                                                <li class="nav-item " role="presentation">
                                                    <button class="nav-link active" id="login-account-tab"
                                                        data-bs-toggle="tab" data-bs-target="#login-account"
                                                        type="button" role="tab" aria-controls="login-account"
                                                        aria-selected="true"><i class="fas fa-user"></i> Login</button>
                                                </li>
                                                <li class="nav-item" role="presentation">
                                                    <button class="nav-link" id="register-tab" data-bs-toggle="tab"
                                                        data-bs-target="#register" type="button" role="tab"
                                                        aria-controls="register" aria-selected="false"><i
                                                            class="fas fa-edit"></i> Register</button>
                                                </li>
                                                <li class="nav-item " role="presentation">
                                                    <button class="nav-link" id="forgot-password-tab"
                                                        data-bs-toggle="tab" data-bs-target="#forgot-password"
                                                        type="button" role="tab" aria-controls="forgot-password"
                                                        aria-selected="false"><i class="fas fa-user"></i> Forgot Password</button>
                                                </li>

                                            </ul>
                                        </div>
                                        <div class="tab-content" id="myTabContent">
                                            <div class="tab-pane fade active show" id="login-account" role="tabpanel" aria-labelledby="login-account-tab">
                                                <!--  Common Author Area -->
                                                <div id="common_author_area">
                                                    <div class="common_author_boxed">
                                                        <div class="common_author_form">
                                                            <form action="{{ route('web.login.post') }}" id="main_author_form" method="POST">
                                                                @csrf
                                                                <input type="hidden" name="csrfmiddlewaretoken" value="{{ csrf_token() }}">
                                                                <div class="form-group">
                                                                    <input type="text" class="form-control" name="email" placeholder="Enter user name" />
                                                                </div>
                                                                <div class="form-group">
                                                                    <input type="password" class="form-control" name="password" placeholder="Enter password" />
                                                                    <a href="#"  >Forgot password?</a>
                                                                </div>
                                                                <div id="errors-list"></div>
                                                                <div class="common_form_submit">
                                                                    <button type="submit" class="btn btn_theme btn_md">Log in</button>
                                                                </div>
                                                                <div class="have_acount_area">
                                                                    <p>Dont have an account? <a href="#" data-bs-toggle="tab" 
                                                                            data-bs-target="#register" aria-controls="register" >Register now</a>
                                                                    </p>
                                                                </div>
                                                            </form>

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="tab-pane fade" id="register" role="tabpanel" aria-labelledby="register-tab">

                                                <div id="common_author_area">

                                                    <div class="common_author_boxed">

                                                        <div class="common_author_form form_area">


                                                            <form action="#" id="main_author_form_register">
                                                                <div class="form-group">
                                                                    <input type="text" class="form-control" autocomplete="off" name="first_name" id="first_name" placeholder="Enter first name*">
                                                                </div>
                                                                <div class="form-group">
                                                                    <input type="text" class="form-control"  autocomplete="off" name="last_name" id="last_name" placeholder="Enter last name*">
                                                                </div>
                                                                <div class="form-group">
                                                                    <input type="text" class="form-control" autocomplete="off" name="email" id="email" placeholder="Your email address*">
                                                                </div>
                                                                <div class="form-group">
                                                                    <input type="text" class="form-control" autocomplete="off" name="phone" id="phone" placeholder="Mobile number*">
                                                                </div>
                                                                <div class="form-group">
                                                                    <input type="text" class="form-control" autocomplete="off" placeholder="Company Name" name="company_name" id="company_name">
                                                                </div>
                                                                <div class="form-group">
                                                                    <input type="password" class="form-control" autocomplete="new-password" placeholder="Password*" name="password" id="password">
                                                                </div>
                                                                <div class="form-group">
                                                                    <input type="password" class="form-control" autocomplete="off" placeholder="Confirm Password*" name="confirm_password" id="confirm_password">
                                                                </div>
                                                                <div id="reg-errors-list"></div>
                                                                <div class="common_form_submit">
                                                                    <button type="submit" class="btn btn_theme btn_md">Register</button>
                                                                </div>
                                                                <!-- <div class="have_acount_area other_author_option">
                                                                    <div class="line_or">
                                                                        <span>or</span>
                                                                    </div>
                                                                    <ul>
                                                                        <li><a href="#!"><img
                                                                                    src="{{ asset('assets/img/icon/google.png') }}"
                                                                                    alt="icon"></a></li>
                                                                        <li><a href="#!"><img
                                                                                    src="{{ asset('assets/img/icon/facebook.png') }}"
                                                                                    alt="icon"></a></li>
                                                                        <li><a href="#!"><img
                                                                                    src="{{ asset('assets/img/icon/twitter.png') }}"
                                                                                    alt="icon"></a></li>
                                                                    </ul>
                                                                </div> -->
                                                            </form>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>

                                            <div class="tab-pane fade" id="forgot-password" role="tabpanel" aria-labelledby="forgot-password-tab">
                                                <!--  Common Author Area -->
                                                <div id="common_author_area">
                                                    <div class="common_author_boxed">
                                                        <div class="common_author_form">
                                                            <form action="{{ route('web.forgot.password') }}" id="forgot_password_form" method="POST">
                                                                @csrf
                                                                <input type="hidden" name="csrfmiddlewaretoken" value="{{ csrf_token() }}">
                                                                <div class="form-group">
                                                                    <input type="text" class="form-control" name="forgot_email" id="forgot_email" placeholder="Enter your email" />
                                                                </div>
                                                               
                                                                
                                                                <div class="common_form_submit">
                                                                    <button type="submit" id="forgot-button" class="btn btn_theme btn_md">Reset Password </button>
                                                                </div>
                                                                <div class="mt-2" id="forgot-error-list">
                                                                   
                                                                </div>
                                                            </form>

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
                <!-- Modal footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                </div>

            </div>
        </div>
    </div>
    <!-- footer content -->
    @include('web.includes.footer')
    <!-- /footer content -->

    <div class="go-top">
        <i class="fas fa-chevron-up"></i>
        <i class="fas fa-chevron-up"></i>
    </div>

    <script src="{{ asset('assets/js/jquery-3.6.0.min.js') }}"></script>
    <!-- Bootstrap js -->
    <script src="{{ asset('assets/js/bootstrap.bundle.js') }}"></script>
    <!-- Meanu js -->
    <script src="{{ asset('assets/js/jquery.meanmenu.js') }}"></script>
    <!-- owl carousel js -->
    <script src="{{ asset('assets/js/owl.carousel.min.js') }}"></script>
    <!-- wow.js -->
    <script src="{{ asset('assets/js/wow.min.js') }}"></script>
    <!-- Custom js -->
    <script src="{{ asset('assets/js/custom.js') }}"></script>

    <script src="{{ asset('assets/js/jquery-ui.min.js') }}"></script>
    <script src="{{ asset('assets/js/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('assets/js/sweetalert.min.js') }}" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <script>
    window.ROUTES = {
        search_airports: '{{ route("search-airports") }}',
        autocomplete_airports: "{{ route('autocomplete-airports') }}",
        flight_view_details: "{{ route('flight-view-details') }}",
    };

    let one_way_session = '{!! json_encode(Session::get("flight_search_oneway")) !!}';
    one_way_session = JSON.parse(one_way_session);

    let return_session = '{!! json_encode(Session::get("flight_search_return")) !!}';
    return_session = JSON.parse(return_session);

    let multi_session = '{!! json_encode(Session::get("flight_search_multi")) !!}';
    multi_session = JSON.parse(multi_session);

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $("#forgot_password_form").validate({
        rules: {
            forgot_email: 'required'
        },
        messages: {
            forgot_email: 'This field is required'
        },
        errorPlacement: function (error, element) {
            error.appendTo(element.parent("div"));
        },
        submitHandler: function(form, event) {
            event.preventDefault();
            $('#forgot-button').html('<i class="fa fa-spinner fa-spin font-20"></i>');
            $.ajax({
                url: "{{ route('web.forgot.password') }}",
                type: "POST",
                data: {"email" : $('#forgot_email').val()},
                success: function(response) {
                    
                    if (response.status) {
                        $('#forgot-button').html('Mail Send! ');
                        $("#forgot-error-list").html("<div class='alert alert-success'>" + response.message + "</div>");
                    }else{
                        $('#forgot-button').html('Reset Password');
                        $("#forgot-error-list").html("<div class='alert alert-danger'>" + response.message + "</div>");
                    }
                }
            });
            return false;
        }
    });

    $("#main_author_form").validate({
        rules: {
            email: 'required',
            password: 'required'
        },
        messages: {
            email: 'This field is required',
            password: 'This field is required'
        },
        errorPlacement: function (error, element) {
            error.appendTo(element.parent("div"));
        },
        submitHandler: function(form, event) {
            var data = $('#main_author_form').serialize();
            event.preventDefault();
           
            $.ajax({
                url: "{{ route('web.login.post') }}",
                type: "POST",
                data: data,
                processData: false,
                success: function(response) {
                    if (response.status) {
                        window.location.reload();
                    }else{
                        $(".alert").remove();
                        $.each(response.errors, function (key, val) {
                            $("#errors-list").append("<div class='alert alert-danger'>" + val + "</div>");
                        });
                        // $('meta[name="csrf-token"]').attr('content').val(response.token);
                    }
                }
            });
            return false;
        }
    });

    $("#main_author_form_register").validate({
        rules: {
            email: {
                required: true,
                email: true
            },
            first_name:'required',
            last_name:'required',
            phone:'required',
            password: {
                required:true,
                minlength: 6,
            },
            confirm_password: {
                required:true,
                minlength: 6,
                equalTo: "#password"
            }
        },
        messages: {
            password: {
                minlength: "Your password must be at least 6 characters long"
            },
            confirm_password: {
                minlength: "Your password must be at least 6 characters long",
                equalTo: "Please enter the same password as above"
            }
        },
        errorPlacement: function (error, element) {
            error.appendTo(element.parent("div"));
        },
        submitHandler: function(form, event) {
            var data = $('#main_author_form_register').serialize();
            event.preventDefault();
           
            $.ajax({
                url: "{{ route('register.post') }}",
                type: "POST",
                data: data,
                processData: false,
                success: function(response) {
                    if (response.status) {
                        $('#main_author_form_register')[0].reset();
                        $("#reg-errors-list").append("<div class='alert reg-alert alert-success'>" + response.msg + "</div>");
                    }else{
                        $(".reg-alert").remove();
                        $.each(response.msg, function (key, val) {
                            $("#reg-errors-list").append("<div class='alert reg-alert alert-danger'>" + val + "</div>");
                        });
                    }
                }
            });
            return false;
        }
    });
    </script>

    @stack('footer')
</body>

</html>