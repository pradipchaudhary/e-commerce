<!-- Modal -->
<div class="modal fade" id="offerModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div v-if="modalDataLoading" style="display: flex; justify-content: space-around;">
                    <strong>Loading...</strong>
                    <div class="spinner-border ml-auto" role="status" aria-hidden="true"></div>
                </div>
                <div v-if="!modalDataLoading">
                <h4 class="modal_title"
                    v-text="modal.manufacturer_name +' '+ modal.product_name+' '+ modal.color_name+' '+modal.carrier_name+' '+modal.status+' '+modal.grade_scale_name+'-STOCK'">
                </h4>
                <span class="text-muted" v-text="'Item #'+modal.item_no"></span>
                <div class="custom-popup__content">
                    <div class="main-content">
                        <div class="avail"> Available : <span v-text="modal.quantity"></span> </div>
                        <div class="price">Price : <span v-text="'$'+modal.price"></span></div>
                    </div>
                    <div class="mt-2">Your offer</div>
                    <div class="quantity" style="margin-top:5px;">
                        <div class="qty">Qty : </div>
                        <button class="btn btn-minus" type="button" v-on:click="decreementCounter()"> - </button>
                        <input type="text" id="quantity" v-model="counter" disabled>
                        <button class="btn btn-plus" type="button" v-on:click="increementCounter()"> + </button>

                        {{-- this is for price --}}
                        <div class="qty" style="margin-left:65px;">Price : </div>
                        <button class="btn btn-minus" type="button" v-on:click="decreementPrice()"> - </button>
                        <input type="text" id="priceCounter" v-model="modal.offer_price" disabled>
                        <button class="btn btn-plus" type="button" v-on:click="increementPrice()"> + </button>
                    </div>
                    <button class="add-to-cart" id="offerSubmit" v-on:click="addToCartByOffer()"> Add to Cart </button>
                </div>
            </div>
            </div>
        </div>
    </div>
</div>
