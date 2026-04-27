<html>
<!DOCTYPE html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>dialogue</title>
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
            <section> 
                
                <div class="tout_bloc_dialogue">
                    <h2>Commentaire du ticket</h2>
                    @foreach($dialogues as $dialogue)
                    <div class="bloc_dialogue" >
                    
                        <p class="reponse">{{$dialogue->reponse}}</p> 
                  
                        <p class="user_nom">{{ Auth::user()->name }}</p>
                    
                        <p classe="date_dialogue">
                            {{\Carbon\Carbon::parse($dialogue->created_at)->format('d/m/Y H:i')}}
                            
                        </p>
                       
                    </div>
                    @endforeach
                    <a class="retoure" href="/ticket">retoure</a>
                </div>
                
            </section>
    


    </div>
    <style>
        .reponse{
            
            color:black;
            font-size: 14px;
            resize: none;
        }
        .user_nom{
            display: flex;
            justify-content: flex-end;
        }
        .bloc_dialogue{
            background-color: white;
            border-radius: 10px;
            padding: 20px;
            margin: 40px;
            box-shadow: 2px 5px 5px rgba(0,0,0,0.1);
            width: 500px;
            height: 60px;
            border-radius: 10%;
            border: solid #1d1c1c;
        }
        .tout_bloc_dialogue{
            max-width: 95%;
            background-color: white;
            margin-left: 20px;
            width: auto;
            height: auto;
            padding-bottom: 25px;
            padding-left: 20px;
            padding-top: 25px;
            padding-right: 20px;
        }

        .retoure{
            display: flex;
            justify-content: flex-end;
        }
       
        h2{
            margin-left: 20px;
        }
        .date_dialogue{
           display: flex;
           justify-content: flex-start;
           margin-bottom: 20px;
        }
    </style>
    <script>
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
            @if (session('reponse'))
                Swal.fire({
                    icon: 'success',
                    title: 'Inscription réussie !',
                    text: '{{ session('reponse') }}',
                    confirmButtonColor: '#3c00ff',
                    timer: 3000,
                    timerProgressBar: true
                });
            @endif
    </script>
</body>
</html>