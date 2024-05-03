<?php

session_start();

require_once 'Database.php';
require_once 'z_int.php';

$database = new Database();

if (isset($_SESSION['error_message'])) {
    $errorMessage = $_SESSION['error_message'];
    $errorMessage = '<div class="error-message">Le stock n\'existe pas.</div>';
    unset($_SESSION['error_message']);
}

// mettre a nul la variable message si un message de validation est present dans la session (ici le message lorsqu'on modifie du stock)
$message = isset($_SESSION['message']) ? $_SESSION['message'] : '';
unset($_SESSION['message']);

$column = isset($_GET['column']) ? $_GET['column'] : 'id_stock';
$order = isset($_GET['order']) ? $_GET['order'] : 'asc';
// requete pour avoir le stock
$sql = "SELECT * FROM stocks ORDER BY $column $order";
$database->query($sql);
$stocks = $database->resultSet();

if (isset($_SESSION['confirmation_message'])) {
    $confirmationMessage = $_SESSION['confirmation_message'];
    $confirmationMessage = '<div class="confirmation-message">La ligne a été supprimée avec succès.</div>';
    unset($_SESSION['confirmation_message']);
}
?>

<!DOCTYPE html>
<html>
<head>
    <link rel="icon" href="../source/img/logogsbpetit.ico" type="image/x-icon">
    <link rel="stylesheet" href="../source/css/app.css">
    <title>ZZWarehouse | Stock</title>
