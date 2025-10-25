// Show Password Function
function showPassword(idPassword, idIcon){
    let inputPassword = document.getElementById(idPassword);
    let icon = document.getElementById(idIcon);

    if (inputPassword.type == "password" && icon.classList.contains("fa-eye")) {
        inputPassword.type = "text";
        icon.classList.replace("fa-eye", "fa-eye-slash");
    } else {
        inputPassword.type = "password";
        icon.classList.replace("fa-eye-slash", "fa-eye");
    }
} 

// Form Validation
(function() {
    const form = document.getElementById('signupForm');
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    const digitsRegex = /^\d+$/;

    const validators = {
        name: {
            emptyMsg: 'Por favor ingresa tu nombre.' ,
            invalidMsg: 'Nombre inválido.',
            test: val => val !== ''
        },
        nameUser: {
            emptyMsg: 'Por favor ingresa un usuario.' ,
            invalidMsg: 'Usuario inválido.',
            test: val => val !== ''
        },
        document: {
            emptyMsg: 'Por favor ingresa tu documento.',
            invalidMsg: 'Solo se permiten números.',
            test: val => val !== '' && digitsRegex.test(val)
        },
        email: {
            emptyMsg: 'Por favor ingresa un correo.',
            invalidMsg: 'Ingresa un correo válido.',
            test: val => val !== '' && emailRegex.test(val)
        },
        password: {
            emptyMsg: 'Por favor ingresa una clave.',
            invalidMsg: 'La clave debe tener al menos 6 caracteres.',
            test: val => val !== '' && val.length >= 6
        },
        confirmPassword: {
            emptyMsg: 'Por favor repite la clave.',
            invalidMsg: 'Las claves no coinciden.',
            test: val => {
                const pwd = document.getElementById('password');
                return val !== '' && pwd && val === pwd.value.trim();
            }
        }
    };

    function ensureErrorNode(input) {
        const container = input.parentNode;
        let err = container.querySelector('.error-text');
        if (!err) {
            err = document.createElement('div');
            err.className = 'error-text';
            container.appendChild(err);
        }
        return err;
    }

    function setError(input, message) {
        input.classList.add('input-error');
        const err = ensureErrorNode(input);
        err.textContent = message;
    }

    function clearError(input) {
        input.classList.remove('input-error');
        const container = input.parentNode;
        const err = container.querySelector('.error-text');
        if (err) err.textContent = '';
    }

    function validateField(input) {
        if (!input) return true;
        const id = input.id;
        const cfg = validators[id];
        if (!cfg) return true;
        const val = input.value.trim();
        if (val === '') {
            setError(input, cfg.emptyMsg);
            return false;
        }
        if (!cfg.test(val)) {
            setError(input, cfg.invalidMsg);
            return false;
        }
        clearError(input);
        return true;
    }

    function firstInvalid(fields) {
        for (const f of fields) {
            if (!validateField(f)) return f;
        }
        return null;
    }

    if (form) {
        const nameInput = document.getElementById('name');
        const userInput = document.getElementById('nameUser');
        const emailInput = document.getElementById('email');
        const docInput = document.getElementById('document');
        const passwordInput = document.getElementById('password');
        const confirmInput = document.getElementById('confirmPassword');
        const managed = [nameInput, userInput, emailInput, docInput, passwordInput, confirmInput];
        form.addEventListener('submit', function(e) {
            let valid = true;
            for (const inp of managed) {
                if (!validateField(inp)) valid = false;
            }
            if (!valid) {
                e.preventDefault();
                const first = firstInvalid(managed);
                if (first) first.focus();
            }
        });
        managed.forEach(inp => {
            if (!inp) return;
            inp.addEventListener('blur', () => validateField(inp));
            inp.addEventListener('input', () => {
                const id = inp.id;
                const val = inp.value.trim();
                if (validators[id] && validators[id].test(val)) {
                    clearError(inp);
                } else {
                    if (id === 'document' && val !== '' && !digitsRegex.test(val)) {
                        setError(inp, validators[id].invalidMsg);
                    }
                }
                if (id === 'password' && confirmInput) {
                    if (confirmInput.value.trim() !== '') validateField(confirmInput);
                }
                if (id === 'confirmPassword') {
                    validateField(confirmInput);
                }
            });
        });
    }
})();

// AJAX Form Submission
$("#signupForm").submit(function(e){
    e.preventDefault();
    let form_data = $(this).serialize();
    $.ajax({
        url: "../../view/home/store.php",
        type: "POST",
        data: form_data,
        success:function(response){
            console.log(response);
            if(response == 2){
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Este correo ya esta en uso!',
                });
            }else if(response == 0){
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Completa todos los campos!',
                });
            }else if(response == 3){
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Las contraseñas no coinciden!',
                });
            }else{
                Swal.fire({
                    position: 'center',
                    icon: 'success',
                    title: 'Tu registro ha sido completado',
                    showConfirmButton: false,
                    timer: 1500
                });
                setTimeout(() => {
                    window.location="login.php";
                }, 1000);
            }
        },
        error: function(error){
            console.log(error);
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Something went wrong!',
            });
        }
    });
    console.log(form_data);
});

// AJAX Form Submission
$("#loginForm").submit(function(e){
    e.preventDefault();
    let form_data = $(this).serialize();
    $.ajax({
        url: "../../view/home/verify.php",
        type: "POST",
        data: form_data,
        success: function(response){
            console.log(response);
            if(response == 1){
                Swal.fire({
                    position: 'center',
                    icon: 'success',
                    title: 'Bienvenido!',
                    showConfirmButton: false,
                    timer: 1500
                });
                setTimeout(() => {
                    window.location = 'suppliers.php';
                }, 1500);
            }else{
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Credenciales Incorrectas',
                });
            }
        },
        error: function(response){
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'unexpected error',
            });
        }
    });
});