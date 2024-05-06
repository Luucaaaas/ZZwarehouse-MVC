<?php

$uc = empty($_GET['uc']) ? "login" : $_GET['uc'];

switch ($uc) {
    case 'login':  //role 1 2 3 4
        include '../source/vues/user/login.php';
        break;
    case 'accueil': // role 1 2 3 4
        include '../source/vues/user/accueil.php';
        break;
    case 'role': // role 1
        include '../source/vues/role/role.php';
        break;
    case 'update_role': // 1
        include '../source/controleur/update_role.php';
        break;
    case 'commande': //role 1 2 
        include '../source/vues/commande/commande.php';
        break;
    case 'add_commande': //role 1 2 3 (4)
        include '../source/vues/commande/add_commande.php';
        break;
    case 'stock': //role 1 2 3 4
        include '../source/vues/stock/stock.php';
        break;
    case 'logout': // role 1 2 3 4 
        include '../source/controleur/logout.php';
        break;
    case 'reset_session': // role 1 2 3 4
        include '../source/controleur/reset_session.php';
        break;
    case 'edit_stock': // role 1
        include '../source/vues/stock/edit_stock.php';
        break;
    case 'add_stock': // role 1
        include '../source/vues/stock/add_stock.php';
        break;
    case 'delete_stock': // role 1
        include '../source/controleur/delete_stock.php';
        break;
}
?>  