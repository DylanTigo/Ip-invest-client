import $ from 'jquery';
window.$ = window.jQuery = $;

require('./bootstrap');
require('metismenu');
require('summernote/dist/summernote.min.js');



$(document).ready(function() {
    $('#menu').metisMenu();
    $('.summernote').summernote();
});