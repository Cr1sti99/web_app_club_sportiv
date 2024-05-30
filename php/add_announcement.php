<?php
// Includem fișierul de configurare pentru conexiunea la baza de date
require_once "config.php";

// Inițiem sesiunea pentru a verifica dacă utilizatorul este autentificat
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: login.php");
    exit;
}

// Definirea și inițializarea variabilelor
$title = $content = "";
$title_err = $content_err = "";

// Procesarea datelor formularului când formularul este trimis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validarea titlului
    if (empty(trim($_POST["title"]))) {
        $title_err = "Please enter a title.";
    } else {
        $title = trim($_POST["title"]);
    }

    // Validarea conținutului
    if (empty(trim($_POST["content"]))) {
        $content_err = "Please enter the content.";
    } else {
        $content = trim($_POST["content"]);
    }

    // Verificăm dacă nu există erori înainte de inserare în baza de date
    if (empty($title_err) && empty($content_err)) {
        // Pregătim o declarație de inserare
        $sql = "INSERT INTO announcements (title, content) VALUES (?, ?)";

        if ($stmt = $conn->prepare($sql)) {
            // Legăm variabilele la declarația pregătită ca parametri
            $stmt->bind_param("ss", $param_title, $param_content);

            // Setăm parametrii
            $param_title = $title;
            $param_content = $content;

            // Încercăm să executăm declarația pregătită
            if ($stmt->execute()) {
                // Redirecționăm la pagina de admin sau undeva unde utilizatorul poate vedea anunțul
                header("location: view_announcements.php");
                exit();
            } else {
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Închidem statement-ul
            $stmt->close();
        }
    }

    // Închidem conexiunea
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Announcement</title>
    <style>
        .wrapper {
            width: 500px;
            padding: 20px;
        }
        .error {
            color: red;
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <h2>Add New Announcement</h2>
        <p>Please fill this form to create a new announcement.</p>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div>
                <label>Title</label>
                <input type="text" name="title" class="form-control" value="<?php echo $title; ?>">
                <span class="error"><?php echo $title_err;?></span>
            </div>    
            <div>
                <label>Content</label>
                <textarea name="content" class="form-control"><?php echo $content; ?></textarea>
                <span class="error"><?php echo $content_err;?></span>
            </div>
            <div>
                <input type="submit" value="Submit">
                <a href="view_announcements.php">Cancel</a>
            </div>
        </form>
    </div>
</body>
</html>
