@extends('layouts.main')
@section('title', 'Add stock')
@section('is_active_stock', 'active')
@section('main_content')
@if($errors->any())
    @dd($errors->all());
@endif
    <div class="row pt-2">
        <div class="col-12" id="app">
            <div class="row">
                <div class="col-6"></div>
                <div class="col-6 text-right my-3">
                    <a href="{{ route('stock.index') }}" class="btn btn-primary btn-sm"><i
                            class="fa-solid fa-eye nav-icon px-1"></i>{{ __('View stock') }}</a>
                </div>
                <div class="col-12">
                    <form action="{{ route('stock.store') }}" method="post">
                        @csrf
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="product_id">{{ __('product') }} <span
                                            class="text-danger font-weight-bold px-1">*</span>
                                    </label>
                                    <select name="product_id" id="product_id"
                                        class="form-control form-control-sm @error('product_id') is-invalid @enderror"
                                        required>
                                        <option value="">{{ __('--select--') }}</option>
                                        @foreach ($products as $product)
                                            <option value="{{ $product->id }}"
                                                {{ old('product_id') == $product->id ? 'selected' : '' }}>
                                                {{ $product->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('product_id')
                                        <p class="invalid-feedback" style="font-size: 1rem">
                                            {{ $message }}
                                        </p>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="manufacturer_id">{{ __('Manufacturer') }} <span
                                            class="text-danger font-weight-bold px-1">*</span>
                                    </label>
                                    <select name="manufacturer_id" id="manufacturer_id"
                                        class="form-control form-control-sm @error('manufacturer_id') is-invalid @enderror"
                                        required>
                                        <option value="">{{ __('--select--') }}</option>
                                        @foreach ($manufacturers as $key => $manufacturer)
                                            <option value="{{ $manufacturer->id }}"
                                                {{ old('$manufacturer') == $manufacturer->id ? 'selected' : '' }}>
                                                {{ $manufacturer->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('manufacturer_id')
                                        <p class="invalid-feedback" style="font-size: 1rem">
                                            {{ $message }}
                                        </p>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="warehouse_id">{{ __('Warehouse') }} <span
                                            class="text-danger font-weight-bold px-1">*</span>
                                    </label>
                                    <select name="warehouse_id" id="warehouse_id"
                                        class="form-control form-control-sm @error('warehouse_id') is-invalid @enderror"
                                        required>
                                        <option value="">{{ __('--select--') }}</option>
                                        @foreach ($warehouses as $warehouse)
                                            <option value="{{ $warehouse->id }}"
                                                {{ config('CONSTANT.DEFAULT_WAREHOUSE_ID') == $warehouse->id ? 'selected' : '' }}>
                                                {{ $warehouse->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('warehouse_id')
                                        <p class="invalid-feedback" style="font-size: 1rem">
                                            {{ $message }}
                                        </p>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="grading_scale_id">{{ __('Grading scale') }} <span
                                            class="text-danger font-weight-bold px-1">*</span>
                                    </label>
                                    <select name="grading_scale_id" id="grading_scale_id"
                                        class="form-control form-control-sm @error('grading_scale_id') is-invalid @enderror select2"
                                        required>
                                        <option value="">{{ __('--select--') }}</option>
                                        @foreach ($grading_scales as $grading_scale)
                                            <option value="{{ $grading_scale->id }}"
                                                {{ old('grading_scale_id') == $grading_scale->id ? 'selected' : '' }}>
                                                {{ $grading_scale->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('grading_scale_id')
                                        <p class="invalid-feedback" style="font-size: 1rem">
                                            {{ $message }}
                                        </p>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="color_id">{{ __('Color') }} <span
                                            class="text-danger font-weight-bold px-1">*</span>
                                    </label>
                                    <select name="color_id" id="color_id"
                                        class="form-control form-control-sm @error('color_id') is-invalid @enderror select2"
                                        required>
                                        <option value="">{{ __('--select--') }}</option>
                                        @foreach ($colors as $color)
                                            <option value="{{ $color->id }}"
                                                {{ old('color_id') == $color->id ? 'selected' : '' }}>
                                                {{ $color->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('color_id')
                                        <p class="invalid-feedback" style="font-size: 1rem">
                                            {{ $message }}
                                        </p>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="carrier_id">{{ __('carrier') }} <span
                                            class="text-danger font-weight-bold px-1">*</span>
                                    </label>
                                    <select name="carrier_id" id="carrier_id"
                                        class="form-control form-control-sm @error('carrier_id') is-invalid @enderror select2"
                                        required>
                                        <option value="">{{ __('--select--') }}</option>
                                        @foreach ($carriers as $carrier)
                                            <option value="{{ $carrier->id }}"
                                                {{ old('carrier_id') == $carrier->id ? 'selected' : '' }}>
                                                {{ $carrier->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('carrier_id')
                                        <p class="invalid-feedback" style="font-size: 1rem">
                                            {{ $message }}
                                        </p>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="status_id">{{ __('Locked status') }} <span
                                            class="text-danger font-weight-bold px-1">*</span>
                                    </label>
                                    <select name="status_id" id="status_id"
                                        class="form-control form-control-sm @error('status_id') is-invalid @enderror select2"
                                        required>
                                        <option value="">{{ __('--select--') }}</option>
                                        @foreach ($statuses as $status)
                                            <option value="{{ $status->id }}"
                                                {{ old('status_id') == $status->id ? 'selected' : '' }}>
                                                {{ $status->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('status_id')
                                        <p class="invalid-feedback" style="font-size: 1rem">
                                            {{ $message }}
                                        </p>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="quantity">{{ __('Quantity') }} <span
                                            class="text-danger font-weight-bold px-1">*</span>
                                    </label>
                                    <input type="number" id="quantity" class="form-control form-control-sm"
                                        value="{{ old('quantity') }}" name="quantity" required>
                                    @error('quantity')
                                        <p class="invalid-feedback" style="font-size: 1rem">
                                            {{ $message }}
                                        </p>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="price">{{ __('Price') }} <span
                                            class="text-danger font-weight-bold px-1">*</span>
                                    </label>
                                    <input type="number" id="price" class="form-control form-control-sm"
                                        value="{{ old('price') }}" name="price" required>
                                    @error('price')
                                        <p class="invalid-feedback" style="font-size: 1rem">
                                            {{ $message }}
                                        </p>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label for="sku">{{ __('SKU') }} <span
                                            class="text-danger font-weight-bold px-1">*</span>
                                    </label>
                                    <input type="number" id="sku" class="form-control form-control-sm"
                                        :class="{ 'is-invalid': check }" value="{{ old('sku') }}" name="sku"
                                        v-on:input="checkSku()" required>
                                    @error('sku')
                                        <p class="invalid-feedback" style="font-size: 1rem">
                                            {{ $message }}
                                        </p>
                                    @enderror
                                    <p class="mb-0 text-danger" v-text="msg"></p>
                                </div>
                            </div>
                            <div class="col-4">
                                <a class="btn btn-sm btn-danger text-white" id="generate_sku"
                                    v-on:click="generateSku()" style="margin-top:30px;">{{ __('Generate Sku') }}</a>
                                    <button id="submit" type="submit" class="btn btn-primary btn-sm"
                                        onclick="return confirm('Are you sure you want to submit ?');" style="margin-top: 28px;"
                                        :disabled="check"><i class="fa-solid fa-eject px-1"></i> Submit</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script src="{{ asset('vue/bundle.js') }}"></script>
    <script>
        new Vue({
            el: "#app",
            data: {
                msg: '',
                check: false
            },
            methods: {
                generateSku: function() {
                    axios.get("{{ route('api.getUniqueSku') }}")
                        .then(function(response) {
                            document.getElementById('sku').value = response.data;
                        })
                        .catch(function(error) {
                            console.log(error);
                            alert("Some Problem Occured");
                        });
                },
                checkSku: function() {
                    let vm = this;
                    var sku = document.getElementById("sku").value;
                    if (sku == '') {
                        vm.msg = '';
                        vm.check = false;
                    } else {
                        axios.get("{{ route('api.checkSku') }}", {
                                params: {
                                    sku: sku
                                }
                            })
                            .then(function(response) {
                                if (response.data == '') {
                                    vm.msg = '';
                                    vm.check = false;
                                } else {
                                    vm.msg = 'SKU already exist';
                                    vm.check = true;
                                }
                            })
                            .catch(function(error) {
                                console.log(error);
                                alert("Some Problem Occured");
                            });
                    }
                }
            },
            mounted() {

            }
        });
    </script>
@endsection
