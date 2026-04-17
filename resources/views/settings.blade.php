<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    
            <div class="container">
            <h1>Paramètre</h1>
            <section class="carte">
                <h2>Crée/Modifier un rôle </h2>

                <div class="information">
                    <div class="bloc">
                        <h1>Modifier l'utilisateur</h1>
                        <p>modifier</p>

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
                        <div class="bloc">
                        <h3>A</h3>
                        <p>Il</p>
                    </div>
                </div>
            </section>

            <section class="carte">
                <h2>Supprimer un rôle</h2>
                <div class="interieur">
                    <p>A</p>
                <div>
            </section>
            <section class="carte">
                <h2>  De</h2>
                <div class="interieur">
                    <p>Au</p>
                <div>
            </section>

        </div>
    </div>
    <h2>Système de permission</h2>
    <fieldset>
  <legend>Choisissez les permissions a accorder&nbsp;:</legend>

  <div>
    <input type="checkbox" id="scales" name="scales" checked />
    <label for="scales">Écailles</label>
    <input type="checkbox" id="horns" name="horns" />
    <label for="horns">Cornes</label>
    <input type="checkbox" id="horns" name="horns" />
    <label for="horns">Cornes</label>
    <input type="checkbox" id="horns" name="horns" />
    <label for="horns">Cornes</label>
    <input type="checkbox" id="horns" name="horns" />
    <label for="horns">Cornes</label>
    <input type="checkbox" id="horns" name="horns" />
    <label for="horns">Cornes</label>
    <input type="checkbox" id="horns" name="horns" />
    <label for="horns">Cornes</label>
    <input type="checkbox" id="horns" name="horns" />
    <label for="horns">Cornes</label>
    <input type="checkbox" id="horns" name="horns" />
    <label for="horns">Cornes</label>
    <input type="checkbox" id="horns" name="horns" />
    <label for="horns">Cornes</label>
  </div>

  <div>
    <input type="checkbox" id="horns" name="horns" />
    <label for="horns">Cornes</label>
    <input type="checkbox" id="horns" name="horns" />
    <label for="horns">Cornes</label>
    <input type="checkbox" id="horns" name="horns" />
    <label for="horns">Cornes</label>
    <input type="checkbox" id="horns" name="horns" />
    <label for="horns">Cornes</label>
    <input type="checkbox" id="horns" name="horns" />
    <label for="horns">Cornes</label>
    <input type="checkbox" id="horns" name="horns" />
    <label for="horns">Cornes</label>
    <input type="checkbox" id="horns" name="horns" />
    <label for="horns">Cornes</label>
    <input type="checkbox" id="horns" name="horns" />
    <label for="horns">Cornes</label>
    <input type="checkbox" id="horns" name="horns" />
    <label for="horns">Cornes</label>
    <input type="checkbox" id="horns" name="horns" />
    <label for="horns">Cornes</label>
    <input type="checkbox" id="horns" name="horns" />
    <label for="horns">Cornes</label>
  </div>
    <div>
    <input type="checkbox" id="scales" name="scales" checked />
    <label for="scales">Écailles</label>
    <input type="checkbox" id="horns" name="horns" />
    <label for="horns">Cornes</label>
    <input type="checkbox" id="horns" name="horns" />
    <label for="horns">Cornes</label>
    <input type="checkbox" id="horns" name="horns" />
    <label for="horns">Cornes</label>
    <input type="checkbox" id="horns" name="horns" />
    <label for="horns">Cornes</label>
    <input type="checkbox" id="horns" name="horns" />
    <label for="horns">Cornes</label>
    <input type="checkbox" id="horns" name="horns" />
    <label for="horns">Cornes</label>
    <input type="checkbox" id="horns" name="horns" />
    <label for="horns">Cornes</label>
  </div>

  <div>
    <input type="checkbox" id="horns" name="horns" />
    <label for="horns">Cornes</label>
    <input type="checkbox" id="horns" name="horns" />
    <label for="horns">Cornes</label>
    <input type="checkbox" id="horns" name="horns" />
    <label for="horns">Cornes</label>
    <input type="checkbox" id="horns" name="horns" />
    <label for="horns">Cornes</label>
    <input type="checkbox" id="horns" name="horns" />
    <label for="horns">Cornes</label>
    <input type="checkbox" id="horns" name="horns" />
    <label for="horns">Cornes</label>
    <input type="checkbox" id="horns" name="horns" />
    <label for="horns">Cornes</label>
    <input type="checkbox" id="horns" name="horns" />
    <label for="horns">Cornes</label>
    <input type="checkbox" id="horns" name="horns" />
    <label for="horns">Cornes</label>
    <input type="checkbox" id="horns" name="horns" />
    <label for="horns">Cornes</label>
    <input type="checkbox" id="horns" name="horns" />
    <label for="horns">Cornes</label>
    <input type="checkbox" id="horns" name="horns" />
    <label for="horns">Cornes</label><input type="checkbox" id="horns" name="horns" />
    <label for="horns">Cornes</label>

  </div>
</fieldset>
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
</style>
<style>
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
</body>
</html>