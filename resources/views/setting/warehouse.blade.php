@extends('layouts.main')
@section('title', 'warehouse')
@section('menu_show', 'menu-open')
@section('s_child_warehouse', 'block')
@section('setting_warehouse', 'active')
@section('main_content')
    <div class="row pt-2">
        <div class="col-12">
            <div class="row">
                <div class="col-6"></div>
                <div class="col-6 text-right my-3">
                    <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#exampleModal"><i
                            class="fa-solid fa-plus px-1"></i>{{ __('Add warehouse') }}</button>
                </div>
                {{-- this is modal for creating warehouse --}}
                <!-- Modal -->
                <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                    aria-hidden="true">
                    <form action="{{ route('warehouse.store') }}" method="post">
                        @csrf
                        <div class="modal-dialog modal-lg" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLongTitle">{{ __('Add warehouse') }}</h5>
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
                                                    value="{{ old('name') }}">
                                                @error('name')
                                                    <p class="invalid-feedback" style="font-size: 1rem">
                                                        {{ $message }}
                                                    </p>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label for="description">Description</label>
                                                <textarea name="description" id="description">{!! old('description') !!}</textarea>
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
                {{-- x this is modal for creating warehouse x --}}
                <div class="col-12">
                    <table id="example1" class="table table-bordered table-hover dataTable dtr-inline"
                        aria-describedby="example2_info">
                        <thead>
                            <tr>
                                <th class="text-center">#</th>
                                <th class="text-center">{{ __('Name') }}</th>
                                <th class="text-center">{{ __('Description') }}</th>
                                <th class="text-center"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($warehouses as $key => $warehouse)
                                <tr>
                                    <td class="text-center">{{ $key + 1 }}</td>
                                    <td class="text-center">{{ $warehouse->name }}</td>
                                    <td class="text-center">{!! $warehouse->description !!}</td>
                                    <td>
                                        <button class="btn-sm btn-primary btn" data-toggle="modal"
                                            data-target="#exampleModal{{ $warehouse->id }}"><i
                                                class="fa-solid fa-pen-to-square px-1"></i>{{ __('Edit') }}</button>

                                        {{-- this is modal for creating warehouse --}}
                                        <!-- Modal -->
                                        <div class="modal fade" id="exampleModal{{ $warehouse->id }}" tabindex="-1"
                                            role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <form action="{{ route('warehouse.update', $warehouse) }}" method="post">
                                                @csrf
                                                @method('PUT')
                                                <div class="modal-dialog modal-lg" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="exampleModalLongTitle">Add warehouse
                                                            </h5>
                                                            <button type="button" class="close"
                                                                data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="row">
                                                                <div class="col-12">
                                                                    <div class="form-group">
                                                                        <label for="exampleInputEmail1">Name <span
                                                                                class="text-danger font-weight-bold px-1">*</span>
                                                                        </label>
                                                                        <input type="text" name="name"
                                                                            class="form-control @error('name') is-invalid @enderror"
                                                                            id="exampleInputEmail1" placeholder="Enter name"
                                                                            value="{{ $warehouse->name }}">
                                                                        @error('name')
                                                                            <p class="invalid-feedback" style="font-size: 1rem">
                                                                                {{ $message }}
                                                                            </p>
                                                                        @enderror
                                                                    </div>
                                                                </div>
                                                                <div class="col-12">
                                                                    <div class="form-group">
                                                                        <label for="description">Description</label>
                                                                        <textarea name="description" id="description{{ $warehouse->id }}">{!! $warehouse->description !!}</textarea>
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
                                                            <button type="button" class="btn btn-secondary"
                                                                data-dismiss="modal">Close</button>
                                                            <button class="btn btn-primary" type="submit"
                                                                onclick="return confirm('Are you sure you want to submit ?');">Submit</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                        {{-- x this is modal for creating warehouse x --}}
                                    </td>
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
                $('#exampleModal').modal('show');
            }
        }
    </script>
    <script>
        CKEDITOR.replace('description');
        @foreach ($warehouses as $warehouse)
            CKEDITOR.replace('description'+{{$warehouse->id}});
        @endforeach
        $(function() {
            $("#example1").DataTable({
                "responsive": true,
                "autoWidth": false,
            });
        });
    </script>
@endsection
