<-- si un gars pourvait tout mettre dans des css se serait un peu mieux mais bon /-->
<style>
.login-wrap {
    /* Fond blanc/cassé pour détacher la carte du fond de page */
    background-color: #ffffff; 
    border-radius: 20px;
    padding: 30px;
    border: 4px solid #e2d9c2; /* Bordure discrète */
    box-shadow: 0 10px 0 rgba(0,0,0,0.05); /* Ombre légère pour l'effet 3D */
    display: flex;
    flex-direction: column;
    gap: 20px;
}

.subtitle {
    font-weight: 700;
    font-size: 1.3rem;
    color: #5d5348;
    display: flex;
    align-items: center;
    gap: 12px;
}

.form-group {
    display: flex;
    flex-direction: column;
    gap: 8px;
}

.form-group label {
    font-weight: 700;
    font-size: 0.9rem;
    color: #8a7e70;
    text-transform: capitalize;
}

/* Style des inputs façon "barre blanche" de la photo */
input {
    background: #fdfcf9;
    border: 2px solid #e2d9c2;
    border-radius: 10px;
    padding: 14px 18px;
    font-family: 'Quicksand', sans-serif;
    font-size: 1.1rem;
    color: #5d5348;
    outline: none;
    transition: border-color 0.2s;
}

input:focus {
    border-color: #f1c40f; /* Jaune quand on clique */
    background: #fff;
}

/* Bouton Jaune SMM2 */
.btn-primary {
    background-color: #f1c40f;
    color: #5d5348;
    font-family: 'Quicksand', sans-serif;
    font-weight: 700;
    font-size: 1.5rem;
    padding: 15px;
    border: none;
    border-radius: 15px;
    cursor: pointer;
    box-shadow: 0 6px 0 #d4ad0c;
    transition: all 0.1s;
    margin-top: 10px;
}

.btn-primary:active {
    transform: translateY(4px);
    box-shadow: 0 2px 0 #d4ad0c;
}
</style>
<br><br>
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
<br><br>
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
<br><br>
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