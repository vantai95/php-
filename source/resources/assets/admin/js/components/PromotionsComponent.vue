<template>
    <div>
        <table class="table table-striped table-bordered table-responsive-md">
            <thead>
            <tr class="table-dark text-center">
                <th style="width: 65px;"></th>
                <th>{{ trans('admin.promotions.columns.name_en') }}</th>
                <th>{{ trans('admin.promotions.columns.name_vi') }}</th>
                <th>{{ trans('admin.promotions.columns.name_ja') }}</th>
                <th>{{ trans('admin.promotions.columns.sequence') }}</th>
            </tr>
            </thead>
            <draggable :list="promotionsNew" :options="{animation:150}" :element="'tbody'" @change="update">
                <tr class="text-center move-cursor" v-for="(item, index) in promotionsNew">
                    <td v-if="item.image">
                        <img width="40" height="40" class="img-circle" style="border: 1px solid #ddd;" v-bind:src="'/images/image_list/'+item.image">
                    </td>
                    <td v-else>
                        <img width="40" height="40" class="img-circle" style="border: 1px solid #ddd;" v-bind:src="'/common-assets/img/promotion_image.png'">
                    </td>
                    <td>{{ item.name_en }}</td>
                    <td>{{ item.name_vi }}</td>
                    <td>{{ item.name_ja }}</td>
                    <td>{{ item.sequence }}</td>
                </tr>
            </draggable>
        </table>
    </div>
</template>

<script>
    import draggable from 'vuedraggable'

    import axious from 'axios'

    export default {

        //add components
        components: {
            draggable,
        },

        //get data from promotion
        props: ['promotions'],

        //update data for
        methods: {
            update(){
                this.promotionsNew.map((item, index) => {
                    item.sequence = index + 1;
                })
                axious.post('update-sequence',{
                    promotions: this.promotionsNew,
                }).then((response) => {
                    //success message
                })
            },
        },

        //get csrf token
        data() {
            return {
                promotionsNew: this.promotions,
                csrf: document.head.querySelector('meta[name="csrf-token"]').content,
            }
        },

        mounted() {
            console.log('Component Mounted')
        }
    }
</script>

<style scoped>

</style>