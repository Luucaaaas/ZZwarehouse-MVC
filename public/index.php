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
    case 'update_role':
        include '../source/controleur/update_role.php';
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
    case 'logout':
        include '../source/controleur/logout.php';
        break;
    case 'reset_session':
        include '../source/controleur/reset_session.php';
        break;
    case 'edit_stock':
        include '../source/vues/stock/edit_stock.php';
        break;
    case 'add_stock':
        include '../source/vues/stock/add_stock.php';
        break;
    case 'delete_stock':
        include '../source/controleur/delete_stock.php';
        break;
}
?>  