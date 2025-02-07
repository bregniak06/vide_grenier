<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Annonces - Vide Grenier</title>
    <link rel="stylesheet" href="annonces.css">
</head>
<body>
    <header>
        <h1>Toutes les annonces</h1>
    </header>
    
    <main class="annonces-container">
        <?php
        // Connexion à la base de données
        $conn = new mysqli("localhost", "root", "", "vide_grenier");
        
        if ($conn->connect_error) {
            die("Erreur de connexion : " . $conn->connect_error);
        }

        // Récupération des annonces
        $sql = "SELECT * FROM annonces ORDER BY id DESC";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                echo '<div class="annonce-card">';
                if (!empty($row['image'])) {
                    echo '<img src="' . htmlspecialchars($row['image']) . '" alt="' . htmlspecialchars($row['titre']) . '" class="annonce-image">';
                }
                echo '<div class="annonce-content">';
                echo '<h2 class="annonce-titre">' . htmlspecialchars($row['titre']) . '</h2>';
                echo '<p class="annonce-prix">' . number_format($row['prix'], 2, ',', ' ') . ' €</p>';
                echo '<p class="annonce-description">' . htmlspecialchars($row['description']) . '</p>';
                echo '<div class="annonce-details">';
                echo '<span class="annonce-categories">' . htmlspecialchars($row['categories']) . '</span>';
                echo '<span class="annonce-telephone">' . htmlspecialchars($row['telephone']) . '</span>';
                echo '</div>';
                echo '</div>';
                echo '</div>';
            }
        } else {
            echo '<p class="no-annonces">Aucune annonce disponible pour le moment.</p>';
        }

        $conn->close();
        ?>
    </main>
</body>
</html>