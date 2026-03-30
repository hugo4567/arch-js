<?php
session_start();

// Si déjà connecté, rediriger vers index
if (isset($_SESSION["admin"])) {//isset est une fonction qui vérifie si une variable est définie et n'est pas null
    header("Location: index.php");// en gros si la session admin existe, redirige vers index.php
    exit;
}

$error = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $login = isset($_POST["login"]) ? $_POST["login"] : "";
    $passwd = isset($_POST["passwd"]) ? $_POST["passwd"] : "";
    
    if ($login === "admin" && $passwd === "admin") {
        $_SESSION["admin"] = time();
        header("Location: index.php");
        exit;
    } else {
        $error = "Identifiants invalides";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Connexion Admin</title>
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <style>
        body {
            font-family: "Times New Roman", Georgia, Serif;
            background-color: #ecf0f1;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }
        
        .login-container {
            background-color: white;
            padding: 40px;
            border-radius: 6px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
        }
        
        h1 {
            font-family: "Playfair Display";
            letter-spacing: 3px;
            color: #2c3e50;
            text-align: center;
            margin-bottom: 30px;
        }
        
        form {
            display: grid;
            gap: 15px;
        }
        
        label {
            font-weight: bold;
            color: #2c3e50;
            font-size: 0.95rem;
        }
        
        input {
            padding: 12px;
            border: 1px solid #bdc3c7;
            border-radius: 4px;
            font-size: 1rem;
        }
        
        input:focus {
            outline: none;
            border-color: #2c3e50;
            box-shadow: 0 0 5px rgba(44, 62, 80, 0.3);
        }
        
        button {
            background-color: #2c3e50;
            color: white;
            padding: 12px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 1rem;
            font-weight: bold;
            transition: background-color 0.2s ease;
        }
        
        button:hover {
            background-color: #34495e;
        }
        
        .error {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
            padding: 12px;
            border-radius: 4px;
            margin-bottom: 15px;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <h1>Connexion Admin</h1>
        
        <?php if ($error): ?>
            <div class="error"><?php echo $error; ?></div>
        <?php endif; ?>
        
        <form method="POST">
            <div>
                <label for="login">Login:</label>
                <input type="text" id="login" name="login" required autofocus>
            </div>
            <div>
                <label for="passwd">Mot de passe:</label>
                <input type="password" id="passwd" name="passwd" required>
            </div>
            <button type="submit">Connexion</button>
        </form>
    </div>
</body>
</html>
