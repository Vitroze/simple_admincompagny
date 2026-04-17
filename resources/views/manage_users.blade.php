<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>

    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap"
        rel="stylesheet"
    />
    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
    />
    
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

        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--primary-light);
            color: var(--text-dark);
        }

        /* ========== Navbar ========== */
        @include("style_navbar")

        /* ========== User Management Styles ========== */
        .container-navbar {
            display: flex;
        }

        .container {
            flex: 1;
            padding: 20px;
        }

        .user-management {
            background-color: var(--white);
            padding: 20px;
            border-radius: 8px;
            box-shadow: var(--shadow-sm);
        }

        .user-management table {
            width: 100%;
            border-collapse: collapse;
        }

        .user-management th, .user-management td {
            padding: 12px;
            border-bottom: 1px solid var(--border-color);
            text-align: left;
        }

        .user-management th {
            background-color: var(--primary-light);
        }

        .btn {
            padding: 8px 12px;
            border: none;
            border-radius: 4px;
            color: var(--white);
            cursor: pointer;
            transition: var(--transition);
        }

        .btn-primary {
            background-color: var(--primary-color);
        }

        .btn-primary:hover {
            background-color: var(--primary-dark);
        }

        .btn-danger {
            background-color: var(--error-color);
        }

        .btn-danger:hover {
            background-color: #c53030;
        }

        .search-user {
            margin-bottom: 20px;
        }
        
        .search-user input {
            width: 25%;
            padding: 10px;
            border: 1px solid var(--border-color);
            border-radius: 4px;
        }

        .search-user input:focus {
            outline: none;
            border-color: var(--primary-color);
            box-shadow: 0 0 0 2px var(--primary-light);
        }

        .search-user input::placeholder {
            color: var(--text-light);
        }

        .search-user input:hover {
            border-color: var(--primary-dark);
        }

        .search-user input:focus:hover {
            border-color: var(--primary-dark);
        }

                .popup_inputuser {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .popup-content {
            background-color: var(--white);
            padding: 20px;
            border-radius: 8px;
            width: 400px;
            box-shadow: var(--shadow-md);
        }

        .popup-content h2 {
            margin-top: 0;
            margin-bottom: 20px;
        }

        .popup-content .form-group {
            margin-bottom: 15px;
        }

        .popup-content label {
            display: block;
            margin-bottom: 5px;
            color: var(--text-medium);
        }

        .popup-content input {
            width: 95%;
            padding: 10px;
            border: 1px solid var(--border-color);
            border-radius: 4px;
        }

        .popup-content input:focus {
            outline: none;
            border-color: var(--primary-color);
            box-shadow: 0 0 0 2px var(--primary-light);
        }

        .popup-content input::placeholder {
            color: var(--text-light);
        }

        .popup-content input:hover {
            border-color: var(--primary-dark);
        }
        
        .popup-content select {
            width: 100%;
            padding: 10px;
            border: 1px solid var(--border-color);
            border-radius: 4px;
        }

        .form-control.green {
            background-color: #d1fae5;
            color: #22c55e;
        }

        .form-control.orange {
            background-color: #fff7ed;
            color: #f59e0b;
        }

        .form-control.red {
            background-color: #fee2e2;
            color: #ef4444;
        }

    </style>
</head>
<body>

    <div class="container-navbar">
        @include("navbar")

        <div class="container">
            <h1>Gérer les utilisateurs</h1>

            <div class="search-user">
                <input type="text" placeholder="Rechercher un utilisateur..." />
            </div>

            <div class="user-management">
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nom d'utilisateur</th>
                            <th>Email</th>
                            <th>Rôle</th>

                            @if ($hasPermissionEdit || $hasPermissionDelete)
                                <th>Actions</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Exemple d'utilisateur -->
                        @foreach ($users as $user)
                        <tr>
                            <td>{{ $user->id }}</td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->usergroup }}</td>

                            @if ($hasPermissionEdit || $hasPermissionDelete)
                                <td>
                                    @if ($hasPermissionEdit)
                                        <button class="btn btn-primary">Modifier</button>
                                    @endif

                                    @if ($hasPermissionDelete)
                                        <button class="btn btn-danger">Supprimer</button>
                                        <form action="/users/{{ $user->id }}" method="POST" style="display:inline;" id="delete-form-{{ $user->id }}">
                                            @csrf
                                            @method('DELETE')
                                        </form>
                                    @endif
                                </td>
                            @endif
                        </tr>
                        @endforeach

                    </tbody>
                    
                </table>
            </div>
        </div>
    </div>
    
    <div class="popup_inputuser" style="display: none;">
        <div class="popup-content">
            <h2>Modifier l'utilisateur</h2>
            <form class="form_action_user" action="/users/{{ $user->id }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="name">Nom de l'utilisateur</label>
                    <input type="text" id="name" name="name" required>
                </div>

                <div class="form-group">
                    <label for="usergroup">Rôle</label>
                    <select id="usergroup" name="usergroup" @if (!$hasPermissionSetRank) disabled @endif required>
                        @foreach ($ranks as $rank)
                            <option value="{{ $rank->name }}" class="form-control">{{ trim($rank->name) }}</option>
                        @endforeach
                    </select>
                </div>

                <button type="submit" class="btn btn-primary add-item">Modifier</button>
                <button type="button" class="btn btn-danger close-popup">Annuler</button>
            </form>
        </div>
    </div>

    <script>
        // Exemple de gestion des actions de modification et suppression
        let popup = document.querySelector('.popup_inputuser');
        document.querySelectorAll('.btn-primary').forEach(button => {
            if (button.classList.contains('add-item')) return;

            button.addEventListener('click', () => {
                popup.style.display = 'flex';
                document.getElementById('name').value = button.parentElement.parentElement.children[1].textContent;
                document.getElementById('usergroup').value = button.parentElement.parentElement.children[3].textContent.trim();
                document.querySelector('.form_action_user').action = `/users/${button.parentElement.parentElement.children[0].textContent}`;
            });
        });

        document.querySelectorAll('.btn-danger').forEach(button => {
            if (button.textContent === 'Supprimer') {
                button.addEventListener('click', () => {
                    Swal.fire({
                        title: 'Êtes-vous sûr?',
                        text: "Cette action est irréversible!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#ef4444',
                        cancelButtonColor: '#6b7280',
                        confirmButtonText: 'Oui, supprimer!',
                        cancelButtonText: 'Annuler'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            document.getElementById(`delete-form-${button.parentElement.parentElement.children[0].textContent}`).submit();
                        }
                    });
                });
            } else {
                button.addEventListener('click', () => {
                    popup.style.display = 'none';
                });
            }
        });

        document.querySelector('.search-user input').addEventListener('input', function() {
            const query = this.value.toLowerCase();
            document.querySelectorAll('.user-management tbody tr').forEach(row => {
                const username = row.children[1].textContent.toLowerCase();
                const email = row.children[2].textContent.toLowerCase();
                if (username.includes(query) || email.includes(query)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        });

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

        @if ($errors->any())
            Swal.fire({
                icon: 'error',
                title: 'Erreur de connexion',
                text: '{{ $errors->first() }}',
                confirmButtonColor: '#3c00ff',
                confirmButtonText: 'Réessayer'
            });
        @endif
    </script>
</body>
</html>