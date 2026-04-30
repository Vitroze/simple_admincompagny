@php
    $droit = App\Models\Droit::where('user_id', Auth::id())->first();
@endphp


<nav>
    <ul class="users">
            <a href="/profile">
                <i class="fas fa-user"></i>
                <span>{{ Auth::user()->name }}</span>
            </a>
    </ul>

    <ul class="navbar">
        <li>
            <a href="/">
                <i class="fas fa-home"></i>
                <span>Accueil</span>
            </a>
            
        </li>
        <li>
            @if ($droit && $droit->ticket)
            <a href="/ticket">
                <i class="fas fa-ticket-alt"></i>
                <span>Tickets</span>
            </a>
            @else
            
            @endif
        </li>
        <li>
            @if ($droit && $droit->gerer_user)
            <a href="/manage-users">
                <i class="fas fa-users"></i>
                <span>Gérer les utilisateurs</span>
            </a>
            @endif
        </li>
        <li>
            @if ($droit && $droit->invantaire)
            <a href="/storage">
                <i class="fas fa-database"></i>
                <span>Inventaire</span>
            </a>
            @endif
        </li>
        <li>
            @if ($droit && $droit->gerer_facture)
            <a href="/generate-factures">
                <i class="fas fa-file-invoice"></i>
                <span>Générer des factures/devis</span>
            </a>
            @endif
        </li>
        <li>
            @if ($droit && $droit->parametre)
            <a href="/settings">
                <i class="fas fa-cog"></i>
                <span>Paramètres</span>
            </a>
            @endif
        </li>

        <li>
            <a href="/logout">
                <i class="fas fa-sign-out-alt"></i>
                <span>Déconnexion</span>
            </a>
        </li>
    </ul>
</nav>