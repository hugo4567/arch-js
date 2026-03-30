<style>
/* --- Importation des polices --- */
@import url('https://fonts.googleapis.com/css2?family=Press+Start+2P&family=Quicksand:wght@500;700&display=swap');

body {
    margin: 0;
    padding: 60px 20px;
    font-family: 'Quicksand', sans-serif;
    /* Fond briques Pixel - VERSION ASSOMBRIE (Thème Nuit) */
    background: #111e22 radial-gradient(#2c3e50 20%, transparent 20%) 0 0,
                #111e22 radial-gradient(#2c3e50 20%, transparent 20%) 8px 8px;
    background-size: 16px 16px;
    image-rendering: pixelated;
    display: flex;
    justify-content: center;
}

.main-container {
    width: 100%;
    max-width: 650px;
}

h1 {
    font-family: 'Press Start 2P', cursive;
    font-size: 1.3rem;
    text-align: center;
    color: #eee; /* Texte clair */
    text-shadow: 3px 3px 0 #c0392b, 5px 5px 0 rgba(0,0,0,0.6); /* Ombre 3D Rouge Sombre */
    margin-bottom: 50px;
    line-height: 1.8;
}

/* --- Message d'erreur (adapté au Dark Mode) --- */
.error-msg {
    background-color: #c0392b; /* Rouge plus sombre */
    color: white;
    padding: 15px;
    border-radius: 8px;
    text-align: center;
    font-weight: 700;
    margin-bottom: 25px;
    border: 4px solid #e74c3c; /* Bordure rouge vive */
    box-shadow: 0 6px 0 rgba(0,0,0,0.2);
}
</style>