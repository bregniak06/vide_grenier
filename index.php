<?php
session_start();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vide Grenier </title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <!-- Header -->
    <header class="header">
        <div class="logo">
            <a href="index.php">
            <img src="media/logo.jpg" alt="logo du site" style="width: 180px; height: auto;">
            </a>
        </div>
        <!--  Barre de recherche -->
          <div class="recherche">
            <input type="text" placeholder="rechercher un article..">
            <button>
                <img src="media/loupe.png" alt="rechercher">
            </button>
          </div>
         <!--  deposer une annonce  -->
              <a href="deposer-annonce.php">
                <button class="btn-deposer-annonce">deposer une annonce</button>
              </a>
          
          <!-- Bouton de connexion / Affichage du nom d'utilisateur -->
          <?php if (isset($_SESSION['user_id'])): ?>
              <!-- L'utilisateur est connecté -->
              <a href="profil.php" class="btn-connexion">
                  <span><?php echo htmlspecialchars($_SESSION['username']); ?></span> <!-- Affiche le nom d'utilisateur -->
              </a>
          <?php else: ?>
              <!-- L'utilisateur n'est pas connecté -->
              <a href="connexion.php" class="btn-connexion">
                  <img src="media/se-connecter.png" alt="se connecter" class="icon-connexion">
                  <span>se connecter</span>
              </a>
          <?php endif; ?>
          
         <!--  bouton de favoris  -->
                <a href="favoris.php" class="btn-favoris">
                    <img src="media/coeur.png" alt="favoris" class="icon-favoris">
                    <span>favoris</span>
                </a>
    </header>

    <!-- Menu de navigation 
    <nav>
        <ul class="menu">
            <li><a href="categorie.php?categorie=immobilier">Immobilier</a></li>
            <li><a href="categorie.php?categorie=electronique">electronique</a></li>
            <li><a href="categorie.php?categorie=mode">mode</a></li>
        </ul>
    </nav>
    -->

    <!-- Section principale -->
    <main>
    <!-- bienvenue -->
        <div class="intro">
            <h2>tu ne le veux plus, vends-le</h2>
            <p>sur vide grenier, vendez et achetez des articles de seconde main facilement.</p>
        </div>
    <!-- banniere -->
     <div class="banner">
        <p>il est temps de vendre !</p>
        <a href="deposer-annonce.php">
            <button class="btn-deposer-annonce">deposer une annonce</button>
        </a>
     </div>

 <!-- affichage des annonces récentes -->
<section class="recent-announcements">
    <h2>Annonces récentes</h2>
    <div class="announcements-container">
        <?php
        // Connexion à la base de données
        try {
            $pdo = new PDO("mysql:host=localhost;dbname=vide_grenier;charset=utf8", "root", "");
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
            // Récupération des 8 dernières annonces
            $sql = "SELECT id, titre, description, image, prix, telephone, date_poste 
                    FROM annonces 
                    ORDER BY date_poste DESC 
                    LIMIT 8";
            
            $stmt = $pdo->query($sql);
            $annonces = $stmt->fetchAll(PDO::FETCH_ASSOC);

            // Vérification si des annonces existent
            if (empty($annonces)) {
                echo "<p>Aucune annonce récente trouvée.</p>";
            } else {
                // Affichage des annonces
                foreach ($annonces as $annonce) {
                    ?>
                    <div class="announcement-card">
                        <div class="card-image">
                            <img src="<?php echo htmlspecialchars($annonce['image'] ?? 'media/image-par-defaut.png'); ?>" 
                                 alt="<?php echo htmlspecialchars($annonce['titre'] ?? 'Sans titre'); ?>">
                            
                        </div>
                        <div class="card-content">
                            <h3><?php echo htmlspecialchars($annonce['titre']); ?></h3>
                            <p class="description"><?php echo htmlspecialchars(substr($annonce['description'], 0, 100)) . '...'; ?></p>
                            <div class="price-contact">
                                <span class="price"><?php echo number_format($annonce['prix'], 0, ',', ' ') . ' euro'; ?></span>
                                <span class="contact">Tél: <?php echo htmlspecialchars($annonce['telephone']); ?></span>
                            </div>
                        </div>
                    </div>
                    <?php
                }
            }
        } catch(PDOException $e) {
            // Gestion des erreurs de connexion ou SQL
            echo "<p>Erreur lors de la récupération des annonces : " . htmlspecialchars($e->getMessage()) . "</p>";
        }
        ?>
    </div>
    <div class="voir-plus-container">
        <a href="annonces.php" class="btn-voir-plus">Voir toutes les annonces</a>
    </div>
</section>



    <!-- Footer -->
    <footer class="footer">
        <div class="footer-content">
            <div class="footer-section">
                <h3>À propos de Vide Grenier</h3>
                <p>Votre plateforme de confiance pour l'achat et la vente d'objets d'occasion.</p>
            </div>
            <div class="footer-section">
                <h3>Liens rapides</h3>
                <ul>
                    <li><a href="index.php">Accueil</a></li>
                    <li><a href="deposer-annonce.php">Déposer une annonce</a></li>
                    <li><a href="categories.php">Catégories</a></li>
                    <li><a href="contact.php">Contact</a></li>
                </ul>
            </div>
            <div class="footer-section">
                <h3>Nous contacter</h3>
                <ul>
                    <li>Email: contact@videgrenier.fr</li>
                    <li>Téléphone: 01 23 45 67 89</li>
                </ul>
            </div>
        </div>
        <div class="footer-bottom">
            <p>&copy; <?php echo date("Y"); ?> Vide Grenier - Tous droits réservés</p>
        </div>
    </footer>
</body>
</html>
