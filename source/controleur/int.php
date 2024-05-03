<?php

$database = new Database();

// utilisateur login ? 
if (!isset($_SESSION['email'])) {
  //redirection sur la page de login si l utilisateur n'est pas connecte 
  header("Location: ./index.php?uc=login");
  exit();
}

if (isset($_SESSION['email'])) {
  $session_duration = 1800; // en secondes
  $current_time = time();
  $login_time = $_SESSION['login_time'];

  $session_time_remaining = $session_duration - ($current_time - $login_time);

  if ($session_time_remaining <= 0) {
    // redirection quand le temps de session n'est plus valide vers le code pour "detruire la session" 
    header("Location: ../source/controleur/logout.php");
      exit();
  }

  $hours_remaining = floor($session_time_remaining / 3600);
  $minutes_remaining = floor(($session_time_remaining % 3600) / 60);
  $seconds_remaining = $session_time_remaining % 60;

  $time_remaining = "Temps de session restant : 
                    " . $hours_remaining . 
                    " heures, " . 
                    $minutes_remaining . 
                    " minutes, " . 
                    $seconds_remaining . 
                    " secondes";
}



$email = $_SESSION['email'];
// qui est login avec quelle role ?
$sql = "SELECT id_utilisateur, nom, prenom, id_role FROM utilisateurs WHERE email = :email";
$database->query($sql);
$database->bind(':email', $email);
$database->execute();
// pour la page commande 
$user = $database->single();

if ($database->rowCount() == 1) {
    $row = $database->single();
    $nom = $row->nom;
    $prenom = $row->prenom;
    $id_role = $row->id_role;
} else {
    $nom = "?";
    $prenom = "???";
    $id_role = "?";
}