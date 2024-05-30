<?php
// Pornirea sesiunii
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Distrugerea tuturor variabilelor sesiunii
$_SESSION = array();

// Distrugerea sesiunii
session_destroy();

// Redirecționarea utilizatorului către pagina principală
header("Location: ../index.php");
exit;
?>
