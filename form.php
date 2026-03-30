<style>
/* --- Importation des polices --- */
@import url('https://fonts.googleapis.com/css2?family=Press+Start+2P&family=Quicksand:wght@500;700&display=swap');

.login-container-global {
    display: flex;
    flex-direction: column;
    gap: 20px;
    max-width: 600px;
    margin: 0 auto;
    padding: 20px;
}

/* --- Style des Cartes (Formulaires) --- */
.login-wrap {
    background-color: #ffffff;
    border-radius: 12px;
    padding: 20px 25px;
    position: relative;
    border: 4px solid transparent;
    box-shadow: 0 6px 0 rgba(0,0,0,0.15);
    transition: transform 0.15s ease-out, border-color 0.15s ease-out;
    display: flex;
    flex-direction: column;
}

.login-wrap:hover {
    transform: scale(1.02);
    border-color: #e74c3c; /* Bordure Rouge SMM2 */
}

/* --- Titre avec icône circulaire --- */
.subtitle {
    font-family: 'Quicksand', sans-serif;
    font-weight: 700;
    font-size: 1.2rem;
    color: #333;
    display: flex;
    align-items: center;
    margin-bottom: 20px;
}

.subtitle::before {
    content: '🎮';
    font-size: 1.2rem;
    background-color: #f1c40f;
    width: 45px;
    height: 45px;
    border-radius: 50%;
    display: flex;
    justify-content: center;
    align-items: center;
    margin-right: 15px;
    box-shadow: 0 3px 0 rgba(0,0,0,0.1);
    color: white;
}

/* Couleurs d'icônes par rôle */
.role-joueur .subtitle::before { content: '🕹️'; background-color: #3498db; }
.role-createur .subtitle::before { content: '🛠️'; background-color: #e67e22; }
.role-admin .subtitle::before { content: '👑'; background-color: #e74c3c; }

/* --- Champs de saisie --- */
.form-group {
    display: flex;
    flex-direction: column;
    gap: 5px;
    margin-bottom: 15px;
}

.form-group label {
    font-family: 'Quicksand', sans-serif;
    font-weight: 700;
    font-size: 0.85rem;
    color: #7f8c8d;
    text-transform: uppercase;
}

.form-group input {
    background: #ecf0f1;
    border: 2px solid #bdc3c7;
    border-radius: 8px;
    padding: 12px;
    font-family: 'Quicksand', sans-serif;
    font-size: 1rem;
    outline: none;
    transition: border-color 0.2s;
}

.form-group input:focus {
    border-color: #3498db;
}

/* --- Bouton de validation --- */
.btn-primary {
    background-color: #2ecc71; /* Vert SMM2 */
    color: white;
    font-family: 'Quicksand', sans-serif;
    font-weight: 700;
    font-size: 1rem;
    padding: 12px;
    border: none;
    border-radius: 8px;
    cursor: pointer;
    box-shadow: 0 4px 0 #27ae60;
    transition: all 0.1s;
}

.btn-primary:active {
    transform: translateY(2px);
    box-shadow: 0 2px 0 #27ae60;
}
</style>

<div class="login-wrap">
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
        <button type="submit" class="btn-primary">Se connecter (Joueur)</button>
    </form>
</div>
<br><br>
<div class="login-wrap">
    <div class="subtitle">Connexion Créateur</div>
    <form method="POST" action="login.php">
        <input type="hidden" name="role" value="createur">
        <div class="form-group">
            <label>Login</label>
            <input type="text" name="login" required>
        </div>
        <div class="form-group">
            <label>Mot de passe</label>
            <input type="password" name="passwd" required>
        </div>
        <button type="submit" class="btn-primary">Se connecter (Créateur)</button>
    </form>
</div>
<br><br>
<div class="login-wrap">
    <div class="subtitle">Connexion Admin</div>
    <form method="POST" action="login.php">
        <input type="hidden" name="role" value="admin">
        <div class="form-group">
            <label>Login</label>
            <input type="text" name="login" required>
        </div>
        <div class="form-group">
            <label>Mot de passe</label>
            <input type="password" name="passwd" required>
        </div>
        <button type="submit" class="btn-primary">Se connecter (Admin)</button>
    </form>
</div>