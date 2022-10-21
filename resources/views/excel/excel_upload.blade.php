@extends('layouts.main')
@section('title', 'Excel upload')
@section('is_active_upload_excel', 'active')
@section('main_content')
    <div class="row pt-2" id="app">
        <div class="col-12">
            <form method="POST" action="{{ route('upload.excelsubmit') }}" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-5">
                        <div class="form-group">
                            <label for="vendor_id">{{ __('Vendors') }}
                            </label>
                            <select v-model="data.vendor_id" name="vendor_id" id="vendor_id"
                                class="form-control form-control-sm" v-on:change="showTable()" required>
                                <option value="">{{ __('--Select--') }}</option>
                                <option :value="vendor.id" v-for="(vendor,key) in vendors" v-text="vendor.name">
                                </option>
                            </select>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="form-group">
                            <label for="excel">{{ __('Excels') }}
                            </label>
                            <input type="file" id="excel" name="file" class="form-control form-control-sm">
                        </div>
                    </div>
                    <div class="col-3" style="margin-top: 30px;">
                        <button class="btn btn-sm btn-primary" id="button"><span class="mx-1"> <i
                                    class="fa-solid fa-upload px-1"></i><span>upload</button>
                        <a class="btn btn-sm btn-danger text-white" href="{{asset('Book1.xlsx')}}" download><span class="mx-1"> <span>Download sample</a>
                    </div>
                </div>
            </form>
            <div class="row my-3" v-if="data.is_data">
                <div class="col-6"></div>
                <div class="col-12">
                    <table id="order_table" class="table table-bordered table-hover dataTable dtr-inline"
                        aria-describedby="example2_info">
                        <thead>
                            <tr>
                                <th class="text-center">{{ __('SKU') }}</th>
                                <th class="text-center">{{ __('ESN/IMEI') }}</th>
                                <th class="text-center">{{ __('Cost price') }}</th>
                                <th class="text-center">{{ __('Selling price') }}</th>
                                <th class="text-center"></th>
                            </tr>
                        </thead>
                        <tbody>
                            <template v-for="(stock,key) in stocks">
                                <tr v-for="(esn,index) in stock.esns" :key="esn.esn">
                                    <td class="text-center" v-text="stock.sku"></td>
                                    <td class="text-center" v-text="esn.esn"></td>
                                    <td class="text-center" v-text="'$'+stock.cost_price"></td>
                                    <td class="text-center" v-text="'$'+stock.price"></td>
                                    <td class="text-center">
                                        <a v-if="esn.status"
                                            class="btn btn-sm btn-success"> Approved <span class="px-1"><i
                                                    class="fa-solid fa-circle-check"></i></span></a>
                                        <a v-if="!esn.status" v-on:click="changeEsnStatus(esn.id)"
                                            class="btn btn-sm btn-primary">Approve <span class="px-1"><i class="fa-solid fa-rotate-right"></i></span></a></td>
                                </tr>
                            </template>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        {{-- this is modal for assigning more esn --}}

    </div>
@endsection
@section('scripts')
    <script src="{{ asset('vue/bundle.js') }}"></script>
    <script>
        new Vue({
            el: "#app",
            data: {
                vendors: @json($vendors),
                stocks: [],
                data: {
                    vendor_id: '',
                    file: '',
                    is_data: false
                }
            },
            methods: {
                showTable: function() {
                    let vm = this;
                    if (vm.data.venodr_id != '') {
                        axios.get("{{ route('filter.vendor') }}", {
                                params: {
                                    vendor_id: vm.data.vendor_id
                                }
                            })
                            .then(function(response) {
                                vm.stocks = response.data;
                                vm.data.is_data = true;
                                console.log(response.data);
                            })
                            .catch(function(error) {
                                console.log(error);
                                alert("Some Problem Occured");
                            });
                    } else {
                        vm.data.is_data = true;
                    }
                },
                changeEsnStatus: function(param) {
                    window.location.href = "change-esn-status/"+param;
                }
            },
            mounted() {
                let vm = this;
            }
        });
    </script>
@endsection
