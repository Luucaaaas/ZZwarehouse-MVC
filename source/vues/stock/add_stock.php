<?php
session_start();

require_once '../source/base/database.php';
require_once '../source/controleur/int.php';

$database = new Database();

// si un utilisateur qui n'est pas admin tape l'url alors il est rediriger vers la page de stock
if ($id_role != '1') {
    header("Location: ./index.php");
    exit;
}
 // recupere les valeur du formulaire
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom = $_POST['nom'];
    $description = $_POST['description'];
    $quantite_disponible = $_POST['quantite_disponible'];
    $type = $_POST['type'];

    // le nom et quantité disponible ne doivent pas etre vide pour declencher la suite du code  
    if (!empty($nom) && !empty($quantite_disponible)) {
        // requete contre les injection sql 
        $sql = "INSERT INTO stocks (nom, description, quantite_disponible, type) VALUES (:nom, :description, :quantite_disponible, :type)";
        $database->query($sql);
        $database->bind(':nom', $nom);
        $database->bind(':description', $description);
        $database->bind(':quantite_disponible', $quantite_disponible);
        $database->bind(':type', $type);

        if ($database->execute()) {
            $_SESSION['message'] = '<div class="confirmation-message">Stock ajouté avec succès !</div>';
            header("Location ./index.php?uc=stock");
        } 
        
    } else {
        $message =  "Veuillez remplir tous les champs requis.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <link rel="icon" href="../source/img/logogsbpetit.ico" type="image/x-icon">
    <link rel="stylesheet" href="../source/css/app.css">
    <title>ZZWarehouse | Ajouter du stock</title>
</head>
<body>
    <header class="header">
    <?php include("../source/vues/html/header.php"); ?>
    </header>
    <h1>Ajouter du stock</h1>

    <?php if (isset($message)) { echo '<p class="error-message">' . htmlspecialchars_decode($message) . '</p>'; } ?>
    <?php if (isset($messageAdd)) { echo '<p class="confirmation-message">' . htmlspecialchars_decode($messageAdd) . '</p>'; } ?>


    <form action="" method="post" class="stock-form">
        <label for="nom" class="stock-label">Nom :</label>
        <input type="text" name="nom" class="stock-input"><br>

        <label for="description" class="stock-label">Description :</label>
        <textarea name="description" class="stock-textarea"></textarea><br>

        <label for="quantite_disponible" class="stock-label">Quantité disponible :</label>
        <input type="number" name="quantite_disponible" class="stock-input"><br>

        <label for="type" class="stock-label">Type :</label>
        <select name="type" class="stock-select">
            <option value="medicament">Médicament</option>
            <option value="materiel">Matériel</option>
        </select><br>

        <div class="button-container">
            <a href=" index.php?uc=stock" class="cancel-button">Annuler</a>
            <button type="submit" onclick="return confirm('Êtes-vous sûr de vouloir ajouter du stock ?')" class="stock-button">Ajouter</button>
        </div>
    </form>

    <footer class="site-footer">
    <?php include("../source/vues/html/footer.php"); ?>
    </footer>
</body>
</html>