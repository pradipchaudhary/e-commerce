<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>LOGIN</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('plugins/fontawesome-free/css/all.min.css') }}">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- icheck bootstrap -->
    <link rel="stylesheet" href="{{ asset('plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('dist/css/adminlte.min.css') }}">
    <link rel="stylesheet" href="{{ asset('dist/css/custom.css') }}">
    <!-- Google Font: Source Sans Pro -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">

</head>

<body class="hold-transition login-page">
    @include('sweetalert::alert')
    <div class="login-box">

        <!-- /.login-logo -->
        <div class="card">
            <div class="card-body">
                <div class="login-logo text-center">
                    <h2> Create an account</h2>
                    <img src="{{ asset('logo.png') }}" alt="">
                </div>
                <div class="row" id="app">
                    <div class="col-12">
                        <form method="POST" action="{{ route('register') }}">
                            @csrf
                            <div class="input-group mb-3">
                                <input type="text" id="name" name="name"
                                    class="form-control @error('name') is-invalid @enderror" placeholder="First name *"
                                    value="{{ old('name') }}" required autocomplete="name" autofocus>
                                <div class="input-group-append">
                                    <div class="input-group-text">
                                        <span class="fas fa-envelope"></span>
                                    </div>
                                </div>
                            </div>
                            @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                            <div class="input-group mb-3">
                                <input type="text" id="last_name" name="last_name"
                                    class="form-control @error('last_name') is-invalid @enderror"
                                    placeholder="Last name *" value="{{ old('last_name') }}" required
                                    autocomplete="last_name" autofocus>
                                <div class="input-group-append">
                                    <div class="input-group-text">
                                        <span class="fas fa-envelope"></span>
                                    </div>
                                </div>
                            </div>
                            @error('last_name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                            <div class="input-group mb-3">
                                <input type="text" id="business_name" name="business_name"
                                    class="form-control @error('business_name') is-invalid @enderror"
                                    placeholder="Business name *" value="{{ old('business_name') }}" required
                                    autocomplete="business_name" autofocus>
                                <div class="input-group-append">
                                    <div class="input-group-text">
                                        <span class="fas fa-envelope"></span>
                                    </div>
                                </div>
                            </div>
                            @error('business_name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                            
                            <div class="input-group" :class="{ 'mb-3': check }">
                                <input v-model="email" type="email" id="email" name="email"
                                    class="form-control @error('email') is-invalid @enderror" placeholder="email"
                                    value="{{ old('email') }}" required autocomplete="email"
                                    v-on:keyup="checkEmail()" autofocus>
                                <div class="input-group-append">
                                    <div class="input-group-text">
                                        <span class="fas fa-envelope"></span>
                                    </div>
                                </div>
                            </div>
                            @error('email')
                                <span class="invalid-feedback" role="alert" v-text="msg">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                            <span class="text-danger mb-3" v-if="msg != ''">@{{ msg }} <a
                                    class="text-primary" data-toggle="modal" data-target="#exampleModal" style="cursor: pointer;">Click
                                    here</a> if you forget your password</span>
                            <div class="input-group mb-3">
                                <input type="password" class="form-control @error('password') is-invalid @enderror"
                                    placeholder="Password" name="password" required autocomplete="current-password">
                                <div class="input-group-append">
                                    <div class="input-group-text">
                                        <span class="fas fa-lock"></span>
                                    </div>
                                </div>
                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="input-group mb-3">
                                <input type="password"
                                    class="form-control @error('password_confirmation') is-invalid @enderror"
                                    placeholder="Confirm password *" name="password_confirmation" required>
                                <div class="input-group-append">
                                    <div class="input-group-text">
                                        <span class="fas fa-lock"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12 mt-2">
                                    <button type="submit" class="btn btn-primary btn-block" id="button">Sign In</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- /.login-card-body -->
        </div>

        {{-- this is modal for email --}}
        <!-- Modal -->
        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Email</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="{{ route('forgetPassword') }}" method="post">
                        <div class="modal-body">
                            @csrf
                            <div class="form-group">
                                <label for="forget_email">{{ __('Email') }} <span
                                        class="text-danger font-weight-bold px-1">*</span>
                                </label>
                                <input type="email" name="forget_email" id="foregt_email" class="form-control">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- /.login-box -->

    <!-- jQuery -->
    <script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
    <!-- Bootstrap 4 -->
    <script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <!-- AdminLTE App -->
    <script src="{{ asset('dist/js/adminlte.min.js') }}"></script>
    <script src="{{ asset('vue/bundle.js') }}"></script>
    <script>
        new Vue({
            el: "#app",
            data: {
                email: '{{ old('email') }}',
                msg: '',
                check: true
            },
            methods: {
                checkEmail: function() {
                    let vm = this;
                    button = document.getElementById('button');
                    mailformat = "/^w+([.-]?w+)*@w+([.-]?w+)*(.w{2,3})+$/";
                    // if (vm.email.match(mailformat)) {
                    axios.get("{{ route('api.checkEmail') }}", {
                            params: {
                                email: vm.email
                            }
                        })
                        .then(function(response) {
                            console.log(response.data);
                            vm.msg = response.data;
                            if (vm.msg != '') {
                                vm.check = false;
                                button.disabled = true;
                            } else {
                                button.disabled = false;
                            }
                        })
                        .catch(function(error) {
                            console.log(error);
                            alert("Some Problem Occured");
                        });
                    // }
                }
            },
            mounted() {

            }
        });
    </script>
</body>

</html>
