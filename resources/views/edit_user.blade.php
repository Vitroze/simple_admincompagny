<h1>Modifier l'utilisateur</h1>

<form action="/manage_users/{{ $user->id }}" method="POST">
    @csrf
    @method('PUT')

    <label>Nom :</label>
    <input type="text" name="name" value="{{ $user->name }}">

    <label>Email :</label>
    <input type="email" name="email" value="{{ $user->email }}">

    <label>Rôle :</label>
    <select name="usergroup">
        <option value="admin" {{ $user->usergroup == 'admin' ? 'selected' : '' }}>Admin</option>
        <option value="user" {{ $user->usergroup == 'user' ? 'selected' : '' }}>Membre</option>
    </select>

    <button type="submit">Enregistrer</button>
</form>
