function findById(items, id) {
    for (var i in items) {
        if (items[i].id == id) {
            return items[i];
        }
    }

    return null;
}

Vue.filter('category', function (id) {
    var category =  findById(this.categories, id)

    return category != null ? category.name : 'Sin categoria';
})

Vue.component('select-category', {
    template: '#select_category_tpl',
    props: ['categories', 'id']
});

Vue.component('note-row', {
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
            this.draft = $.extend({}, this.note);
            this.errors = []
            this.editing = true;
        },
        cancel: function () {
            this.editing = false;
        },
        update: function () {

            this.errors = [];

            this.$http.put('/api/v1/notes' + this.note.id, this.draft)
                .then(function (response) {
                    this.$parent.notes.$set(this.$parent.notes.indexOf(this.note), response.data.note);

                    this.editing = false;
                }, function (response) {
                    this.errors = response.data.errors;
                })
        },
        remove: function () {
            this.$http.delete('/api/v1/notes/' + this.note.id)
                .then(function (response) {
                    this.$parent.notes.$remov(this.note);
                })
        }
    }
});

var vm = new Vue({
    el: 'body',
    data: {
        new_note: {
            note: '',
            category_id: ''
        },
        errors: [],
        error: '',
        notes: [],
        categories: [
            {
                id: 1,
                name: 'Laravel'
            },
            {
                id: 2,
                name: 'Vue.js'
            },
            {
                id: 3,
                name: 'SASS'
            },
        ]
    },
    ready: function () {
        this.$http.get('/api/v1/notes')
            .then(function (response) {
                this.notes = response.data;
            });

        Vue.http.interceptors.push({
            response: function (response) {
                if (response.ok) {
                    return response;
                }

                $('#error_message').show();

                this.error = response.data.message;

                $('#error_message').delay(3000)
                    .fadeOut(1000, function () {
                        this.error = '';
                    })

                return response;
            }.bind(this)
        })
    },
    methods: {
        createNote: function () {
            this.errors = [];

            this.$http.post('/api/v1/notes', this.new_note)
                .then(function (response) {
                    this.notes.push(response.data.note);
                    this.new_note = {note: '', category_id: ''}
                }, function (response) {
                    this.errors = response.data.errors;
                })
        }
    },
    filters: {
    }
})