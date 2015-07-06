/*global $, jQuery, alert, console, require, shortcut*/
/*jslint browser: true*/
var notesController = {
    notesView: null,
    init: function () {
        'use strict';
        this.notesView = new NotesView();
        this.notesView.show();
    }
};