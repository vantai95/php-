<template>
    <div>
        <table class="table table-striped table-bordered table-responsive-md">
            <thead>
            <tr class="table-dark text-center">
                <th>{{trans('admin.items.columns.name_en')}}</th>
                <th>{{trans('admin.items.columns.name_vi')}}</th>
                <th>{{trans('admin.items.columns.name_ja')}}</th>
                <th>{{trans('admin.items.columns.sequence')}}</th>

            </tr>
            </thead>
            <draggable :list="itemsNew" :options="{animation:150}" :element="'tbody'" @change="update">
                <tr class="text-center move-cursor" v-for="(item, index) in itemsNew">
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
        props: ['items'],

        // update data for
        methods: {
            update() {
                this.itemsNew.map((item, index) => {
                    item.sequence = index + 1;
                })
                axious.post('update-sequence', {
                    items: this.itemsNew,
                }).then((response) => {
                    // success message
                })
            }
        },

        //get csrf token
        data() {
            return {
                itemsNew: this.items,
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