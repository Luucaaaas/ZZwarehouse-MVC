<?php
session_start();
require_once 'Database.php';
require_once 'z_int.php';

$database = new Database();


$sql = "SELECT s.nom AS nom_produit, SUM(c.quantite) AS total_commande
        FROM commandes c
        JOIN stocks s ON c.id_stock = s.id_stock
        WHERE c.statut = 'Validee'
        GROUP BY c.id_stock
        ORDER BY total_commande DESC;";

$database->query($sql);
$results = $database->resultSet();
?>
<!DOCTYPE html>
<head>
    <link rel="icon" href="../source/img/logogsbpetit.ico" type="image/x-icon">
    <link rel="stylesheet" href="../source/css/app.css">
    <title>ZZWarehouse | Produit 📈></title>
</head>
<header class="header">
<?php include("zz_header.html"); ?>
</header>
<body>  





<table>
    <tr>
      <th>Nom produit</th>
      <th>Total des commande</th>
    </tr>
    <tr>
    <?php foreach ($results as $row): ?>
        <td data-label="nom"><?php echo $row->nom_produit; ?></td>
        <td data-label="total"><?php echo $row->total_commande; ?></td>
    <tr>
    <?php endforeach; ?>
  </table>








</body>
<footer class="site-footer">
<?php include("zz_footer.html"); ?>
</footer>
</html