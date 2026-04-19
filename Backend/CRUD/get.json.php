<?php

$path_json = "/../../levels";

function save_level($id, $contenu){

    $nom = "$id.json";

    file_put_contents($nom, $contenu);
}


function get_level_by_id($id){
    global $path_json;
    $nom = "$id.json";

    $contenu = file_get_contents($path_json . $nom);

    if ($contenu !== false) {
        return $contenu;
    } else {
    echo "Erreur lors de la lecture du fichier $nom.";
}
}


function get_all_levels(){ // return an array of json files.
    global $path_json;
    $contenus_json = [];
    $fichiers = scandir($path_json);

    for ($i = 0; $i < count($fichiers); $i++){
        $contenu = file_get_contents($fichiers[$i]);

        if ($contenu !== false) {
            $contenus_json[] = $contenu;
        } else {
            echo "Erreur lors de la lecture du fichier $fichiers[$i]";
        }
    }

    return $contenus_json;
}

function delete_file($id){
    global $path_json;
    $nom = "$id.json";

    return unlink($path_json . $nom);
}

?>

/*
{
  "Name": "Paff",
  "Gravity": 20
}
*/


/*

# La Superglobale `$_FILES` en PHP

Lorsqu'un fichier est envoyé via un formulaire HTML (`enctype="multipart/form-data"`), PHP stocke les informations dans le tableau associatif **`$_FILES`**.

## 1. Structure du tableau
Pour un champ défini par `<input type="file" name="avatar">`, les données sont accessibles via `$_FILES['avatar']`.

| Clé | Description | Exemple de valeur |
| :--- | :--- | :--- |
| `name` | Nom d'origine du fichier | `photo.jpg` |
| `full_path` | Chemin complet (si fourni par le navigateur) | `images/photo.jpg` |
| `type` | Type MIME du fichier | `image/jpeg` |
| `tmp_name` | **Chemin temporaire** sur le serveur | `/tmp/phpgUv7z` |
| `error` | Code d'erreur (0 = succès) | `0` |
| `size` | Taille du fichier en **octets** | `524288` (512 Ko) |

---

## 2. Les codes d'erreurs courants
La valeur `$_FILES['avatar']['error']` permet de vérifier si l'upload a fonctionné :

* **0 (UPLOAD_ERR_OK)** : Succès total.
* **1 (UPLOAD_ERR_INI_SIZE)** : Dépasse `upload_max_filesize` dans `php.ini`.
* **4 (UPLOAD_ERR_NO_FILE)** : L'utilisateur n'a sélectionné aucun fichier.

*/