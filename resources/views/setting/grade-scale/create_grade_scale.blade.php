@extends('layouts.main')
@section('title', 'Add Grade scale')
@section('menu_show', 'menu-open')
@section('s_child_grade', 'block')
@section('setting_grade_scale', 'active')
@section('main_content')
    <div class="row pt-2">
        <div class="col-12">
            <div class="row">
                <div class="col-6"></div>
                <div class="col-6 text-right my-2">
                    <a href="{{ route('grade-scale.index') }}" class="btn btn-primary btn-sm"><i
                            class="fa-solid fa-eye px-1"></i>{{ __('Grade scale') }}</a>
                </div>
                {{-- this is modal for creating grade --}}
                <div class="col-12" id="app">
                    <form action="{{route('grade-scale.store')}}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="grade_id">Grade <span class="text-danger font-weight-bold px-1">*</span>
                                    </label>
                                    <select name="grade_id" id="grade_id" class="form-control form-control-sm @error('grade_id') is-invalid @enderror" required>
                                        <option value="">{{ __('--select--') }}</option>
                                        @foreach ($grades as $grade)
                                            <option value="{{ $grade->id }}">{{ $grade->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('grade_id')
                                        <p class="invalid-feedback" style="font-size: 1rem">
                                            {{ $message }}
                                        </p>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-6 ">
                                <div class="form-group">
                                    <label for="name">Name
                                    </label>
                                    <input type="text"
                                        class="form-control form-control-sm @error('name') is-invalid @enderror" name="name"
                                        id="name" value="{{ old('name') }}">
                                    @error('name')
                                        <p class="invalid-feedback" style="font-size: 1rem">
                                            {{ $message }}
                                        </p>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-6 primary">
                                <div class="form-group">
                                    <label for="apperance">Apperance
                                    </label>
                                    <input type="text"
                                        class="form-control form-control-sm @error('apperance') is-invalid @enderror"
                                        name="apperance" id="apperance" value="{{ old('apperance') }}">
                                    @error('apperance')
                                        <p class="invalid-feedback" style="font-size: 1rem">
                                            {{ $message }}
                                        </p>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="apperance">screen <span class="text-danger font-weight-bold px-1">*</span>
                                    </label>
                                    <input type="text"
                                        class="form-control form-control-sm @error('screen') is-invalid @enderror"
                                        name="screen" id="screen" value="{{ old('screen') }}">
                                    @error('screen')
                                        <p class="invalid-feedback" style="font-size: 1rem">
                                            {{ $message }}
                                        </p>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-6 primary">
                                <div class="form-group">
                                    <label for="other">other <span class="text-danger font-weight-bold px-1">*</span>
                                    </label>
                                    <input type="text"
                                        class="form-control form-control-sm @error('other') is-invalid @enderror"
                                        name="other" id="other" value="{{ old('other') }}">
                                    @error('other')
                                        <p class="invalid-feedback" style="font-size: 1rem">
                                            {{ $message }}
                                        </p>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-6 secondary">
                                <div class="form-group">
                                    <label for="lcd">lcd <span class="text-danger font-weight-bold px-1">*</span>
                                    </label>
                                    <input type="text"
                                        class="form-control form-control-sm @error('lcd') is-invalid @enderror" name="lcd"
                                        id="lcd" value="{{ old('lcd') }}">
                                    @error('lcd')
                                        <p class="invalid-feedback" style="font-size: 1rem">
                                            {{ $message }}
                                        </p>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-12 primary">
                                <div class="form-group">
                                    <label for="bezel">Housing/Bezel
                                    </label>
                                    <textarea name="bezel" id="bezel"></textarea>
                                    @error('bezel')
                                        <p class="invalid-feedback" style="font-size: 1rem">
                                            {{ $message }}
                                        </p>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-12 secondary">
                                <div class="form-group">
                                    <label for="functionality">
                                        Functionality:
                                    </label>
                                    <textarea name="functionality" id="functionality"></textarea>
                                    @error('functionality')
                                        <p class="invalid-feedback" style="font-size: 1rem">
                                            {{ $message }}
                                        </p>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="image">Images <span class="text-danger font-weight-bold px-1">*</span>
                                    </label>
                                    <input type="file"
                                        class="form-control form-control-sm @error('image') is-invalid @enderror"
                                        name="image[]" id="image" multiple>
                                    @error('image')
                                        <p class="invalid-feedback" style="font-size: 1rem">
                                            {{ $message }}
                                        </p>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-6 mb-2">
                                <button type="submit" class="btn btn-primary btn-sm "
                                    onclick="return confirm('Are you sure you want to Submit ? ');"><span class="px-1"><i class="fa-solid fa-eject"></i></span> Submit</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script>
        CKEDITOR.replace('bezel');
        CKEDITOR.replace('functionality');
    </script>
    <script>
        $(function() {
            $(".secondary").css("display", "none");
            $("#grade_id").on("change", function() {
                grade_id = $("#grade_id").val();
                if (grade_id == '') {
                    alert("Please select grade");
                    $(".primary").css("display", "none");
                    $(".secondary").css("display", "none");
                } else {
                    if (grade_id == 1) {
                        $(".secondary").css("display", "none");
                        $(".primary").css("display", "");
                    } else {
                        $(".primary").css("display", "none");
                        $(".secondary").css("display", "");
                    }
                }
            });
        });
    </script>
@endsection
