// Elements
const loginBtn = document.getElementById('loginBtn');
const loginModal = document.getElementById('loginModal');
const loginForm = document.getElementById('loginForm');
const loginError = document.getElementById('loginError');
const usernameInput = document.getElementById('username');
const passwordInput = document.getElementById('password');

if (loginBtn && loginModal && loginForm) {

    // Open modal and focus username
    loginBtn.addEventListener('click', function(e) {
        e.preventDefault();
        loginModal.style.display = 'block';
        usernameInput.focus();
    });

    // Close modal
    const closeBtn = loginModal.querySelector('.close');
    if (closeBtn) {
        closeBtn.addEventListener('click', () => loginModal.style.display = 'none');
    }

    // Close when clicking outside modal
    window.addEventListener('click', e => {
        if (e.target === loginModal) loginModal.style.display = 'none';
    });

    // Close with Esc key
    window.addEventListener('keydown', e => {
        if (e.key === "Escape") loginModal.style.display = 'none';
    });

    // Client-side validation
    loginForm.addEventListener('submit', function(e) {
        const username = usernameInput.value.trim();
        const password = passwordInput.value.trim();

        if (!username || !password) {
            e.preventDefault(); // Prevent submit
            loginError.textContent = 'Please enter both username and password.';
            loginError.style.display = 'block';
        } else {
            loginError.style.display = 'none'; 
            // Let PHP handle authentication & role-based redirect
        }
    });

    // Hide error when typing
    usernameInput.addEventListener('input', () => loginError.style.display = 'none');
    passwordInput.addEventListener('input', () => loginError.style.display = 'none');
}
document.addEventListener('DOMContentLoaded', () => {
    const footer = document.querySelector('footer'); // select footer
    const adminBtn = document.getElementById('adminLoginBtn'); // select admin button

    // Ensure button starts hidden
    adminBtn.style.display = 'none';

    // Show button only when footer is double-clicked
    footer.addEventListener('dblclick', () => {
    adminBtn.style.display = adminBtn.style.display === 'block' ? 'none' : 'block';
});
});

// Server-side errors handled in HTML via inline script
// Example in index.php:v
// <?php if (isset($_SESSION['login_error'])): ?>
// <script>
// document.addEventListener('DOMContentLoaded', () => {
//     const loginError = document.getElementById('loginError');
//     const loginModal = document.getElementById('loginModal');
//     if (loginError && loginModal) {
//         loginError.textContent = "<?= $_SESSION['login_error']; ?>";
//         loginError.style.display = 'block';
//         loginModal.style.display = 'block';
//     }
// });
// </script>
// <?php unset($_SESSION['login_error']); ?>

