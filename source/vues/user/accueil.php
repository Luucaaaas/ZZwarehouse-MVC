<?php
session_start();

require_once '../source/base/database.php';
require_once '../source/controleur/int.php';

if (isset($_SESSION['messageCommande'])) {
    $messageCommande = $_SESSION['messageCommande'];
    unset($_SESSION['messageCommande']);
}




$database = new Database();

$sql = "SELECT YEAR(date_commande) AS annee, MONTH(date_commande) AS mois, SUM(quantite) AS total_commande
        FROM commandes
        WHERE statut = 'Validee'
        GROUP BY YEAR(date_commande), MONTH(date_commande)
        ORDER BY YEAR(date_commande), MONTH(date_commande)";

$database->query($sql);
$results = $database->resultSet();







?>

<!DOCTYPE html>
<head>
    <link rel="icon" href="./img/logogsbpetit.ico" type="image/x-icon">
    <link rel="stylesheet" href="./style/app.css">
    <title>ZZWarehouse | Accueil de <?php echo $prenom?></title>
</head>
<header class="header">
    <?php include("../source/vues/html/header.php"); ?>
</header>
    <body>  
<?php if ($id_role == '3' || $id_role == '4') : ?><?php if (isset($messageCommande)) { echo '<p class="confirmation-message">' . htmlspecialchars_decode($messageCommande) . '</p>'; } ?><?php endif; ?>






    <li><a href="p_top_commande.php"><img src="./img/stonks.png" width="100" height="100"><br>TOP article 📈🔥</a></li>








    <table>
            <tr>
                <th>Mois</th>
                <th>Année</th>
                <th>Quantité total des commandes</th>
            </tr>

    <?php foreach ($results as $row)
    $mois = date('F', mktime(0, 0, 0, $row->mois, 1)); ?>
        <tr>
                <td data-label="mois"><?php echo $mois; ?></td>
                <td data-label="annee"><?php echo $row->annee; ?></td>
                <td data-label="Quantité total"><?php echo $row->total_commande; ?></td>

            </tr>
    </table>








</body>
<footer class="site-footer">
    <?php include("../source/vues/html/footer.php"); ?>
</footer>
</html