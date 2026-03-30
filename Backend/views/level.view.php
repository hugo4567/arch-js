<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Panel Admin - Niveaux</title>
    <style>
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
        .btn { padding: 5px 10px; text-decoration: none; color: white; background-color: #007BFF; border-radius: 3px; }
        .btn-danger { background-color: #DC3545; }
    </style>
</head>
<body>
    <h1>Gestion des Niveaux</h1>
    <a href="index.php?action=add" class="btn">+ Ajouter un niveau</a>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nom</th>
                <th>Type</th>
                <th>Level</th>
                <th>Joués</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($levels as $l): ?>
            <tr>
                <td><?= $l['id'] ?></td>
                <td><?= htmlspecialchars($l['name']) ?></td>
                <td><?= $l['type'] ?></td>
                <td><?= $l['level'] ?></td>
                <td><?= $l['nb_play'] ?></td>
                <td>
                    <a href="index.php?action=edit&id=<?= $l['id'] ?>" class="btn">Modifier</a>
                    <a href="index.php?action=delete&id=<?= $l['id'] ?>" class="btn btn-danger" onclick="return confirm('Sûr de vouloir supprimer ?');">Supprimer</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>