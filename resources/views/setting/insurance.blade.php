@extends('layouts.main')
@section('title', 'Insurance')
@section('menu_show', 'menu-open')
@section('setting_insurance', 'active')
@section('main_content')
    <div class="row pt-2">
        <div class="col-12">
            <div class="row">
                <div class="col-6"></div>
                <div class="col-12 my-4">
                    <table id="example1" class="table table-bordered table-hover dataTable dtr-inline"
                        aria-describedby="example2_info">
                        <thead>
                            <tr>
                                <th class="text-center">#</th>
                                <th class="text-center">{{ __('status') }}</th>
                                <th class="text-center">{{ __('percentage') }}</th>
                                <th class="text-center">{{ __('Description') }}</th>
                                <th class="text-center"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($insurances as $key => $insurance)
                                <tr>
                                    <td class="text-center">{{ $key + 1 }}</td>
                                    <td class="text-center">{{ $insurance->status ? 'yes' : 'no' }}</td>
                                    <td class="text-center">{{ $insurance->percent . '%' }}</td>
                                    <td class="text-center">{!! $insurance->description !!}</td>
                                    <td>
                                        <button class="btn-sm btn-primary btn" data-toggle="modal"
                                            data-target="#exampleModal{{ $insurance->id }}"><i
                                                class="fa-solid fa-pen-to-square px-1"></i>{{ __('Edit') }}</button>

                                        {{-- this is modal for creating insurance --}}
                                        <!-- Modal -->
                                        <div class="modal fade" id="exampleModal{{ $insurance->id }}" tabindex="-1"
                                            role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <form action="{{ route('insurance.update', $insurance) }}" method="post">
                                                @csrf
                                                @method('PUT')
                                                <div class="modal-dialog modal-lg" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="exampleModalLongTitle">Add insurance
                                                            </h5>
                                                            <button type="button" class="close" data-dismiss="modal"
                                                                aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="row">
                                                                @if ($insurance->status)
                                                                    <div class="col-12">
                                                                        <div class="form-group">
                                                                            <label for="exampleInputEmail1">Percentage <span
                                                                                    class="text-danger font-weight-bold px-1">*</span>
                                                                            </label>
                                                                            <input type="number" step="0.1"
                                                                                name="percent"
                                                                                class="form-control @error('percent') is-invalid @enderror"
                                                                                id="exampleInputEmail1"
                                                                                placeholder="Enter percent"
                                                                                value="{{ $insurance->percent }}">
                                                                            @error('percent')
                                                                                <p class="invalid-feedback"
                                                                                    style="font-size: 1rem">
                                                                                    {{ $message }}
                                                                                </p>
                                                                            @enderror
                                                                        </div>
                                                                    </div>
                                                                @endif
                                                                <div class="col-12">
                                                                    <div class="form-group">
                                                                        <label for="description">Description</label>
                                                                        <textarea name="description" class="form-control form-control-sm">{{ $insurance->description }}</textarea>
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
                                        {{-- x this is modal for creating insurance x --}}
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
        $(function() {
            $("#example1").DataTable({
                "responsive": true,
                "autoWidth": false,
            });
        });
    </script>
@endsection
