<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Asigurați-vă că utilizatorul este logat
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header('Location: login.php');
    exit;
}

require_once 'config.php'; // Include configurația bazei de date

// Verificăm dacă ID-ul anunțului este prezent în URL
if (isset($_GET['id']) && !empty(trim($_GET['id']))) {
    $id = trim($_GET['id']);

    // Pregătim selectarea datelor anunțului
    $sql = "SELECT * FROM announcements WHERE id = ?";
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("i", $param_id);
        $param_id = $id;

        // Încercăm să executăm interogarea
        if ($stmt->execute()) {
            $result = $stmt->get_result();

            if ($result->num_rows == 1) {
                /* Preiau datele anunțului */
                $announcement = $result->fetch_array(MYSQLI_ASSOC);
            } else {
                // URL-ul conține un ID invalid
                echo "Error: Announcement not found.";
                exit();
            }
        } else {
            echo "Oops! Something went wrong. Please try again later.";
        }
    }

    $stmt->close();
}

// Procesarea datelor din formular când formularul este trimis
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['id'])) {
    $id = $_POST['id'];
    $title = trim($_POST['title']);
    $content = trim($_POST['content']);

    // Pregătim interogarea de update
    $sql = "UPDATE announcements SET title = ?, content = ? WHERE id = ?";

    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("ssi", $param_title, $param_content, $param_id);

        // Setăm parametrii
        $param_title = $title;
        $param_content = $content;
        $param_id = $id;

        // Încercăm să executăm interogarea de update
        if ($stmt->execute()) {
            header("Location: view_announcements.php");
            exit();
        } else {
            echo "Something went wrong. Please try again later.";
        }
    }

    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Announcement</title>
</head>
<body>
    <h2>Edit Announcement</h2>
    <?php if (isset($announcement)): ?>
    <form action="<?php echo htmlspecialchars(basename($_SERVER['REQUEST_URI'])); ?>" method="post">
        <div>
            <label for="title">Title:</label>
            <input type="text" id="title" name="title" value="<?php echo htmlspecialchars($announcement['title']); ?>" required>
        </div>
        <div>
            <label for="content">Content:</label>
            <textarea id="content" name="content" required><?php echo htmlspecialchars($announcement['content']); ?></textarea>
        </div>
        <input type="hidden" name="id" value="<?php echo $announcement['id']; ?>">
        <div>
            <input type="submit" value="Submit">
        </div>
    </form>
    <?php endif; ?>
</body>
</html>
