<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <title>Gentelella Alela! |</title>

    <!-- Bootstrap -->
    <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet" />
    <!-- Font Awesome -->
    <link href="{{ asset('assets/css/font-awesome.min.css') }}" rel="stylesheet" />
    <!-- Custom Theme Style -->
    <link href="{{ asset('assets/css/custom.min.css') }}" rel="stylesheet" />
</head>

<body class="login">
    <div>
        <a class="hiddenanchor" id="signup"></a>
        <a class="hiddenanchor" id="signin"></a>

        <div class="login_wrapper">
            <div class="animate form login_form">
                <section class="login_content">
                    <form method="POST" action="{{ route('login') }}">
                        @csrf
                        <h1>{{ __('User Login') }}</h1>
                        <div>
                            <input type="text" class="form-control @error('email') is-invalid @enderror"
                                placeholder="{{ __('Email Address') }}" name="email" value="{{ old('email') }}" required
                                autocomplete="email" autofocus>
                            
                        </div>
                        <div>
                            <input id="password" type="password"
                                class="form-control @error('email') is-invalid @enderror" name="password" required
                                autocomplete="current-password">
                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="text-start">
                            <input class="" type="checkbox" name="remember" id="remember"
                                {{ old('remember') ? 'checked' : '' }}>

                            <label class="form-check-label" for="remember">
                                {{ __('Remember Me') }}
                            </label>
                            
                        </div>
                        <div>
                            
                            <button type="submit" class="btn btn-primary">
                                {{ __('Login') }}
                            </button>
                            <!-- @if (Route::has('password.request'))
                            <a class="btn btn-link" href="{{ route('password.request') }}">
                                {{ __('Forgot Your Password?') }}
                            </a>
                            @endif -->
                        </div>

                        <div class="separator">
                            <div class="clearfix"></div>
                            <br />

                            <div>
                                <h1><i class="fa fa-plane"></i> 5k Travels</h1>
                                <p>© @php echo date('Y'); @endphp All Rights Reserved.</p>
                            </div>
                        </div>
                    </form>
                </section>
            </div>
        </div>
    </div>
</body>

</html>