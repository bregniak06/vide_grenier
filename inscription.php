<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Connexion à la base de données
    $conn = new mysqli("localhost", "root", "", "vide_grenier");

    // Vérifier la connexion
    if ($conn->connect_error) {
        die("Échec de la connexion : " . $conn->connect_error);
    }

    // Récupération des données du formulaire
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);

    // Préparation de la requête d'insertion
    $stmt = $conn->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $username, $email, $password);

    // Exécution de la requête
    if ($stmt->execute()) {
        // Redirection vers la page de connexion après une inscription réussie
        header("Location: connexion.php");
        exit(); // Assurez-vous que le script s'arrête après la redirection
    } else {
        echo "Erreur : " . $conn->error;
    }

    // Fermeture de la connexion
    $stmt->close();
    $conn->close();
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Inscription</title>
    <link rel="stylesheet" href="inscription.css">
    <style>
        #togglePassword {
            cursor: pointer;
            background-color: transparent;
            border: none;
            color: blue;
            font-size: 0.9em;
        }
    </style>
</head>
<body>
    <h2>Inscription</h2>
    <form action="inscription.php" method="POST">
        <label for="username">Nom d'utilisateur :</label>
        <input type="text" name="username" id="username" required>
        
        <label for="email">Email :</label>
        <input type="email" name="email" id="email" required>
        
        <label for="password">Mot de passe :</label>
        <div style="display: flex; align-items: center;">
            <input type="password" name="password" id="password" required>
            <button type="button" id="togglePassword">Afficher</button>
        </div>
        
        <button type="submit">S'inscrire</button>
    </form>
    <script>
        const passwordInput = document.getElementById('password');
        const togglePasswordButton = document.getElementById('togglePassword');

        togglePasswordButton.addEventListener('click', function () {
            // Bascule entre 'text' et 'password'
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                togglePasswordButton.textContent = 'Masquer';
            } else {
                passwordInput.type = 'password';
                togglePasswordButton.textContent = 'Afficher';
            }
        });
    </script>
</body>
</html>
