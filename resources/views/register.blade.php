<!doctype html>
<html lang="fr">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>Inscription - Sup2Voyage</title>

        <!-- Fonts -->
        <link
            href="https://fonts.googleapis.com/css2?family=MonteCarlo&display=swap"
            rel="stylesheet"
        />
        <link
            href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&display=swap"
            rel="stylesheet"
        />

        <!-- Icons -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />

        <!-- SweetAlert2 -->
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

        <style>
            /* ========== Variables CSS ========== */
            :root {
                --primary-color: #3c00ff;
                --primary-dark: #2a00b3;
                --primary-light: rgba(60, 0, 255, 0.1);
                --text-dark: #2f2f2f;
                --text-medium: #4f4f4f;
                --text-light: #7a7a7a;
                --border-color: #e0e0e0;
                --success-color: #22c55e;
                --error-color: #ef4444;
                --warning-color: #f59e0b;
                --white: #ffffff;
                --shadow-sm: 0 2px 8px rgba(0, 0, 0, 0.08);
                --shadow-md: 0 8px 24px rgba(0, 0, 0, 0.12);
                --shadow-lg: 0 20px 60px rgba(0, 0, 0, 0.2);
                --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            }

            /* ========== Reset & Base ========== */
            * {
                margin: 0;
                padding: 0;
                box-sizing: border-box;
            }

            body {
                min-height: 100vh;
                font-family: "Montserrat", sans-serif;
                background: linear-gradient(
                        135deg,
                        rgba(60, 0, 255, 0.1) 0%,
                        rgba(11, 6, 51, 0.6) 100%
                    ),
                    url("resources/pictures/search_traval.webp") center / cover no-repeat fixed;
                display: flex;
                align-items: center;
                justify-content: center;
                padding: 40px 20px;
            }

            /* ========== Main Container ========== */
            main {
                width: 100%;
                max-width: 560px;
                animation: fadeInUp 0.6s ease-out;
            }

            @keyframes fadeInUp {
                from {
                    opacity: 0;
                    transform: translateY(30px);
                }
                to {
                    opacity: 1;
                    transform: translateY(0);
                }
            }

            /* ========== Register Card ========== */
            .register-card {
                background: var(--white);
                border-radius: 24px;
                padding: 48px 40px;
                box-shadow: var(--shadow-lg);
                position: relative;
                overflow: hidden;
            }

            .register-card::before {
                content: '';
                position: absolute;
                top: 0;
                left: 0;
                right: 0;
                height: 4px;
                background: linear-gradient(90deg, var(--primary-color), var(--primary-dark));
            }

            /* ========== Header ========== */
            .register-header {
                text-align: center;
                margin-bottom: 36px;
            }

            .register-card h2 {
                font-family: "MonteCarlo", cursive;
                font-size: 52px;
                color: var(--primary-color);
                margin-bottom: 8px;
                line-height: 1.2;
            }

            .subtitle {
                color: var(--text-medium);
                font-size: 15px;
                font-weight: 400;
                line-height: 1.5;
            }

            /* ========== Form Elements ========== */
            .form-row-group {
                display: grid;
                grid-template-columns: 1fr 1fr;
                gap: 20px;
                margin-bottom: 24px;
            }

            .form-group {
                margin-bottom: 24px;
                position: relative;
            }

            .form-group label {
                display: block;
                font-size: 14px;
                font-weight: 600;
                color: var(--text-dark);
                margin-bottom: 10px;
                transition: var(--transition);
            }

            .label-required::after {
                content: ' *';
                color: var(--error-color);
            }

            .input-wrapper {
                position: relative;
                display: flex;
                align-items: center;
            }

            .input-icon {
                position: absolute;
                left: 16px;
                color: var(--text-light);
                font-size: 16px;
                transition: var(--transition);
                pointer-events: none;
                z-index: 1;
            }

            .form-group input,
            .form-group select {
                width: 100%;
                border: 2px solid var(--border-color);
                border-radius: 12px;
                padding: 14px 16px 14px 46px;
                font-size: 15px;
                font-family: "Montserrat", sans-serif;
                transition: var(--transition);
                background: var(--white);
            }

            .form-group select {
                cursor: pointer;
                appearance: none;
                background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 12 12'%3E%3Cpath fill='%237a7a7a' d='M6 9L1 4h10z'/%3E%3C/svg%3E");
                background-repeat: no-repeat;
                background-position: right 16px center;
                padding-right: 40px;
            }

            .form-group input:focus,
            .form-group select:focus {
                outline: none;
                border-color: var(--primary-color);
                box-shadow: 0 0 0 4px var(--primary-light);
            }

            .form-group input:focus ~ .input-icon,
            .form-group select:focus ~ .input-icon {
                color: var(--primary-color);
            }

            .form-group input::placeholder {
                color: #b0b0b0;
            }

            /* ========== Password Toggle ========== */
            .password-toggle {
                position: absolute;
                right: 16px;
                background: none;
                border: none;
                color: var(--text-light);
                cursor: pointer;
                padding: 8px;
                font-size: 16px;
                transition: var(--transition);
                display: flex;
                align-items: center;
                justify-content: center;
                z-index: 2;
            }

            .password-toggle:hover {
                color: var(--primary-color);
            }

            /* ========== Password Strength ========== */
            .password-strength {
                margin-top: 10px;
                display: none;
            }

            .password-strength.active {
                display: block;
            }

            .strength-bar {
                height: 4px;
                background: var(--border-color);
                border-radius: 2px;
                overflow: hidden;
                margin-bottom: 6px;
            }

            .strength-bar-fill {
                height: 100%;
                width: 0%;
                transition: var(--transition);
                border-radius: 2px;
            }

            .strength-text {
                font-size: 12px;
                font-weight: 500;
            }

            .strength-weak .strength-bar-fill {
                width: 33%;
                background: var(--error-color);
            }

            .strength-medium .strength-bar-fill {
                width: 66%;
                background: var(--warning-color);
            }

            .strength-strong .strength-bar-fill {
                width: 100%;
                background: var(--success-color);
            }

            /* ========== Checkbox & Terms ========== */
            .terms-group {
                margin: 24px 0;
            }

            .checkbox-wrapper {
                display: flex;
                align-items: flex-start;
                gap: 10px;
                cursor: pointer;
                user-select: none;
            }

            .checkbox-wrapper input[type="checkbox"] {
                width: 18px;
                height: 18px;
                margin-top: 2px;
                cursor: pointer;
                accent-color: var(--primary-color);
                flex-shrink: 0;
            }

            .checkbox-wrapper label {
                font-size: 14px;
                color: var(--text-medium);
                cursor: pointer;
                line-height: 1.5;
                font-weight: 400;
            }

            .checkbox-wrapper a {
                color: var(--primary-color);
                font-weight: 600;
                text-decoration: none;
                transition: var(--transition);
            }

            .checkbox-wrapper a:hover {
                color: var(--primary-dark);
                text-decoration: underline;
            }

            /* ========== Buttons ========== */
            .btn-register {
                width: 100%;
                border: none;
                border-radius: 12px;
                padding: 16px;
                font-size: 16px;
                font-weight: 600;
                font-family: "Montserrat", sans-serif;
                background: linear-gradient(135deg, var(--primary-color), var(--primary-dark));
                color: var(--white);
                cursor: pointer;
                transition: var(--transition);
                box-shadow: 0 4px 12px rgba(60, 0, 255, 0.3);
                position: relative;
                overflow: hidden;
            }

            .btn-register::before {
                content: '';
                position: absolute;
                top: 50%;
                left: 50%;
                width: 0;
                height: 0;
                border-radius: 50%;
                background: rgba(255, 255, 255, 0.2);
                transform: translate(-50%, -50%);
                transition: width 0.6s, height 0.6s;
            }

            .btn-register:hover::before {
                width: 400px;
                height: 400px;
            }

            .btn-register:hover {
                transform: translateY(-2px);
                box-shadow: 0 6px 20px rgba(60, 0, 255, 0.4);
            }

            .btn-register:active {
                transform: translateY(0);
            }

            .btn-register:disabled {
                opacity: 0.6;
                cursor: not-allowed;
                transform: none;
            }

            /* ========== Login Link ========== */
            .login-link {
                text-align: center;
                margin-top: 28px;
                padding-top: 24px;
                border-top: 1px solid var(--border-color);
                color: var(--text-medium);
                font-size: 14px;
            }

            .login-link a {
                color: var(--primary-color);
                font-weight: 600;
                text-decoration: none;
                transition: var(--transition);
            }

            .login-link a:hover {
                color: var(--primary-dark);
                text-decoration: underline;
            }

            /* ========== Error Messages ========== */
            .error-message {
                display: none;
                color: var(--error-color);
                font-size: 13px;
                margin-top: 8px;
                padding: 8px 12px;
                background: rgba(239, 68, 68, 0.1);
                border-radius: 8px;
                border-left: 3px solid var(--error-color);
            }

            .error-message.active {
                display: block;
                animation: slideDown 0.3s ease-out;
            }

            @keyframes slideDown {
                from {
                    opacity: 0;
                    transform: translateY(-10px);
                }
                to {
                    opacity: 1;
                    transform: translateY(0);
                }
            }

            /* ========== Responsive Design ========== */
            @media (max-width: 640px) {
                body {
                    padding: 20px 12px;
                }

                .register-card {
                    padding: 36px 28px;
                    border-radius: 20px;
                }

                .register-card h2 {
                    font-size: 44px;
                }

                .subtitle {
                    font-size: 14px;
                }

                .form-row-group {
                    grid-template-columns: 1fr;
                    gap: 0;
                }

                .form-group input,
                .form-group select {
                    padding: 12px 14px 12px 42px;
                    font-size: 14px;
                }

                .btn-register {
                    padding: 14px;
                    font-size: 15px;
                }
            }

            @media (max-width: 380px) {
                .register-card {
                    padding: 28px 20px;
                }

                .register-card h2 {
                    font-size: 38px;
                }
            }

            /* ========== Loading State ========== */
            .btn-register.loading {
                pointer-events: none;
                opacity: 0.7;
            }

            .btn-register.loading::after {
                content: '';
                width: 16px;
                height: 16px;
                margin-left: 10px;
                border: 2px solid var(--white);
                border-top-color: transparent;
                border-radius: 50%;
                display: inline-block;
                animation: spin 0.6s linear infinite;
            }

            @keyframes spin {
                to {
                    transform: rotate(360deg);
                }
            }
        </style>
    </head>
    <body>
        <main>
            <section class="register-card" aria-labelledby="register-title">
                <div class="register-header">
                    <h2 id="register-title">Inscription</h2>
                    <p class="subtitle">
                        Créez votre compte pour découvrir vos prochaines aventures
                    </p>
                </div>

                <form action="#" method="post" id="registerForm">
                    @csrf

                        <div class="form-group">
                            <label for="name" class="label-required">Nom d'utilisateur</label>
                            <div class="input-wrapper">
                                <input
                                    type="text"
                                    id="name"
                                    name="name"
                                    placeholder="Votre nom d'utilisateur"
                                    value="{{ old('name') }}"
                                    required
                                    autocomplete="given-name"
                                />
                                <i class="fas fa-user input-icon"></i>
                            </div>
                        @error('email')
                        <div class="error-message active">
                            <i class="fas fa-exclamation-circle"></i> {{ $message }}
                        </div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="email" class="label-required">Adresse email</label>
                        <div class="input-wrapper">
                            <input
                                type="email"
                                id="email"
                                name="email"
                                placeholder="exemple@email.com"
                                value="{{ old('email') }}"
                                required
                                autocomplete="email"
                            />
                            <i class="fas fa-envelope input-icon"></i>
                        </div>
                        @error('email')
                        <div class="error-message active">
                            <i class="fas fa-exclamation-circle"></i> {{ $message }}
                        </div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="password" class="label-required">Mot de passe</label>
                        <div class="input-wrapper">
                            <input
                                type="password"
                                id="password"
                                name="password"
                                placeholder="Créez un mot de passe sécurisé"
                                required
                                autocomplete="new-password"
                            />
                            <i class="fas fa-lock input-icon"></i>
                            <button type="button" class="password-toggle" data-target="password" aria-label="Afficher le mot de passe">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                        <div class="password-strength" id="passwordStrength">
                            <div class="strength-bar">
                                <div class="strength-bar-fill"></div>
                            </div>
                            <span class="strength-text"></span>
                        </div>
                        @error('password')
                        <div class="error-message active">
                            <i class="fas fa-exclamation-circle"></i> {{ $message }}
                        </div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="password_confirmation" class="label-required">Confirmer le mot de passe</label>
                        <div class="input-wrapper">
                            <input
                                type="password"
                                id="password_confirmation"
                                name="password_confirmation"
                                placeholder="Confirmez votre mot de passe"
                                required
                                autocomplete="new-password"
                            />
                            <i class="fas fa-lock input-icon"></i>
                            <button type="button" class="password-toggle" data-target="password_confirmation" aria-label="Afficher le mot de passe">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                        @error('password_confirmation')
                        <div class="error-message active">
                            <i class="fas fa-exclamation-circle"></i> {{ $message }}
                        </div>
                        @enderror
                    </div>

                    <div class="terms-group">
                        <div class="checkbox-wrapper">
                            <input
                                type="checkbox"
                                id="terms"
                                name="terms"
                                required
                            />
                            <label for="terms">
                                J'accepte les <a href="#">conditions d'utilisation</a> et la <a href="#">politique de confidentialité</a>
                            </label>
                        </div>
                        @error('terms')
                        <div class="error-message active">
                            <i class="fas fa-exclamation-circle"></i> {{ $message }}
                        </div>
                        @enderror
                    </div>

                    <button class="btn-register" type="submit" id="submitBtn">
                        Créer mon compte
                    </button>
                </form>

                <p class="login-link">
                    Vous avez déjà un compte ?
                    <a href="/login">Se connecter</a>
                </p>
            </section>
        </main>

        <script>
            // Password Toggle for all password fields
            const passwordToggles = document.querySelectorAll('.password-toggle');
            
            passwordToggles.forEach(toggle => {
                toggle.addEventListener('click', function() {
                    const targetId = this.getAttribute('data-target');
                    const passwordInput = document.getElementById(targetId);
                    const icon = this.querySelector('i');
                    
                    const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                    passwordInput.setAttribute('type', type);
                    
                    if (type === 'text') {
                        icon.classList.remove('fa-eye');
                        icon.classList.add('fa-eye-slash');
                        this.setAttribute('aria-label', 'Masquer le mot de passe');
                    } else {
                        icon.classList.remove('fa-eye-slash');
                        icon.classList.add('fa-eye');
                        this.setAttribute('aria-label', 'Afficher le mot de passe');
                    }
                });
            });

            // Password Strength Checker
            const passwordInput = document.getElementById('password');
            const strengthIndicator = document.getElementById('passwordStrength');
            const strengthText = strengthIndicator.querySelector('.strength-text');

            function checkPasswordStrength(password) {
                let strength = 0;
                let feedback = '';

                if (password.length === 0) {
                    strengthIndicator.classList.remove('active');
                    return;
                }

                strengthIndicator.classList.add('active');

                // Length check
                if (password.length >= 8) strength++;
                if (password.length >= 12) strength++;

                // Character variety checks
                if (/[a-z]/.test(password) && /[A-Z]/.test(password)) strength++;
                if (/\d/.test(password)) strength++;
                if (/[^a-zA-Z\d]/.test(password)) strength++;

                // Remove previous strength classes
                strengthIndicator.classList.remove('strength-weak', 'strength-medium', 'strength-strong');

                if (strength <= 2) {
                    strengthIndicator.classList.add('strength-weak');
                    feedback = 'Mot de passe faible';
                } else if (strength <= 4) {
                    strengthIndicator.classList.add('strength-medium');
                    feedback = 'Mot de passe moyen';
                } else {
                    strengthIndicator.classList.add('strength-strong');
                    feedback = 'Mot de passe fort';
                }

                strengthText.textContent = feedback;
            }

            passwordInput.addEventListener('input', function() {
                checkPasswordStrength(this.value);
            });

            // Password Match Validation
            const passwordConfirmation = document.getElementById('password_confirmation');
            
            function validatePasswordMatch() {
                if (passwordConfirmation.value && passwordInput.value !== passwordConfirmation.value) {
                    passwordConfirmation.setCustomValidity('Les mots de passe ne correspondent pas');
                } else {
                    passwordConfirmation.setCustomValidity('');
                }
            }

            passwordInput.addEventListener('input', validatePasswordMatch);
            passwordConfirmation.addEventListener('input', validatePasswordMatch);

            // Form Loading State
            const registerForm = document.getElementById('registerForm');
            const submitBtn = document.getElementById('submitBtn');

            registerForm.addEventListener('submit', function(e) {
                // Validate terms checkbox
                const termsCheckbox = document.getElementById('terms');
                if (!termsCheckbox.checked) {
                    e.preventDefault();
                    Swal.fire({
                        icon: 'warning',
                        title: 'Conditions requises',
                        text: 'Vous devez accepter les conditions d\'utilisation pour continuer',
                        confirmButtonColor: '#3c00ff',
                        confirmButtonText: 'Compris'
                    });
                    return;
                }

                submitBtn.classList.add('loading');
                submitBtn.textContent = 'Création du compte';
            });

            // SweetAlert for errors
            @if ($errors->any())
                Swal.fire({
                    icon: 'error',
                    title: 'Erreur d\'inscription',
                    html: '<ul style="text-align: left; padding-left: 20px;">@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>',
                    confirmButtonColor: '#3c00ff',
                    confirmButtonText: 'Corriger'
                });
            @endif

            // Success message
            @if (session('success'))
                Swal.fire({
                    icon: 'success',
                    title: 'Inscription réussie !',
                    text: '{{ session('success') }}',
                    confirmButtonColor: '#3c00ff',
                    timer: 3000,
                    timerProgressBar: true
                });
            @endif
        </script>
    </body>
</html>
