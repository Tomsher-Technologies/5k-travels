<!DOCTYPE html>
<html lang="zxx">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
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
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('assets/img/favicon.png') }}">
    @stack('header')
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
                                                        aria-selected="true"><i class="fas fa-user"></i>Login</button>
                                                </li>




                                                <li class="nav-item" role="presentation">
                                                    <button class="nav-link" id="register-tab" data-bs-toggle="tab"
                                                        data-bs-target="#register" type="button" role="tab"
                                                        aria-controls="register" aria-selected="false"><i
                                                            class="fas fa-edit"></i>Register</button>
                                                </li>



                                            </ul>
                                        </div>
                                        <div class="tab-content" id="myTabContent">


                                            <div class="tab-pane fade active show" id="login-account" role="tabpanel"
                                                aria-labelledby="login-account-tab">

                                                <!--  Common Author Area -->
                                                <div id="common_author_area">

                                                    <div class="common_author_boxed">

                                                        <div class="common_author_form">
                                                            <form action="{{route('login')}}" id="main_author_form" method="POST">
                                                                @csrf
                                                                <div class="form-group">
                                                                    <input type="text" class="form-control" name="email" placeholder="Enter user name" />
                                                                </div>
                                                                <div class="form-group">
                                                                    <input type="password" class="form-control" name="password" placeholder="Enter password" />
                                                                    <a href="forgot-password.html">Forgot password?</a>
                                                                </div>
                                                                <div class="common_form_submit">
                                                                    <button type="submit" class="btn btn_theme btn_md">Log in</button>
                                                                </div>
                                                                <div class="have_acount_area">
                                                                    <p>Dont have an account? <a href="#register"
                                                                            data-bs-toggle="modal"
                                                                            data-bs-target="#register">Register now</a>
                                                                    </p>
                                                                </div>
                                                            </form>

                                                        </div>
                                                    </div>
                                                </div>

                                            </div>


                                            <div class="tab-pane fade" id="register" role="tabpanel"
                                                aria-labelledby="register-tab">

                                                <div id="common_author_area">

                                                    <div class="common_author_boxed">

                                                        <div class="common_author_form">


                                                            <form action="#" id="main_author_form">
                                                                <div class="form-group">
                                                                    <input type="text" class="form-control"
                                                                        placeholder="Enter first name*">
                                                                </div>
                                                                <div class="form-group">
                                                                    <input type="text" class="form-control"
                                                                        placeholder="Enter last name*">
                                                                </div>
                                                                <div class="form-group">
                                                                    <input type="text" class="form-control"
                                                                        placeholder="your email address (Optional)">
                                                                </div>
                                                                <div class="form-group">
                                                                    <input type="text" class="form-control"
                                                                        placeholder="Mobile number*">
                                                                </div>
                                                                <div class="form-group">
                                                                    <input type="text" class="form-control"
                                                                        placeholder="User name*">
                                                                </div>
                                                                <div class="form-group">
                                                                    <input type="password" class="form-control"
                                                                        placeholder="Password">
                                                                </div>
                                                                <div class="common_form_submit">
                                                                    <button
                                                                        class="btn btn_theme btn_md">Register</button>
                                                                </div>
                                                                <div class="have_acount_area other_author_option">
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

    <script src="{{ asset('assets/js/jquery.validate.min.js') }}"></script>

    <script>
    window.ROUTES = {
        search_airports: '{{ route("search-airports") }}',

    };

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
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
        submitHandler: function(form) {
            // form.submit();
            var data = new FormData($('#main_author_form')[0]);
            $.ajax({
                url: "{{ route('login')}}",
                type: "POST",
                data: data,
                success: function(response) {
                    
                }
            });

        }
    });
    </script>

    @stack('footer')
</body>

</html>