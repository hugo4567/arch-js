<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Connexion – Chess Database</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="login-wrap">
    <div class="login-box">
        <div class="logo">♛</div>
        <div class="subtitle">Chess Database — Admin</div>

        <?php if (isset($erreur)): ?>
            <div class="alert alert-error">⚠ <?= htmlspecialchars($erreur) ?></div>
        <?php endif; ?>

        <form method="POST" action="admin_form.php">
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