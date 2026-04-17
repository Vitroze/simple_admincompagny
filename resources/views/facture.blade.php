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
            max-height: 80vh;
            overflow-y: auto;
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

        .product-group {
            display: flex;
            gap: 10px;
            align-items: flex-end;
        }

        .additional-products {
            margin-top: 15px;
        }

        .additional-products .form-group {
            margin-bottom: 10px;
        }

        /* Set scroll and height container */
        .additional-products {
            max-height: 20px;
            overflow-y: auto;
        }

    </style>
</head>
<body>

    <div class="container-navbar">
        @include("navbar")

        <div class="container">
            <h1>Gérer les factures</h1>

            <div class="search-user">
                <input type="text" placeholder="Rechercher une facture..." />
                @if ($user->hasPermission('create_facture'))
                    <button class="btn btn-primary add-popup">Ajouter une facture</button>    
                @endif
            </div>

            <div class="user-management">
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Facture</th>
                            <th>Client</th>
                            <th>Status</th>
                            <th>Montant total</th>
                            <th>Date d'échéance</th>
                            <th>Dernière modification</th>

                            @if ($user->hasPermission('edit_facture') or $user->hasPermission('delete_facture') or $user->hasPermission('download_facture'))
                                <th>Actions</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Exemple d'utilisateur -->
                        @foreach ($factures as $facture)
                            <tr>
                                <td>{{ $facture->id }}</td>
                                @if ($user->hasPermission('edit_facture'))
                                    <td hidden>{{ $facture->products }}</td>
                                @endif
                                <td>{{ $facture->reference }}</td>
                                <td>{{ $facture->client_name }}</td>
                                <td>
                                    <span class="form-control {{ $facture->status === 'paid' ? 'green' : ($facture->status === 'pending' ? 'orange' : 'red') }}">
                                        {{ ucfirst($facture->status) }}
                                    </span>
                                </td>
                                <td>{{ number_format($facture->total_amount, 2) }} €</td>
                                <td>{{ \Carbon\Carbon::parse($facture->due_date)->format('d/m/Y') }}</td>
                                <td>{{ \Carbon\Carbon::parse($facture->updated_at)->format('d/m/Y H:i') }}</td>
                                @if ($user->hasPermission('edit_facture') or $user->hasPermission('delete_facture') or $user->hasPermission('download_facture'))
                                    <td>
                                        @if ($user->hasPermission('download_facture'))
                                            <button class="btn btn-primary" onclick="window.location.href='/factures-download/{{ $facture->id }}'">Télécharger</button>
                                        @endif

                                        @if ($user->hasPermission('edit_facture'))
                                            <button class="btn btn-primary modify-items" id="modify-{{ $facture->id }}">Modifier</button>
                                        @endif

                                        @if ($user->hasPermission('delete_facture'))
                                            <button class="btn btn-danger" id="delete-{{ $facture->id }}">Supprimer</button>
                                            <form id="{{ $facture->id }}" action="/factures/{{ $facture->id }}" method="POST" style="display: none;">
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
            <h2>Ajouter une facture</h2>
            <form class="factures_add" action="/factures-add" method="POST">
                @csrf
                <div class="form-group">
                    <label for="client_name">Nom du client</label>
                    <input type="text" id="client_name" name="client_name" required>
                </div>
                <div class="form-group">
                    <label for="status">Status</label>
                    <select id="status" name="status" required>
                        @foreach ($CONFIG_STATUS as $key => $value)
                            <option value="{{ $key }}">{{ $value }}</option>
                        @endforeach
                    </select>
                </div>

                <div id="additional-products"></div>

                <div class="form-group">
                    <label for="due_date">Date d'échéance</label>
                    <input type="date" id="due_date" name="due_date" required>
                </div>

                <input type="hidden" id="products" name="products">

                <button type="button" class="btn btn-primary" id="add-product">+ Ajouter un produit</button>
                <button type="submit" class="btn btn-primary add-item">Ajouter</button>
                <button type="button" class="btn btn-danger close-popup">Annuler</button>
            </form>
        </div>
    </div>

    <script>
        // Exemple de gestion des actions de modification et suppression
        let popup = document.querySelector('.popup_inputuser');
        let client_name = document.getElementById('client_name');
        let status = document.getElementById('status');
        let due_date = document.getElementById('due_date');
        let button_add = document.querySelector('.add-item');

        document.querySelector(".add-popup").addEventListener('click', () => {
            popup.style.display = 'flex';
            button_add.textContent = 'Ajouter';
            popup.querySelector('form').action = '/factures-add';
            client_name.value = '';
            status.value = 'pending';
            due_date.value = '';
            document.getElementById('additional-products').innerHTML = '';
        });

        button_add.addEventListener('click', (e) => {
            /* JSON */
            let products = [];
            for (let i = 1; i <= document.getElementById('additional-products').children.length; i++) {
                let name = document.getElementById(`product_name_${i}`).value;
                let price = parseFloat(document.getElementById(`price_${i}`).value);
                let quantity = parseInt(document.getElementById(`quantity_${i}`).value);
                if (name && !isNaN(price) && !isNaN(quantity)) {
                    products.push({ name, price, quantity });
                }
            }
            
            if (products.length === 0) {
                Swal.fire({
                    icon: 'error',
                    title: 'Erreur',
                    text: 'Veuillez ajouter au moins un produit avec des informations valides.',
                    confirmButtonColor: '#3c00ff',
                    confirmButtonText: 'Réessayer'
                });
                e.preventDefault();
                return;
            }

            document.getElementById('products').value = JSON.stringify(products);
            document.querySelector('.factures_add').submit();
            e.preventDefault();
        });

        let additionalProductsContainer = document.getElementById('additional-products');
        document.getElementById('add-product').addEventListener('click', () => {
            let productIndex = additionalProductsContainer.children.length + 1;
            let productGroup = document.createElement('div');
            productGroup.classList.add('product-group');
            productGroup.id = `product-group-${productIndex}`;
            productGroup.style.display = 'flex';
            productGroup.style.gap = '30px';
            productGroup.style.alignItems = 'flex-end';
            productGroup.innerHTML = `
                <div class="form-group">
                    <label for="product_name_${productIndex}">Nom du produit</label>
                    <input type="text" id="product_name_${productIndex}" name="additional_products[${productIndex}][name]" required>
                </div>
                <div class="form-group">
                    <label for="price_${productIndex}">Prix</label>
                    <input type="number" step="0.01" id="price_${productIndex}" name="additional_products[${productIndex}][price]" required>
                </div>
                <div class="form-group">
                    <label for="quantity_${productIndex}">Quantité</label>
                    <input type="number" id="quantity_${productIndex}" name="additional_products[${productIndex}][quantity]" required>
                </div>
                <div class="form-group">
                    <button type="button" class="btn btn-danger remove-product" style="height: 40px; margin-top: 22px;">-</button>
                </div>
            `;
            additionalProductsContainer.appendChild(productGroup);
        });

        document.querySelectorAll('.btn-danger').forEach(button => {
            if (button.classList.contains('close-popup')) {
                button.addEventListener('click', () => {
                    popup.style.display = 'none';
                });
            } else {
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
                            console.log(`Suppression de l'item avec ID: ${button.id.split('-')[1]}`);
                            document.getElementById(`${button.id.split('-')[1]}`).submit();
                        }
                    });
                });
            }
        });

        document.addEventListener('click', (e) => {
            if (e.target.classList.contains('remove-product')) {
                e.target.closest('.product-group').remove();
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

        document.querySelectorAll('.modify-items').forEach(button => {
            button.addEventListener('click', () => {
                popup.style.display = 'flex';
                client_name.value = button.parentElement.parentElement.children[3].textContent;
                status.value = button.parentElement.parentElement.children[4].textContent.trim().toLowerCase();
                due_date.value = button.parentElement.parentElement.children[6].textContent.split('/').reverse().join('-');
                let products = JSON.parse(button.parentElement.parentElement.children[1].textContent.replace(/€/g, '').trim());
                console.log(status.value);

                for (let i = 0; i < products.length; i++) {
                    let product = products[i];
                    let productGroup = document.createElement('div');
                    productGroup.classList.add('product-group');
                    productGroup.id = `product-group-${i + 1}`;
                    productGroup.style.display = 'flex';
                    productGroup.style.gap = '30px';
                    productGroup.style.alignItems = 'flex-end';
                    productGroup.innerHTML = `
                        <div class="form-group">
                            <label for="product_name_${i + 1}">Nom du produit</label>
                            <input type="text" id="product_name_${i + 1}" name="additional_products[${i + 1}][name]" value="${product.name}" required>
                        </div>
                        <div class="form-group">
                            <label for="price_${i + 1}">Prix</label>
                            <input type="number" step="0.01" id="price_${i + 1}" name="additional_products[${i + 1}][price]" value="${product.price}" required>
                        </div>
                        <div class="form-group">
                            <label for="quantity_${i + 1}">Quantité</label>
                            <input type="number" id="quantity_${i + 1}" name="additional_products[${i + 1}][quantity]" value="${product.quantity}" required>
                        </div>
                        <div class="form-group">
                            <button type="button" class="btn btn-danger remove-product" style="height: 40px; margin-top: 22px;">-</button>
                        </div>
                    `;
                    document.getElementById('additional-products').appendChild(productGroup);
                }

                popup.querySelector('form').action = `/factures/${button.id.split('-')[1]}`;
                button_add.textContent = 'Modifier';
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