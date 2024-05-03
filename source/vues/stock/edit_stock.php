<?php
session_start();
require_once 'Database.php';
require_once 'z_int.php';

$database = new Database();

// si un utilisateur qui n'est pas admin tape l'url p_edit_stock.php?id_stock=1 alors il est rediriger vers la page de stock
if ($id_role != '1') {
    header("Location:p_stock.php");
    exit;
}

// si l'url ne contient pas ?id_stock= alors redireger vers la page stock avec un message d'erreur 
if (!isset($_GET['id_stock'])) {
    $_SESSION['error_message'] = "Le stock n'existe pas.";
    header("Location: p_stock.php");
    exit;
}

// recupere l'id
$id_stock = $_GET['id_stock'];

// recupere les info
$sql = "SELECT * FROM stocks WHERE id_stock = :id_stock";
$database->query($sql);
$database->bind(':id_stock', $id_stock);
$stock = $database->single();

//si le stock n'esiste pas alors on est rediriger vers la page du stock avec un message d'erreur 
if (!$stock) {
    $_SESSION['error_message'] = "Le stock n'existe pas.";
    header("Location: p_stock.php");
    exit;
}

//verification du formulaire pour mettre a jour le stock
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom = $_POST['nom'];
    $description = $_POST['description'];
    $quantite_disponible = $_POST['quantite_disponible'];
    $type = $_POST['type'];

    // requette preparé pour mettre a jour le stock
    $sql = "UPDATE stocks SET nom = :nom, description = :description, quantite_disponible = :quantite_disponible, type = :type WHERE id_stock = :id_stock";
    $database->query($sql);
    $database->bind(':nom', $nom);
    $database->bind(':description', $description);  
    $database->bind(':quantite_disponible', $quantite_disponible);
    $database->bind(':type', $type);
    $database->bind(':id_stock', $id_stock);
    $database->execute();

    // message de confirmation qui passe dans la page stock
    $_SESSION['message'] = '<div class="confirmation-message">Le stock a été modifié avec succès.</div>';

    // redirection vers la page de stock une fois que la modification est validé 
    header("Location: p_stock.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <link rel="icon" href="../source/img/logogsbpetit.ico" type="image/x-icon">
    <link rel="stylesheet" href="../source/css/app.css">
    <title>ZZWarehouse | Modifier le stock</title>
</head>
<body>
    <header class="header">
        <?php include("zz_header.html"); ?>
    </header>

    <h1>Modifier le stock</h1>

    <form action="p_edit_stock.php?id_stock=<?php echo $id_stock; ?>" method="post" class="stock-form">
        <label for="nom" class="stock-label">Nom :</label>
        <input type="text" name="nom" value="<?php echo $stock->nom; ?>" class="stock-input"><br>

        <label for="description" class="stock-label">Description :</label>
        <textarea name="description" class="stock-textarea"><?php echo $stock->description; ?></textarea><br>

        <label for="quantite_disponible" class="stock-label">Quantité disponible :</label>
        <input type="number" name="quantite_disponible" value="<?php echo $stock->quantite_disponible; ?>" class="stock-input"><br>

        <label for="type" class="stock-label">Type :</label>
        <select name="type" class="stock-select">
            <option value="medicament" <?php if ($stock->type === 'medicament') echo 'selected'; ?>>Médicament</option>
            <option value="materiel" <?php if ($stock->type === 'materiel') echo 'selected'; ?>>Matériel</option>
        </select><br>

        <div class="button-container">
            <a href="p_stock.php" class="cancel-button">Annuler</a>
            <button type="submit" onclick="return confirm('Êtes-vous sûr de vouloir modifier le stock ?')" class="stock-button">Modifier</button>
        </div>
    </form>

    <footer class="site-footer">
        <?php include("zz_footer.html"); ?>
    </footer>
</body>
</html>