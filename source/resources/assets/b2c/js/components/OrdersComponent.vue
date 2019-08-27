<template>
    <div>
        <div class="item-list-table">
            <div class="table-responsive-sm">
                <div class="row row-style">
                    <div class="col-5">
                        {{trans('b2c.order.text.packs')}}
                    </div>
                    <div class="col text-left">
                        {{trans('b2c.order.text.unit_price')}}
                    </div>
                    <div class="col text-center">
                        {{trans('b2c.order.text.pack_quantity')}}
                    </div>
                    <div class="col-1 text-center">
                        {{trans('b2c.order.text.total')}}
                    </div>
                </div>
                <div v-for="(item,index) in items" :key="index">
                    <div class="row tr-style">
                        <div class="col-5">
                            {{item.name}}
                        </div>
                        <div class="col text-left">
                            <input type="hidden" :name="'item_price[' + item.id + ']'" :value="item.price"/>
                            {{formatPrice(item.price)}}
                        </div>
                        <div class="col text-center">
                            <span><i v-bind:class="item.quantity == 0 ? 'decrease-arrow' : ''"
                                     v-on:click="item.quantity == 0 ? item.quantity = 0 : item.quantity -= 1"
                                     class="fa fa-angle-left"></i></span>
                            <input type="text" v-model="item.quantity" v-on:keypress="isNumber()" :maxlength="max"
                                   :name="'quantity[' + item.id + ']'"
                                   class="input-quantity"/>
                            <span><i v-on:click="item.quantity += 1" class="fa fa-angle-right"></i></span>
                        </div>
                        <div class="col-1 text-center">
                            <input type="hidden" :name="'sub_total[' + item.id + ']'"
                                   :value="item.price * item.quantity"/>
                            {{formatPrice(item.price * item.quantity)}}
                        </div>
                    </div>
                </div>
                <div class="row tr-style last-tr-style">
                    <div class="col-5">
                        <textarea name="note" class="form-control" rows="6" cols="60"
                                  :placeholder="trans('b2c.reservation.place_holder.note')"></textarea>
                    </div>
                    <div class="row col">
                        <div class="col-9 text-left total-title">
                            {{trans('b2c.order.text.total_price')}}
                        </div>
                        <div class="col-3 total-price-style text-right">
                            <input type="hidden" name="grand_total" :value="totalPrice">
                            {{formatPrice(totalPrice)}}
                        </div>
                        <div class="col-12">
                            {{trans('b2c.order.text.note')}}
                        </div>
                        <div class="col-12">
                            <button type="submit"
                                    class="btn res-button">{{trans('b2c.buttons.order')}}
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import axious from 'axios'

    export default {
        //get csrf token
        data() {
            return {
                items: [],
                current_url: window.location.origin,
                csrf: document.head.querySelector('meta[name="csrf-token"]').content,
                max: 3,
            }
        },
        mounted() {
            this.getWeeklyItems();
        },
        computed: {
            totalPrice: function () {
                let total_price = 0;
                for (let i = 0; i < this.items.length; i++) {
                    total_price += (this.items[i].price * this.items[i].quantity);
                }
                return total_price;
            }
        },
        methods: {
            getWeeklyItems() {
                axious.get('orders/get-weekly-items')
                    .then(response => {
                        this.items = response.data;
                        console.log(this.items);
                    })
                    .catch(error => console.log(error))

            },
            formatPrice(value) {
                let val = (value / 1).toFixed(0).replace('.', ',')
                return val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".")
            },
            isNumber(evt) {
                evt = (evt) ? evt : window.event;
                var charCode = (evt.which) ? evt.which : evt.keyCode;
                if ((charCode > 31 && (charCode < 48 || charCode > 57)) && charCode !== 46) {
                    evt.preventDefault();
                } else {
                    return true;
                }
            }
        }
    }
</script>

<style scoped>

</style>