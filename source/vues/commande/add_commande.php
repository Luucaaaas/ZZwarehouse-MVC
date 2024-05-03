<?php
session_start();

require_once '../source/Base/Database.php';
require_once '../controleur/int.php';

$database = new Database();


$sql = "SELECT id_utilisateur, nom, prenom, id_role FROM utilisateurs WHERE email = :email";
$database->query($sql);
$database->bind(':email', $email);
$database->execute();

$user = $database->single();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupérer les valeurs du formulaire
    $id_utilisateur = $_POST['id_utilisateur'];
    $id_stock = $_POST['id_stock'];
    $quantite = $_POST['quantite'];
    
    if (!empty($id_utilisateur) && !empty($id_stock) && !empty($quantite)) {
        if ($user->id_role == 4) {
            $type_mouvement = 'Entree';
            $messageCommande = "Merci pour votre envoi.";
        } else {
            $type_mouvement = 'Sortie';
            $messageCommande = "Votre commande sera traitée dans les plus brefs délais.";
        }
        
        $sql = "INSERT INTO commandes (id_utilisateur, id_stock, quantite, type_mouvement) VALUES (:id_utilisateur, :id_stock, :quantite, :type_mouvement)";
        $database->query($sql);
        $database->bind(':id_utilisateur', $id_utilisateur);
        $database->bind(':id_stock', $id_stock);
        $database->bind(':quantite', $quantite);
        $database->bind(':type_mouvement', $type_mouvement);
        if ($database->execute()) {
            $_SESSION['messageCommande'] = $messageCommande;
            header("Location: p_commande.php");
        }
        
    } else {
        $messageErr =  "Veuillez remplir tous les champs requis.";
    }
}

    $sql = "SELECT * FROM stocks";
    $database->query($sql);
    $stocks = $database->resultSet();



?>

<!DOCTYPE html>
<html>
<head>
    <link rel="icon" href="../source/img/logogsbpetit.ico" type="image/x-icon">
    <link rel="stylesheet" href="../source/css/app.css">
    <title>ZZWarehouse | Passer une commande</title>
</head>
<body>
    <header class="header">
        <?php include("zz_header.html"); ?>
    </header>
    <h1>Passer une commande</h1>
    <?php if (isset($messageErr)) { echo '<p class="error-message">' . htmlspecialchars_decode($messageErr) . '</p>'; } ?>

    <form action="" method="post" class="stock-form">
        <input type="hidden" name="id_utilisateur" value="<?php echo $user->id_utilisateur; ?>">

        <label for="id_stock"  class="stock-label">Produit en stock:</label>
        <select name="id_stock" id="id_stock" class="stock-select">
            <?php foreach ($stocks as $stock) : ?>
                <option value="<?php echo $stock->id_stock; ?>"><?php echo $stock->nom; ?></option>
            <?php endforeach; ?>
        </select><br>

        <label for="quantite" class="stock-label">Quantité:</label>
        <input type="number" name="quantite" id="quantite" class="stock-input"><br>

        <input type="submit" value="Soumettre"onclick="return confirm('Êtes-vous sûr de vouloir passer la commande ?')"class="stock-button">
    </form>





    <footer class="site-footer">
        <?php include("zz_footer.html"); ?>
    </footer>
</body>
</html>