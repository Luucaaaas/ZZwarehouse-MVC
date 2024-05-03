<?php echo "Bonjour, $prenom $nom $id_role !"; ?><br>
<?php echo $time_remaining ?>
<?php     $resetMessage = isset($_GET['resetMessage']) ? $_GET['resetMessage'] : ''; ?>
<form action="./index.php?uc=reset_session" method="POST">
        <button type="submit" name="reset">Réinitialiser le temps de session</button>
    </form>
<?php if (empty($resetMessage)) {
  echo '<br>';
}
?>

<?php if (!empty($resetMessage)) {
    echo htmlspecialchars($resetMessage) . '<br><br>';
}
?>
<hr class="custom"/>
<p class="copyright-text">Copyright © 2024</p>
<div class="social-icons">
  <a class="github" href="https://github.com/Luucaaaas/ZZWarehouse" target="_blank"><img src="./img/github.png"width="50" height="50"></a>
</div>