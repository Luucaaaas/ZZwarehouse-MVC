<?php
session_start();

$resetMessage = '';

if (isset($_POST['reset'])) {
    $_SESSION['login_time'] = time();
    $resetMessage = 'La session a été mise à jour.';
}

header("Location: index.php?uc=accueil&resetMessage=" . urlencode($resetMessage));
exit();
?>