// ẩn hiện mật khẩu
const passwords = document.querySelectorAll(".password");
const togglePasswords = document.querySelectorAll(".toggle-password");

togglePasswords.forEach((togglePassword, index) => {
    togglePassword.addEventListener('click', () => {
        const pass = passwords[index];
        if (pass.getAttribute("type") === "password") {
            pass.setAttribute("type", "text");
            togglePassword.className = "fa-solid fa-eye-slash toggle-password";
        } else {
            pass.setAttribute("type", "password");
            togglePassword.className = "fa-solid fa-eye toggle-password";
        }
    });
});
