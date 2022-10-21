@extends('layouts.main')
@section('title', 'Stock')
@section('is_active_stock', 'active')
@section('main_content')
    <div class="row pt-2" id="app">
        <div class="col-12">
            <div class="row">
                <div class="col-12 card p-3">
                    <div class="row">
                        <div class="col-3">
                            <div class="form-group">
                                <label for="product_id">{{ __('product') }}
                                </label>
                                <select v-model="data.product_id" name="product_id" id="product_id"
                                    class="form-control form-control-sm @error('product_id') is-invalid @enderror">
                                    <option value="">{{ __('--Select--') }}</option>
                                    <option :value="product.id" v-for="(product,key) in products" v-text="product.name">
                                    </option>
                                </select>
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="form-group">
                                <label for="grading_scale_id">{{ __('Grade scale') }}
                                </label>
                                <select name="grading_scale_id" id="grading_scale_id" v-model="data.grading_scale_id"
                                    class="form-control form-control-sm @error('grading_scale_id') is-invalid @enderror">
                                    <option value="">{{ __('--Select--') }}</option>
                                    <option :value="grading_scale.id" v-for="(grading_scale,key) in grading_scales"
                                        v-text="grading_scale.name"></option>
                                </select>
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="form-group">
                                <label for="color_id">{{ __('color') }}
                                </label>
                                <select name="color_id" id="color_id" v-model="data.color_id"
                                    class="form-control form-control-sm @error('color_id') is-invalid @enderror">
                                    <option value="">{{ __('--Select--') }}</option>
                                    <option :value="color.id" v-for="(color,key) in colors" v-text="color.name">
                                    </option>
                                </select>
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="form-group">
                                <label for="carrier_id">{{ __('carrier') }}
                                </label>
                                <select name="carrier_id" id="carrier_id" v-model="data.carrier_id"
                                    class="form-control form-control-sm @error('carrier_id') is-invalid @enderror">
                                    <option value="">{{ __('--Select--') }}</option>
                                    <option :value="carrier.id" v-for="(carrier,key) in carriers" v-text="carrier.name">
                                    </option>
                                </select>
                            </div>
                        </div>
                        <div class="col-3">
                            <button class="btn btn-sm btn-primary" id="search" v-on:click="loadData()">Search <i
                                    class="fa-solid fa-magnifying-glass px-1"></i></button>
                        </div>
                    </div>
                </div>
                <div class="col-6"></div>
                <div class="col-6 text-right my-1">
                    <a href="{{ route('stock-log.index') }}" class="btn btn-warning btn-sm"><i
                            class="fa-solid fa-eye px-1"></i>{{ __('View stock log') }}</a>
                    <a href="{{ route('stock.create') }}" class="btn btn-primary btn-sm"><i
                            class="fa-solid fa-plus px-1"></i>{{ __('Add stock') }}</a>
                </div>
                <div class="col-12">
                    <table id="stock_table" class="table table-bordered table-hover dataTable dtr-inline"
                        aria-describedby="example2_info">
                        <thead>
                            <tr>
                                <th class="text-center">#</th>
                                <th class="text-center">{{ __('Name') }}</th>
                                <th class="text-center">{{ __('SKU') }}</th>
                                <th class="text-center">{{ __('Grade scale') }}</th>
                                <th class="text-center">{{ __('Carrier') }}</th>
                                <th class="text-center">{{ __('Color') }}</th>
                                <th class="text-center">{{ __('Quantity') }}</th>
                                <th class="text-center">{{ __('Cost Price') }}</th>
                                <th class="text-center">{{ __('Selling Price') }}</th>
                                <th class="text-center"></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(stock,key) in stocks">
                                <td class="text-center" v-text="(current_page-1)*per_page+(key+1)"></td>
                                <td class="text-center" v-text="stock.product.name"></td>
                                <td class="text-center" v-text="stock.sku"></td>
                                <td class="text-center" v-text="stock.grading_scale.name"></td>
                                <td class="text-center" v-text="stock.carrier.name"></td>
                                <td class="text-center" v-text="stock.color.name"></td>
                                <td class="text-center" v-text="stock.quantity"></td>
                                <td class="text-center" v-text="stock.cost_price == null ? 'NA' : stock.cost_price + ' $'"></td>
                                <td class="text-center" v-text="stock.price + ' $'"></td>
                                <td class="text-center">
                                    <a class="btn btn-sm btn-primary text-white" data-toggle="modal"
                                        data-target="#exampleModal" v-on:click="openModal(stock.product.name,stock.id)"><i
                                            class="fa-solid fa-plus px-1"></i>{{ __('Add more') }}</a>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <ul class="pagination pagination-sm d-flex justify-content-center my-2">
                        <li class="page-item text-primary" v-for="(page,index) in pages" v-on:click="loadPage(index)"
                            :class="index == current_page ? 'active' : ''" style="cursor: pointer;"><a
                                class="page-link" v-if="index != 0 && index != pages.length -1" v-text="index"></a> <a
                                class="page-link" v-if="index == 0" v-text="'«'"></a> <a class="page-link"
                                v-if="index == pages.length-1" v-text="'»'"></a></li>
                    </ul>
                </div>
            </div>
        </div>
        {{-- this is modal for adding more stock --}}
        <!-- Modal -->
        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-xl" role="document">
                <form action="{{ route('stock.add') }}" method="post">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">{{ __('Add stock') }}</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            @csrf
                            <input type="hidden" name="stock_id" id="stock_id" value="">
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="name">{{ __('Name') }} <span
                                            class="text-danger font-weight-bold px-1">*</span>
                                    </label>
                                    <input type="text" id="name" class="form-control form-control-sm" value="" name="name"
                                        required disabled>
                                    @error('name')
                                        <p class="invalid-feedback" style="font-size: 1rem">
                                            {{ $message }}
                                        </p>
                                    @enderror
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-6">
                                    <div class="form-group">
                                        <label for="price">{{ __('price') }} <span
                                                class="text-danger font-weight-bold px-1">*</span>
                                        </label>
                                        <input type="number" step="0.1" id="price" class="form-control form-control-sm"
                                            value="" name="price" required>
                                        @error('price')
                                            <p class="invalid-feedback" style="font-size: 1rem">
                                                {{ $message }}
                                            </p>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group">
                                        <label for="quantity">{{ __('quantity') }} <span
                                                class="text-danger font-weight-bold px-1">*</span>
                                        </label>
                                        <input type="number" step="0.1" id="quantity" class="form-control form-control-sm"
                                            value="" name="quantity" required>
                                        @error('quantity')
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
                            <button type="submit" class="btn btn-primary"
                                onclick="return confirm('Are you sure you want to submit?')">{{ __('Save changes') }}</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        {{-- xxx this is modal for adding more stock xxx --}}
    </div>
