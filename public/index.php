<?php

$uc = empty($_GET['uc']) ? "login" : $_GET['uc'];

switch ($uc) {
    case 'login':
        include '../source/vues/user/login.php';
        break;
    case 'accueil':
        include '../source/vues/user/accueil.php';
        break;
    case 'role':
        include '../source/vues/role/role.php';
        break;
    case 'commande':
        include '../source/vues/commande/commande.php';
        break;
    case 'add_commande':
        include '../source/vues/commande/add_commande.php';
        break;
    case 'stock':
        include '../source/vues/stock/stock.php';
        break;
}
?>  