// login.blade.php
// register.blade.php

function togglePassword(fieldId) {
    const passwordField = document.getElementById(fieldId);
    const eyeIcon = document.querySelector(`#${fieldId}-eye`);

    if (passwordField.type === 'password') {
        passwordField.type = 'text';
        eyeIcon.classList.add('text-blue-500'); // Tambahkan efek ketika visible
    } else {
        passwordField.type = 'password';
        eyeIcon.classList.remove('text-blue-500');
    }
}
