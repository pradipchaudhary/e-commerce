@extends('layouts.main')
@section('title', 'Order History')
@section('is_active_order_history', 'active')
@section('main_content')
    <div class="row pt-2" id="app">
        <div class="col-12">
            <div class="row">
                <div class="col-12 card p-3">
                    <div class="row">
                        <div class="col-3">
                            <div class="form-group">
                                <label for="user_id">{{ __('User') }}
                                </label>
                                <select v-model="data.user_id" name="user_id" id="user_id"
                                    class="form-control form-control-sm">
                                    <option value="">{{ __('--Select--') }}</option>
                                    <option :value="user.id" v-for="(user,key) in users" v-text="user.name">
                                    </option>
                                </select>
                            </div>
                        </div>
                        <div class="col-2">
                            <div class="form-group">
                                <label for="from">{{ __('From') }}
                                </label>
                                <input type="date" class="form-control form-control-sm" name="from"
                                    v-model="data.from">
                            </div>
                        </div>
                        <div class="col-2">
                            <div class="form-group">
                                <label for="from">{{ __('To') }}
                                </label>
                                <input type="date" class="form-control form-control-sm" name="to" v-model="data.to">
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="form-group">
                                <label for="from">{{ __('Order no.') }}
                                </label>
                                <input type="text" class="form-control form-control-sm" name="token"
                                    v-model="data.token">
                            </div>
                        </div>
                        <div class="col-2" style="margin-top:1.6rem;">
                            <button class="btn btn-sm btn-primary" id="search" v-on:click="loadData()">Search <i
                                    class="fa-solid fa-magnifying-glass px-1"></i></button>
                        </div>
                    </div>
                </div>
                <div class="col-6"></div>
                <div class="col-12">
                    <table id="order_table" class="table table-bordered table-hover dataTable dtr-inline"
                        aria-describedby="example2_info">
                        <thead>
                            <tr>
                                <th class="text-center">#</th>
                                <th class="text-center">{{ __('Name') }}</th>
                                <th class="text-center">{{ __('Order no.') }}</th>
                                <th class="text-center"></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(order,key) in orders">
                                <td class="text-center" v-text="key+1"></td>
                                <td class="text-center" v-text="order[0].user.name"></td>
                                <td class="text-center" v-text="order[0].token"></td>
                                <td class="text-center">
                                    <button class="btn btn-primary btn-sm"
                                        v-bind:class="[order[0].is_paid ? 'btn-success': 'btn-danger']"
                                        v-on:click="switchPaidStatus(key)" :disabled="order[0].is_paid ? true : false"></i>
                                        <span v-text="order[0].is_paid ? 'Paid' : 'Unpaid'"></span></button>

                                    <a class="btn btn-primary btn-sm text-white" v-on:click="redirect(order[0])"></i>
                                        <span >View Details</span></a>

                                    <!-- <button href="#" data-toggle="modal" data-target="#exampleModal"
                                        v-on:click="openModal(key)" class="btn btn-primary btn-sm" v-if="order[0].is_paid"
                                        :disabled="order[0].is_dispatch ? true : false"><i
                                            class="fa-solid fa-hand-holding px-1 pb-1"></i>
                                        <span v-text="order[0].is_dispatch ? 'Assigned' : 'Assign Esn'"></span></button>
                                    <button href="#" data-toggle="modal" data-target="#exampleModalDetail"
                                        v-on:click="openDetailModal(key)" class="btn btn-primary btn-sm" v-if="order[0].is_dispatch"><i
                                            class="fa-solid fa-hand-holding px-1 pb-1"></i>
                                        <span v-text="order[0].is_dispatch ? 'View Detail' : ''"></span></button> -->

                                    <button class="btn btn-primary btn-sm"
                                        v-bind:class="[order[0].is_delivered ? 'btn-success': 'btn-danger']"
                                        v-on:click="switchDeliverStatus(key)" :disabled="order[0].is_delivered ? true : false"
                                        v-if="checkDeliver(key)">
                                        <span v-text="order[0].is_delivered ? 'Delivered':'Not delivered'"></span></button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <!-- <ul class="pagination pagination-sm d-flex justify-content-center my-2">
                        <li class="page-item text-primary" v-for="(page,index) in pages" v-on:click="loadPage(index)"
                            :class="index == current_page ? 'active' : ''" style="cursor: pointer;"><a class="page-link"
                                v-if="index != 0 && index != pages.length -1" v-text="index"></a> <a class="page-link"
                                v-if="index == 0" v-text="'«'"></a> <a class="page-link" v-if="index == pages.length-1"
                                v-text="'»'"></a></li> -->
                    </ul>
                </div>
            </div>
        </div>
        {{-- this is modal for assigning more esn --}}
        <!-- Modal -->
        <div class="modal fade" id="exampleModalDetail" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-xl" role="document">
               <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">{{ __('Order Detail') }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" v-if="esnModal!=''">
                   <table class="table table-bordered table-hover dataTable dtr-inline"
                        aria-describedby="example2_info">
                        <thead>
                            <tr>
                                <th class="text-center">#</th>
                                <th class="text-center">{{ __('ESN') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                           <tr v-for="(esn_modal,esn_key) in esnModal">
                               <td class="text-center" v-text="esn_key+1"></td>
                               <td class="text-center" v-text="esn_modal.esn"></td>
                           </tr>
                        </tbody>
                    </table>
                    <div class="container my-2" v-if="track_no != ''">
                        <table class="table table-bordered table-hover dataTable dtr-inline"
                        aria-describedby="example2_info">
                        <thead>
                            <tr>
                                <th class="text-center">Track number</th>
                                <th class="text-center" v-text="track_no"></th>
                            </tr>
                            <tr>
                                <th class="text-center">Shipping method</th>
                                <th class="text-center" v-text="shipping_method_name"></th>
                            </tr>
                            <tr>
                                <th class="text-center">Shipping description</th>
                                <th class="text-center" v-text="shipping_name"></th>
                            </tr>
                            <tr>
                                <th class="text-center">Insurance description</th>
                                <th class="text-center" v-text="insurance_name"></th>
                            </tr>
                            <tr>
                                <th class="text-center">Business Phone number</th>
                                <th class="text-center" v-text="business_phone_no"></th>
                            </tr>
                            <tr>
                                <th class="text-center">Address</th>
                                <th class="text-center" v-text="address"></th>
                            </tr>
                            <tr>
                                <th class="text-center">Note :</th>
                                <th class="text-center" v-text="note"></th>
                            </tr>
                        </thead>
                    </table>
                    </div>
                </div>
            </div>
        </div>
        {{-- xxx this is modal for assigning more esn xxx --}}
        {{-- this is modal for assigning more esn --}}
        <!-- Modal -->
        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-xl" role="document">
                <form action="{{ route('order_history.dispatch') }}" method="POST">
                    @csrf
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">{{ __('Assign ESN') }}</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body" v-if="order_modal!=''">
                            @csrf
                            <p class="text-center" v-if="order_modal != ''">Assign ESN for @{{ order_modal.stock.product.manufacturer.name + ' ' + order_modal.stock.product.name + ' ' + order_modal.stock.color.name + ' ' + order_modal.stock.status.name + ' ' + order_modal.stock.grading_scale.name + '-STOCK' }}</p>
                            <input type="hidden" name="order_log_id" id="order_log_id" :value="order_modal.id">
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="name">{{ __('Tracking number') }} <span
                                            class="text-danger font-weight-bold px-1">*</span>
                                    </label>
                                    <input type="text" name="track_id" class="form-control form-control-sm">
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="name">{{ __('Shipping method') }} <span
                                            class="text-danger font-weight-bold px-1">*</span>
                                    </label>
                                    <select name="shipping_method_id" class="form-control form-control-sm">
                                        <option :value="shipping_method.id" v-for="shipping_method in shipping_methods">
                                            @{{ shipping_method.name }}</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row" id="loop" v-for="index in order_modal.quantity">
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="name">{{ __('ESN \ IMEI ') }} <span
                                                class="text-danger font-weight-bold px-1">*</span>
                                        </label>
                                        <input type="text" :id="'esn_' + index"
                                            v-on:input="checkEsn(order_modal.id,index)"
                                            class="form-control form-control-sm" value=""
                                            v-model="tokenData[index-1]" name="esn[]" required>
                                    </div>
                                </div>
                                <p class="mb-0 pl-3 text-danger" style="margin-top:-10px;" :id="'feedback_' + index">
                                </p>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button id="button" class="btn btn-primary" v-on:click="dispatch()"
                                id="button">{{ __('Shipp') }}</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        {{-- xxx this is modal for assigning more esn xxx --}}
    </div>
@endsection
@section('scripts')
    <script src="{{ asset('vue/bundle.js') }}"></script>
    <script>
        new Vue({
            el: "#app",
            data: {
                users: @json($users),
                shipping_methods: @json($shipping_methods),
                pages: [],
                orders: [],
                current_page: '',
                per_page: 0,
                loop: 0,
                order_modal: [],
                esnModal : [],
                track_no : "",
                shipping_method_name : "",
                shipping_name : "",
                insurance_name : "",
                business_phone_no : "",
                address : "",
                note:"",
                data: {
                    page: '',
                    user_id: '',
                    from: '',
                    to: '',
                    token: ''
                },
                tokenData: []
            },
            methods: {
                loadData: function() {
                    let vm = this;
                    button = document.getElementById('search');
                    button.disabled = true;
                    button.innerHTML = 'Loading <i class="fa-solid fa-spinner px-1"></i>';
                    axios.get("{{ route('order_history.report') }}", {
                            params: vm.data
                        })
                        .then(function(response) {
                            vm.orders = response.data;
                            // console.log(vm.orders);
                            // vm.pages = response.data.links;
                            // vm.current_page = response.data.current_page;
                            // vm.per_page = response.data.per_page;
                            button.disabled = false;
                            button.innerHTML = 'Search <i class="fa-solid fa-magnifying-glass px-1"></i>';
                        })
                        .catch(function(error) {
                            console.log(error);
                            alert("Some Problem Occured");
                        });
                },
                redirect : function(order_log){
                    window.location.href = "{{url('/')}}"+"/order-detail/"+ order_log.token;
                },
                // loadPage: function(index) {
                //     let vm = this;
                //     if (index == 0) {
                //         vm.data.page = parseInt(vm.current_page) - 1;
                //     } else if (index == vm.pages.length - 1) {
                //         vm.data.page = parseInt(vm.current_page) + 1;
                //     } else {
                //         vm.data.page = index;
                //     }
                //     if (vm.current_page != 0 && vm.data.page != vm.pages.length - 1) {
                //         axios.get("{{ route('order_history.report') }}", {
                //                 params: vm.data
                //             })
                //             .then(function(response) {
                //                 vm.orders = response.data.data;
                //                 vm.current_page = response.data.current_page;
                //                 button.disabled = false;
                //                 button.innerHTML =
                //                     'Search <i class="fa-solid fa-magnifying-glass px-1"></i>';
                //             })
                //             .catch(function(error) {
                //                 console.log(error);
                //                 alert("Some Problem Occured");
                //             });
                //     }
                // },
                switchPaidStatus: function(key) {
                    let vm = this;
                    if (confirm('Are you sure You want to switch status to Paid ?')) {
                        axios.post("{{ route('order_history.switchPaidStatus') }}", {
                                order: vm.orders[key][0]
                            })
                            .then(function(response) {
                                console.log(response);
                                vm.loadData();
                            })
                            .catch(function(error) {
                                alert("Some Problem Occured");
                            });
                    }
                },
                switchDeliverStatus: function(key) {
                    let vm = this;
                    if (confirm('Are you sure product is delivered ?')) {
                        axios.post("{{ route('order_history.switchDeliverStatus') }}", {
                                order: vm.orders[key]
                            })
                            .then(function(response) {
                                console.log(response);
                                vm.loadData();
                            })
                            .catch(function(error) {
                                alert("Some Problem Occured");
                            });
                    }
                },
                checkDeliver : function(key){
                    let vm = this;
                    temp = true;
                    vm.orders[key].forEach(element => {
                        if(!element.is_dispatch){
                            temp = false;
                        }
                    });  
                    return temp;
                },
                checkEsn: function(order_log_id, index) {
                    let vm = this;
                    esn = document.getElementById("esn_" + index).value;
                    button = document.getElementById("button");
                    axios.get("{{ route('api.checkEsn') }}", {
                        params: {
                            esn: esn
                        }
                    }).then(function(response) {
                        element = document.getElementById("feedback_" + index);
                        if (response.data) {
                            button.disabled = true;
                            element.innerHTML = "Esn doesn't exist";
                        } else {
                            button.removeAttribute('disabled');
                            element.innerHTML = "";
                        }
                    }).catch(function(error) {
                        console.log(error);
                        alert("Something went wrong");
                    });
                },
                dispatch: function() {
                    let vm = this;
                    // (document.getElementById("button")).disabled = true;
                    check = false;
                    for (let i = 0; i < vm.tokenData.length; i++) {
                        if (vm.tokenData.indexOf(vm.tokenData[i]) !== vm.tokenData.lastIndexOf(vm.tokenData[
                                i])) {
                            check = true;
                        }
                    }
                    if (check) {
                        event.preventDefault();
                        (document.getElementById("button")).disabled = true;
                        alert("ESN is repeated !");
                    } else {
                        (document.getElementById("button")).disabled = false;
                        return true;
                    }
                },
                openModal: function(key) {
                    let vm = this;
                    vm.order_modal = vm.orders[key];
                },
                openDetailModal: function(key) {
                    let vm = this;
                    vm.esnModal = vm.orders[key].stock.esns;
                    vm.track_no = vm.orders[key].track_id;
                    vm.shipping_method_name = vm.orders[key].shipping_method.name;
                    vm.shipping_name = vm.orders[key].shipping.name;
                    vm.insurance_name = vm.orders[key].insurance.description;
                    vm.business_phone_no = vm.orders[key].user.user_detail.business_phone_number;
                    vm.address = vm.orders[key].user.user_detail.address;
                    vm.note = vm.orders[key].description;
                    // console.log(vm.orders[key]);
                }
            },
            mounted() {
                let vm = this;
                vm.loadData();
            }
        });
    </script>
@endsection