@endsection
@section('scripts')
    <script src="{{ asset('vue/bundle.js') }}"></script>
    <script>
        new Vue({
            el: "#app",
            data: {
                stocks: [],
                carriers: [],
                grading_scales: [],
                colors: [],
                products: [],
                pages: [],
                current_page: '',
                per_page: 0,
                data: {
                    page: '',
                    product_id: '',
                    grading_scale_id: '',
                    color_id: '',
                    carrier_id: '',
                }
            },
            methods: {
                loadData: function() {
                    let vm = this;
                    button = document.getElementById('search');
                    button.disabled = true;
                    button.innerHTML = 'Loading <i class="fa-solid fa-spinner px-1"></i>';
                    axios.get("{{ route('api.stock.index') }}", {
                            params: vm.data
                        })
                        .then(function(response) {
                            vm.stocks = response.data.data;
                            vm.pages = response.data.links;
                            vm.current_page = response.data.current_page;
                            vm.per_page = response.data.per_page;
                            button.disabled = false;
                            button.innerHTML = 'Search <i class="fa-solid fa-magnifying-glass px-1"></i>';
                        })
                        .catch(function(error) {
                            console.log(error);
                            alert("Some Problem Occured");
                        });
                },
                loadAllSetting: function() {
                    let vm = this;
                    axios.get("{{ route('api.loadStockSetting') }}")
                        .then(function(response) {
                            vm.products = response.data.products;
                            vm.colors = response.data.colors;
                            vm.grading_scales = response.data.grading_scales;
                            vm.carriers = response.data.carriers;
                        })
                        .catch(function(error) {
                            console.log(error);
                            alert("Some Problem Occured");
                        });
                },
                loadPage: function(index) {
                    let vm = this;
                    if (index == 0) {
                        vm.data.page = parseInt(vm.current_page) - 1;
                    } else if (index == vm.pages.length - 1) {
                        vm.data.page = parseInt(vm.current_page) + 1;
                    } else {
                        vm.data.page = index;
                    }
                    if (vm.current_page != 0 && vm.data.page != vm.pages.length - 1) {
                        axios.get("{{ route('api.stock.index') }}", {
                                params: vm.data
                            })
                            .then(function(response) {
                                vm.stocks = response.data.data;
                                vm.current_page = response.data.current_page;
                                button.disabled = false;
                                button.innerHTML =
                                    'Search <i class="fa-solid fa-magnifying-glass px-1"></i>';
                            })
                            .catch(function(error) {
                                console.log(error);
                                alert("Some Problem Occured");
                            });
                    }
                },
                openModal: function(stockName, stockId) {
                    document.getElementById('name').value = stockName;
                    document.getElementById('stock_id').value = stockId;
                }
            },
            mounted() {
                let vm = this;
                vm.loadData();
                vm.loadAllSetting();
            }
        });
    </script>
@endsection
