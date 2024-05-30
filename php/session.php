<?php
// Pornește o sesiune PHP sau reia una existentă
session_start();

// Configurează afișarea erorilor pentru depanare
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Verificăm dacă utilizatorul este logat. Dacă nu, îl redirecționăm la pagina de login.
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php"); // Redirecționează utilizatorul la pagina de login
    exit; // Oprește execuția scriptului pentru a asigura că redirecționarea are loc
}
?>
