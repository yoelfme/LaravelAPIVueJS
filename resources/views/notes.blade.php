@extends('layout')

@section('content')
	<div class="row">
        <div class="col-md-8 col-md-offset-2">
            <h1>Styde | VueJS</h1>
    
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Categoria</th>
                        <th>Nota</th>
                        <th style="width: 50px;">&nbsp;</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="note in notes" :note.sync="note" :categories="categories" is="note-row"></tr>
                    <tr>
                        <td><select-category :categories="categories" :id.sync="new_note.category_id"></select-category></td>
                        <td><input type="text" v-model="new_note.note" class="form-control"></td>
                        <td>
                            <a @@click="createNote()">
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
	@verbatim
	<template id="select_category_tpl">
        <select v-model="id" class="form-control">
            <option value="">- Elija categoria -</option>
            <option v-for="category in categories" :value="category.id">
                {{ category.name }}
            </option>
        </select>
    </template>

    <template id="note_row_tpl">
        <tr>
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
                    <select-category :categories="categories" :id.sync="note.category_id"></select-category>
                </td>
                <td><input type="text" v-model="note.note" class="form-control"></td>
                <td>
                    <a href="" @click.prevent="update()">
                        <span class="glyphicon glyphicon-ok" aria-hidden="true"></span>
                    </a>
                </td>
            </template>
        </tr>
    </template>
    @endverbatim

    <script src="{{ url('js/vue.js') }}"></script>
    <script src="{{ url('js/notes.js') }}"></script>
@endsection