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
                <form action="/ticket" class="" method="get">

                        <br>
                        <br>
                        <textarea class="description" id="description" name="description" placeholder="Veiller explique votre demande"></textarea>
                        <br>
                        <br>
                        <br>
                        <button type="submit" >envoyer</button>

                </form>

            </section>
             <section classe="voire_ticket"  >
                <h2> Voir les tickes!!!</h2>
                <div>
                    
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
        
    
    
    </style>
</body>
</html>