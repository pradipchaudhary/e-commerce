@extends('layouts.main')
@section('title', 'Offer')
@section('is_active_offer', 'active')
@section('main_content')
    <div class="row pt-2" id="app">
        <div class="col-12">
            <div class="row">
                <div class="col-3 my-3">
                    <div class="form-group">
                        <label for="user_id">{{ __('User') }}
                        </label>
                        <select v-model="data.user_id" name="user_id" id="user_id"
                            class="form-control form-control-sm @error('user_id') is-invalid @enderror">
                            <option value="">{{ __('--Select--') }}</option>
                            <option :value="user.id" v-for="(user,key) in users" v-text="user.name">
                            </option>
                        </select>
                    </div>
                </div>
                <div class="col-3 my-3">
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
                <div class="col-3 my-3">
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
                <div class="col-3" style="margin-top:2.6rem">
                    <div class="form-group">
                        <button class="btn btn-sm btn-primary" v-on:click="searchData()" id="search">Search <i
                                class="fa-solid fa-magnifying-glass px-1"></i></button>
                    </div>
                </div>
                <div class="col-12">
                    <table id="example1" class="table table-bordered table-hover dataTable dtr-inline"
                        aria-describedby="example2_info">
                        <thead>
                            <tr>
                                <th class="text-center">#</th>
                                <th class="text-center">{{ __('Name') }}</th>
                                <th class="text-center">{{ __('Product name') }}</th>
                                <th class="text-center">{{ __('offer') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(offer,key) in offers">
                                <td class="text-center" v-text="key+1"></td>
                                <td class="text-center" v-text="offer.user.name +' ('+ offer.user.email +')'"></td>
                                <td class="text-center">
                                    @{{ offer.stock.product.manufacturer.name + ' ' + offer.stock.product.name + ' ' + offer.stock.color.name + ' ' + offer.stock.status.name + ' ' + offer.stock.grading_scale.name + '-STOCK' }}
                                </td>
                                <td class="text-center">
                                    <a class="btn btn-sm btn-primary text-white" data-toggle="modal" data-target="#offer"
                                        v-on:click="openModal(offer.id)" v-if="offer.status == 2">See offer</a>
                                    <button class="btn bt-sm btn-danger" v-if="offer.status == 0">Rejected <i
                                            class="fa-solid fa-circle-xmark px-1"></i></button>
                                    <button class="btn bt-sm btn-success" v-if="offer.status == 1">Accepted <i
                                            class="fa-solid fa-circle-check px-1"></i></button>
                                    <button class="btn bt-sm btn-warning" v-if="offer.status == 3">Countered <i class="fa-solid fa-rotate px-1"></i></button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                {{-- this is modal for offer preview --}}
                <div class="modal fade offer-popup" id="offer" tabindex="-1" role="dialog"
                    aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Offer preview</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body" v-for="(offer,key) in singleOffer">
                                <div class="ap">
                                    <div class="av"> Avaliable : <span> @{{ offer.stock.quantity }} </span> </div>

                                    {{-- price --}}
                                    <div class="price"> Price : <span> @{{ '$' + offer.stock.price }} </span></div>


                                </div>
                                <div class="offer">
                                    <h4 class="title"> Your Offered </h4>

                                    <div class="ap">
                                        <div class="qt"> Quantity : <span> @{{ offer.quantity }} </span></div>
                                        <div class="price"> Price : <span> @{{ '$' + offer.price }} </span></div>
                                        <div class="mpbtn">
                                            <span class="p-btn">
                                                <i class="fa-solid fa-minus" v-on:click="decreementPrice(key)"></i>
                                            </span>
                                            <span class="p-value">@{{ offer_price }}</span>
                                            <span class="p-btn" v-on:click="incrementPrice(key)">
                                                <i class="fa-solid fa-plus"></i>
                                            </span>
                                        </div>
                                    </div>

                                    {{-- price --}}

                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-danger" id="reject"
                                    v-on:click="submitFeedBack(false)">Reject
                                    offer</button>
                                <button type="submit" class="btn btn-primary" id="submit"
                                    v-on:click="submitFeedBack(true)">Counter</button>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- xxx end of modal for offer preview xxx --}}
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
                offers: [],
                singleOffer: [],
                users: [],
                grading_scales: [],
                products: [],
                offer_price: '',
                data: {
                    user_id: '',
                    product_id: '',
                    grading_scale_id: '',
                }
            },
            methods: {
                loadAllData: function() {
                    let vm = this;
                    axios.get("{{ route('offer.data') }}")
                        .then(function(response) {
                            vm.offers = response.data.data;
                        })
                        .catch(function(error) {
                            console.log(error);
                            alert("Some Problem Occured");
                        });
                },
                openModal: function(offer_id) {
                    let vm = this;
                    axios.get("{{ route('api.getDataByOfferId') }}", {
                            params: {
                                offer_id: offer_id
                            }
                        })
                        .then(function(response) {
                            vm.singleOffer = response.data;
                            vm.offer_price = vm.singleOffer[0].price;
                        })
                        .catch(function(error) {
                            console.log(error);
                            alert("Some Problem Occured");
                        });
                },
                incrementPrice: function(key) {
                    let vm = this;
                    if (vm.singleOffer[key].stock.price > vm.offer_price) {
                        vm.offer_price++;
                    }
                },
                searchData: function() {
                    let vm = this;
                    button = document.getElementById('search');
                    button.disabled = true;
                    button.innerHTML = 'Loading <i class="fa-solid fa-spinner px-1"></i>';
                    axios.get("{{ route('offer.data') }}", {
                            params: {
                                user_id: vm.data.user_id,
                                product_id: vm.data.product_id,
                                grading_scale_id: vm.data.grading_scale_id
                            }
                        })
                        .then(function(response) {
                            vm.offers = response.data.data;
                            button.disabled = false;
                            button.innerHTML = 'Search <i class="fa-solid fa-magnifying-glass px-1"></i>';
                        })
                        .catch(function(error) {
                            console.log(error);
                            alert("Some Problem Occured");
                        });

                },
                submitFeedBack: function(flag) {
                    let vm = this;
                    if (confirm('Are you sure you want to send this feedback?')) {
                        if (flag == 0) {
                            reject = document.getElementById('reject');
                            reject.disabled = true;
                            reject.innerHTML = 'Loading <i class="fa-solid fa-spinner px-1"></i>';
                            button = document.getElementById('submit');
                            button.disabled = true;
                        } else {
                            reject = document.getElementById('reject');
                            reject.disabled = true;
                            button = document.getElementById('submit');
                            button.disabled = true;
                            button.innerHTML = 'Loading <i class="fa-solid fa-spinner px-1"></i>';
                        }
                        axios.post("{{ route('offer.status') }}", {
                                offer_id: vm.singleOffer[0].id,
                                offer_price: vm.offer_price,
                                is_accept: flag
                            })
                            .then(function(response) {
                                button.disabled = false;
                                button.innerHTML = 'Send feedback';
                                reject.disabled = false;
                                reject.innerHTML = 'Reject';
                                vm.loadAllData();
                                $('#offer').modal('hide');
                                alert(response.data);
                            })
                            .catch(function(error) {
                                alert("Some Problem Occured");
                            });
                    }
                },
                loadSettingDataForOffer: function() {
                    let vm = this;
                    axios.get("{{ route('api.getOfferSettingData') }}")
                        .then(function(response) {
                            vm.users = response.data.users;
                            vm.products = response.data.products;
                            vm.grading_scales = response.data.grading_scales;
                        })
                        .catch(function(error) {
                            console.log(error);
                            alert("Some Problem Occured");
                        });
                },
                decreementPrice: function(key) {
                    let vm = this;
                    if (vm.singleOffer[key].price < vm.offer_price) {
                        vm.offer_price--;
                    }
                },
            },
            mounted() {
                let vm = this;
                vm.loadSettingDataForOffer();
                vm.loadAllData();
            }
        });
    </script>
@endsection
