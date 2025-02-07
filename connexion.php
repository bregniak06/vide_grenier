<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Connexion</title>
    <link rel="stylesheet" href="inscription.css">
</head>
<body>
    <h2>Connexion</h2>
    <form action="connexion.php" method="POST">
        <?php
        session_start();
        if (isset($_SESSION['error'])) {
            echo '<div class="error-message visible">' . htmlspecialchars($_SESSION['error']) . '</div>';
            unset($_SESSION['error']);
        }
        ?>
        <label for="email">Email :</label>
        <input type="email" name="email" id="email" required>
        <label for="password">Mot de passe :</label>
        <input type="password" name="password" id="password" required>
        <button type="submit">Se connecter</button>
        <div class="signup-link">
            Pas encore de compte ? <a href="inscription.php">Inscrivez-vous ici</a>
        </div>
    </form>
    <?php
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $conn = new mysqli("localhost", "root", "", "vide_grenier");

        if ($conn->connect_error) {
            $_SESSION['error'] = "Erreur de connexion à la base de données";
            header("Location: connexion.php");
            exit();
        }

        $email = $_POST['email'];
        $password = $_POST['password'];

        // Vérifier si l'utilisateur existe
        $stmt = $conn->prepare("SELECT user_id, username, password FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $stmt->bind_result($id, $username, $hashed_password);
            $stmt->fetch();
            
            // Vérification du mot de passe
            if (password_verify($password, $hashed_password)) {
                // Enregistrer l'utilisateur et son nom d'utilisateur dans la session
                $_SESSION['user_id'] = $id;
                $_SESSION['username'] = $username; // Stockage du nom d'utilisateur

                header("Location: index.php"); // Redirection vers la page d'accueil
                exit();
            } else {
                $_SESSION['error'] = "Email ou mot de passe incorrect";
                header("Location: connexion.php"); // Redirection en cas de mot de passe incorrect
                exit();
            }
        } else {
            $_SESSION['error'] = "Email ou mot de passe incorrect";
            header("Location: connexion.php"); // Redirection si l'utilisateur n'existe pas
            exit();
        }

        $stmt->close();
        $conn->close();
    }
    ?>
</body>
</html>
