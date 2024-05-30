<?php
// Pornește o sesiune PHP sau reia una existentă
session_start();

// Configurează afișarea erorilor pentru depanare
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Include fișierul de configurare pentru baza de date
require_once 'includes/config.php';

// Inițializează variabilele pentru id, name, birthdate și team_name
$id = '';
$name = '';
$birthdate = '';
$team_name = '';

// Verifică dacă există un parametru 'id' în URL și dacă este numeric
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    // Preia valoarea id-ului din URL
    $id = $_GET['id'];
    
    // Pregătește interogarea SQL pentru a prelua datele membrului din baza de date
    $sql = "SELECT name, birthdate, team_name FROM team_members WHERE id = ?";
    if ($stmt = $conn->prepare($sql)) {
        // Leagă parametrii și execută interogarea
        $stmt->bind_param("i", $id);
        $stmt->execute();
        // Leagă rezultatele interogării la variabilele name, birthdate și team_name
        $stmt->bind_result($name, $birthdate, $team_name);
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
    <meta charset="UTF-8"> <!-- Setează codificarea caracterelor -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> <!-- Asigură o bună afișare pe dispozitive mobile -->
    <title>Adaugă/Modifică Membru</title> <!-- Titlul paginii -->
    <link href="css/style.css" rel="stylesheet" type="text/css"> <!-- Include fișierul CSS pentru stiluri -->
</head>
<body>
    <header>
        <h1>Adaugă/Modifică Membru</h1> <!-- Titlul paginii -->
    </header>
    <main>
        <!-- Formular pentru adăugarea sau modificarea unui membru -->
        <form id="memberForm" action="php/save_member.php" method="post">
            <!-- Câmp ascuns pentru id-ul membrului -->
            <input type="hidden" name="id" id="id" value="<?php echo htmlspecialchars($id); ?>">
            <!-- Câmp pentru numele membrului -->
            <label for="name">Nume Prenume:</label>
            <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($name); ?>" required>
            <!-- Câmp pentru data nașterii -->
            <label for="birthdate">Data nașterii:</label>
            <input type="date" id="birthdate" name="birthdate" value="<?php echo htmlspecialchars($birthdate); ?>" required>
            <!-- Câmp pentru selectarea echipei -->
            <label for="team_name">Nume Echipa:</label>
            <select id="team_name" name="team_name" required>
                <option value="Trailblazers" <?php echo ($team_name == 'Trailblazers') ? 'selected' : ''; ?>>Trailblazers (Echipa de Trail)</option>
                <option value="Cloud Chasers" <?php echo ($team_name == 'Cloud Chasers') ? 'selected' : ''; ?>>Cloud Chasers (Echipa de Sky-Running)</option>
                <option value="Trail Cubs" <?php echo ($team_name == 'Trail Cubs') ? 'selected' : ''; ?>>Trail Cubs (Echipa de Juniori)</option>
                <option value="Evergreen Runners" <?php echo ($team_name == 'Evergreen Runners') ? 'selected' : ''; ?>>Evergreen Runners (Echipa de Seniori)</option>
            </select>
            <!-- Buton pentru salvarea membrului -->
            <button type="submit">Salvează</button>
        </form>
    </main>
</body>
</html>
<!-- Script pentru validarea formularului înainte de trimitere -->
<script>
    // Adaugă un event listener pentru evenimentul 'submit' al formularului cu id-ul 'memberForm'
    document.getElementById('memberForm').addEventListener('submit', function(event) {
        
        // Preia valoarea câmpului 'birthdate' și creează un obiect Date
        var birthdate = new Date(document.getElementById('birthdate').value);
        
        // Preia valoarea selectată a câmpului 'team_name'
        var teamName = document.getElementById('team_name').value;
        
        // Creează un obiect Date pentru data curentă
        var today = new Date();
        
        // Calculează vârsta persoanei pe baza datei de naștere
        var age = today.getFullYear() - birthdate.getFullYear();
        
        // Calculează diferența de luni între data curentă și data de naștere
        var m = today.getMonth() - birthdate.getMonth();
        
        // Ajustează calculul vârstei dacă luna curentă este înaintea lunii de naștere
        // sau dacă este aceeași lună, dar ziua curentă este înaintea zilei de naștere
        if (m < 0 || (m === 0 && today.getDate() < birthdate.getDate())) {
            age--;
        }

        // Inițializează un mesaj de eroare gol
        var errorMessage = '';
        
        // Verifică echipa selectată și vârsta persoanei pentru a vedea dacă se încadrează în limitele de vârstă
        if (teamName === 'Trailblazers' || teamName === 'Cloud Chasers') {
            if (age < 18) {
                // Setează mesajul de eroare dacă vârsta este sub 18 ani pentru echipele Trailblazers sau Cloud Chasers
                errorMessage = 'Vârsta minimă pentru echipa ' + teamName + ' este de 18 ani.';
            }
        } else if (teamName === 'Trail Cubs') {
            if (age > 18) {
                // Setează mesajul de eroare dacă vârsta este peste 18 ani pentru echipa Trail Cubs
                errorMessage = 'Vârsta maximă pentru echipa Trail Cubs este de 18 ani.';
            }
        } else if (teamName === 'Evergreen Runners') {
            if (age < 50) {
                // Setează mesajul de eroare dacă vârsta este sub 50 de ani pentru echipa Evergreen Runners
                errorMessage = 'Vârsta minimă pentru echipa Evergreen Runners este de 50 ani.';
            }
        }

        // Dacă există un mesaj de eroare, afișează-l și previne trimiterea formularului
        if (errorMessage) {
            alert(errorMessage); // Afișează mesajul de eroare într-o fereastră de alertă
            event.preventDefault(); // Previne trimiterea formularului
        }
    });
</script>
