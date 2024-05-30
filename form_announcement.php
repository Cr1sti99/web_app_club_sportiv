<?php
// Pornește o sesiune PHP sau reia una existentă
session_start();

// Configurează afișarea erorilor pentru depanare
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Include fișierul de configurare pentru baza de date
require_once 'includes/config.php';

// Inițializează variabilele pentru id, title și content
$id = '';
$title = '';
$content = '';

// Verifică dacă există un parametru 'id' în URL și dacă este numeric
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    // Preia valoarea id-ului din URL
    $id = $_GET['id'];
    
    // Pregătește interogarea SQL pentru a prelua datele anunțului din baza de date
    $sql = "SELECT title, content FROM announcements WHERE id = ?";
    if ($stmt = $conn->prepare($sql)) {
        // Leagă parametrii și execută interogarea
        $stmt->bind_param("i", $id);
        $stmt->execute();
        // Leagă rezultatele interogării la variabilele title și content
        $stmt->bind_result($title, $content);
        // Preia rezultatele
        $stmt->fetch();
        // Închide declarația
        $stmt->close();
    }
}

// Închide conexiunea la baza de date
$conn->close();
?>
<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Adaugă/Modifică Anunț</title>
    <link href="css/style.css" rel="stylesheet" type="text/css">
</head>
<body>
    <header>
        <h1>Adaugă/Modifică Anunț</h1>
    </header>
    <main>
        <!-- Formular pentru adăugarea sau modificarea unui anunț -->
        <form id="announcementForm" action="php/save_announcement.php" method="post">
            <!-- Câmp ascuns pentru id-ul anunțului -->
            <input type="hidden" name="id" id="id" value="<?php echo htmlspecialchars($id); ?>">
            <!-- Câmp pentru titlul anunțului -->
            <label for="title">Titlu:</label>
            <input type="text" id="title" name="title" value="<?php echo htmlspecialchars($title); ?>" required>
            <!-- Câmp pentru conținutul anunțului -->
            <label for="content">Conținut:</label>
            <textarea id="content" name="content" required><?php echo htmlspecialchars($content); ?></textarea>
            <!-- Buton pentru salvarea anunțului -->
            <button type="submit">Salvează</button>
        </form>
    </main>
</body>
</html>
<script>
    // Adaugă un eveniment de submit pentru formular
    document.getElementById('announcementForm').addEventListener('submit', function(event) {
        // Preia valorile titlului și conținutului
        var title = document.getElementById('title').value;
        var content = document.getElementById('content').value;

        // Verifică dacă câmpurile sunt completate
        if (!title || !content) {
            // Afișează un mesaj de alertă și previne trimiterea formularului dacă câmpurile nu sunt completate
            alert('Te rog să completezi toate câmpurile.');
            event.preventDefault();
        }
    });
</script>
