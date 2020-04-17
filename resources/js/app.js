/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');
import $ from 'jquery';

window.$ = window.jQuery = $;
window.datepicker = require('bootstrap-datepicker');
window.Clipboard = require('clipboard');

//init datepicker for add file form
$('#date').datepicker({
    autoclose: true,
    format: 'dd-mm-yyyy'
});

//init clipboard
new Clipboard('.btn-clipboard');

//Ajax add links
$('#add-link-form').submit(function (e) {
    let $form = $(this);
    $.ajax({
        url: $form.attr('action'),
        type: $form.attr('method'),
        data: $form.serialize(),
        dataType: 'json',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function (res) {
            //reset form
            $form.trigger('reset');
            //hide error alerts
            $('.alert-link-error').hide(200);
            //show success
            $('.alert-link-success').show(200);
            $('.alert-link-success').text(res.success);
            //remove empty tr if exist
            clearTable(res);
            //set tr form res
            setTr(res);

        },
        error: function (res) {
            //clear error text
            $('.alert-link-error').text('');
            //hide success alert
            $('.alert-link-error').hide(200);
            //show errors
            $.each(res.responseJSON, function (key, value) {
                jQuery('.alert-danger').show(200);
                jQuery('.alert-danger').append('<p>' + value + '</p>');
            });
        }
    });

    function clearTable(res) {
        let generalEmptyTable = $('.general-empty-table');
        let oneTimeEmptyTable = $('.one-time-empty-table');
        if (res.link.single_view === 0) {
            if (generalEmptyTable.length) {
                generalEmptyTable.remove();
            }
        } else {
            if (oneTimeEmptyTable.length) {
                oneTimeEmptyTable.remove();
            }
        }
    }

    function setTr(res) {
        let tr = '<tr id="row-' + res.link.id + '">' +
            '   <td>' +
            '       <div class="input-group">' +
            '           <input type="text" id="link-' + res.link.id + '" class="form-control" value="' + res.link.alias + '">' +
            '           <div class="input-group-append">' +
            '               <button class="btn btn-outline-info btn-clipboard" type="button" data-clipboard-target="#link-' + res.link.id + '">' +
            '                   <i class="fa fa-files-o" aria-hidden="true"></i>' +
            '               </button>' +
            '           </div>' +
            '       </div>' +
            '   </td>' +
            '   <td>' +
                    res.link.created_at +
            '   </td>';
        if (res.link.single_view === 0) {
            tr = tr +
                '   <td>'
                        + res.link.views +
                '   </td>' +
                '   <td>' +
                '   <button data-id="' + res.link.id + '" class="btn btn-outline-danger btn-sm delete-link-button">' +
                '       <i class="fa fa-trash-o" aria-hidden="true"></i>' +
                '   </button>' +
                '   </td>' +
                '</tr>';

            $('.general-links-row').prepend(tr);
        } else {
            //set status
            let columnStatus = res.link.views === 0
                ? '<span class="text-success">Active</span>'
                : '<span class="text-danger">Not active</span>';

            tr = tr +
                '   <td>'
                        + columnStatus +
                '   </td>' +
                '   <td>' +
                '       <button data-id="' + res.link.id + '" class="btn btn-outline-danger btn-sm delete-link-button">' +
                '           <i class="fa fa-trash-o" aria-hidden="true"></i>' +
                '       </button>' +
                '   </td>' +
                '</tr>';

            $('.one-time-links-row').prepend(tr);
        }
    }

    //disable submit
    e.preventDefault();

    //hide alerts
    window.setTimeout(function () {
        $('.alert-link').fadeOut(200);
    }, 6000);
});

//Ajax delete link
$(document).on('click', '.delete-link-button', function () {
    let button = $(this);
    let id = button.attr('data-id');

    $.ajax({
        url: '/links/' + id,
        type: 'DELETE',
        dataType: 'json',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },

        success: function (res) {
            //remove table row
            $('#row-' + id).remove();
            //show success
            $('.alert-link-success').show(200);
            $('.alert-link-success').text(res.success);
        },

        error: function () {
            alert('Error deleting link');
        }
    });

    //hide alerts
    window.setTimeout(function () {
        $('.alert-link').fadeOut(200);
    }, 6000);
});
