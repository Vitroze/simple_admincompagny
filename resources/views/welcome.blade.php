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

        .container-navbar {
            display: flex;
        }

        .container {
            flex: 1;
            padding: 20px;
        }

        body {background-color: rgb(234, 236, 245);}

.barre_tache {
  display: flex;
  justify-content: center;
  background: rgba(126, 88, 180, 0.8);
  padding: 15px 0;
}
.link {
  margin: 0 20px;
  text-decoration: none;
  font-size: 1.1rem;
}
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
</head>
<body>

    <div class="container-navbar">
        @include("navbar")

        <div class="container">
            <h1>Accueil</h1>
            <section class="carte">
                <h2>Présentation de la journée</h2>

                <div class="information">
                    <div class="bloc">
                        <h3>Dernnier utilisateur</h3>
                        <p>{{ $lastUser->name }} ({{ $lastUser->created_at->format('d/m/Y') }})</p>
                    </div>
                    <div class="bloc">
                        <h3>Activité</h3>
                        <p>Ticket traité : {{ $countTicketClosing }}</p>
                        <p>Ticket à traité : {{ $countTicketOpen }}</p>
                        <p>Nombre d'utilisateurs : {{ $users }}</p>
                    </div>
                    <div class="bloc">
                        <h3>Actualité</h3>
                        <p>Il n'y a aucune actualité à afficher.</p>
                    </div>
                </div>
            </section>

            <section class="carte">
                <h2>Évènements</h2>
                <div class="interieur">
                    <p>Aucun évènement à afficher</p>
                <div>
            </section>
            <section class="carte">
                <h2>  Dernier changement effectuer</h2>
                <div class="interieur">
                    <p>Aucun changement à afficher</p>
                <div>
            </section>

        </div>
    </div>

    <script>
        
        // SweetAlert for errors
        @if ($errors->any())
            Swal.fire({
                icon: 'error',
                title: 'Erreur de validation',
                html: '<ul style="text-align: left; padding-left: 20px;">@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>',
                confirmButtonColor: '#3c00ff',
                confirmButtonText: 'OK'
            });
        @endif

        // Success message
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