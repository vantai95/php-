<template>
    <div>
        <table class="table table-striped table-bordered table-responsive-md">
            <thead>
            <tr class="table-dark text-center">
                <th>{{ trans('admin.menus.columns.name_en') }}</th>
                <th>{{ trans('admin.menus.columns.name_vi') }}</th>
                <th>{{ trans('admin.menus.columns.name_ja') }}</th>
                <th>{{ trans('admin.menus.columns.sequence') }}</th>
            </tr>
            </thead>
            <draggable :list="menusNew" :options="{animation:150}" :element="'tbody'" @change="update">
                <tr class="text-center move-cursor" v-for="(item, index) in menusNew">
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

        // get data from menu
        props: ['menus'],

        // update data for
        methods: {
            update(){
                this.menusNew.map((item, index) => {
                  item.sequence = index + 1;
                })
                axious.post('update-sequence',{
                    menus: this.menusNew,
                }).then((response) => {
                   // success message
                })
            }
        },

        //get csrf token
        data() {
            return {
                menusNew: this.menus,
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