// Password toggle  | data-pw-toggle -> for input, data-pw-toggle-btn -> for toggle button
$(document).on('click', '[data-pw-toggle-btn]', function () {
    const $input = $(this).siblings('[data-pw-toggle]');
    $input.attr('type', $input.attr('type') === 'password' ? 'text' : 'password');
    $(this).children('i').toggleClass('bi-eye bi-eye-slash');
});


// jQuery(document).ready(function ($) {
//     $('[data-select2="tag"]').select2({
//         allowClear: true,
//         width: '100%',
//         placeholder: function () {
//             return $(this).data('placeholder') || 'Select options';
//         }
//     });
// });