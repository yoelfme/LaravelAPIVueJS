@extends('layout')

@section('content')
	<div class="row">
        <div class="col-md-8 col-md-offset-2">
            <h1>Styde | VueJS</h1>

            <div class="alert-container">
                <p v-show="alert.display" class="alert alert-danger" id="error_message" transition="fade">@{{ alert.message }}</p>
            </div>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Categoria</th>
                        <th>Nota</th>
                        <th style="width: 50px;">&nbsp;</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="note in notes"
                        :note="note"
                        :categories="categories"
                        is="note-row"
                        @update-note="updateNote"
                        @delete-note="deleteNote"></tr>
                    <tr>
                        <td><select-category :categories="categories" :id.sync="new_note.category_id"></select-category></td>
                        <td>
                            <input type="text" v-model="new_note.note" class="form-control">
                            <ul v-if="errors.length">
                                <li v-for="error in errors" class="text-danger">@{{ error }}</li>
                            </ul>
                        </td>
                        <td>
                            <a @@click.prevent="createNote()">
                                <span class="glyphicon glyphicon-ok" aria-hidden="true"></span>
                            </a>
                        </td>
                    </tr>
                </tbody>
            </table>  
        </div>
    </div>
@endsection

@section('scripts')
    <style>
        .fade-transition {
            transition: all 1s ease;
            opacity: 100;
        }

        .fade-enter, .fade-leave {
            opacity: 0;
        }

        .alert-container {
            height: 60px;
        }
    </style>

    <script type="text/javascript" src="js/main.js"></script>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.5.2/animate.min.css">
@endsection