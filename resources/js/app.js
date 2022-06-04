require('./bootstrap');
window.Noty = require('noty');
$(function(){
    $('[required]').each(function () {
        $(this).closest('.form-group')
            .find('label')
            .append('<sup class="text-danger mx-1">*</sup>');
    });
    $('nav i.fas').addClass('fa-fw mr-1');

    $('body').tooltip({
        selector: '[data-toggle="tooltip"]',
        html : true,
    }).on('click', '[data-toggle="tooltip"]', function () {
        // hide tooltip when you click on it
        $(this).tooltip('hide');
    });
});
Noty.overrideDefaults({
    layout: 'topRight',
    theme: 'bootstrap-v4',
    timeout: 3000
});
