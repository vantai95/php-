<template>
    <div>
        <table class="table table-striped table-bordered table-responsive-md">
            <thead>
            <tr class="table-dark text-center">
                <th>{{ trans('admin.categories.columns.name_en') }}</th>
                <th>{{ trans('admin.categories.columns.name_vi') }}</th>
                <th>{{ trans('admin.categories.columns.name_ja') }}</th>
                <th>{{ trans('admin.categories.columns.sequence') }}</th>
            </tr>
            </thead>
            <draggable :list="categoriesNew" :options="{animation:150}" :element="'tbody'" @change="update">
                <tr class="text-center move-cursor" v-for="(category, index) in categoriesNew">
                    <td>{{ category.name_en }}</td>
                    <td>{{ category.name_vi }}</td>
                    <td>{{ category.name_ja }}</td>
                    <td>{{ category.sequence }}</td>
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
        props: ['categories'],

        // update data for
        methods: {
            update(){
                this.categoriesNew.map((category, index) => {
                    category.sequence = index + 1;
                })
                axious.post('update-sequence',{
                    categories: this.categoriesNew,
                }).then((response) => {
                    // success message
                })
            }
        },

        //get csrf token
        data() {
            return {
                categoriesNew: this.categories,
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