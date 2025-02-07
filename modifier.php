<?php
// Connexion à la base de données
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "vide_grenier";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Traitement de la mise à jour
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $titre = $_POST['titre'];
    $description = $_POST['description'];
    $prix = $_POST['prix'];
    $image = $_POST['image'];
    $telephone = $_POST['telephone'];
    $categorie = $_POST['categorie'];

    // Mettre à jour les données dans la base de données
    $sql = "UPDATE annonces SET titre='$titre', description='$description', prix=$prix, image='$image', telephone='$telephone', categorie='$categorie' WHERE id=$id";

    if ($conn->query($sql) === TRUE) {
        echo "<p style='color: green;'>Annonce mise à jour avec succès.</p>";
    } else {
        echo "<p style='color: red;'>Erreur lors de la mise à jour: " . $conn->error . "</p>";
    }
}

// Récupérer les données de l'annonce à modifier
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $sql = "SELECT * FROM annonces WHERE id = $id";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $titre = $row['titre'];
        $description = $row['description'];
        $prix = $row['prix'];
        $image = $row['image'];
        $telephone = $row['telephone'];
        $categorie = $row['categorie'];
    } else {
        echo "<p style='color: red;'>Aucune annonce trouvée.</p>";
        exit;
    }
} else {
    echo "<p style='color: red;'>ID non spécifié.</p>";
    exit;
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier l'annonce</title>
    <link rel="stylesheet" href="modifier.css">
    
</head>
<body>
    <h1>Modifier l'annonce</h1>
    <form action="edit_annonce.php?id=<?php echo $id; ?>" method="post">
        <input type="hidden" name="id" value="<?php echo $id; ?>">
        
        <label for="titre">Titre:</label>
        <input type="text" id="titre" name="titre" value="<?php echo $titre; ?>" required><br><br>
        
        <label for="description">Description:</label>
        <textarea id="description" name="description" required><?php echo $description; ?></textarea><br><br>
        
        <label for="prix">Prix:</label>
        <input type="number" step="0.01" id="prix" name="prix" value="<?php echo $prix; ?>" required><br><br>
        
        <label for="image">Image URL:</label>
        <input type="text" id="image" name="image" value="<?php echo $image; ?>" required><br><br>
        
        <label for="telephone">Téléphone:</label>
        <input type="text" id="telephone" name="telephone" value="<?php echo $telephone; ?>" required><br><br>
        
        <label for="categorie">Catégorie:</label>
        <input type="text" id="categorie" name="categorie" value="<?php echo $categorie; ?>" required><br><br>
        
        <button type="submit">Mettre à jour</button>
    </form>
</body>
</html>

<?php
$conn->close();
?>