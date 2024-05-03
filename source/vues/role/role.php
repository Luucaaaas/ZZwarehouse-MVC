<?php
session_start();

require_once '../source/base/database.php';
require_once '../source/controleur/int.php';
    
// si un utilisateur qui n'est pas admin tape l'url alors il est rediriger vers la page d'acceuil
if ($id_role != '1') {
    header("Location: ../index.php?login.php");
    exit;
}

$database = new Database();

// pour avoir les utlisateur
$database->query("SELECT * FROM utilisateurs");
$utilisateurs = $database->resultSet();

// pour avoir les roless
$database->query("SELECT * FROM roles");
$roles = $database->resultSet();


// info de tri pour 
$column = $_GET['column'] ?? 'id_utilisateur';
$order = $_GET['order'] ?? 'asc';

// inverser l'ordre
$newOrder = ($order === 'asc') ? 'desc' : 'asc';

// pour mettre à jour le tableau
$database->query("SELECT * FROM utilisateurs ORDER BY $column $order");
$utilisateurs = $database->resultSet();

?>

<!DOCTYPE html>
<html>
<head>
    <link rel="icon" href="./source/img/logogsbpetit.ico" type="image/x-icon">
    <link rel="stylesheet" href="./source/css/app.css">
    <title>ZZWarehouse | Utilisateurs</title>
</head>
<header class="header">
    <?php include("./vues/header.php"); ?>
</header>
<body>
    <h1>Rôle</h1>
    <?php if (isset($_SESSION['messageRole'])) { ?><div class="confirmation-message"><?php echo $_SESSION['messageRole']; ?></div><?php unset($_SESSION['messageRole']); ?><?php } ?>
    <table> 
    <thead class="role-column">
        <th scope="col">
            <a href="./index.php?uc=role&column=id_utilisateur&order=<?php echo ($column === 'id_utilisateur' && $order === 'asc') ? 'desc' : 'asc'; ?>">
            ID
                <?php if ($column === 'id_utilisateur') { ?>
                    <?php if ($order === 'asc') { ?>
                    <img src="./source/img/fleche-haut.png" width="30" height="30" alt="haut">
                    <?php } else { ?>
                    <img src="./source/img/fleche-bas.png" width="30" height="30" alt="bas">           
                    <?php } ?>
                <?php } ?>
            </a>
        </th>
        <th scope="col">
            <a href="./index.php?uc=role&column=nom&order=<?php echo ($column === 'nom' && $order === 'asc') ? 'desc' : 'asc'; ?>">
            Utilisateur
                <?php if ($column === 'nom') { ?>
                    <?php if ($order === 'asc') { ?>
                    <img src="./source/img/fleche-haut.png" width="30" height="30" alt="haut">
                    <?php } else { ?>
                    <img src="./source/img/fleche-bas.png" width="30" height="30" alt="bas">           
                    <?php } ?>
                <?php } ?>
            </a>
        </th>
        <th scope="col">
            <a href="./index.php?uc=role&column=email&order=<?php echo ($column === 'email' && $order === 'asc') ? 'desc' : 'asc'; ?>">
            Email
                <?php if ($column === 'email') { ?>
                    <?php if ($order === 'asc') { ?>
                    <img src="./source/img/fleche-haut.png" width="30" height="30" alt="haut">
                    <?php } else { ?>
                    <img src="./source/img/fleche-bas.png" width="30" height="30" alt="bas">           
                    <?php } ?>
                <?php } ?>
            </a>
        </th>
        <th scope="col">
            <a href="./index.php?uc=role&column=id_role&order=<?php echo ($column === 'id_role' && $order === 'asc') ? 'desc' : 'asc'; ?>">
            Utilisateur
                <?php if ($column === 'id_role') { ?>
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
        <tbody class="page-role">
    <?php foreach ($utilisateurs as $utilisateur) { ?>
        <tr>
            <td data-label="ID"><?php echo $utilisateur->id_utilisateur; ?></td>
            <td data-label="Utilisateur"><?php echo $utilisateur->nom  . ' ' .  $utilisateur->prenom; ?></td>
            <td data-label="Email"><?php echo $utilisateur->email; ?></td>
            <td data-label="Role">
                <form onsubmit="return confirmUpdateRole('<?php echo $utilisateur->nom; ?>')" action="./controleur/update_role.php" method="post">
                    <input type="hidden" name="id_utilisateur" value="<?php echo $utilisateur->id_utilisateur; ?>">
                    <?php if ($utilisateur->id_role == 1) { ?>
                        <img src="./source/img/admin.png" width="50" height="50" alt="admin">
                    <?php } elseif ($utilisateur->id_role == 2) { ?>
                        <img src="./source/img/utilisateur.png" width="50" height="50" alt="user">
                    <?php } elseif ($utilisateur->id_role == 3) { ?>
                        <img src="./source/img/client.png" width="50" height="50" alt="client">
                    <?php } elseif ($utilisateur->id_role == 4) { ?>
                        <img src="./source/img/fournisseur.png" width="50" height="50" alt="fournisseur">
                    <?php } ?>
                    <div class="flex-container">
                        <br>
                        <select name="id_role">
                            <?php foreach ($roles as $role) { ?>
                                <option value="<?php echo $role->id_role; ?>" <?php if ($role->id_role == $utilisateur->id_role) echo 'selected'; ?>>
                                    <?php echo $role->nom_role; ?>
                                </option>
                            <?php } ?>
                        </select>
                        <br>
                        <button type="submit">Appliquer</button>
                    </div>
                </form>
            </td>
        </tr>
    <?php } ?>
</tbody>
    </table>
    <script>
    function confirmUpdateRole(nomUtilisateur) {
        return confirm("Voulez-vous vraiment mettre à jour le rôle de l'utilisateur " + nomUtilisateur + " ?");
    }
    </script>
</body>
<footer class="site-footer">
    <?php include("./vues/footer.php"); ?>
</footer>
</html>