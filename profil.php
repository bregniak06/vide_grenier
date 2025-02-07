<?php
session_start();

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['user_id'])) {
    header('Location: connexion.php');
    exit();
}

// Connexion à la base de données
try {
    $pdo = new PDO("mysql:host=localhost;dbname=vide_grenier;charset=utf8", "root", "");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    die("Erreur de connexion : " . $e->getMessage());
}

// Traitement de la déconnexion
if (isset($_POST['deconnexion'])) {
    session_destroy();
    header('Location: index.php');
    exit();
}

// Traitement de la suppression d'annonce
if (isset($_POST['supprimer_annonce'])) {
    $annonce_id = $_POST['annonce_id'];
    try {
        $stmt = $pdo->prepare("DELETE FROM annonces WHERE id = ? AND user_id = ?");
        $stmt->execute([$annonce_id, $_SESSION['user_id']]);
        $message_succes = "Annonce supprimée avec succès";
    } catch(PDOException $e) {
        $message_erreur = "Erreur lors de la suppression : " . $e->getMessage();
    }
}

// Récupération des annonces de l'utilisateur

try {
    $stmt = $pdo->prepare("SELECT * FROM annonces WHERE user_id = ? ORDER BY date_poste DESC");
    $stmt->execute([$_SESSION['user_id']]);
    $annonces = $stmt->fetchAll(PDO::FETCH_ASSOC);

    
} catch(PDOException $e) {
    $message_erreur = "Erreur lors de la récupération des annonces : " . $e->getMessage();
}

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mon Profil - Vide Grenier</title>
    <link rel="stylesheet" href="profil.css">
    <style>
        .profile-container {
            max-width: 1200px;
            margin: 40px auto;
            padding: 20px;
        }

        .profile-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
        }

        .deconnexion-btn {
            background-color: #ff4444;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .deconnexion-btn:hover {
            background-color: #cc0000;
        }

        .mes-annonces {
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }

        .annonce-item {
            display: grid;
            grid-template-columns: 150px 1fr auto;
            gap: 20px;
            padding: 15px;
            border-bottom: 1px solid #eee;
            align-items: center;
        }

        .annonce-image img {
            width: 150px;
            height: 100px;
            object-fit: cover;
            border-radius: 5px;
        }

        .annonce-details h3 {
            margin: 0 0 10px 0;
            color: #333;
        }

        .annonce-details p {
            margin: 5px 0;
            color: #666;
        }

        .annonce-actions {
            display: flex;
            gap: 10px;
        }

        .modifier-btn, .supprimer-btn {
            padding: 8px 15px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .modifier-btn {
            background-color: #4CAF50;
            color: white;
        }

        .supprimer-btn {
            background-color: #ff4444;
            color: white;
        }

        .modifier-btn:hover {
            background-color: #45a049;
        }

        .supprimer-btn:hover {
            background-color: #cc0000;
        }

        .message {
            padding: 10px;
            margin-bottom: 20px;
            border-radius: 5px;
        }

        .succes {
            background-color: #dff0d8;
            color: #3c763d;
            border: 1px solid #d6e9c6;
        }

        .erreur {
            background-color: #f2dede;
            color: #a94442;
            border: 1px solid #ebccd1;
        }
    </style>
</head>
<body>
    <?php include 'header.php'; // Inclure votre header ?>

    <div class="profile-container">
        <div class="profile-header">
            <h1>Mon Profil</h1>
            <form method="POST" style="display: inline;">
                <button type="submit" name="deconnexion" class="deconnexion-btn">
                    Se déconnecter
                </button>
            </form>
        </div>

        <?php if (isset($message_succes)): ?>
            <div class="message succes"><?php echo $message_succes; ?></div>
        <?php endif; ?>

        <?php if (isset($message_erreur)): ?>
            <div class="message erreur"><?php echo $message_erreur; ?></div>
        <?php endif; ?>

        <div class="mes-annonces">
            <h2>Mes Annonces</h2>
            <?php if (empty($annonces)): ?>
                <p>Vous n'avez pas encore publié d'annonces.</p>
            <?php else: ?>
                <?php foreach ($annonces as $annonce): ?>
                    <div class="annonce-item">
                        <div class="annonce-image">
                            <img src="<?php echo htmlspecialchars($annonce['image']); ?>" 
                                 alt="<?php echo htmlspecialchars($annonce['titre']); ?>">
                        </div>
                        <div class="annonce-details">
                            <h3><?php echo htmlspecialchars($annonce['titre']); ?></h3>
                            <p>Prix : <?php echo number_format($annonce['prix'], 0, ',', ' '); ?> euro</p>
                            <p>Date de publication : <?php echo date('d/m/Y', strtotime($annonce['date_poste'])); ?></p>
                        </div>
                        <div class="annonce-actions">
                            <a href="modifier.php?id=<?php echo $annonce['id']; ?>" 
                               class="modifier-btn">Modifier</a>
                            <form method="POST" style="display: inline;">
                                <input type="hidden" name="annonce_id" 
                                       value="<?php echo $annonce['id']; ?>">
                                <button type="submit" name="supprimer_annonce" 
                                        class="supprimer-btn" 
                                        onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette annonce ?');">
                                    Supprimer
                                </button>
                            </form>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>

    <?php include 'footer.php'; // Inclure votre footer ?>
</body>
</html>
