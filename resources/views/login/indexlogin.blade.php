<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="shortcut icon" href="{{ asset('template/assets/images/favicon.svg') }}" type="image/x-icon" />
    <title>Sign In | Absensi App</title>

    <!-- ========== All CSS files linkup ========= -->
    <link rel="stylesheet" href="{{ asset('template/assets/css/bootstrap.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('template/assets/css/lineicons.css') }}" />
    <link rel="stylesheet" href="{{ asset('template/assets/css/materialdesignicons.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('template/assets/css/fullcalendar.css') }}" />
    <link rel="stylesheet" href="{{ asset('template/assets/css/main.css') }}" />
</head>

<body>
    <!-- ========== signin-section start ========== -->
    <section class="signin-section">
        <div class="container-fluid">
            <div class="row g-0 auth-row min-vh-100 d-flex align-items-center justify-content-center p-5">
                <div class="col-lg-6">
                    <div class="auth-cover-wrapper bg-primary-100">
                        <div class="auth-cover">
                            <div class="title text-center">
                                <h1 class="text-primary mb-10">Welcome To TimeARC </h1>
                                <p class="text-medium">Sign in to your account</p>
                            </div>
                            <div class="cover-image">
                                <img src="{{ asset('template/assets/images/auth/signin-image.svg') }}" alt="Signin Image" />
                            </div>
                            <div class="shape-image">
                                <img src="{{ asset('template/assets/images/auth/shape.svg') }}" alt="Shape" />
                            </div>
                        </div>
                    </div>
                </div>
                <!-- end col -->

                <div class="col-lg-6">
                    <div class="signin-wrapper">
                        <div class="form-wrapper">
                            <h6 class="mb-15">Sign In</h6>
                            <p class="text-sm mb-25">
                                Please enter your credentials to continue.
                            </p>

                            <!-- Login Form -->
                            <form method="POST" action="{{ route('login') }}">
                                @csrf

                                <!-- Email -->
                                <div class="input-style-1">
                                    <label for="email">Email</label>
                                    <input type="email" name="email" id="email" placeholder="Email" required autofocus
                                        value="{{ old('email') }}" />
                                    @error('email')
                                        <div class="text-danger mt-1">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Password -->
                                <div class="input-style-1">
                                    <label for="password">Password</label>
                                    <input type="password" name="password" id="password" placeholder="Password" required />
                                    @error('password')
                                        <div class="text-danger mt-1">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Remember me -->
                                <div class="form-check checkbox-style mb-30">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember">
                                    <label class="form-check-label" for="remember">
                                        Remember Me
                                    </label>
                                </div>

                                <!-- Submit button -->
                                <div class="button-group d-flex justify-content-center flex-wrap">
                                    <button type="submit" class="main-btn primary-btn btn-hover w-100 text-center">
                                        Sign In
                                    </button>
                                </div>

                            </form>

                            <!-- Footer -->
                            <div class="singin-option pt-40">
                                <p class="text-sm text-medium text-center text-gray">Don't have an account?</p>
                                <p class="text-sm text-medium text-dark text-center">
                                    <a href="#">Create an account</a>
                                </p>
                                <div class="text-center mt-3">
                                    <a href="#" class="hover-underline">
                                        Forgot Password?
                                    </a>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                <!-- end col -->
            </div>
            <!-- end row -->
        </div>
    </section>


    <!-- ========== signin-section end ========== -->
    <script src="{{ asset('template/assets/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('template/assets/js/Chart.min.js') }}"></script>
    <script src="{{ asset('template/assets/js/main.js') }}"></script>
</body>

</html>
