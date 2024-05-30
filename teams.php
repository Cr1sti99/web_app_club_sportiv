<?php
// Pornește o sesiune PHP sau reia una existentă
session_start();

// Configurează afișarea erorilor pentru depanare
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Include fișierul de configurare pentru baza de date
require_once 'includes/config.php';

// Definește echipele și imaginile asociate
$teams = [
    'Trailblazers' => 'imagini/trail.jpg',
    'Cloud Chasers' => 'imagini/sky.jpg',
    'Trail Cubs' => 'imagini/juniori.jpg',
    'Evergreen Runners' => 'imagini/seniori.jpg',
];

// Definește descrierile echipelor
$descriptions = [
    'Trailblazers' => 'Echipa de Trail este inima aventurii în natură, unde membrii noștri își împing limitele și descoperă frumusețea peisajelor montane. Antrenamentele sunt concepute pentru a dezvolta rezistența și agilitatea necesară pentru terenuri variate.',
    'Cloud Chasers' => 'Echipa de Sky Running abordează cele mai înalte vârfuri și cele mai tehnice coborâri. Programul nostru este destinat celor care caută să se bucure de adrenalina alergării la altitudine.',
    'Trail Cubs' => 'Echipa de Juniori oferă un mediu prietenos și de suport pentru cei mici să se bucure de alergare. Prin joc și activități interactive, copiii învață importanța sportului pentru sănătate și dezvoltare.',
    'Evergreen Runners' => 'Echipa de Seniori încurajează stilul activ de viață indiferent de vârstă. Fie că alergi pentru a te menține în formă sau pentru a participa la competiții, comunitatea noastră este aici pentru a susține fiecare alergător.',
];

// Definește activitățile echipelor
$activities = [
    'Trailblazers' => ['Explorare de trasee montane lungi', 'Sesiuni tehnice de alergare', 'Retrageri și tabere de antrenament'],
    'Cloud Chasers' => ['Antrenamente specializate la înălțime', 'Competiții de skyrunning', 'Seminarii despre tehnici de alergare și siguranță pe munte'],
    'Trail Cubs' => ['Antrenamente și jocuri', 'Cursuri de inițiere în alergarea de anduranță', 'Participare la evenimente și curse pentru copii'],
    'Evergreen Runners' => ['Antrenamente de anduranță și rezistență', 'Evenimente sociale și de grup', 'Workshop-uri de sănătate și fitness'],
];
?>
<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Retezat Running - Echipe</title>
    <meta name="author" content="Cristi Serban">
    <meta name="keywords" content="Retezat, Trail, Skyrunning, Echipe">
    <meta name="description" content="Echipele Clubului Sportiv Retezat Running">
    <link href="css/style.css" rel="stylesheet" type="text/css">
</head>
<body>
    <?php include 'includes/header.php'; ?> <!-- Include fișierul de antet -->
    <main>
        <table>
            <?php $i = 0; ?>
            <?php foreach ($teams as $teamName => $imagePath): ?>
                <?php if ($i % 2 == 0): ?> <!-- Începe un nou rând pentru fiecare două echipe -->
                    <tr>
                <?php endif; ?>
                <td class="flip-container">
                    <div class="flipper">
                        <div class="front" style="background-image: url('<?php echo $imagePath; ?>');">
                            <h2>Echipa <strong><?php echo $teamName; ?></strong></h2> <!-- Numele echipei -->
                        </div>
                        <div class="back">
                            <p><?php echo $descriptions[$teamName]; ?></p> <!-- Descrierea echipei -->
                            <p>Activitățile echipei includ:</p>
                            <ul class="activities-list">
                                <?php foreach ($activities[$teamName] as $activity): ?>
                                    <li><?php echo $activity; ?></li> <!-- Activitățile echipei -->
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    </div>
                </td>
                <?php if ($i % 2 == 1): ?> <!-- Încheie rândul după două echipe -->
                    </tr>
                <?php endif; ?>
                <?php $i++; ?>
            <?php endforeach; ?>
        </table>
        <div class="members-section">
            <button onclick="showMembers()">Membrii</button> <!-- Buton pentru afișarea membrilor echipelor -->
            <?php if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true && isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
                <button onclick="window.location.href='php/edit_members.php'">Adaugă/Editare Membrii</button> <!-- Buton pentru adăugare/editare membri, vizibil doar pentru admin -->
            <?php endif; ?>
            <div id="members-list-container" style="display:none;">
                <h3>Membrii Echipei</h3>
                <div id="members-list-content"></div> <!-- Container pentru lista membrilor -->
            </div>
        </div>
    </main>
    <?php include 'includes/footer.php'; ?> <!-- Include fișierul de subsol -->
    <script>
        function showMembers() {
            var membersListContainer = document.getElementById('members-list-container');
            var membersListContent = document.getElementById('members-list-content');

            // Verifică dacă utilizatorul este autentificat
            if (<?php echo isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true ? 'true' : 'false'; ?>) {
                fetch('php/get_members.php') // Obține lista membrilor de la server
                    .then(response => response.json())
                    .then(data => {
                        membersListContent.innerHTML = '';
                        if (data.length > 0) {
                            // Afișează membrii fiecărei echipe
                            data.forEach(team => {
                                var teamHeader = document.createElement('h4');
                                teamHeader.textContent = 'Echipa ' + team.team_name;
                                membersListContent.appendChild(teamHeader);

                                var teamMembers = document.createElement('ul');
                                team.members.forEach(member => {
                                    var li = document.createElement('li');
                                    li.textContent = member.name;
                                    teamMembers.appendChild(li);
                                });
                                membersListContent.appendChild(teamMembers);
                            });
                        } else {
                            membersListContent.innerHTML = '<p>Nu sunt încărcați membri ai echipelor.</p>';
                        }
                        membersListContainer.style.display = 'block';
                    })
                    .catch(error => console.error('Error:', error));
            } else {
                alert('Din motive de GDPR membrii echipelor sunt vizibili doar pentru utilizatorii autentificați.');
            }
        }
    </script>
</body>
</html>
