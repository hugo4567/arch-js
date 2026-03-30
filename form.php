<?php
session_start();

if (isset($_POST["login"])) {
    if ($_POST["login"] == "admin" && $_POST["passwd"] == "admin") {
        $_SESSION["admin"] = time();
        header("Location: admin_joueur.php");
        exit();
    } else {
        $erreur = "Login ou mot de passe incorrect.";
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Connexion</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
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
   }
   
   .form-group label {
       font-size: .82rem;
       text-transform: uppercase;
       letter-spacing: .08em;
       color: var(--gold-light);
       font-weight: 600;
   }
   
   .form-group input,
   .form-group select {
       background: var(--surface2);
       border: 1px solid var(--gold);
       border-radius: var(--radius);
       color: var(--text);
       padding: 10px 14px;
       font-family: 'DM Sans', sans-serif;
       font-size: .95rem;
       transition: border-color .2s, box-shadow .2s;
       outline: none;
       width: 100%;
   }
   
   .form-group input:focus,
   .form-group select:focus {
       border-color: var(--gold-light);
       box-shadow: 0 0 0 3px rgba(181,136,99,.2);
   }
   
   .form-group select option {
       background: var(--surface2);
       color: var(--gold-light);
   }
</style>
<div class="login-wrap">
    <div class="login-box">
        <div class="subtitle">Connexion joueur</div>

        <?php if (isset($erreur)): ?>
            <div class="alert alert-error">⚠ <?= htmlspecialchars($erreur) ?></div>
        <?php endif; ?>

        <form method="POST" action="form.php">
            <div class="form-group" style="margin-bottom:16px;">
                <label for="login">Login</label>
                <input type="text" id="login" name="login" autocomplete="username" autofocus>
            </div>
            <div class="form-group" style="margin-bottom:24px;">
                <label for="passwd">Mot de passe</label>
                <input type="password" id="passwd" name="passwd" autocomplete="current-password">
            </div>
            <button type="submit" class="btn btn-primary" style="width:100%;justify-content:center;">
                Se connecter
            </button>
        </form>
    </div>
</div>

<div class="login-wrap">
    <div class="login-box">
        <div class="subtitle">Connexion Createur</div>

        <?php if (isset($erreur)): ?>
            <div class="alert alert-error">⚠ <?= htmlspecialchars($erreur) ?></div>
        <?php endif; ?>

        <form method="POST" action="form.php">
            <div class="form-group" style="margin-bottom:16px;">
                <label for="login">Login</label>
                <input type="text" id="login" name="login" autocomplete="username" autofocus>
            </div>
            <div class="form-group" style="margin-bottom:24px;">
                <label for="passwd">Mot de passe</label>
                <input type="password" id="passwd" name="passwd" autocomplete="current-password">
            </div>
            <button type="submit" class="btn btn-primary" style="width:100%;justify-content:center;">
                Se connecter
            </button>
        </form>
    </div>
</div>

<div class="login-wrap">
    <div class="login-box">
        <div class="subtitle">Connexion Admin</div>

        <?php if (isset($erreur)): ?>
            <div class="alert alert-error">⚠ <?= htmlspecialchars($erreur) ?></div>
        <?php endif; ?>

        <form method="POST" action="form.php">
            <div class="form-group" style="margin-bottom:16px;">
                <label for="login">Login</label>
                <input type="text" id="login" name="login" autocomplete="username" autofocus>
            </div>
            <div class="form-group" style="margin-bottom:24px;">
                <label for="passwd">Mot de passe</label>
                <input type="password" id="passwd" name="passwd" autocomplete="current-password">
            </div>
            <button type="submit" class="btn btn-primary" style="width:100%;justify-content:center;">
                Se connecter
            </button>
        </form>
    </div>
</div>




</body>
</html>
