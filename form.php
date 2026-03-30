<style>
/* --- Importation des polices --- */
@import url('https://fonts.googleapis.com/css2?family=Quicksand:wght@500;700&display=swap');

:root {
    --smm-yellow: #f1c40f;
    --smm-bg: #f3eee1; /* Fond crème de l'interface */
    --smm-text-dark: #7a6e5d; /* Marron pour les labels */
    --smm-text-main: #5d5348; /* Texte principal */
    --smm-border: #e2d9c2;
}

body {
    background-color: #dcd4c0;
    font-family: 'Quicksand', sans-serif;
}

.login-container-global {
    display: flex;
    flex-direction: column;
    max-width: 800px;
    margin: 40px auto;
    background-color: var(--smm-bg);
    border-radius: 15px;
    overflow: hidden;
    box-shadow: 0 10px 25px rgba(0,0,0,0.1);
}

/* --- Barre de titre jaune --- */
.header-settings {
    background-color: var(--smm-yellow);
    padding: 15px 25px;
    display: flex;
    align-items: center;
    gap: 15px;
}

.header-settings h2 {
    color: white;
    font-size: 2rem;
    margin: 0;
    text-shadow: 2px 2px 0px rgba(0,0,0,0.1);
}

/* --- Grille de contenu --- */
.login-content {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 20px;
    padding: 30px;
}

/* --- Style des Groupes (Champs) --- */
.form-group {
    display: flex;
    flex-direction: column;
    gap: 8px;
}

.form-group label {
    font-weight: 700;
    font-size: 0.95rem;
    color: var(--smm-text-dark);
}

/* --- Le "Wrapper" de l'input (Rectangle Blanc + Icône Jaune) --- */
.input-wrapper {
    display: flex;
    background: white;
    border-radius: 10px;
    border: 3px solid #fff;
    box-shadow: 0 4px 0 rgba(0,0,0,0.05);
    overflow: hidden;
    height: 60px;
    align-items: stretch;
}

.input-icon {
    background-color: var(--smm-yellow);
    width: 60px;
    display: flex;
    justify-content: center;
    align-items: center;
    color: white;
    font-size: 1.5rem;
}

.input-field {
    flex: 1;
    border: none;
    padding: 0 20px;
    font-size: 1.2rem;
    color: var(--smm-text-main);
    font-family: 'Quicksand', sans-serif;
    font-weight: 500;
    outline: none;
}

/* --- Bouton OK --- */
.footer-actions {
    display: flex;
    justify-content: center;
    padding-bottom: 30px;
}

.btn-primary {
    background-color: var(--smm-yellow);
    color: var(--smm-text-main);
    font-family: 'Quicksand', sans-serif;
    font-weight: 700;
    font-size: 1.8rem;
    padding: 12px 100px;
    border: none;
    border-radius: 12px;
    cursor: pointer;
    box-shadow: 0 6px 0 #d4ad0c;
    transition: transform 0.1s;
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