/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');
import $ from 'jquery';

window.$ = window.jQuery = $;
window.datepicker = require('bootstrap-datepicker');

//init datepicker for add file form
$('#date').datepicker({
    autoclose: true,
    format: 'dd-mm-yyyy'
});

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
            jQuery('.alert-link-error').hide(200);
            //show success
            jQuery('.alert-link-success').show(200);
            jQuery('.alert-link-success').text(res.success);
            //remove empty tr if exist
            clearTable(res);
            //set tr form res
            setTr(res);

        },
        error: function (res) {
            //clear error text
            jQuery('.alert-link-error').text('');
            //hide success alert
            jQuery('.alert-link-error').hide(200);
            //show errors
            jQuery.each(res.responseJSON, function (key, value) {
                jQuery('.alert-danger').show(200);
                jQuery('.alert-danger').append('<p>' + value + '</p>');
            });
        }
    });
    //disable submit
    e.preventDefault();
    //hide alerts
    window.setTimeout(function () {
        $('.alert-link').fadeOut(200);
    }, 6000);

    function clearTable(res) {
        if (res.link.single_view === 0) {
            if ($('.general-empty-table').length) {
                $('.general-empty-table').remove();
            }
        } else {
            if ($('.one-time-empty-table').length) {
                $('.one-time-empty-table').remove();
            }
        }
    }

    function setTr(res) {
        let tr = "<tr><td>" + res.link.alias + "</td>" +
            "<td>" + res.link.created_at + "</td>";
        if (res.link.single_view === 0) {
            tr = tr + "<td>" + res.link.views + "</td></tr>";
            $('.general-links-row').prepend(tr);
        } else {
            let columnStatus = res.link.views === 0
                ? '<span class="text-success">Active</span>'
                : '<span class="text-danger">Not active</span>';
            tr = tr + "<td>" + columnStatus + "</td></tr>";
            $('.one-time-links-row').prepend(tr);
        }
    }
});
