<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
    </style>
</head>
<body>
    <div class="container-navbar">
        @include("navbar")

            <div class="container">
            <h1>Paramètre</h1>
            <section class="carte">
                <h2>Crée/Modifier un rôle </h2>

                <div class="information">
                    <div class="bloc">
                        <h1>Modifier l'utilisateur</h1>
                       
                        
                        
<div class="cree_role">
    <br>                             
    <form action="/settings" method="POST">
        @csrf
        <input type="hidden" name="action" value="role">
        <textarea  name="nom" id="nom" placeholder="Metter le nom de votre nouveau role"></textarea>
        <button type="submit">cree</button>
    </form>                      

    <br>
</div>
<form action="/settings/droit" method="POST">
    @csrf
    <input type="hidden"name="action" value="droit">
    <label>Rôle :</label>
    <select name="role_id" id="role_id">
        @foreach($roles as $role)
            <option value="{{$role->id }}">{{ $role->name }}</option>
        @endforeach
    </select>
    <div class="bloc">
        <legend>Choisissez les permissions a accorder&nbsp;:</legend>
        <br>
        @foreach ($allpermissions as $permission)
            <input type="checkbox" id="permission_{{ $permission->id }}" name_permission="{{$permission->name_permission}}" name="permissions[]" value="{{ $permission->id }}" />
            <label for="permission_{{ $permission->id }}">{{ ucfirst(str_replace('_', ' ', $permission->name_permission)) }}</label>
        @endforeach
        <br>
        <br>
        <button type="submit">Valider</button>
    </div>
</form>
    </div>
                </div>
            </section>

            <section class="carte">
                <h2>Supprimer un rôle</h2>
                <form action="settings/supprimer" method="POST">
                    @csrf
                    <label>Rôle :</label>
                    <select name="role_id" id="role_id">
                        @foreach($roles as $role)
                            <option value="{{$role->id }}">{{ $role->name }}</option>
                        @endforeach
                    </select>
                    <button type="submit">Supprimer</button>
                    </form>
            </section>
        </div>
    </div>
  
<style>
    h2 {
        color: blue;
        font-size: 30px;
        text-align: center;
    }

    .container {
        background-color: #f2f2f2;
        padding: 20px;
        border-radius: 10px;
    }

    body {background-color: rgb(234, 236, 245);}
    .carte {
    background: rgba(255, 255, 255, 0.9);
    margin: 40px 50px;
    padding: 20px;
    border-radius: 8px;
    }
    .information {
    display: flex;
    justify-content: space-between;
    gap: 20px;
    }
    .bloc {
    flex: 1;
    background: rgba(255, 255, 255, 0.95);
    padding: 15px;
    border-radius: 8px;
    box-shadow: 0 2px 6px rgba(0,0,0,0.1);
    text-align: center;
    }
    .bloc p{
        display:flex;
        justify-content:end;
        text-align: center;
    }
    .btn btn-primary{
        display:flex;
        justify-content:end;
        text-align: center;
    }
    .interieur{
        display: flex;
        flex-direction: column;
        border-radius: 8px;
        background-color: rgb(246, 242, 242);
        text-align: center;
        justify-content:start;
        align-items: start;
    }
</style>
<script>
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
            title: 'Erreur',
            html: '<ul style="text-align: left; padding-left: 20px;">@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>',
            confirmButtonColor: '#3c00ff',
            confirmButtonText: 'Corriger'
        });
    @endif

    const roleID = document.getElementById('role_id');
    const permissions = @json($permissions);
    roleID.addEventListener('change', function() {
        const selectedRole = this.value;
        const checkboxes = document.querySelectorAll('input[type="checkbox"]');
        
        console.log('Role sélectionné :', selectedRole);
        console.log('Permissions disponibles :', permissions);
        const rolePermissions = @json($roles->mapWithKeys(function($role) {
            return [$role->id => $role->getAllPermissionsNames()];
        }));

        checkboxes.forEach(checkbox => {
            const permissionName = checkbox.getAttribute('name_permission');

            console.log('Vérification de la permission :', permissionName);

            if (rolePermissions[selectedRole] && rolePermissions[selectedRole].includes(permissionName)) {
                checkbox.checked = true;
            } else {
                checkbox.checked = false;
            }
        });

        console.log(permissions[selectedRole]);
    });
</script>
</body>
</html>