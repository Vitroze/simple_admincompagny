<!doctype html>
<html lang="fr">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>Connexion - Simple AdminCompagny</title>

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
                padding: 20px;
            }

            /* ========== Main Container ========== */
            main {
                width: 100%;
                max-width: 460px;
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

            /* ========== Login Card ========== */
            .login-card {
                background: var(--white);
                border-radius: 24px;
                padding: 48px 40px;
                box-shadow: var(--shadow-lg);
                position: relative;
                overflow: hidden;
            }

            .login-card::before {
                content: '';
                position: absolute;
                top: 0;
                left: 0;
                right: 0;
                height: 4px;
                background: linear-gradient(90deg, var(--primary-color), var(--primary-dark));
            }

            /* ========== Header ========== */
            .login-header {
                text-align: center;
                margin-bottom: 36px;
            }

            .login-card h2 {
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
            }

            .form-group input {
                width: 100%;
                border: 2px solid var(--border-color);
                border-radius: 12px;
                padding: 14px 16px 14px 46px;
                font-size: 15px;
                font-family: "Montserrat", sans-serif;
                transition: var(--transition);
                background: var(--white);
            }

            .form-group input:focus {
                outline: none;
                border-color: var(--primary-color);
                box-shadow: 0 0 0 4px var(--primary-light);
            }

            .form-group input:focus ~ .input-icon {
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
            }

            .password-toggle:hover {
                color: var(--primary-color);
            }

            /* ========== Form Row ========== */
            .form-row {
                display: flex;
                align-items: center;
                justify-content: space-between;
                margin: 20px 0 28px;
                font-size: 14px;
            }

            .remember {
                display: flex;
                align-items: center;
                gap: 8px;
                color: var(--text-medium);
                cursor: pointer;
                user-select: none;
            }

            .remember input[type="checkbox"] {
                width: 18px;
                height: 18px;
                cursor: pointer;
                accent-color: var(--primary-color);
            }

            .forgot {
                color: var(--primary-color);
                font-weight: 600;
                text-decoration: none;
                transition: var(--transition);
            }

            .forgot:hover {
                color: var(--primary-dark);
                text-decoration: underline;
            }

            /* ========== Buttons ========== */
            .btn-login {
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

            .btn-login::before {
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

            .btn-login:hover::before {
                width: 300px;
                height: 300px;
            }

            .btn-login:hover {
                transform: translateY(-2px);
                box-shadow: 0 6px 20px rgba(60, 0, 255, 0.4);
            }

            .btn-login:active {
                transform: translateY(0);
            }

            /* ========== Register Link ========== */
            .register {
                text-align: center;
                margin-top: 28px;
                padding-top: 24px;
                border-top: 1px solid var(--border-color);
                color: var(--text-medium);
                font-size: 14px;
            }

            .register a {
                color: var(--primary-color);
                font-weight: 600;
                text-decoration: none;
                transition: var(--transition);
            }

            .register a:hover {
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
            @media (max-width: 540px) {
                body {
                    padding: 12px;
                }

                .login-card {
                    padding: 36px 28px;
                    border-radius: 20px;
                }

                .login-card h2 {
                    font-size: 44px;
                }

                .subtitle {
                    font-size: 14px;
                }

                .form-group input {
                    padding: 12px 14px 12px 42px;
                    font-size: 14px;
                }

                .btn-login {
                    padding: 14px;
                    font-size: 15px;
                }
            }

            @media (max-width: 380px) {
                .login-card {
                    padding: 28px 20px;
                }

                .login-card h2 {
                    font-size: 38px;
                }

                .form-row {
                    flex-direction: column;
                    align-items: flex-start;
                    gap: 12px;
                }
            }

            /* ========== Loading State ========== */
            .btn-login.loading {
                pointer-events: none;
                opacity: 0.7;
            }

            .btn-login.loading::after {
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
            <section class="login-card" aria-labelledby="login-title">
                <div class="login-header">
                    <h2 id="login-title">Bienvenue</h2>
                    <p class="subtitle">
                        Connectez-vous pour accéder à votre compte
                    </p>
                </div>

                <form action="#" method="post" id="loginForm">
                    @csrf

                    <div class="form-group">
                        <label for="email">Adresse email</label>
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
                    </div>

                    <div class="form-group">
                        <label for="password">Mot de passe</label>
                        <div class="input-wrapper">
                            <input
                                type="password"
                                id="password"
                                name="password"
                                placeholder="Entrez votre mot de passe"
                                required
                                autocomplete="current-password"
                            />
                            <i class="fas fa-lock input-icon"></i>
                            <button type="button" class="password-toggle" aria-label="Afficher le mot de passe">
                                <i class="fas fa-eye" id="toggleIcon"></i>
                            </button>
                        </div>
                    </div>

                    <button class="btn-login" type="submit">
                        Se connecter
                    </button>
                </form>

                <p class="register">
                    Pas encore de compte ?
                    <a href="/register">Créer un compte</a>
                </p>
            </section>
        </main>

        <script>
            // Password Toggle
            const passwordToggle = document.querySelector('.password-toggle');
            const passwordInput = document.getElementById('password');
            const toggleIcon = document.getElementById('toggleIcon');

            passwordToggle.addEventListener('click', function() {
                const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                passwordInput.setAttribute('type', type);
                
                if (type === 'text') {
                    toggleIcon.classList.remove('fa-eye');
                    toggleIcon.classList.add('fa-eye-slash');
                    passwordToggle.setAttribute('aria-label', 'Masquer le mot de passe');
                } else {
                    toggleIcon.classList.remove('fa-eye-slash');
                    toggleIcon.classList.add('fa-eye');
                    passwordToggle.setAttribute('aria-label', 'Afficher le mot de passe');
                }
            });

            // Form Loading State
            const loginForm = document.getElementById('loginForm');
            const submitBtn = document.querySelector('.btn-login');

            loginForm.addEventListener('submit', function() {
                submitBtn.classList.add('loading');
                submitBtn.textContent = 'Connexion en cours';
            });

            // SweetAlert for errors
            @if ($errors->any())
                Swal.fire({
                    icon: 'error',
                    title: 'Erreur de connexion',
                    text: '{{ $errors->first() }}',
                    confirmButtonColor: '#3c00ff',
                    confirmButtonText: 'Réessayer'
                });
            @endif

            // Success message (if needed)
            @if (session('success'))
                Swal.fire({
                    icon: 'success',
                    title: 'Succès',
                    text: '{{ session('success') }}',
                    confirmButtonColor: '#3c00ff',
                    timer: 3000,
                    timerProgressBar: true
                });
            @endif
        </script>
    </body>
</html>
