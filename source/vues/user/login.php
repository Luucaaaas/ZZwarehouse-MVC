<?php
session_start();

// connexion a la bdd
require_once '../source/base/database.php';

$database = new Database();


// déjà connecté ?
if (isset($_SESSION['email'])) {
    header("Location: ./index.php?uc=accueil");
    exit();
}

// login
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['login'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // requete preparée (injections SQL attention)
    $sql = "SELECT * FROM utilisateurs WHERE email = :email";
    $database->query($sql);
    $database->bind(':email', $email);
    $user = $database->single();

    if ($user && $user->blocked_until && $user->blocked_until > date('Y-m-d H:i:s')) {
        $remainingTime = strtotime($user->blocked_until) - time();
        $remainingTime = ($remainingTime > 0) ? gmdate('H:i:s', $remainingTime) : '00:00:00';
        $loginError = "Trop de tentatives de connexion infructueuses. <br> 
                        Votre compte est bloqué pendant encore <br> 
                        $remainingTime. <br>
                        Veuillez contacter votre administrateur"; // msg d'erreur lors du 10eme mauvais mot de passe renseigner  
    } else {
        if ($user && password_verify($password, $user->mot_de_passe)) {
            $_SESSION['email'] = $email;
            
            // Initialise $_SESSION['login_time'] lors de la connexion réussie
            $_SESSION['login_time'] = time();

            // reset la valeur login_attempts a 0 si la connexion est réussi
            $sql = "UPDATE utilisateurs SET login_attempts = 0 WHERE email = :email";
            $database->query($sql);
            $database->bind(':email', $email);
            $database->execute();

            session_regenerate_id();
            header("Location: ./index.php?uc=accueil");
            exit();
        } else {
            if ($user && $user->login_attempts >= 10) {
                $blockedUntil = date('Y-m-d H:i:s', strtotime('+20 minutes'));

                $sql = "UPDATE utilisateurs SET login_attempts = 0, blocked_until = :blockedUntil WHERE email = :email";
                $database->query($sql);
                $database->bind(':blockedUntil', $blockedUntil);
                $database->bind(':email', $email);
                $database->execute();

                $remainingTime = strtotime($blockedUntil) - time();
                $remainingTime = ($remainingTime > 0) ? gmdate('H:i:s', $remainingTime) : '00:00:00';
                $loginError = "Trop de tentatives de connexion infructueuses. <br>
                                Votre compte est bloqué pendant encore <br> 
                                $remainingTime. <br>
                                Veuillez contacter votre administrateur"; // message quand le compte est deja bloquer 
            } else {
                // si le mot de passe est faux
                $sql = "UPDATE utilisateurs SET login_attempts = login_attempts + 1 WHERE email = :email";
                $database->query($sql);
                $database->bind(':email', $email);
                $database->execute();
                $loginError = "Email ou mot de passe invalides";
            }
        }
    }
}

// signup
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['signup'])) {
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    // mail déjà existant ?
    $sql = "SELECT COUNT(*) AS count FROM utilisateurs WHERE email = :email";
    $database->query($sql);
    $database->bind(':email', $email);
    $count = $database->single()->count;

    //mail deja utilisé
    if ($count > 0) {
        $signupError = "Cette adresse e-mail <br> est déjà renseignée";
    } else {
        // hashage mdp
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // ajout utilisateur avec requete preparée avec id_role a 2 car cela corespond a un utilisateur
        $sql = "INSERT INTO utilisateurs (nom, prenom, email, mot_de_passe, id_role) VALUES (:nom, :prenom, :email, :password, 2)";
        $database->query($sql);
        $database->bind(':nom', $nom);
        $database->bind(':prenom', $prenom);
        $database->bind(':email', $email);
        $database->bind(':password', $hashedPassword);
        if ($database->execute()) {
            $message = "L'utilisateur <br> $nom, $prenom <br> a été créé avec succès.";
        }
    }
}

$database = null;
?>     

<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="./style/index.css">
    <title>ZZWarehouse | Login</title>
    <link rel="icon" href="./img/logogsbpetit.ico" type="image/x-icon">
</head>
<body>
<div class="container">
    <div class="image-container"></div>
    <div class="info-container">
        <div class="gsblogo"><a href="index.php?uc=login"><img src="./img/logogsb.png"></a></div>

        <div class="main">
            <input type="checkbox" id="chk" aria-hidden="true">

            <div class="login">
                <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">

                <label for="chk" aria-hidden="true">Login</label>
                    <input type="email" name="email" placeholder="Email" required><br>
                    <input type="password" name="password" placeholder="Mot de passe" required><br>
                  
                    <input type="submit" name="login" value="Se connecter">
                </form>
                <?php if (isset($message)) { echo '<p class="message">' . htmlspecialchars_decode($message) . '</p>'; } ?>
        <?php if (isset($loginError)) { echo '<p class="error">' . htmlspecialchars_decode($loginError) . '</p>'; } ?>
        <?php if (isset($signupError)) { echo '<p class="error">' . htmlspecialchars_decode($signupError) . '</p>'; } ?>
            </div>

            <div class="signup">
                <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
                <label for="chk" aria-hidden="true">Sign up</label>
                    <input type="text" name="nom" placeholder="Nom" required><br>
                    <input type="text" name="prenom" placeholder="Prénom" required><br>
                    <input type="email" name="email" placeholder="Email" required><br>
                    <input type="password" name="password" placeholder="Mot de passe" required><br>
                    <input type="submit" name="signup" value="S'inscrire">
                </form>
            </div>
        </div>
    </div>
</div>
</body>
</html>