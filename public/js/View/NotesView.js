/*global $, jQuery, alert, console, require, shortcut*/
/*jslint browser: true*/
function NotesView() {
    'use strict';
    this.show = function () {
        console.log("In notes View");
        window.location.href = './notes';
    };
}
