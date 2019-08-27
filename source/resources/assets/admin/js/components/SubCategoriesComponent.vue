<template>
    <div>
        <table class="table table-striped table-bordered table-responsive-md">
            <thead>
            <tr class="table-dark text-center">
                <th>{{trans('admin.sub_categories.columns.name_en')}}</th>
                <th>{{trans('admin.sub_categories.columns.name_vi')}}</th>
                <th>{{trans('admin.sub_categories.columns.name_ja')}}</th>
                <th>{{trans('admin.sub_categories.columns.sequence')}}</th>

            </tr>
            </thead>
            <draggable :list="subCategoriesNew" :options="{animation:150}" :element="'tbody'" @change="update">
                <tr class="text-center move-cursor" v-for="(subCategory, index) in subCategoriesNew">
                    <td>{{ subCategory.name_en }}</td>
                    <td>{{ subCategory.name_vi }}</td>
                    <td>{{ subCategory.name_ja }}</td>
                    <td>{{ subCategory.sequence }}</td>
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
        props: ['sub_categories'],

        // update data for
        methods: {
            update() {
                this.subCategoriesNew.map((subCategory, index) => {
                    subCategory.sequence = index + 1;
                })
                axious.post('update-sequence', {
                    sub_categories: this.subCategoriesNew,
                }).then((response) => {
                    // success message
                })
            }
        },

        //get csrf token
        data() {
            return {
                subCategoriesNew: this.sub_categories,
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