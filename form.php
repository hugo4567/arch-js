<style>
    .form-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 16px;
    }
    
    @media (max-width: 600px) {
        .form-grid { grid-template-columns: 1fr; }
    }
    
    .form-group {
        display: flex;
        flex-direction: column;
        gap: 6px;
        margin-bottom: 16px;
    }
    
    .form-group label {
        font-size: .82rem;
        text-transform: uppercase;
        letter-spacing: .08em;
        color: #b58863; /* Couleur gold fallback */
        font-weight: 600;
    }
    
    .form-group input {
        background: #fff;
        border: 1px solid #b58863;
        border-radius: 4px;
        padding: 10px 14px;
        font-size: .95rem;
        outline: none;
        width: 100%;
    }

    .login-wrap {
        margin-bottom: 30px;
        padding: 20px;
        border: 1px solid #ddd;
        border-radius: 8px;
        background: #fdfdfd;
    }

    .subtitle {
        font-weight: bold;
        font-size: 1.2rem;
        margin-bottom: 15px;
        color: #2c3e50;
        border-bottom: 2px solid #b58863;
        display: inline-block;
    }

    .btn-primary {
        background-color: #2c3e50;
        color: white;
        padding: 12px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        width: 100%;
        font-weight: bold;
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