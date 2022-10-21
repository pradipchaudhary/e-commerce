@extends('layouts.main')
@section('title', 'User')
@section('is_active_user', 'active')
@section('main_content')

    <div class="card text-sm ">
        <div class="card-header my-2">
            <div class="row my-1">
                <div class="col-md-6" style="margin-bottom:-5px;">
                    <p class="">{{ __('User list') }}</p>
                </div>
                <div class="
                        col-md-6 text-right">
                    <a class="btn text-white btn-sm btn-primary" data-toggle="modal" data-target="#modal-lg">
                        {{ __('Add user') }}</a>
                </div>
            </div>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
            <table id="example1" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th class="text-center">{{ __('S.no') }}</th>
                        <th class="text-center">{{ __('User') }}</th>
                        <th class="text-center">{{ __('E-mail') }}</th>
                        <th class="text-center"></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $key => $user)
                        <tr>
                            <td class="text-center">{{ $key + 1 }}</td>
                            <td class="text-center">{{ $user->name }}
                            <td class="text-center">{{ $user->email }}</td>
                            <td class="text-center">
                                <a data-toggle="modal" data-target="#modal-lg{{ $user->id }}"
                                    class="btn btn-danger mx-1 btn-sm text-white"><i class="fas fa-key px-1"></i>
                                    {{ __('Change Password') }}</a>

                                {{-- change password moadl --}}
                                <div class="modal fade text-sm" id="modal-lg{{$user->id}}">
                                    <div class="modal-dialog modal-xl">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="">{{ __('Add User') }}</h5>
                                                <button type=" button" class="close" data-dismiss="modal"
                                                    aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <form method="post" action="{{ route('user.update',$user) }}">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="row">
                                                        <div class="col-4">
                                                            <div class="input-group input-group-sm">
                                                                <div class="input-group-prepend">
                                                                    <span class="input-group-text">
                                                                        {{ __('Password') }} <span
                                                                            class="text-danger px-1 font-weight-bold">*</span>
                                                                    </span>
                                                                </div>
                                                                <input type="password" value="{{ old('password') }}"
                                                                    name="password"
                                                                    class="form-control  @error('password') is-invalid @enderror">
                                                                @error('password')
                                                                    <p class="invalid-feedback" style="font-size: 1rem">
                                                                        {{ __('Password field is required') }}
                                                                    </p>
                                                                @enderror
                                                            </div>
                                                        </div>
                                                        <div class="col-4">
                                                            <div class="input-group input-group-sm">
                                                                <div class="input-group-prepend">
                                                                    <span class="input-group-text">
                                                                        {{ __('Confirm password') }} <span
                                                                            class="text-danger px-1 font-weight-bold">*</span>
                                                                    </span>
                                                                </div>
                                                                <input type="text"
                                                                    value="{{ old('password_confirmation') }}"
                                                                    name="password_confirmation"
                                                                    class="form-control  @error('password_confirmation') is-invalid @enderror">
                                                                @error('password_confirmation')
                                                                    <p class="invalid-feedback" style="font-size: 1rem">
                                                                        {{ __('Password didnot match') }}
                                                                    </p>
                                                                @enderror
                                                            </div>
                                                        </div>
                                                        <div class="col-2">
                                                            <button type="submit" class="btn btn-primary btn-sm"><i
                                                                    class="fas fa-plus px-1"></i>
                                                                Submit</button>
                                                        </div>
                                                    </div>

                                                </form>
                                            </div>
                                            <div class="modal-footer justify-content-between">
                                                <button type="button" class="btn btn-default"
                                                    data-dismiss="modal">Close</button>
                                            </div>
                                        </div>
                                        <!-- /.modal-content -->
                                    </div>
                                    <!-- /.modal-dialog -->
                                </div>
                            </td>
                        </tr>
                    @endforeach
            </table>
        </div>
        <!-- /.card-body -->
    </div>

    {{-- modal for adding user status --}}
    <div class="modal fade text-sm" id="modal-lg">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="">{{ __('Add User') }}</h5>
                    <button type=" button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="post" action="{{ route('user.store') }}">
                        @csrf
                        <div class="row">
                            <div class="col-4">
                                <div class="input-group input-group-sm">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            {{ __('name') }} <span class="text-danger px-1 font-weight-bold">*</span>
                                        </span>
                                    </div>
                                    <input type="text" value="{{ old('name') }}" name="name"
                                        class="form-control  @error('name') is-invalid @enderror">
                                    @error('name')
                                        <p class="invalid-feedback" style="font-size: 1rem">
                                            {{ __('name field is required') }}
                                        </p>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="input-group input-group-sm">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            {{ __('E-MAIL') }} <span class="text-danger px-1 font-weight-bold">*</span>
                                        </span>
                                    </div>
                                    <input type="email" value="{{ old('email') }}" name="email"
                                        class="form-control  @error('email') is-invalid @enderror">
                                    @error('email')
                                        <p class="invalid-feedback" style="font-size: 1rem">
                                            {{ __('E-mail field is required') }}
                                        </p>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-4">
                                <div class="input-group input-group-sm">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            {{ __('Password') }} <span class="text-danger px-1 font-weight-bold">*</span>
                                        </span>
                                    </div>
                                    <input type="password" value="{{ old('password') }}" name="password"
                                        class="form-control  @error('password') is-invalid @enderror">
                                    @error('password')
                                        <p class="invalid-feedback" style="font-size: 1rem">
                                            {{ __('Password field is required') }}
                                        </p>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-4 my-2">
                                <div class="input-group input-group-sm">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            {{ __('Confirm password') }} <span
                                                class="text-danger px-1 font-weight-bold">*</span>
                                        </span>
                                    </div>
                                    <input type="text" value="{{ old('password_confirmation') }}"
                                        name="password_confirmation"
                                        class="form-control  @error('password_confirmation') is-invalid @enderror">
                                    @error('password_confirmation')
                                        <p class="invalid-feedback" style="font-size: 1rem">
                                            {{ __('Password didnot match') }}
                                        </p>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-4 my-2">
                                <button type="submit" class="btn btn-primary btn-sm"><i class="fas fa-plus px-1"></i>
                                    Submit</button>
                            </div>
                        </div>

                    </form>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    {{-- end of modal for adding user status --}}
@endsection

@section('scripts')
    <script>
        $(function() {
            $("#example1").DataTable({
                "responsive": true,
                "autoWidth": false,
            });
        });
    </script>
    <script>
        window.onload = function() {
            if ({{ $errors->any() }}) {
                $('#modal-lg').modal('show');
            }
        }
    </script>
@endsection
