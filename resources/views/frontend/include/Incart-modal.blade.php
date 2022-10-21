<!-- Modal -->
<div class="modal fade" id="cartModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <h4 class="modal_title"
                    v-text="modal.manufacturer_name +' '+ modal.product_name+' '+ modal.color_name+' '+modal.carrier_name+' '+modal.status+' '+modal.grade_scale_name">
                </h4>
                <span class="text-muted" v-text="'Item# '+modal.item_no"></span>
                <div class="custom-popup__content">
                    <div class="main-content">
                        <div class="avail"> Available : <span v-text="modal.quantity"></span> </div>
                        <div class="price">Price : <span v-text="'$'+modal.price"></span></div>
                        <div class="offer"> <a href="#"> Or Make an Offer </a></div>
                    </div>
                    <div class="quantity">
                        <div class="qty">Qty : </div>
                        <button class="btn btn-minus" type="button" v-on:click="decreementCounter()"> - </button>
                        <input type="text" id="quantity" v-model="counter" disabled>
                        <button class="btn btn-plus" type="button" v-on:click="increementCounter()"> + </button>
                    </div>
                    <button class="add-to-cart" id="cartSubmit" v-on:click="addToCart()"> Add to Cart </button>
                </div>
            </div>
        </div>
    </div>
</div>
