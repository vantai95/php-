<template>
    <div class="m-content sub-item-content" style="display:none">
        <div class="col-12 ">
            <div class="col-12 text-right form-group m-form__group row">
                <a @click="addSubItem()" title="Add more sub item" style="margin-left:auto"
                   class="btn btn-success m-btn m-btn--icon m-btn--icon-only m-btn--pill m-btn--air">
                    <i class="fa fa-plus-circle"></i>
                </a>
            </div>
            <div v-for="(subItem, index) in subItems" :key="index">
                <div class="form-group m-form__group row">
                    <div class="col-lg-4 ">
                        <label class="col-form-label col-sm-12">{{trans('admin.items.text.sub_item_name')}} <span
                                class="text-danger">* </span></label>
                        <div class="col-sm-12">
                            <select v-model="subItem.item_id" :name="'sub_items[' + index + ']'" class="form-control m-input" @change="getItemsData(index)">
                                <option v-for="item in items" :value="item.id">
                                    {{item.name}}
                                </option>
                            </select>
                        </div>
                    </div>

                    <div class="col-lg-3">
                        <label class="col-form-label col-sm-12">{{trans('admin.items.columns.price')}}  </label>
                        <div class="col-sm-12">
                            <input v-model="subItem.price" class="form-control m-input" disabled="disabled">
                        </div>
                    </div>

                    <div class="col-lg-3">
                        <img v-if="subItem.image" alt="Item Image" class="sub-item-image" :src="currentUrl+ '/images/image_list/' + subItem.image" width="75px"
                             height="75px"/>
                        <img v-else alt="Item Image" class="sub-item-image" :src="currentUrl+ '/common-assets/img/item_image.jpg'" width="75px"
                             height="75px"/>
                    </div>
                    <div class="col-lg-2">
                        <a @click="removeSubItem(index)"
                           class="btn btn-outline-danger m-btn m-btn--icon btn-sm m-btn--icon-only m-btn--pill m-btn--air">
                            <i class="fa fa-trash"></i>
                        </a>
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
                currentUrl: window.location.origin,
                subItems: subItems,
                subItem: {},
                items: items,
                csrf: document.head.querySelector('meta[name="csrf-token"]').content,
            }
        },

        mounted() {

        },

        methods: {
            addSubItem: function () {
                this.subItems.push({})
            },
            removeSubItem: function (index) {
                this.subItems.splice(index, 1);
            },
            getAllItems() {
                axious.get('get-all-items')
                    .then(response => this.items = response.data)
                    .catch(error => console.log(error))
            },
            getItemsData(index) {
                let subItem = this.subItems[index];
                if (subItem){
                    let item = this.items.find(x => x.id === subItem.item_id);
                    Vue.set(subItem, 'price', item.price);
                    Vue.set(subItem, 'image', item.image);
                }
            }

        }
    }
</script>

<style scoped>

</style>