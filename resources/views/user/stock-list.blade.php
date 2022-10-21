@section('title', 'STOCK-LIST')
@include('frontend.include.header')
@include('frontend.include.navbar')
<section id="breadcrumb">
    <div class="container">
        <div class="row ">
            <div class="col-md-12">
                <div class="breadcrumb">
                    <h1> Stock List </h1>
                </div>
            </div>
        </div>
    </div>
</section>
<section id="app" class="">
    <div class="container">
        <div class="row">
            @include('frontend.include.filter')
            @include('frontend.include.cart-modal')
            @include('frontend.include.offer-modal')
            <!-- Main Content -->
            <div class="col-md-9">

                <div class="main_content">
                    <div class="d-flex justify-content-between align-items-center stock-list-heading">
                        <h4 class="title"> </h4>
                        <div class="cart_menu">
                            <ul>
                                <a href="{{ route('cart.index') }}">
                                    <li>
                                        <i class="fa-solid fa-cart-arrow-down"></i> Cart <span
                                            v-text="cart_count"></span>
                                    </li>
                                </a>
                            </ul>

                        </div>
                    </div>

                    <div class="stock-list mt-2">
                        <!-- item group -->
                        <div class="accordion" id="accordionExample">
                            <div class="accordion-item" v-for="(product,key) in products">
                                <h2 class="accordion-header" id="headingOne">
                                    <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                        :data-bs-target="'#collapse' + product[0].item_number" aria-expanded="true"
                                        aria-controls="collapseOne">

                                        <div class="product_name">
                                            <div class="product_value"
                                                v-text="product[0].manufacturer_name +' '+product[0].product_name">
                                            </div>
                                            <span v-for="(stock,key) in product"
                                                v-text="stock.color_name +' / '"></span>
                                            <span v-for="(stock,key) in product"
                                                v-text="stock.carrier_name + (product.length == key + 1 ? ' ' : ' / ')"></span>
                                        </div>

                                        <div class="product_qty">Qty <span
                                                v-text="getSumOfQuantity(product,'quantity')"></span></div>

                                        <div class="product_price">Price <span v-text="'$'+product[0].price+'+'"></span>
                                        </div>


                                        <div class="product_store_name" v-text="product[0].grading_name + '-'+ 'STOCK'">
                                        </div>
                                    </button>
                                </h2>
                                <div :id="'collapse' + product[0].item_number" class="accordion-collapse collapse "
                                    aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                                    <div class="accordion-body">
                                        <table class="table borderless">
                                            <thead>
                                                <th class="table_item">Item</th>
                                                <th class="text-center">Qty</th>
                                                <th>Price</th>
                                                <th></th>
                                            </thead>
                                            <tbody>
                                                <tr v-for="(stock,key) in product">
                                                    <td>
                                                        @{{ stock.color_name + ' ' + stock.carrier_name + ' ' + stock.status_name }}
                                                        <span v-text="'(#'+ stock.item_number +')'"></span>
                                                    </td>
                                                    <td class="text-center" v-text="stock.quantity"></td>
                                                    <td v-text="'$'+ stock.price"></td>
                                                    <td>
                                                        <button class="btn btn-buy js-open-popup" data-bs-toggle="modal"
                                                            data-bs-target="#cartModal" v-on:click="openModal(stock.id)"
                                                            v-if="!checkCart(stock.id)">Buy
                                                        </button>
                                                        <button class="btn btn-in-cart js-open-popup"
                                                            data-bs-toggle="modal" data-bs-target="#inCartModal"
                                                            v-if="checkCart(stock.id)">In
                                                            cart
                                                        </button>
                                                        <button class="btn btn-in-cart js-open-popup btn btn-offer"
                                                            data-bs-toggle="modal" data-bs-target="#offerModal"
                                                            v-on:click="openModal(stock.id)"
                                                            v-if="!checkCart(stock.id)">Offer
                                                        </button>
                                                        <span class="myalert">
                                                            <i class="fa-solid fa-bell"></i>
                                                        </span>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- end item group -->
                    </div>
                    <nav aria-label="Page navigation example">
                        <ul class="pagination">
                            <li class="page-item"><a class="page-link" v-on:click="paginate(current_page,'prev')"><i
                                        class="fa-solid fa-arrow-left"></i></a></li>
                            <li class="page-item" :class="[current_page == item ? 'active' : '']"
                                v-for="item in total_pages_count" v-on:click="paginate(item,'current')"><a
                                    class="page-link" v-text="item"></a></li>
                            <li class="page-item"><a class="page-link" v-on:click="paginate(current_page,'next')"> <i
                                        class="fa-solid fa-arrow-right"></i>
                                </a></li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    </div>
