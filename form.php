<style>
/* --- Importation des polices --- */
@import url('https://fonts.googleapis.com/css2?family=Press+Start+2P&family=Quicksand:wght@500;700&display=swap');

.login-container-global {
    display: flex;
    flex-direction: column;
    gap: 25px;
    width: 100%;
}

/* --- Style des Cartes (Formulaires) --- */
.login-wrap {
    background-color: #ffffff;
    border-radius: 15px;
    padding: 25px;
    position: relative;
    border: 4px solid transparent;
    box-shadow: 0 8px 0 rgba(0,0,0,0.15);
    transition: transform 0.1s ease-out, border-color 0.1s;
}

.login-wrap:hover {
    transform: scale(1.02);
    border-color: #e74c3c; /* Bordure Rouge SMM2 au survol */
}

/* --- Titre avec icône circulaire --- */
.subtitle {
    font-family: 'Quicksand', sans-serif;
    font-weight: 700;
    font-size: 1.3rem;
    color: #333;
    display: flex;
    align-items: center;
    margin-bottom: 25px;
}

.subtitle::before {
    content: '';
    width: 50px;
    height: 50px;
    border-radius: 50%;
    display: flex;
    justify-content: center;
    align-items: center;
    margin-right: 20px;
    box-shadow: 0 4px 0 rgba(0,0,0,0.1);
    color: white;
    font-size: 1.4rem;
}

/* Couleurs et icônes par rôle */
.role-joueur .subtitle::before { content: '🕹️'; background-color: #3498db; }
.role-createur .subtitle::before { content: '🛠️'; background-color: #e67e22; }
.role-admin .subtitle::before { content: '👑'; background-color: #e74c3c; }

/* --- Champs de saisie --- */
.form-group {
    display: flex;
    flex-direction: column;
    gap: 8px;
    margin-bottom: 20px;
}

.form-group label {
    font-family: 'Quicksand', sans-serif;
    font-weight: 700;
    font-size: 0.9rem;
    color: #95a5a6;
    text-transform: uppercase;
    padding-left: 5px;
}

.form-group input {
    background: #f1f3f4;
    border: 3px solid #dee2e6;
    border-radius: 10px;
    padding: 14px;
    font-family: 'Quicksand', sans-serif;
    font-size: 1rem;
    outline: none;
    transition: border-color 0.2s;
}

.form-group input:focus {
    border-color: #f1c40f; /* Jaune SMM2 au focus */
}

/* --- Bouton Vert SMM2 --- */
.btn-primary {
    background-color: #2ecc71;
    color: white;
    font-family: 'Quicksand', sans-serif;
    font-weight: 700;
    font-size: 1.1rem;
    padding: 15px;
    border: none;
    border-radius: 12px;
    cursor: pointer;
    width: 100%;
    box-shadow: 0 5px 0 #27ae60;
    transition: all 0.1s;
}

.btn-primary:active {
    transform: translateY(3px);
    box-shadow: 0 2px 0 #27ae60;
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