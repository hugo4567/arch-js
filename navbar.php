<style>
    /* Style basique pour la barre de navigation */
    nav {
        background-color: #1a1a1a; /* Noir futuriste */
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 0 5%;
        height: 70px;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        box-shadow: 0 2px 10px rgba(0,0,0,0.5);
    }

    nav .logo a {
        color: #00d4ff; /* Bleu néon */
        text-decoration: none;
        font-weight: 900;
        font-size: 1.5rem;
        letter-spacing: 2px;
    }

    nav ul {
        list-style: none;
        display: flex;
        margin: 0;
        padding: 0;
    }

    nav ul li {
        margin-left: 30px;
    }

    nav ul li a {
        color: #ffffff;
        text-decoration: none;
        font-size: 1rem;
        font-weight: 500;
        transition: 0.3s;
    }

    nav ul li a:hover {
        color: #00d4ff;
        text-shadow: 0 0 8px #00d4ff;
    }
</style>

<nav>
    <div class="logo"><a href="index.php">PIXEL BLASTER</a></div>
    <ul>
        <li><a href="index.php">Accueil</a></li>
        <li><a href="login.php">Connexion / Login</a></li>
    </ul>
</nav>