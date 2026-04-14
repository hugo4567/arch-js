<?php 
// Définition des valeurs par défaut (vides pour la création, remplies pour la modification)

/*if(!isset($level_data)){ // val par défaut
    $level_data['name'] = '';
    $level_data['type'] = 0;
    $level_data['id_crea'] = 0;
    $level_data['level'] = 0;
    $level_data['nb_play'] = 0;
    $level_data['note_pos'] = 0;
    $level_data['note_neg'] = 0;
}*/

$is_edit = ($level_data !== null);
$name = $is_edit ? $level_data['name'] : '';
$type = $is_edit ? $level_data['type'] : 0;
$id_crea = $is_edit ? $level_data['id_crea'] : 0;
$level = $is_edit ? $level_data['level'] : 0;
$nb_play = $is_edit ? $level_data['nb_play'] : 0;
$note_pos = $is_edit ? $level_data['note_pos'] : 0;
$note_neg = $is_edit ? $level_data['note_neg'] : 0;
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title><?= $is_edit ? 'Modifier' : 'Ajouter' ?> un niveau</title>
    <style>
        form { max-width: 400px; margin: 20px 0; display: flex; flex-direction: column; gap: 10px; }
        input { padding: 8px; }
        button { padding: 10px; background-color: #28A745; color: white; border: none; cursor: pointer; }
    </style>
</head>
<body>
    <h1><?= $is_edit ? 'Modifier le niveau' : 'Créer un niveau' ?></h1>
    <a href="AdminPannel.php">Retour à la liste</a>

    <form method="POST" action="">
        <label>Nom :</label>
        <input type="text" name="name" value="<?= htmlspecialchars($name) ?>" required>

        <label>Type :</label>
        <input type="number" name="type" value="<?= $type ?>" required>

        <label>ID Créateur :</label>
        <input type="number" name="id_crea" value="<?= $id_crea ?>" required>
"$nb_play ?>" required>

        <label>Notes Positives :</label>
        <input type="number" name="note_pos" value="<?= $note_pos ?>" required>

        <label>Notes Négatives :</label>
        <input type="number" name="note_neg" value="<?= $note_neg ?>" required>

        <button type="submit">Enregistrer</button>
    </form>
</body>
</html>