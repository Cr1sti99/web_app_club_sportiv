<?php
// Pornește o sesiune PHP sau reia una existentă
session_start();

// Configurează afișarea erorilor pentru depanare
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
?>
<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8"> <!-- Setează codificarea caracterelor -->
    <title>Înregistrare</title> <!-- Titlul paginii -->
    <link href="css/style.css" rel="stylesheet" type="text/css"> <!-- Include fișierul CSS pentru stiluri generale -->
    <link href="css/register.css" rel="stylesheet" type="text/css"> <!-- Include fișierul CSS specific pentru înregistrare -->
</head>
<body>
    <?php include 'includes/header.php'; ?> <!-- Include fișierul de antet -->
    <main class="register-main">
        <div class="form-wrapper">
            <h2>Înregistrare</h2> <!-- Titlul secțiunii de înregistrare -->
            <p>Completați acest formular pentru a crea un cont.</p> <!-- Instrucțiuni pentru utilizatori -->
            <?php 
            // Verifică dacă există erori și le afișează
            if (!empty($errors)) {
                echo '<div class="error">';
                foreach ($errors as $error) {
                    echo '<p>' . htmlspecialchars($error) . '</p>';
                }
                echo '</div>';
            }
            ?>
            <!-- Formular pentru înregistrare -->
            <form action="php/save_user.php" method="post">
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
    <?php include 'includes/footer.php'; ?> <!-- Include fișierul de subsol -->
</body>
</html>
