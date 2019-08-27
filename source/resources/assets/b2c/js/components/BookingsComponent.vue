<template>
    <div>
        <!--<div class="choose-item">
            <select name="category_id" v-model="category_id" class="form-control" @change="getItemByCategories()">
                <option v-for="category in categories" :value="category.id">{{category.name}}</option>
            </select>
        </div>-->
        <div class="item-list-table">
            <div class="table-responsive-sm">
                <div class="row row-style">
                    <div v-if="category_id == 1" class="col-5">
                        {{trans('b2c.reservation.text.dishes')}}
                    </div>
                    <div v-else class="col-5">
                        {{trans('b2c.reservation.text.set_dishes')}}
                    </div>
                    <div class="col text-left">
                        {{trans('b2c.reservation.text.unit_price')}}
                    </div>
                    <div class="col text-center">
                        {{trans('b2c.reservation.text.quantity')}}
                    </div>
                    <div class="col text-center">
                        {{trans('b2c.reservation.text.total')}}
                    </div>
                </div>
                <div v-for="(item,index) in items" :key="index">
                    <div class="row tr-style">
                        <div v-bind:class="category_id == 2 ? 'black-title' : ''" class="col-5">
                            {{item.name}}
                        </div>
                        <div class="col text-left">
                            <input type="hidden"  :name="'item_price[' + item.id + ']'" :value="item.price"/>
                            {{formatPrice(item.price)}}  VNĐ
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
                        <div class="col text-center">
                            <input type="hidden" :name="'sub_total[' + item.id + ']'" :value="item.price * item.quantity"/>
                            {{formatPrice(item.price * item.quantity)}} VNĐ
                        </div>
                    </div>
                    <div v-for="subItem in item.subItems " class="row tr-style">
                        <div class="col-12 pl-5-em">
                            {{subItem.name}}
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
                            {{trans('b2c.reservation.text.total_price')}}
                        </div>
                        <div class="col-3 total-price-style text-right">
                            <input type="hidden" name="grand_total" :value="totalPrice">
                            {{formatPrice(totalPrice)}}  VNĐ
                        </div>
                        <div class="col-12">
                            {{trans('b2c.reservation.text.note')}}
                        </div>
                        <div class="col-12">
                            <button type="submit"
                                    class="btn res-button">{{trans('b2c.buttons.booking')}}
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <!--<table class="table">-->
            <!--<thead class="thead-dark">-->
            <!--<tr>-->
            <!--<th style="width: 45%;">{{trans('b2c.reservation.text.dishes')}}</th>-->
            <!--<th class="text-left" style="width: 15%;">{{trans('b2c.reservation.text.unit_price')}}</th>-->
            <!--<th class="text-center" style="width: 35%;">{{trans('b2c.reservation.text.quantity')}}</th>-->
            <!--<th class="text-center" style="width: 5%;">{{trans('b2c.reservation.text.total')}}</th>-->
            <!--</tr>-->
            <!--</thead>-->
            <!--<tbody style="background: white;">-->
            <!--<tr v-for="(item,index) in items" :key="index" class="tr-style">-->
            <!--<td>{{item.name}}</td>-->
            <!--<td class="text-left">{{item.price}}</td>-->
            <!--<td class="text-center">-->
            <!--<span><i v-on:click="item.quantity == 0 ? item.quantity = 0 : item.quantity -= 1"-->
            <!--class="fa fa-angle-left"></i></span>-->
            <!--<input type="text" v-model="item.quantity" :name="'quantity[' + item.id + ']'"-->
            <!--class="input-quantity"/>-->
            <!--<span><i v-on:click="item.quantity += 1" class="fa fa-angle-right"></i></span>-->
            <!--</td>-->
            <!--<td class="text-center" >{{item.price * item.quantity}}</td>-->
            <!--</tr>-->
            <!--<tr>-->
            <!--<td rowspan="3">-->
            <!--<textarea class="form-control" rows="6" placeholder="...">-->
            <!--</textarea>-->
            <!--</td>-->
            <!--<td class="text-left total-title">{{trans('b2c.reservation.text.total_price')}}</td>-->
            <!--<td class="text-center">-->
            <!--</td>-->
            <!--<td class="text-center text-danger font-weight-bold">{{totalPrice}}</td>-->
            <!--</tr>-->
            <!--<tr>-->
            <!--<td class="total-des" colspan="100%">{{trans('b2c.reservation.text.note')}}</td>-->
            <!--</tr>-->
            <!--<tr>-->
            <!--<td colspan="100%">-->
            <!--<button type="button" class="btn res-button">{{trans('b2c.buttons.booking')}}</button>-->
            <!--</td>-->
            <!--</tr>-->
            <!--</tbody>-->
            <!--</table>-->
        </div>
        <!--</form>-->
    </div>
</template>

<script>
    import axious from 'axios'

    export default {
        //get csrf token
        data() {
            return {
                category_id: 1,
                items: [],
                current_url: window.location.origin,
                csrf: document.head.querySelector('meta[name="csrf-token"]').content,
                categories: categories,
                max: 3,
            }
        },
        mounted() {
            this.getItemByCategories();
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
            getItemByCategories() {
                if (this.category_id != null) {
                    axious.get('reservations/get-item-by-categories/' + this.category_id)
                        .then(response => {
                            this.items = response.data;
                            console.log(this.items);
                        })
                        .catch(error => console.log(error))
                } else {
                    this.items = []
                }
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