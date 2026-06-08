// Password toggle  | data-pw-toggle -> for input, data-pw-toggle-btn -> for toggle button
$(document).on('click', '[data-pw-toggle-btn]', function () {
    const $input = $(this).siblings('[data-pw-toggle]');
    $input.attr('type', $input.attr('type') === 'password' ? 'text' : 'password');
    $(this).children('i').toggleClass('bi-eye bi-eye-slash');
});



// Login form
// $(document).on('submit', 'form[data-login-form]', async function (e) {
//     e.preventDefault();
//     const $form = $(this);
//     const $alert = $form.find('[data-login-alert]').removeClass('show');
//     const $spinner = $form.find('[data-login-spinner]');
//     const $label = $form.find('[data-login-label], [data-login-arrow]');
//     const $submit = $form.find('[data-login-submit]').prop('disabled', true);

//     const showAlert = msg => $form.find('[data-login-alert-msg]').text(msg) && $alert.addClass('show');

//     const email = $form.find('[data-login-email]').val().trim();
//     const pw = $form.find('[data-login-password]').val();

//     if (!email || !pw) return showAlert('Please fill in both fields.') && $submit.prop('disabled', false);

//     $label.hide();
//     $spinner.css('display', 'flex');

//     try {
//         const res = await fetch($form.data('login-endpoint') || '/api/admin/login', {
//             method: 'POST',
//             headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
//             body: JSON.stringify({ email, password: pw }),
//         });
//         const data = await res.json();
//         res.ok ? window.location.href = data.redirectTo || $form.data('login-redirect') || '/dashboard'
//             : showAlert(data.message || 'Invalid credentials. Please try again.');
//     } catch {
//         showAlert('Network error. Please try again.');
//     } finally {
//         $label.show();
//         $spinner.hide();
//         $submit.prop('disabled', false);
//     }
// });