</head>
<body>
    <header class="header">
        <?php include("zz_header.html"); ?>
    </header>

    <div class=container-titre>
        <div class=trois></div>
        <div class=trois><h1>Stock</h1></div>
        <div class=trois><?php if ($id_role == '1') : ?><a href="p_add_stock.php" class="btn-add">➕Ajouter un stock</a><?php endif; ?></div>
        </div>

        <?php if (!empty($message)) : ?><p class="message"><?php echo $message; ?></p><?php endif; ?>
        <?php if (isset($confirmationMessage)) { echo '<p class="message">' . htmlspecialchars_decode($confirmationMessage) . '</p>'; } ?>
        <?php if (isset($errorMessage)) { echo '<p class="message">' . htmlspecialchars_decode($errorMessage) . '</p>'; } ?>
        <?php if (isset($messageAdd)) { echo '<p class="confirmation-message">' . htmlspecialchars_decode($messageAdd) . '</p>'; } ?>


        <table>
            <thead class="role-column">
                <tr>
                    <th scope="col">
                        <form method="get">
                            <button type="submit" name="column" value="id_stock">
                                ID
                                <?php if ($column === 'id_stock') { ?>
                                    <?php if ($order === 'asc') { ?>
                                        <img src="../source/img/fleche-haut.png" width="30" height="30" alt="haut">
                                    <?php } else { ?>
                                        <img src="../source/img/fleche-bas.png" width="30" height="30" alt="bas">           
                                    <?php } ?>
                                <?php } ?>
                            </button>
                            <input type="hidden" name="order" value="<?php echo ($column === 'id_stock' && $order === 'asc') ? 'desc' : 'asc'; ?>">
                        </form>
                    </th>
                    <th scope="col">
                        <form method="get">
                            <button type="submit" name="column" value="nom">
                                Nom
                                <?php if ($column === 'nom') { ?>
                                    <?php if ($order === 'asc') { ?>
                                        <img src="../source/img/fleche-haut.png" width="30" height="30" alt="haut">
                                    <?php } else { ?>
                                        <img src="../source/img/fleche-bas.png" width="30" height="30" alt="bas">           
                                    <?php } ?>
                                <?php } ?>
                            </button>
                            <input type="hidden" name="order" value="<?php echo ($column === 'nom' && $order === 'asc') ? 'desc' : 'asc'; ?>">
                        </form>
                    </th>
                    <th scope="col">
                        <form method="get">
                            <button type="submit" name="column" value="description">
                                Description
                                <?php if ($column === 'description') { ?>
                                    <?php if ($order === 'asc') { ?>
                                        <img src="../source/img/fleche-haut.png" width="30" height="30" alt="haut">
                                    <?php } else { ?>
                                        <img src="../source/img/fleche-bas.png" width="30" height="30" alt="bas">           
                                    <?php } ?>
                                <?php } ?>
                            </button>
                            <input type="hidden" name="order" value="<?php echo ($column === 'description' && $order === 'asc') ? 'desc' : 'asc'; ?>">
                        </form>
                    </th>
                    <th scope="col">
                        <form method="get">
                            <button type="submit" name="column" value="quantite_disponible">
                                Quantité disponible
                                <?php if ($column === 'quantite_disponible') { ?>
                                    <?php if ($order === 'asc') { ?>
                                        <img src="../source/img/fleche-haut.png" width="30" height="30" alt="haut">
                                    <?php } else { ?>
                                        <img src="../source/img/fleche-bas.png" width="30" height="30" alt="bas">           
                                    <?php } ?>
                                <?php } ?>
                            </button>
                            <input type="hidden" name="order" value="<?php echo ($column === 'quantite_disponible' && $order === 'asc') ? 'desc' : 'asc'; ?>">
                        </form>
                    </th>
                    <th scope="col">
                        <form method="get">
                            <button type="submit" name="column" value="type">
                                Type
                                <?php if ($column === 'type') { ?>
                                    <?php if ($order === 'asc') { ?>
                                        <img src="../source/img/fleche-haut.png" width="30" height="30" alt="haut">
                                    <?php } else { ?>
                                        <img src="../source/img/fleche-bas.png" width="30" height="30" alt="bas">           
                                    <?php } ?>
                                <?php } ?>
                            </button>
                            <input type="hidden" name="order" value="<?php echo ($column === 'type' && $order === 'asc') ? 'desc' : 'asc'; ?>">
                        </form>
                    </th>
                    <?php if ($id_role == '1') : ?><th scope="col">Modifier</th><?php endif; ?>
                    <?php if ($id_role == '1') : ?><th scope="col">Supprimer</th><?php endif; ?>
                    <?php if ($id_role == '1' || $id_role == '2') : ?><th scope="col">Stock faible</th><?php endif; ?>
                </tr>
                <thead>
                    <tbody>
                        <?php foreach ($stocks as $item) { ?>
                            <tr>
                                <td data-label="ID"><?php echo $item->id_stock; ?></td>
                                <td data-label="Nom"><?php echo $item->nom; ?></td>
                                <td data-label="Description"><?php echo $item->description; ?></td>
                                <td data-label="Quantité disponible"><?php echo $item->quantite_disponible; ?></td>
                                <td data-label="Type">
                                    <?php if ($item->type == 'Medicament') : ?>
                                        <img src="../source/img/medicament.png" width="50" height="50"alt="medicament">
                                    <?php else : ?>
                                        <img src="../source/img/materiel.png" width="50" height="50"alt="materiel">
                                    <?php endif; ?><br>
                                    <?php echo $item->type; ?>
                                </td>
                                <?php if ($id_role == '1') : ?><td data-label="Modifier">
                                    <form action="p_edit_stock.php" method="get">
                                        <input type="hidden" name="id_stock" value="<?php echo $item->id_stock; ?>">
                                        <button type="submit" class="cursor-pointer">🖊️</button>
                                    </form>
                                </td><?php endif; ?>
                                <?php if ($id_role == '1') : ?><td data-label="Supprimer">
                                    <form id="delete-form-<?php echo $item->id_stock; ?>" action="z_delete_stock.php" method="post">
                                    <input type="hidden" name="id_stock" value="<?php echo $item->id_stock; ?>">
                                    <button type="button" class="cursor-pointer" onclick="showConfirmation(<?php echo $item->id_stock; ?>, '<?php echo addslashes($item->nom); ?>')">🗑️</button>
                                </form>
                            </td><?php endif; ?>






                            
<?php if ($id_role == '1' || $id_role == '2') : ?>
    <td data-label="Stock faible">
        <?php if ($item->quantite_disponible <= 50) { ?>
            <span style="color: red;">Stock faible</span>
        <?php } ?>
    </td>
<?php endif; ?>






                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
                <script>
                // Popup de confirmation
                function showConfirmation(idStock, productName) {
                    if (confirm("Êtes-vous sûr de vouloir supprimer le produit \"" + productName + "\" ?")) {
                        // Si "OK" est sélectionné, alors supprimer
                        document.getElementById('delete-form-' + idStock).submit();
                    }
                }
                </script>
                <footer class="site-footer">
                    <?php include("zz_footer.html"); ?>
                </footer>
</body>
</html>