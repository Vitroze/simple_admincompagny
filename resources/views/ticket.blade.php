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
    <link rel="stylesheet" href="{{asset('style_ticket.css')}}">
</head>
<body>


    <div class="container-navbar">
        @include("navbar")

        <div class="container">
            <section class="ajouter_ticket">
            <h1>ajouter un tickets</h1>
                <form action="/tickets" method="post">
                        @csrf
                        <br>
                        <div classe="message_ticket">
                            <br>
                            <textarea  id="description" name="description" placeholder="Veiller explique votre demande"></textarea>
                            <br>
                        </div>
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
             <section classe="voire_ticket">
                <h2> Voir les tickets</h2>
                <div class="tout_bloc">
                    @foreach($tickets as $ticket)
                    <div class="bloc" >
                        <p class="description">{{$ticket->description}}</p>
                        <button class="bouton_repondre add_reponse" type="submit" data-id={{$ticket->id}}>Repondre</button>
                        <a href="/ticket_dialogue/{{$ticket->id}}">Voir plus</a>
                        <div class="date_statut">
                            <p >
                            {{$statusTicket[$ticket->statut]}}
                            </p>
                            <p>
                                {{ \Carbon\Carbon::parse($ticket->date_ticket)->format('d/m/Y') }}
                            </p>

                            @if ($user->hasPermission('change_status_ticket'))
                            <form action="/ticket/{{ $ticket->id }}/statut" method="POST" style="display:inline">
                                 @csrf
                                <select name="statut">
                                    @foreach($statusTicket as $key => $value)
                                        <option value="{{ $key }}" {{ $ticket->statut == $key ? 'selected' : '' }}>{{ $value }}</option>
                                    @endforeach
                                </select>
                                <button type="submit">Modifier</button>
                            </form>
                             @endif
                        </div>

                    </div>
                    @endforeach
            
                </div>
            </section>
            <div class="popup_inputuser" style="display: none;">
                <div class="popup-content">
                    <form action="/ticket_dialogue" method="POST">
                        @csrf
                        <div>
                        </div>
                        <div>
                        <input type="hidden" name="ticket_id" id="ticket_id">
                        <input type="text"id="reponse" name="reponse" placeholder="metez votre reponse">
                        </div>
                        <div>
                            <button type="button" class="btn btn-danger close-popup">Annuler</button>
                            <button type="submit"class=" btn_envoyer">Envoyer</button>
                        </div>
                    </form>

                </div>
            </div>

            <a href="/"></a>
        </div>
    </div>
    <style>
            textarea{
            width: 250px;
            height: 100px;
        }
        .description{
            width: 30%;     
            height: 100px;
            resize: none;
        }
        .ajouter_ticket{
            
            display: block;
            align-items: center;
           
        }
        .inscription{
            display: flex;
            flex-direction: row;  
            margin-left: 20px;  
            margin-right: 100px;
        }
      
        button{
            background: linear-gradient(70);
            margin-left: 35px;
            margin-right: 100px;
        }
        .btn_envoyer{
            margin-right: 100px;
            margin-left: 400px;
            margin: 20px;
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
        .popup-content input {
            width: 95%;
            padding: 10px;
            border: 1px solid var(--border-color);
            border-radius: 4px;
            width: auto;
            height: auto;
            padding-right: 200px;
            padding-bottom: 50px;
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

            let popup = document.querySelector('.popup_inputuser');
            let reponse = document.getElementById('reponse');
            let button_add = document.querySelector('.add_reponse');
            let ticket_id=document.getElementById('ticket_id')

            document.querySelectorAll(".bouton_repondre").forEach(button=>{button.addEventListener('click', () => {
                let id=button.getAttribute('data-id');
                popup.style.display = 'flex';
                ticket_id.value=id
                reponse.value= '';
                button_add.textContent = 'Repondre';
                });
            });

            document.querySelectorAll('.btn-danger').forEach(button => {
                if (button.classList.contains('close-popup')) {
                    button.addEventListener('click', () => {
                        popup.style.display = 'none';
                    });
                }
            });
            function confirmerSuppression(btn) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Confirmer la suppression ?',
                    text: 'Ce ticket sera supprimé définitivement !',
                    showCancelButton: true,
                    confirmButtonColor: '#ef4444',
                    cancelButtonColor: '#3c00ff',
                    confirmButtonText: 'Supprimer',
                    cancelButtonText: 'Annuler'
                }).then((result) => {
                if (result.isConfirmed) {
                    btn.closest('form').submit();
                }
                });
            }


            // statut modifié message
            @if (session('statut_modifie'))
                Swal.fire({
                    icon: 'success',
                    title: 'Inscription réussie !',
                    text: '{{ session('statut_modifie') }}',
                    confirmButtonColor: '#3c00ff',
                    timer: 3000,
                    timerProgressBar: true
                });
            @endif
            // ticket supprimé message
            @if (session('ticket_supprimr'))
                Swal.fire({
                    icon: 'success',
                    title: 'Inscription réussie !',
                    text: '{{ session('ticket_supprimr') }}',
                    confirmButtonColor: '#3c00ff',
                    timer: 3000,
                    timerProgressBar: true
                });
            @endif
    </script>
</body>
</html>