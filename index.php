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
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> <!-- Asigură o bună afișare pe dispozitive mobile -->
    <title>Retezat Running</title> <!-- Titlul paginii -->
    <meta name="author" content="Cristi Serban"> <!-- Autorul paginii -->
    <!-- META tags pentru SEO -->
    <meta name="keywords" content="Retezat, Trail, Skyrunning, club sportiv, alergare, fitness"> <!-- Cuvinte cheie pentru SEO -->
    <meta name="description" content="Clubul Sportiv Retezat Running - Promovăm sănătatea și activitățile sportive"> <!-- Descrierea paginii pentru SEO -->
    <link rel="stylesheet" href="css/style.css" type="text/css"> <!-- Include fișierul CSS pentru stiluri generale -->
</head>
<body>
    <?php include 'includes/header.php'; ?> <!-- Include fișierul de antet -->
    <main>
        <section id="about" class="info-section">
            <h2>Despre Noi</h2> <!-- Titlul secțiunii despre noi -->
            <p>Bine ați venit la Clubul Sportiv Retezat Running! Suntem o comunitate dedicată promovării sănătății și activităților sportive în rândul tuturor vârstelor. Ne mândrim cu diversele noastre secțiuni și echipe care practică diferite sporturi.</p>
            <p>Indiferent dacă sunteți un începător curios sau un alergător experimentat, vă așteptăm să vă alăturați echipei noastre și să vă bucurați de experiența sportivă alături de noi!</p>
            <h3>Antrenamente și Programe</h3> <!-- Subtitlul secțiunii despre antrenamente și programe -->
            <p>Clubul nostru oferă o varietate de antrenamente și programe adaptate pentru toate nivelurile de aptitudine. De la antrenamente de bază pentru începători până la programe de pregătire pentru competiții de trail running, avem ceva pentru fiecare.</p>
            <p>Pentru detalii despre programele noastre, vă rugăm să consultați pagina noastră de <a href="sections.php">Secții</a> sau să ne contactați pentru mai multe informații.</p>
        </section>
        <section id="mission" class="info-section">
            <h2>Misiunea Noastră</h2> <!-- Titlul secțiunii despre misiunea noastră -->
            <p>Misiunea noastră este de a oferi oportunități pentru oameni de toate vârstele și nivelurile de aptitudine să se implice în activități sportive, să își îmbunătățească sănătatea fizică și mentală și să construiască relații puternice prin efortul comun în sport.</p>
        </section>
        <section id="join" class="info-section">
            <h2>Alătură-te Nouă</h2> <!-- Titlul secțiunii pentru alăturare -->
            <p>Vă invităm să explorați secțiunile și echipele noastre și să vă alăturați nouă în călătoria noastră spre performanță sportivă și viață sănătoasă!</p>
            <a href="contact.php" class="button">Contactează-ne pentru a te înscrie, pentru a solicita informații suplimentare sau pentru a ne trimite un mesaj 😊</a> <!-- Buton pentru a contacta clubul pentru înscriere -->
        </section>
    </main>
    <?php include 'includes/footer.php'; ?> <!-- Include fișierul de subsol -->
</body>
</html>
