<!DOCTYPE html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ticket</title>
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
            <section class="ajouter_ticket">
            <h1>ajouter un tickes</h1>
                <form action="/tickets" method="post">
                        @csrf
                        <br>
                        <br>
                        <textarea class="description" id="description" name="description" placeholder="Veiller explique votre demande"></textarea>
                        <br>
                        <br>
                        <div class="inscription">
                            <br>
                            <input type="date"id="date_tiket"name="date_tiket" placeholder="date du jour">
                            <br>
                            <br>
                            <button type="submit" >envoyer</button>
                        </div>
                </form>

            </section>
            //afficher les ticker stocke dans la base de donné 
             <section classe="voire_ticket"  >
                <h2> Voir les tickes!!!</h2>
                <div class="tout_bloc">
                    @foreach($tickets as $ticket)
                    <div class="bloc" >
                        <p class="description">{{$ticket->description}}</p>
                        <div class="date_statut">
                        <p >
                        {{$ticket->statut}}
                        
                       </p>
                        <p >
                            {{ \Carbon\Carbon::parse($ticket->date_ticket)->format('d/m/Y') }}
                        
                        </p>
                        </div>

                    </div>
                    @endforeach
            
                </div>




            </section>
            <a href="/"></a>
        </div>
    </div>
    <style>
        .description{
        width: 30%;     
        height: 100px;
        resize: none;
        }
        .ajouter_ticket{
            
            display: block;
            align-items: center;
           
        }
        /* button{
            display: flex;
            justify-content: flex-end;

        } */
        .inscription{
           
            padding-left: auto ;     
        }
        button{
            background: linear-gradient(70)
        }
        .bloc{
            background-color: white;
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 20px;
            box-shadow: 2px 5px 5px rgba(0,0,0,0.1);
            width: 300px;
            height: 170px;
            border-radius: 10%;
            border: solid #1d1c1c;
        }

        .description{
            color:black;
            font-size: 14px;
        }
        .tout_bloc{
            max-width: 95%;
            background: red;
            display: grid;
            grid-template-columns: repeat(3, 400px);
            margin-left: 20px;
        }

        .date_statut{
            display: flex;
            color: #1d1c1c;
            flex-direction:row ;
            justify-content: space-between;

        }
        
    
    </style>
    <script>
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