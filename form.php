<style>
.login-wrap {
    /* Style "Interface" sur fond sombre */
    background-color: #f3eee1; /* On garde le crème pour le contraste */
    border-radius: 20px;
    padding: 25px;
    border: 4px solid #ffffff;
    box-shadow: 0 10px 0 rgba(0,0,0,0.4);
    display: flex;
    flex-direction: column;
    gap: 15px;
}

.subtitle {
    font-weight: 700;
    color: #5d5348;
    font-size: 1.2rem;
    border-bottom: 2px solid #e2d9c2;
    padding-bottom: 10px;
    margin-bottom: 5px;
}

.form-group {
    display: flex;
    flex-direction: column;
    gap: 5px;
}

/* On remet les inputs bien propres */
input {
    background: white;
    border: 2px solid #e2d9c2;
    border-radius: 10px;
    padding: 12px 15px;
    font-family: 'Quicksand', sans-serif;
    font-size: 1rem;
    color: #5d5348;
    outline: none;
}

input:focus {
    border-color: #f1c40f;
}

/* Le bouton "C'est parti" / "Gérer" */
.btn-primary {
    background-color: #f1c40f;
    color: #5d5348;
    font-weight: 700;
    font-size: 1.3rem;
    padding: 12px;
    border: none;
    border-radius: 12px;
    cursor: pointer;
    box-shadow: 0 6px 0 #d4ad0c;
    transition: all 0.1s;
    margin-top: 10px;
}

.btn-primary:hover {
    background-color: #f3d047;
}

.btn-primary:active {
    transform: translateY(4px);
    box-shadow: 0 2px 0 #d4ad0c;
}
</style>

<div class="login-container-global">
    <div class="login-wrap role-joueur">
        <div class="subtitle">Connexion Joueur</div>
        <form method="POST" action="login.php">
            <input type="hidden" name="role" value="joueur">
            <div class="form-group">
                <label>Login</label>
                <input type="text" name="login" required>
            </div>
            <div class="form-group">
                <label>Mot de passe</label>
                <input type="password" name="passwd" required>
            </div>
            <button type="submit" class="btn-primary">C'est parti !</button>
        </form>
    </div>

    <div class="login-wrap role-createur">
        <div class="subtitle">Connexion Créateur</div>
        <form method="POST" action="login.php">
            <input type="hidden" name="role" value="createur">
            <div class="form-group">
                <label>Nom de créateur</label>
                <input type="text" name="login" required>
            </div>
            <div class="form-group">
                <label>Code secret</label>
                <input type="password" name="passwd" required>
            </div>
            <button type="submit" class="btn-primary">Éditer mes niveaux</button>
        </form>
    </div>

    <div class="login-wrap role-admin">
        <div class="subtitle">Administration</div>
        <form method="POST" action="login.php">
            <input type="hidden" name="role" value="admin">
            <div class="form-group">
                <label>Identifiant Maître</label>
                <input type="text" name="login" required>
            </div>
            <div class="form-group">
                <label>Mot de passe</label>
                <input type="password" name="passwd" required>
            </div>
            <button type="submit" class="btn-primary">Gérer le monde</button>
        </form>
    </div>
</div>