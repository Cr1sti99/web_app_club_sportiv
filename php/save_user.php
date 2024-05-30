<?php
// Pornește o sesiune PHP sau reia una existentă
session_start();

// Configurează afișarea erorilor pentru depanare
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Include fișierul de configurare pentru baza de date
require_once '../includes/config.php'; // corectarea căii către config.php

// Inițializează un array pentru erori
$errors = [];

// Verifică dacă formularul a fost trimis prin metoda POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Preia și trim datele din formular
    $username = trim($_POST["username"]);
    $email = trim($_POST["email"]);
    $password = $_POST["password"];
    $confirm_password = $_POST["confirm_password"];

    // Verifică dacă toate câmpurile sunt completate și dacă parolele se potrivesc
    if (empty($username) || empty($email) || empty($password) || empty($confirm_password)) {
        $errors[] = "Toate câmpurile sunt obligatorii.";
    } elseif ($password !== $confirm_password) {
        $errors[] = "Parolele nu se potrivesc.";
    } else {
        // Verifică dacă există deja un cont cu această adresă de email
        $sql = "SELECT id FROM users WHERE email = ?";
        if ($stmt = $conn->prepare($sql)) {
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $stmt->store_result();

            if ($stmt->num_rows > 0) {
                $errors[] = "Există deja un cont cu această adresă de email.";
            } else {
                // Adaugă utilizatorul în baza de date
                $sql = "INSERT INTO users (username, email, password, role) VALUES (?, ?, ?, 'user')";
                if ($stmt = $conn->prepare($sql)) {
                    $hashed_password = password_hash($password, PASSWORD_DEFAULT); // Hashează parola
                    $stmt->bind_param("sss", $username, $email, $hashed_password);
                    if ($stmt->execute()) {
                        // Redirecționează utilizatorul la pagina de login după înregistrare
                        header("location: ../php/login.php");
                        exit;
                    } else {
                        $errors[] = "Ceva nu a mers bine. Încercați din nou mai târziu.";
                    }
                }
            }
            $stmt->close();
        }
    }
    $conn->close();
}
?>
<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8"> <!-- Setează codificarea caracterelor -->
    <title>Înregistrare</title> <!-- Titlul paginii -->
    <link href="../css/style.css" rel="stylesheet" type="text/css"> <!-- Include fișierul CSS pentru stiluri generale -->
    <link href="../css/register.css" rel="stylesheet" type="text/css"> <!-- Include fișierul CSS specific pentru înregistrare -->
</head>
<body>
    <?php include '../includes/header.php'; ?> <!-- Include fișierul de antet -->
    <main class="register-main">
        <div class="form-wrapper">
            <h2>Înregistrare</h2> <!-- Titlul secțiunii de înregistrare -->
            <?php 
            // Afișează erorile dacă există
            if (!empty($errors)) {
                echo '<div class="error">';
                foreach ($errors as $error) {
                    echo '<p>' . htmlspecialchars($error) . '</p>';
                }
                echo '</div>';
            }
            ?>
            <!-- Formular de înregistrare -->
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                <div class="form-group">
                    <label>Username</label> <!-- Etichetă pentru câmpul de username -->
                    <input type="text" name="username" value="<?php echo htmlspecialchars($username ?? ''); ?>" required> <!-- Câmp de input pentru username -->
                </div>
                <div class="form-group">
                    <label>Email</label> <!-- Etichetă pentru câmpul de email -->
                    <input type="email" name="email" value="<?php echo htmlspecialchars($email ?? ''); ?>" required> <!-- Câmp de input pentru email -->
                </div>
                <div class="form-group">
                    <label>Password</label> <!-- Etichetă pentru câmpul de parolă -->
                    <input type="password" name="password" required> <!-- Câmp de input pentru parolă -->
                </div>
                <div class="form-group">
                    <label>Confirm Password</label> <!-- Etichetă pentru câmpul de confirmare parolă -->
                    <input type="password" name="confirm_password" required> <!-- Câmp de input pentru confirmare parolă -->
                </div>
                <div class="form-group">
                    <input type="submit" value="Înregistrare"> <!-- Buton de submit pentru formular -->
                </div>
            </form>
        </div>
    </main>
    <?php include '../includes/footer.php'; ?> <!-- Include fișierul de subsol -->
</body>
</html>
