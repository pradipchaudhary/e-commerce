@extends('layouts.main')
@section('title', 'Shipping')
@section('menu_show', 'menu-open')
@section('setting_shipping', 'active')
@section('main_content')
    <div class="row pt-2">
        <div class="col-12">
            <div class="row">
                <div class="col-6"></div>
                <div class="col-6 text-right my-3">
                    <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#shippingTarget"><i
                            class="fa-solid fa-plus px-1"></i>{{ __('Add shipping') }}</button>
                </div>
                {{-- this is modal for creating shipping --}}
                <!-- Modal -->
                {{-- <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                    aria-hidden="true">
                    <form action="{{ route('shipping.freeShippingEdit') }}" method="post">
                        @csrf
                        <div class="modal-dialog modal-lg" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLongTitle">{{ __('Edit shipping') }}</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label for="exampleInputEmail1">Quantity <span
                                                        class="text-danger font-weight-bold px-1">*</span> </label>
                                                <input type="number" name="quantity"
                                                    class="form-control @error('quantity') is-invalid @enderror"
                                                    id="exampleInputEmail1" placeholder="Enter quantity"
                                                    value="{{ $shippings->whereNull('name')->first()->quantity ?? 0 }}"
                                                    required>
                                                @error('quantity')
                                                    <p class="invalid-feedback" style="font-size: 1rem">
                                                        {{ $message }}
                                                    </p>
                                                @enderror
                                            </div>
                                        </div>
                                        
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label for="description">Description</label>
                                                <textarea name="description" id="description">{{ $shippings->whereNull('name')->first()->description ?? '' }}</textarea>
                                                @error('description')
                                                    <p class="invalid-feedback" style="font-size: 1rem">
                                                        {{ $message }}
                                                    </p>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    <button class="btn btn-primary" type="submit"
                                        onclick="return confirm('Are you sure you want to submit ?');">Submit</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div> --}}
                {{-- x this is modal for creating shipping x --}}
                <!-- Modal -->
                <div class="modal fade" id="shippingTarget" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                    aria-hidden="true">
                    <form action="{{ route('shipping.store') }}" method="post">
                        @csrf
                        <div class="modal-dialog modal-lg" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLongTitle">{{ __('Edit shipping') }}</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label for="exampleInputEmail1">Name <span
                                                        class="text-danger font-weight-bold px-1">*</span> </label>
                                                <input type="text" name="name"
                                                    class="form-control @error('name') is-invalid @enderror"
                                                    id="exampleInputEmail1" placeholder="Enter name"
                                                    value="{{ old('name') }}" required>
                                                @error('name')
                                                    <p class="invalid-feedback" style="font-size: 1rem">
                                                        {{ $message }}
                                                    </p>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label for="exampleInputEmail1">Price <span
                                                        class="text-danger font-weight-bold px-1">*</span> </label>
                                                <input type="number" name="cost"
                                                    class="form-control @error('cost') is-invalid @enderror"
                                                    value="{{ old('cost') }}" required step="0.1">
                                                @error('cost')
                                                    <p class="invalid-feedback" style="font-size: 1rem">
                                                        {{ $message }}
                                                    </p>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label for="exampleInputEmail1">Free shipping if Quantity is above  </label>
                                                <input type="number" name="quantity"
                                                    class="form-control @error('quantity') is-invalid @enderror"
                                                    id="exampleInputEmail1" placeholder="Enter quantity"
                                                    value="{{ old('quantity') ?? 0 }}" required>
                                                @error('quantity')
                                                    <p class="invalid-feedback" style="font-size: 1rem">
                                                        {{ $message }}
                                                    </p>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label for="description">Description</label>
                                                <textarea name="description" class="form-control">{{ old('description') }}</textarea>
                                                @error('description')
                                                    <p class="invalid-feedback" style="font-size: 1rem">
                                                        {{ $message }}
                                                    </p>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    <button class="btn btn-primary" type="submit"
                                        onclick="return confirm('Are you sure you want to submit ?');">Submit</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                {{-- x this is modal for creating shipping x --}}
                {{-- free shipping div --}}
                {{-- <div class="col-12">
                    <div class="alert alert-info alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        <h5><i class="fa-solid fa-bullhorn"></i></h5>
                        {{ __('Free shipping above ') }} {{ $shippings->whereNull('name')->first()->quantity ?? 0 }}
                        Quantity <a class="btn btn-sm btn-primary" data-toggle="modal" data-target="#exampleModal"> <i
                                class="fa-solid fa-pen-to-square px-1"></i> Edit</a>
                    </div>
                </div> --}}
                {{-- end of free shippimg div --}}
                <div class="col-12">
                    <table id="example1" class="table table-bordered table-hover dataTable dtr-inline"
                        aria-describedby="example2_info">
                        <thead>
                            <tr>
                                <th class="text-center">#</th>
                                <th class="text-center">{{ __('Name') }}</th>
                                <th class="text-center">{{ __('price') }}</th>
                                <th class="text-center">{{ __('Free shipping if Quantity is above') }}</th>
                                <th class="text-center">{{ __('Description') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($shippings->whereNotNull('name')->values() as $key => $shipping)
                                <tr>
                                    <td class="text-center">{{ $key + 1 }}</td>
                                    <td class="text-center">{{ $shipping->name }}</td>
                                    <td class="text-center">{{ $shipping->cost . ' $' }}</td>
                                    <td class="text-center">{{ $shipping->quantity }}</td>
                                    <td class="text-center">{{ $shipping->description }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script>
        window.onload = function() {
            if ({{ $errors->any() }}) {
                $('#shippingTarget').modal('show');
            }
        }
    </script>
    <script>
        $(function() {
            $("#example1").DataTable({
                "responsive": true,
                "autoWidth": false,
            });
        });
    </script>
@endsection
