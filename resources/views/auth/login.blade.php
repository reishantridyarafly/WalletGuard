<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>Log In | Wallet Guard</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="{{ csrf_token() }}" name="csrf-token">
    <!-- App favicon -->
    <link rel="shortcut icon" href="{{ asset('assets') }}/images/favicon.ico">

    <!-- App css -->
    <link href="{{ asset('assets') }}/css/icons.min.css" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets') }}/css/app.min.css" rel="stylesheet" type="text/css" id="light-style" />
    <link href="{{ asset('assets') }}/css/app-dark.min.css" rel="stylesheet" type="text/css" id="dark-style" />

</head>

<body class="loading authentication-bg"
    data-layout-config='{"leftSideBarTheme":"dark","layoutBoxed":false, "leftSidebarCondensed":false, "leftSidebarScrollable":false,"darkMode":false, "showRightSidebarOnStart": true}'>

    <!-- Pre-loader -->
    <div id="preloader">
        <div id="status">
            <div class="bouncing-loader">
                <div></div>
                <div></div>
                <div></div>
            </div>
        </div>
    </div>
    <!-- End Preloader-->


    <div class="account-pages pt-2 pt-sm-5 pb-4 pb-sm-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-xxl-4 col-lg-5">
                    <div class="card">

                        <div class="card-body p-4">

                            <div class="text-center w-75 m-auto">
                                <h4 class="text-dark-50 text-center pb-0 fw-bold">Sign In</h4>
                            </div>

                            <form id="form">
                                <div class="mb-3">
                                    <label for="username" class="form-label">Email / Phone</label>
                                    <input class="form-control" type="text" id="username" name="username" autofocus
                                        placeholder="Enter your email / phone">
                                    <small class="text-danger errorUsername mt-2"></small>
                                </div>

                                <div class="mb-3">
                                    <a href="{{ route('password.request') }}" class="text-muted float-end"><small>Forgot
                                            your
                                            password?</small></a>
                                    <label for="password" class="form-label">Password</label>
                                    <div class="input-group input-group-merge">
                                        <input type="password" id="password" name="password" class="form-control"
                                            placeholder="Enter your password">
                                        <div class="input-group-text" data-password="false">
                                            <span class="password-eye"></span>
                                        </div>
                                    </div>
                                    <small class="text-danger errorPassword mt-2"></small>
                                </div>

                                <div class="mb-3 mb-3">
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input" id="checkbox-signin"
                                            {{ old('remember') ? 'checked' : '' }}>
                                        <label class="form-check-label" for="checkbox-signin">Remember me</label>
                                    </div>
                                </div>

                                <div class="mb-3 mb-0 text-center">
                                    <button class="btn btn-primary" type="submit" id="login"> Log In </button>
                                </div>


                            </form>
                        </div> <!-- end card-body -->
                    </div>
                    <!-- end card -->

                    <div class="row mt-3">
                        <div class="col-12 text-center">
                            <p class="text-muted">Don't have an account? <a href="{{ route('register') }}"
                                    class="text-muted ms-1"><b>Sign Up</b></a></p>
                        </div> <!-- end col -->
                    </div>
                    <!-- end row -->

                </div> <!-- end col -->
            </div>
            <!-- end row -->
        </div>
        <!-- end container -->
    </div>
    <!-- end page -->

    <!-- bundle -->
    <script src="{{ asset('assets') }}/js/vendor.min.js"></script>
    <script src="{{ asset('assets') }}/js/app.min.js"></script>


    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $('#form').submit(function(e) {
                e.preventDefault();
                $.ajax({
                    data: $(this).serialize(),
                    url: "{{ route('login') }}",
                    type: "POST",
                    dataType: 'json',
                    beforeSend: function() {
                        $('#login').attr('disabled', 'disabled');
                        $('#login').text('Process...');
                    },
                    complete: function() {
                        $('#login').removeAttr('disabled');
                        $('#login').html('Login');
                    },
                    success: function(response) {
                        if (response.errors) {
                            $('.errorUsername').html(response.errors.username || '');
                            $('.errorPassword').html(response.errors.password || '');
                        } else if (response.NoUsername || response.NonActiveUsername || response
                            .WrongPassword) {
                            let errorMessage = '';
                            if (response.NoUsername) {
                                errorMessage = response.NoUsername.message;
                            } else if (response.NonActiveUsername) {
                                errorMessage = response.NonActiveUsername.message;
                            } else if (response.WrongPassword) {
                                errorMessage = response.WrongPassword.message;
                            }

                            Swal.fire({
                                icon: 'error',
                                title: 'Validation Failed',
                                text: errorMessage
                            });

                            if (response.NoUsername || response.NonActiveUsername) {
                                $('#username').val('');
                            }
                            if (response.WrongPassword || response.NoUsername || response
                                .NonActiveUsername) {
                                $('#password').val('');
                            }
                        } else {
                            window.location.href = response.redirect;
                        }

                    },
                    error: function(xhr, ajaxOptions, thrownError) {
                        console.error(xhr.status + "\n" + xhr.responseText + "\n" +
                            thrownError);
                    }
                });
            });
        })
    </script>
</body>

</html>
