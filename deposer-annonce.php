<?php
session_start();

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['user_id'])) {
    header("Location: connexion.php"); // Rediriger vers la page de connexion si non connecté
    exit();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter une annonce</title>
    <link rel="stylesheet" href="annonce_depot.css">
</head>
<body>
    <h2>Ajouter une annonce</h2>
    <form action="deposer-annonce.php" method="post" enctype="multipart/form-data">
        <label for="titre">Titre du projet :</label>
        <input type="text" name="titre" id="titre" required><br>

        <label for="telephone">Numéro de téléphone :</label>
        <input type="text" name="telephone" id="telephone" required pattern="\d{8}" titre="Le numéro de téléphone doit comporter exactement 8 chiffres."><br>

        <label for="description">Description :</label>
        <textarea name="description" id="description" required></textarea><br>

        <label for="prix">Prix :</label>
        <input type="number" name="prix" id="prix" step="0.01" required><br>

        <label for="image">Image :</label>
        <input type="file" name="image" id="image" accept="image/*" required><br>

        <label for="categories">Catégorie :</label>
        <select name="categories" id="categories" required>
            <option value="1">Appareils électroniques</option>
            <option value="2">Appareils ménagers</option>
            <option value="3">Appareils utilitaires</option>
        </select><br>

        <button type="submit">Ajouter</button>
    </form>
</body>
</html>

<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Activer les erreurs PHP
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    // Connexion à la base de données
    $conn = new mysqli("localhost", "root", "", "vide_grenier");
    if ($conn->connect_error) {
        die("Échec de connexion : " . $conn->connect_error);
    }

    // Récupération des données du formulaire
    $titre = $_POST['titre'];
    $telephone = $_POST['telephone'];
    $description = $_POST['description'];
    $prix = $_POST['prix'];
    $categorie = $_POST['categories'];  // Correction ici : 'categories' => 'categories'
    $user_id = $_SESSION['user_id'];  // Récupération de l'user_id de la session

    // Vérification de l'image
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $image_tmp = $_FILES['image']['tmp_name']; // Emplacement temporaire
        $image_name = basename($_FILES['image']['name']); // Nom du fichier
        $target_dir = "uploads/"; // Dossier cible
        $target_file = $target_dir . uniqid() . "_" . $image_name; // Chemin final

        // Vérifier si le dossier existe et est accessible
        if (!is_dir($target_dir) || !is_writable($target_dir)) {
            die("Le dossier de téléchargement n'existe pas ou n'est pas accessible en écriture.");
        }

        // Déplacement du fichier téléchargé
        if (move_uploaded_file($image_tmp, $target_file)) {
            // Préparer la requête pour insérer dans la base de données
            $stmt = $conn->prepare("INSERT INTO annonces (titre, telephone, description, prix, categories, image, user_id) VALUES (?, ?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("sssdssi", $titre, $telephone, $description, $prix, $categorie, $target_file, $user_id);

            // Exécution de la requête
            if ($stmt->execute()) {
                echo "Annonce ajoutée avec succès.";
            } else {
                echo "Erreur lors de l'ajout de l'annonce : " . $conn->error;
            }

            $stmt->close();
        } else {
            echo "Échec lors du déplacement de l'image.";
        }
    } else {
        // Identifier le problème si l'image n'est pas téléchargée
        $upload_error = $_FILES['image']['error'];
        switch ($upload_error) {
            case UPLOAD_ERR_INI_SIZE:
            case UPLOAD_ERR_FORM_SIZE:
                echo "Le fichier dépasse la taille maximale autorisée.";
                break;
            case UPLOAD_ERR_PARTIAL:
                echo "Le fichier n'a été que partiellement téléchargé.";
                break;
            case UPLOAD_ERR_NO_FILE:
                echo "Aucun fichier n'a été téléchargé.";
                break;
            case UPLOAD_ERR_NO_TMP_DIR:
                echo "Dossier temporaire manquant.";
                break;
            case UPLOAD_ERR_CANT_WRITE:
                echo "Échec de l'écriture du fichier sur le disque.";
                break;
            case UPLOAD_ERR_EXTENSION:
                echo "Le téléchargement a été stoppé par une extension PHP.";
                break;
            default:
                echo "Erreur inconnue lors du téléchargement.";
                break;
        }
    }

    $conn->close();
}
?>
