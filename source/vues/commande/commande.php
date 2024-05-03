<?php
session_start();

require_once './source/Base/Database.php';
require_once './controleur/int.php';

$database = new Database();

if ($id_role != '1' && $id_role != '2') {
    header("Location: ../public/index?uc=accueil");
    exit;
}

$column = isset($_GET['column']) ? $_GET['column'] : 'date_commande';
$order = isset($_GET['order']) ? $_GET['order'] : 'asc';

$database->query("SELECT c.id_commande, u.nom AS nom_utilisateur, u.prenom AS prenom_utilisateur, s.nom AS nom_produit, c.quantite, c.type_mouvement, c.date_commande, c.statut FROM commandes c
                  JOIN utilisateurs u ON c.id_utilisateur = u.id_utilisateur
                  JOIN stocks s ON c.id_stock = s.id_stock
                  ORDER BY $column $order");
$commandes = $database->resultSet();

if (isset($_POST['valider_commande'])) {
    $commande_id = $_POST['commande_id'];

    $database->query("SELECT stocks.quantite_disponible AS stock_disponible, commandes.quantite AS quantite_commande, commandes.type_mouvement FROM commandes JOIN stocks ON commandes.id_stock = stocks.id_stock WHERE commandes.id_commande = :commande_id");
    $database->bind(':commande_id', $commande_id);
    $result = $database->single();

    $stock_disponible = $result->stock_disponible;
    $quantite_commande = $result->quantite_commande;
    $type_mouvement = $result->type_mouvement;

    if ($type_mouvement === 'Sortie' && $stock_disponible < $quantite_commande) {
        $_SESSION['messageCommande'] = 'La quantité en stock est insuffisante pour valider la commande.';
    } else {
        $database->query("UPDATE commandes SET statut = 'validee' WHERE id_commande = :commande_id");
        $database->bind(':commande_id', $commande_id);
        $database->execute();

        if ($type_mouvement === 'Sortie') {
            $nouveau_stock = $stock_disponible - $quantite_commande;
        } else {
            $nouveau_stock = $stock_disponible + $quantite_commande;
        }

        $database->query("UPDATE stocks SET quantite_disponible = :nouveau_stock WHERE id_stock = (SELECT id_stock FROM commandes WHERE id_commande = :commande_id)");
        $database->bind(':nouveau_stock', $nouveau_stock);
        $database->bind(':commande_id', $commande_id);
        $database->execute();
        //valide commande
        $_SESSION['messageCommande'] = 'Le statut de la commande a été mis à jour.';
    }
} elseif (isset($_POST['invalider_commande'])) {
    $commande_id = $_POST['commande_id'];

    $database->query("UPDATE commandes SET statut = 'invalidée' WHERE id_commande = :commande_id");
    $database->bind(':commande_id', $commande_id);
    $database->execute();
    // invalide commande 
    $_SESSION['messageCommande'] = 'Le statut de la commande a été mis à jour.';
}

if (isset($_SESSION['messageCommande'])) {
    $messageCommande = $_SESSION['messageCommande'];
    unset($_SESSION['messageCommande']);
}

?>

<!DOCTYPE html>
<html>
<head>
    <link rel="icon" href="./source/img/logogsbpetit.ico" type="image/x-icon">
    <link rel="stylesheet" href="./source/css/app.css">
    <title>ZZWarehouse | Commande</title>
</head>
<body>
    <header class="header">
        <?php include("./vues/header.php"); ?>
    </header>

    <div class="container-titre">
        <div class="trois"></div>
        <div class="trois"><h1>Commande</h1></div>
        <div class="trois">
        <?php if ($id_role == '1' || $id_role == '2') : ?>
             <a href="./vues/add_commande.php" class="btn-add">➕Ajouter une Commande</a>
            <?php endif; ?>
        </div>
    </div>
    <?php if (isset($messageCommande)) { echo '<p class="confirmation-message">' . htmlspecialchars_decode($messageCommande) . '</p>'; } ?>
        <table>
            <thead class="role-column">
                <th scope="col">
                    <a href="./index.php?uc=commande&column=id_commande&order=<?php echo ($column === 'id_commande' && $order === 'asc') ? 'desc' : 'asc'; ?>">
                    ID
                        <?php if ($column === 'id_commande') { ?>
                            <?php if ($order === 'asc') { ?>
                            <img src="./source/img/fleche-haut.png" width="30" height="30" alt="haut">
                            <?php } else { ?>
                            <img src="./source/img/fleche-bas.png" width="30" height="30" alt="bas">           
                            <?php } ?>
                        <?php } ?>
                    </a>
                </th>
                <th scope="col">
                    <a href="./index.php?uc=commande&column=nom_utilisateur&order=<?php echo ($column === 'nom_utilisateur' && $order === 'asc') ? 'desc' : 'asc'; ?>">
                    Utilisateur
                        <?php if ($column === 'nom_utilisateur') { ?>
                            <?php if ($order === 'asc') { ?>
                            <img src="./source/img/fleche-haut.png" width="30" height="30" alt="haut">
                            <?php } else { ?>
                            <img src="./source/img/fleche-bas.png" width="30" height="30" alt="bas">           
                            <?php } ?>
                        <?php } ?>
                    </a>
                </th>
                <th scope="col">
                    <a href="./index.php?uc=commande&column=nom_produit&order=<?php echo ($column === 'nom_produit' && $order === 'asc') ? 'desc' : 'asc'; ?>">
                    Produit
                        <?php if ($column === 'nom_produit') { ?>
                            <?php if ($order === 'asc') { ?>
                            <img src="./source/img/fleche-haut.png" width="30" height="30" alt="haut">
                            <?php } else { ?>
                            <img src="./source/img/fleche-bas.png" width="30" height="30" alt="bas">           
                            <?php } ?>
                        <?php } ?>
                    </a>
                </th>
                <th scope="col">
                    <a href="./index.php?uc=commande&column=quantite&order=<?php echo ($column === 'quantite' && $order === 'asc') ? 'desc' : 'asc'; ?>">
                    Quantité
                        <?php if ($column === 'quantite') { ?>
                            <?php if ($order === 'asc') { ?>
                            <img src="./source/img/fleche-haut.png" width="30" height="30" alt="haut">
                            <?php } else { ?>
                            <img src="./source/img/fleche-bas.png" width="30" height="30" alt="bas">           
                            <?php } ?>
                        <?php } ?>
                    </a>
                </th>                
                <th scope="col">
                    <a href="./index.php?uc=commande&column=type_mouvement&order=<?php echo ($column === 'type_mouvement' && $order === 'asc') ? 'desc' : 'asc'; ?>">
                    Mouvement
                        <?php if ($column === 'type_mouvement') { ?>
                            <?php if ($order === 'asc') { ?>
                            <img src="./source/img/fleche-haut.png" width="30" height="30" alt="haut">
                            <?php } else { ?>
                            <img src="./source/img/fleche-bas.png" width="30" height="30" alt="bas">           
                            <?php } ?>
                        <?php } ?>
                    </a>
                </th>                 
                <th scope="col">
                    <a href="./index.php?uc=commande&column=date_commande&order=<?php echo ($column === 'date_commande' && $order === 'asc') ? 'desc' : 'asc'; ?>">
                    Date
                        <?php if ($column === 'date_commande') { ?>
                            <?php if ($order === 'asc') { ?>
                            <img src="./source/img/fleche-haut.png" width="30" height="30" alt="haut">
                            <?php } else { ?>
                            <img src="./source/img/fleche-bas.png" width="30" height="30" alt="bas">           
                            <?php } ?>
                        <?php } ?>
                    </a>
                </th>
                <th scope="col">
                    <a href="./index.php?uc=commande&column=statut&order=<?php echo ($column === 'statut' && $order === 'asc') ? 'desc' : 'asc'; ?>">
                    Statut
                        <?php if ($column === 'statut') { ?>
                            <?php if ($order === 'asc') { ?>
                            <img src="./source/img/fleche-haut.png" width="30" height="30" alt="haut">
                            <?php } else { ?>
                            <img src="./source/img/fleche-bas.png" width="30" height="30" alt="bas">           
                            <?php } ?>
                        <?php } ?>
                    </a>
                </th>       
                </tr>
            </thead>
            <tbody>
        <?php foreach ($commandes as $commande) : ?>
            <tr>
                <td data-label="ID"><?php echo $commande->id_commande; ?></td>
                <td data-label="Utilisateur"><?php echo $commande->nom_utilisateur . ' ' . $commande->prenom_utilisateur; ?></td>
                <td data-label="Produit"><?php echo $commande->nom_produit; ?></td>
                <td data-label="Quantite"><?php echo $commande->quantite; ?></td>
                <td data-label="Mouvement">                    
                    <div><?php
                        if ($commande->type_mouvement === 'Entree') {
                            echo '<img src="./source/img/entree.png" width="30" height="30" alt="Mouvement d\'entrée">';
                        } elseif ($commande->type_mouvement === 'Sortie') {
                            echo '<img src="./source/img/sortie.png" width="30" height="30"  alt="Mouvement de sortie">';
                        }
                    ?><br><?php echo $commande->type_mouvement; ?></div></td>
                <td data-label="Date"><?php echo $commande->date_commande; ?></td>
                <td data-label="Statut">
                    <?php if ($commande->statut === 'Validee') {
                        echo '<img src="./source/img/validee.png" width="50" height="50" alt="Statut validé">';
                    } elseif ($commande->statut === 'Invalidée') {
                        echo '<img src="./source/img/invalidee.png" width="50" height="50" alt="Statut invalidé">';
                    } elseif ($commande->statut === 'En attente') {
                        echo '<img src="./source/img/en attente.png" width="50" height="50" alt="Statut en attente">';
                    }
                    ?><br>
                    <h3><?php echo $commande->statut; ?></h3>

                    <?php if ($commande->statut === 'En attente') : ?>
                        <form method="POST" class="inline-form">
                            <?php if ($id_role == '1') : ?>
                                <div class="flex-container-2"><br>
                                    <input type="hidden" name="commande_id" value="<?php echo $commande->id_commande; ?>">
                                    <button type="submit" name="valider_commande" class="stock-button" onclick="return confirm('Êtes-vous sûr de vouloir valider la commande ?')">Valider</button>
                                    <button type="submit" name="invalider_commande" class="cancel-button" onclick="return confirm('Êtes-vous sûr de vouloir invalider la commande ?')">Invalider</button>
                                </div>
                            <?php endif; ?>
                        </form>
                    <?php endif; ?>
                </td>
                    </tr>
                <?php endforeach; ?>
            <div>
        </tbody>
    </table>
    <footer class="site-footer">
    <?php include("./vues/footer.php"); ?>
</footer>
</body>
</html>