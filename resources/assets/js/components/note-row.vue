<template>
     <tr class="animated" transition="bounce-out">
        <template v-if="! editing">
            <td>{{ note.category_id | category }}</td>
            <td>{{ note.note }}</td>
            <td>
                <a href="" @click.prevent="edit()"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></a>
                <a href="" @click.prevent="remove()">
                    <span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
                </a>
            </td>
        </template>
        <template v-else>
            <td>
                <select-category :categories="categories" :id.sync="draft.category_id"></select-category>
            </td>
            <td>
                <input type="text" v-model="draft.note" class="form-control">
                <ul v-if="errors.length">
                    <li v-for="error in errors" class="text-danger">{{ error }}</li>
                </ul>
            </td>
            <td>
                <a href="" @click.prevent="update()">
                    <span class="glyphicon glyphicon-ok" aria-hidden="true"></span>
                </a>
                <a href="" @click.prevent="cancel()">
                    <span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
                </a>
            </td>
        </template>
    </tr>
</template>


<script>

import Vue from 'vue'

export default {
    template: '#note_row_tpl',
    props: ['note', 'categories'],
    data: function () {
        return {
            editing: false,
            errors: [],
            draft: {}
        };
    },
    methods: {
        edit: function () {
            this.draft = Vue.util.extend({}, this.note);
            this.errors = []
            this.editing = true;
        },
        cancel: function () {
            this.editing = false;
        },
        update: function () {

            this.errors = [];
            this.$dispatch('update-note', this);
        },
        remove: function () {
            this.$dispatch('delete-note', this.note)
        }
    }
}
</script>