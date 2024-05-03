<header class="header">
  <link rel="stylesheet" href="./style/app.css">
    <a href="./index.php?uc=accueil" class="logo"><img src="./img/logogsbpetit.ico"width="50" height="50"><span>Accueil</span></a>
    <input class="menu-btn" type="checkbox" id="menu-btn" />
    <label class="menu-icon" for="menu-btn"><span class="navicon"></span></label>
    <ul class="menu">

    <?php if ($id_role == '1') : ?><li><a href="./index.php?uc=role"><img src="./img/role.png" width="25" height="25"><br>Rôle</a></li><?php endif; ?>
    <?php if ($id_role == '1' || $id_role == '2') : ?><li><a href="./index.php?uc=commande&column=date_commande&order=desc"><img src="./img/commande.png" width="25" height="25"><br>Commande</a></li><?php endif; ?>
    <?php if ($id_role == '3' || $id_role == '4') : ?><li><a href="./index.php?uc=add_commande"><img src="./img/commande.png" width="25" height="25"><br>Commande</a></li><?php endif; ?>
      <li><a href="./index.php?uc=stock"><img src="./img/stock.png" width="25" height="25"><br>Stock</a></li>
      <li><a href="../source/controleur/logout.php"><img src="./img/logout.png" width="25" height="25"><br>Se déconnecter</a></li>
    </ul>
  </header>

