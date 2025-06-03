document.addEventListener('DOMContentLoaded', () => {
    const registrationForm = document.getElementById('registrationForm');
    const fullNameInput = document.getElementById('fullName');
    const usernameInput = document.getElementById('username');
    const passwordInput = document.getElementById('password');
    const confirmPasswordInput = document.getElementById('confirmPassword');
    const dobInput = document.getElementById('dob');
    const occupationSelect = document.getElementById('occupation');
    const countrySelect = document.getElementById('country');
    const termsCheckbox = document.getElementById('terms');
    const profilePictureInput = document.getElementById('profilePicture');
    const fileNameSpan = document.getElementById('fileName');

    // Password strength elements
    const passwordStrengthBar = document.querySelector('#passwordStrength .strength-bar::before'); // Pseudo-element
    const passwordStrengthText = document.querySelector('#passwordStrength .strength-text');
    const passwordStrengthContainer = document.getElementById('passwordStrength');

    // Show/Hide password toggles
    const togglePasswordIcons = document.querySelectorAll('.toggle-password');

    // --- Helper Functions ---
    function showError(inputElement, message) {
        const formGroup = inputElement.closest('.form-group');
        const errorMessageDiv = formGroup.querySelector('.error-message');

        formGroup.classList.add('invalid');
        errorMessageDiv.textContent = message;
        inputElement.setAttribute('aria-invalid', 'true');
        errorMessageDiv.setAttribute('aria-hidden', 'false');
    }

    function clearError(inputElement) {
        const formGroup = inputElement.closest('.form-group');
        const errorMessageDiv = formGroup.querySelector('.error-message');

        formGroup.classList.remove('invalid');
        errorMessageDiv.textContent = '';
        inputElement.setAttribute('aria-invalid', 'false');
        errorMessageDiv.setAttribute('aria-hidden', 'true');
    }

    // --- Validation Logic ---
    function validateFullName() {
        if (fullNameInput.value.trim() === '') {
            showError(fullNameInput, 'Họ và tên không được để trống.');
            return false;
        }
        clearError(fullNameInput);
        return true;
    }

    function validateUsername() {
        const username = usernameInput.value.trim();
        if (username === '') {
            showError(usernameInput, 'Tên đăng nhập không được để trống.');
            return false;
        }
        if (username.length < 4) {
            showError(usernameInput, 'Tên đăng nhập phải có ít nhất 4 ký tự.');
            return false;
        }
        // Regex: only alphanumeric and underscore
        if (!/^[a-zA-Z0-9_]+$/.test(username)) {
            showError(usernameInput, 'Tên đăng nhập chỉ được chứa chữ, số và dấu gạch dưới.');
            return false;
        }
        clearError(usernameInput);
        return true;
    }

    function checkPasswordStrength(password) {
        let strength = 0;
        let text = 'Rất yếu';
        let barColor = 'red';

        if (password.length >= 6) strength++;
        if (/[A-Z]/.test(password)) strength++; // Uppercase letters
        if (/[a-z]/.test(password)) strength++; // Lowercase letters
        if (/[0-9]/.test(password)) strength++; // Numbers
        if (/[!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?~]/.test(password)) strength++; // Special characters

        let barWidth = (strength / 5) * 100;

        if (strength <= 1) {
            text = 'Rất yếu'; barColor = 'var(--error-color)';
        } else if (strength <= 2) {
            text = 'Yếu'; barColor = '#ffb300'; // Orange
        } else if (strength <= 3) {
            text = 'Trung bình'; barColor = '#ffc107'; // Yellow
        } else if (strength <= 4) {
            text = 'Mạnh'; barColor = '#8bc34a'; // Light Green
        } else {
            text = 'Rất mạnh'; barColor = 'var(--success-color)';
        }

        // Apply styles to the pseudo-element via parent
        passwordStrengthContainer.style.setProperty('--bar-width', barWidth + '%');
        passwordStrengthContainer.style.setProperty('--bar-color', barColor);
        passwordStrengthText.textContent = text;
        
        // Remove previous strength classes and add current one
        passwordStrengthContainer.classList.remove('weak', 'medium', 'strong');
        if (strength <= 2) passwordStrengthContainer.classList.add('weak');
        else if (strength <= 4) passwordStrengthContainer.classList.add('medium');
        else passwordStrengthContainer.classList.add('strong');
    }

    function validatePassword() {
        const password = passwordInput.value;
        if (password === '') {
            showError(passwordInput, 'Mật khẩu không được để trống.');
            checkPasswordStrength(''); // Reset strength meter
            return false;
        }
        if (password.length < 6) {
            showError(passwordInput, 'Mật khẩu phải có ít nhất 6 ký tự.');
            return false;
        }
        // More robust password check (e.g., at least one number, one uppercase, one lowercase)
        if (!/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).{6,}$/.test(password)) {
             showError(passwordInput, 'Mật khẩu phải chứa ít nhất 1 chữ hoa, 1 chữ thường và 1 số.');
             return false;
        }
        clearError(passwordInput);
        return true;
    }

    function validateConfirmPassword() {
        if (confirmPasswordInput.value.trim() === '') {
            showError(confirmPasswordInput, 'Vui lòng xác nhận mật khẩu.');
            return false;
        }
        if (confirmPasswordInput.value !== passwordInput.value) {
            showError(confirmPasswordInput, 'Mật khẩu xác nhận không khớp.');
            return false;
        }
        clearError(confirmPasswordInput);
        return true;
    }

    function validateDob() {
        if (dobInput.value.trim() === '') {
            showError(dobInput, 'Vui lòng chọn ngày sinh.');
            return false;
        }
        // Optional: Check if age is reasonable (e.g., at least 13 years old)
        const birthDate = new Date(dobInput.value);
        const today = new Date();
        let age = today.getFullYear() - birthDate.getFullYear();
        const m = today.getMonth() - birthDate.getMonth();
        if (m < 0 || (m === 0 && today.getDate() < birthDate.getDate())) {
            age--;
        }
        if (age < 13) {
            showError(dobInput, 'Bạn phải từ 13 tuổi trở lên để đăng ký.');
            return false;
        }
        clearError(dobInput);
        return true;
    }

    function validateOccupation() {
        if (occupationSelect.value === '') {
            showError(occupationSelect, 'Vui lòng chọn nghề nghiệp.');
            return false;
        }
        clearError(occupationSelect);
        return true;
    }

    function validateCountry() {
        if (countrySelect.value === '') {
            showError(countrySelect, 'Vui lòng chọn quốc gia.');
            return false;
        }
        clearError(countrySelect);
        return true;
    }

    function validateTerms() {
        if (!termsCheckbox.checked) {
            showError(termsCheckbox, 'Bạn phải đồng ý với các điều khoản.');
            return false;
        }
        clearError(termsCheckbox);
        return true;
    }

    // --- Event Listeners for Real-time Validation ---
    fullNameInput.addEventListener('input', validateFullName);
    usernameInput.addEventListener('input', validateUsername);
    passwordInput.addEventListener('input', () => {
        validatePassword();
        checkPasswordStrength(passwordInput.value);
    });
    confirmPasswordInput.addEventListener('input', validateConfirmPassword);
    dobInput.addEventListener('change', validateDob); // Use 'change' for date input
    occupationSelect.addEventListener('change', validateOccupation);
    countrySelect.addEventListener('change', validateCountry);
    termsCheckbox.addEventListener('change', validateTerms); // Use 'change' for checkbox

    // --- File Input Update ---
    if (profilePictureInput && fileNameSpan) {
        profilePictureInput.addEventListener('change', (event) => {
            if (event.target.files.length > 0) {
                fileNameSpan.textContent = event.target.files[0].name;
                clearError(profilePictureInput); // Clear error if file selected
            } else {
                fileNameSpan.textContent = 'Chưa có tệp nào được chọn';
                // You might choose to show an error if file is required, but typically it's optional
            }
        });
        // Handle keyboard interaction for custom file upload button
        document.querySelector('.upload-button').addEventListener('keydown', (e) => {
            if (e.key === 'Enter' || e.key === ' ') {
                e.preventDefault(); // Prevent default scroll for space key
                profilePictureInput.click();
            }
        });
    }

    // --- Show/Hide Password Toggle ---
    togglePasswordIcons.forEach(toggle => {
        toggle.addEventListener('click', () => {
            const input = toggle.previousElementSibling; // The input field
            const type = input.getAttribute('type') === 'password' ? 'text' : 'password';
            input.setAttribute('type', type);
            // Toggle icon
            toggle.querySelector('i').classList.toggle('fa-eye');
            toggle.querySelector('i').classList.toggle('fa-eye-slash');
            // Update ARIA label
            toggle.setAttribute('aria-label', type === 'password' ? 'Hiện mật khẩu' : 'Ẩn mật khẩu');
        });
    });

    // --- Form Submission ---
    registrationForm.addEventListener('submit', (event) => {
        event.preventDefault(); // Prevent default form submission

        // Run all validations on submit
        const isFullNameValid = validateFullName();
        const isUsernameValid = validateUsername();
        const isPasswordValid = validatePassword();
        const isConfirmPasswordValid = validateConfirmPassword();
        const isDobValid = validateDob();
        const isOccupationValid = validateOccupation();
        const isCountryValid = validateCountry();
        const isTermsValid = validateTerms();

        // Check overall form validity
        if (isFullNameValid && isUsernameValid && isPasswordValid && isConfirmPasswordValid &&
            isDobValid && isOccupationValid && isCountryValid && isTermsValid) {
            alert('Đăng ký thành công! Chúc mừng bạn đã là thành viên của CLB Yêu Nhạc!');
            // In a real application, you would send the form data to the server here using fetch() or XMLHttpRequest
            // Example:
            /*
            const formData = new FormData(registrationForm);
            fetch('/api/register', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('Đăng ký thành công!');
                    registrationForm.reset(); // Clear form after successful submission
                } else {
                    alert('Có lỗi xảy ra: ' + data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Có lỗi mạng hoặc server. Vui lòng thử lại.');
            });
            */
            registrationForm.reset(); // For demonstration, reset form
            fileNameSpan.textContent = 'Chưa có tệp nào được chọn'; // Reset file name display
            passwordStrengthContainer.style.setProperty('--bar-width', '0%');
            passwordStrengthContainer.style.setProperty('--bar-color', '#ccc');
            passwordStrengthText.textContent = '';
            passwordStrengthContainer.classList.remove('weak', 'medium', 'strong');

        } else {
            // Find the first invalid element and scroll to it
            const firstInvalid = document.querySelector('.form-group.invalid input, .form-group.invalid select, .form-group.invalid textarea, .form-group.invalid .terms-checkbox input');
            if (firstInvalid) {
                firstInvalid.scrollIntoView({ behavior: 'smooth', block: 'center' });
                firstInvalid.focus(); // Focus on the first invalid field
            }
            alert('Vui lòng kiểm tra lại các thông tin bạn đã nhập.');
        }
    });

    // --- Reset button functionality ---
    const resetButton = document.getElementById('resetButton');
    if (resetButton) {
        resetButton.addEventListener('click', () => {
            // Clear all errors when reset button is clicked
            document.querySelectorAll('.form-group.invalid').forEach(el => {
                el.classList.remove('invalid');
                el.querySelector('.error-message').textContent = '';
            });
            fileNameSpan.textContent = 'Chưa có tệp nào được chọn'; // Reset file name display
            passwordStrengthContainer.style.setProperty('--bar-width', '0%');
            passwordStrengthContainer.style.setProperty('--bar-color', '#ccc');
            passwordStrengthText.textContent = '';
            passwordStrengthContainer.classList.remove('weak', 'medium', 'strong');
        });
    }
});