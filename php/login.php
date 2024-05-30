<?php
// Pornește o sesiune PHP sau reia una existentă
session_start();

// Configurează afișarea erorilor pentru depanare
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Include fișierul de configurare pentru baza de date
require_once '../includes/config.php';

// Verificarea dacă formularul a fost trimis prin metoda POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Preia datele din formular
    $username = $_POST['username'];
    $password = $_POST['password'];
    $login_err = '';

    // Pregătește interogarea SQL pentru a verifica existența utilizatorului
    $sql = "SELECT id, username, password, role FROM users WHERE username = ?";
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        // Leagă parametrii și execută declarația
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $stmt->store_result();

        // Verifică dacă utilizatorul există
        if ($stmt->num_rows == 1) {
            // Leagă rezultatele la variabile
            $stmt->bind_result($id, $username, $hashed_password, $role);
            $stmt->fetch();

            // Verifică dacă parola introdusă se potrivește cu cea stocată în baza de date
            if (password_verify($password, $hashed_password)) {
                // Setează variabilele de sesiune
                $_SESSION["loggedin"] = true;
                $_SESSION["id"] = $id;
                $_SESSION["username"] = $username;
                $_SESSION["role"] = $role;

                // Redirecționează utilizatorul către pagina de opțiuni
                header("location: options.php");
                exit();
            } else {
                // Mesaj de eroare dacă parola este incorectă
                $login_err = "Parola introdusă nu este validă.";
            }
        } else {
            // Mesaj de eroare dacă utilizatorul nu există
            $login_err = "Nu există cont asociat acestui nume de utilizator.";
        }
    } else {
        // Mesaj de eroare dacă interogarea SQL eșuează
        echo "Oops! Something went wrong. Please try again later.";
    }

    // Închide declarația
    $stmt->close();
}

// Închide conexiunea la baza de date
$conn->close();
?>
<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8"> <!-- Setează codificarea caracterelor -->
    <title>Login</title> <!-- Titlul paginii -->
    <link href="../css/style.css" rel="stylesheet" type="text/css"> <!-- Include fișierul CSS pentru stiluri generale -->
    <link href="../css/register.css" rel="stylesheet" type="text/css"> <!-- Include fișierul CSS specific pentru înregistrare/login -->
</head>
<body>
    <?php include '../includes/header.php'; ?> <!-- Include fișierul de antet -->
    <main class="register-main">
        <div class="form-wrapper">
            <h2>Login</h2> <!-- Titlul secțiunii de login -->
            <p>Te rog să completezi datele de autentificare.</p> <!-- Instrucțiuni pentru utilizatori -->
            <?php 
            // Afișează mesajul de eroare dacă există
            if (!empty($login_err)) {
                echo '<div class="error">' . htmlspecialchars($login_err) . '</div>';
            }
            ?>
            <!-- Formular de login -->
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                <div class="form-group">
                    <label>Username</label> <!-- Etichetă pentru câmpul de username -->
                    <input type="text" name="username" required> <!-- Câmp de input pentru username -->
                </div>
                <div class="form-group">
                    <label>Password</label> <!-- Etichetă pentru câmpul de parolă -->
                    <input type="password" name="password" required> <!-- Câmp de input pentru parolă -->
                </div>
                <div class="form-group">
                    <input type="submit" value="Login"> <!-- Buton de submit pentru formular -->
                </div>
            </form>
        </div>
    </main>
    <?php include '../includes/footer.php'; ?> <!-- Include fișierul de subsol -->
</body>
</html>