</section>
@include('frontend.include.footer')
<!-- JavaScript Bundle with Popper -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"
    integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
<script src="{{ asset('user/assets/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('user/assets/js/main.js') }}"></script>
<script src="{{ asset('vue/bundle.js') }}"></script>
<script>
    new Vue({
        el: "#app",
        data: {
            products: [],
            statuses: [],
            primary_grades: [],
            secondary_grades: [],
            manufacturers: [],
            counter: 1,
            cart_count: 0,
            current_page: 0,
            total_pages_count: '',
            user_id: {{ auth()->id() }},
            carts: [],
            offers: [],
            cart_offers: [],
            primary_garde_id: {{ config('CONSTANT.PRIMARY_GARDE') }},
            secondary_grade_id: {{ config('CONSTANT.SECONDARY_GRADE') }},
            data: {
                requested_page: 0,
                status_id: [],
                grading_scale_id: [],
                manufacturer_id: []
            },
            modalDataLoading: false,
            modal: {
                manufacturer_name: '',
                product_name: '',
                carrier_name: '',
                status: '',
                grade_scale_name: '',
                color_name: '',
                quantity: 0,
                price: 0,
                offer_price: 0,
                item_no: '',
                stock_id: ''
            }
        },
        methods: {
            initModal: function() {
                let vm = this;
                vm.modal.manufacturer_name= '';
                vm.modal.product_name= '';
                vm.modal.carrier_name= '';
                vm.modal.status= '';
                vm.modal.grade_scale_name= '';
                vm.modal.color_name= '';
                vm.modal.quantity= 0;
                vm.modal.price= 0;
                vm.modal.offer_price= 0;
                vm.modal.item_no= '';
                vm.modal.stock_id= '';
            },
            loadData: function() {
                let vm = this;
                axios.get("{{ route('get_stock') }}")
                    .then(function(response) {
                        vm.products = response.data.data;
                        vm.statuses = response.data.statuses;
                        vm.manufacturers = response.data.manufacturers;
                        vm.primary_grades = response.data.grade_scales[
                            {{ config('CONSTANT.PRIMARY_GARDE') }}];
                        vm.secondary_grades = response.data.grade_scales[
                            {{ config('CONSTANT.SECONDARY_GRADE') }}];
                        vm.cart_count = response.data.cart_count;
                        vm.total_pages_count = response.data.total_pages;
                        vm.carts = response.data.carts;
                        vm.offers = response.data.offers;
                        vm.cart_offers = response.data.cart_offers;
                    })
                    .catch(function(error) {
                        console.log(vm.data);
                        alert("Some Problem Occured");
                    });
            },
            fliterData: function() {
                let vm = this;
                axios.post("{{ route('get_stock_post') }}", vm.data)
                    .then(function(response) {
                        vm.products = response.data.data;
                        vm.cart_count = response.data.cart_count;
                        vm.carts = response.data.carts;
                        vm.offers = response.data.offers;
                        vm.cart_offers = response.data.cart_offers;
                        vm.current_page = response.data.current_page;
                        vm.total_pages_count = response.data.total_pages;
                    })
                    .catch(function(error) {
                        console.log(error);
                        alert("Some Problem Occured");
                    });
            },
            clearAll: function() {
                let vm = this;
                vm.data.status_id.splice(0, vm.data.status_id.length);
                vm.data.grading_scale_id.splice(0, vm.data.grading_scale_id.length);
                vm.data.manufacturer_id.splice(0, vm.data.manufacturer_id.length);
                vm.fliterData();
            },
            paginate: function(page, flag) {
                let vm = this;
                if (flag == 'prev') {
                    vm.data.requested_page = page - 2;
                } else if (flag == 'next') {
                    vm.data.requested_page = page;
                } else {
                    vm.data.requested_page = page - 1;
                }
                console.log(vm.data.requested_page, vm.current_page);
                if (vm.data.requested_page >= 0 && vm.data.requested_page < vm.total_pages_count) {
                    axios.post("{{ route('get_stock_post') }}", vm.data)
                        .then(function(response) {
                            vm.products = response.data.data;
                            vm.cart_count = response.data.cart_count;
                            vm.current_page = response.data.current_page;
                        })
                        .catch(function(error) {
                            console.log(error);
                            alert("Some Problem Occured");
                        });
                }
            },
            openModal: function(stock_id) {
                let vm = this;
                vm.modalDataLoading = true;
                vm.initModal();
                vm.counter = 1;
                axios.get("{{ route('api.getStockById') }}", {
                        params: {
                            stock_id: stock_id
                        }
                    })
                    .then(function(response) {
                        vm.modal.manufacturer_name = response.data.product.manufacturer.name;
                        vm.modal.product_name = response.data.product.name;
                        vm.modal.carrier_name = response.data.carrier.name;
                        vm.modal.status = response.data.status.name;
                        vm.modal.item_no = response.data.product_no;
                        vm.modal.grade_scale_name = response.data.grading_scale.name;
                        vm.modal.quantity = response.data.quantity;
                        vm.modal.price = response.data.price;
                        vm.modal.offer_price = response.data.price;
                        vm.modal.stock_id = response.data.id;
                        vm.modalDataLoading = false;
                    })
                    .catch(function(error) {
                        console.log(error);
                        // vm.modalDataLoading = false;
                        alert("Some Problem Occured");
                    });
            },
            increementCounter: function() {
                let vm = this;
                if (vm.modal.quantity > vm.counter) {
                    vm.counter++;
                }
            },
            decreementCounter: function() {
                let vm = this;
                if (vm.counter > 1) {
                    vm.counter--;
                }
            },
            addToCart: function() {
                let vm = this;
                button = document.getElementById('cartSubmit');
                button.disabled = true;
                button.innerHTML = 'Loading <i class="fa-solid fa-spinner px-1"></i>';
                axios.post("{{ route('addToCart') }}", {
                        quantity: vm.counter,
                        stock_id: vm.modal.stock_id,
                    })
                    .then(function(response) {
                        button.disabled = false;
                        button.innerHTML = 'Add to Cart';
                        vm.fliterData();
                        $('#cartModal').modal('hide');
                        alert(response.data);
                    })
                    .catch(function(error) {
                        alert("Some Problem Occured");
                    });
            },
            addToCartByOffer: function() {
                let vm = this;
                button = document.getElementById('offerSubmit');
                button.disabled = true;
                button.innerHTML = 'Loading <i class="fa-solid fa-spinner px-1"></i>';
                // console.log(vm.modal.stock_id);
                axios.post("{{ route('addOffer') }}", {
                        quantity: vm.counter,
                        offer_price: vm.modal.offer_price,
                        stock_id: vm.modal.stock_id
                    })
                    .then(function(response) {
                        button.disabled = false;
                        button.innerHTML = 'Add to Cart';
                        vm.fliterData();
                        $('#offerModal').modal('hide');
                        alert(response.data);
                    })
                    .catch(function(error) {
                        alert("Some Problem Occured");
                    });
            },
            openIncartModal: function(cart_id) {
                let vm = this;
                axios.get("{{ route('api.getCartById') }}", {
                        params: {
                            cart_id: cart_id
                        }
                    })
                    .then(function(response) {
                        console.log(response);
                    })
                    .catch(function(error) {
                        console.log(error);
                        alert("Some Problem Occured");
                    });
            },
            decreementPrice: function() {
                let vm = this;
                if (vm.modal.offer_price > 0) {
                    vm.modal.offer_price--;
                }
            },
            increementPrice: function() {
                let vm = this;
                if (vm.modal.offer_price < vm.modal.price) {
                    vm.modal.offer_price++;
                }
            },
            checkCart: function(stock_id) {
                let vm = this;
                return vm.cart_offers.some(function(el) {
                    if (el.stock_id == stock_id) {
                        return true;
                    } else {
                        return false;
                    }
                });
            },
            getSumOfQuantity: function(arr, key) {
                return arr.reduce((accumulator, current) => accumulator + Number(current[key]), 0)
            }
        },
        mounted() {
            let vm = this;
            vm.loadData();
        }
    });
</script>
</body>

</html>
