<style>
/* --- Importation des polices --- */
@import url('https://fonts.googleapis.com/css2?family=Press+Start+2P&family=Quicksand:wght@500;700&display=swap');

.login-container-global {
    display: flex;
    flex-direction: column;
    gap: 25px;
    max-width: 600px;
    margin: 0 auto;
    padding: 20px;
}

/* --- Style des Cartes (Formulaires) - VERSION SOMBRE --- */
.login-wrap {
    background-color: #1a1a1a; /* Gris très foncé pour le fond de carte */
    border-radius: 12px;
    padding: 25px;
    position: relative;
    border: 4px solid #333; /* Bordure sombre par défaut */
    box-shadow: 0 8px 0 rgba(0,0,0,0.3); /* Ombre plus marquée */
    transition: transform 0.1s ease-out, border-color 0.15s ease-out;
    display: flex;
    flex-direction: column;
}

.login-wrap:hover {
    transform: scale(1.02);
    border-color: #f1c40f; /* Bordure Jaune Néon SMM2 au survol */
}

/* --- Titre avec icône circulaire --- */
.subtitle {
    font-family: 'Quicksand', sans-serif;
    font-weight: 700;
    font-size: 1.3rem;
    color: #eee; /* Texte clair */
    display: flex;
    align-items: center;
    margin-bottom: 25px;
}

.subtitle::before {
    content: '🎮';
    font-size: 1.3rem;
    background-color: #333; /* Fond sombre pour l'icône */
    width: 50px;
    height: 50px;
    border-radius: 50%;
    display: flex;
    justify-content: center;
    align-items: center;
    margin-right: 18px;
    box-shadow: 0 4px 0 rgba(0,0,0,0.2);
    color: white;
    border: 2px solid transparent;
}

/* Couleurs d'icônes par rôle (plus "flashy" sur fond sombre) */
.role-joueur .subtitle::before { 
    content: '🕹️'; 
    border-color: #3498db; /* Bleu Électrique */
    box-shadow: 0 0 10px rgba(52, 152, 219, 0.5);
}
.role-createur .subtitle::before { 
    content: '🛠️'; 
    border-color: #e67e22; /* Orange Vif */
    box-shadow: 0 0 10px rgba(230, 126, 34, 0.5);
}
.role-admin .subtitle::before { 
    content: '👑'; 
    border-color: #e74c3c; /* Rouge Néon */
    box-shadow: 0 0 10px rgba(231, 76, 60, 0.5);
}

/* --- Champs de saisie - VERSION SOMBRE --- */
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
    color: #aaa; /* Texte gris moyen */
    text-transform: uppercase;
}

.form-group input {
    background: #2c2c2c; /* Fond de l'input sombre */
    border: 2px solid #444; /* Bordure de l'input */
    border-radius: 8px;
    padding: 14px;
    font-family: 'Quicksand', sans-serif;
    font-size: 1rem;
    color: #fff; /* Texte saisi en blanc */
    outline: none;
    transition: border-color 0.2s;
}

.form-group input:focus {
    border-color: #f1c40f; /* Jaune Néon au focus */
}

/* --- Bouton de validation (plus contrasté) --- */
.btn-primary {
    background-color: #2ecc71; /* Vert SMM2 */
    color: white;
    font-family: 'Quicksand', sans-serif;
    font-weight: 700;
    font-size: 1.1rem;
    padding: 15px;
    border: none;
    border-radius: 10px;
    cursor: pointer;
    box-shadow: 0 5px 0 #27ae60;
    transition: all 0.1s;
}

.btn-primary:active {
    transform: translateY(2px);
    box-shadow: 0 2px 0 #27ae60;
}
</style>