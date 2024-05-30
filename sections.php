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
    <title>Retezat Running - Secțiuni</title> <!-- Titlul paginii -->
    <meta name="author" content="Cristi Serban"> <!-- Autorul paginii -->
    <meta name="keywords" content="Retezat, Trail, Skyrunning, Secțiuni"> <!-- Cuvinte cheie pentru SEO -->
    <meta name="description" content="Secțiile Clubului Sportiv Retezat Running"> <!-- Descrierea paginii pentru SEO -->
    <link href="css/style.css" rel="stylesheet" type="text/css"> <!-- Include fișierul CSS pentru stiluri generale -->
</head>
<body>
    <?php include 'includes/header.php'; ?> <!-- Include fișierul de antet -->
    <main>
        <table>
            <tr>
                <!-- Prima secțiune: Secția de Trail Running -->
                <td class="flip-container">
                    <div class="flipper">
                        <div class="front" style="background-image: url('imagini/sectie_trail.jpg');"> <!-- Imaginea pentru secțiunea de trail -->
                            <h2>Secția de Trail Running</h2>
                        </div>
                        <div class="back">
                            <p>Secția de Trail Running este nucleul pasionaților de aventură în natură, oferind membrilor posibilitatea de a explora trasee montane diverse. Programele de antrenament sunt special concepute pentru a crește rezistența fizică și agilitatea necesară pe terenuri variate și provocatoare.</p>
                            <p>Activitățile secției includ:</p>
                            <ul>
                                <li>Explorare de trasee montane</li>
                                <li>Sesiuni de antrenament tehnic</li>
                                <li>Tabere de antrenament și retrageri în natură</li>
                            </ul>
                        </div>
                    </div>
                </td>
                <!-- A doua secțiune: Secția de Skyrunning -->
                <td class="flip-container">
                    <div class="flipper">
                        <div class="front" style="background-image: url('imagini/sky_running.jpg');"> <!-- Imaginea pentru secțiunea de skyrunning -->
                            <h2>Secția de Skyrunning</h2>
                        </div>
                        <div class="back">
                            <p>Secția de Skyrunning îi adună pe cei mai ambițioși alergători, dornici să cucerească cele mai înalte vârfuri. Antrenamentele sunt adaptate pentru a face față provocărilor unice ale alergării la altitudine mare, combinând alergarea cu tehnici de alpinism.</p>
                            <p>Activitățile secției includ:</p>
                            <ul>
                                <li>Alergări pe creste și vârfuri montane</li>
                                <li>Sesiuni de adaptare la condiții extreme de altitudine</li>
                                <li>Participări la competiții de skyrunning</li>
                            </ul>
                        </div>
                    </div>
                </td>
            </tr>
            <tr>
                <!-- A treia secțiune: Secția de Endurance Running -->
                <td class="flip-container">
                    <div class="flipper">
                        <div class="front" style="background-image: url('imagini/endurance.jpg');"> <!-- Imaginea pentru secțiunea de endurance running -->
                            <h2>Secția de Endurance Running</h2>
                        </div>
                        <div class="back">
                            <p>Secția de Endurance Running este dedicată atleților care preferă cursele lungi. Programul este orientat spre dezvoltarea rezistenței și a capacității de a menține un efort susținut, ideal pentru ultramaratoane și curse de anduranță.</p>
                            <p>Activitățile secției includ:</p>
                            <ul>
                                <li>Antrenamente pentru îmbunătățirea rezistenței la efort</li>
                                <li>Strategii de nutriție și hidratare</li>
                                <li>Evenimente și maratoane de anduranță</li>
                            </ul>
                        </div>
                    </div>
                </td>
                <!-- A patra secțiune: Secția de Fitness și Recuperare -->
                <td class="flip-container">
                    <div class="flipper">
                        <div class="front" style="background-image: url('imagini/recuperare.jpg');"> <!-- Imaginea pentru secțiunea de fitness și recuperare -->
                            <h2>Secția de Fitness și Recuperare</h2>
                        </div>
                        <div class="back">
                            <p>Secția de Fitness și Recuperare pune accent pe îmbunătățirea condiției fizice și pe recuperarea optimă după efort.</p>
                            <p>Activitățile secției includ:</p>
                            <ul>
                                <li>Sesiuni pentru îmbunătățirea flexibilității și forței</li>
                                <li>Workshop-uri de recuperare și tehnici de relaxare musculară</li>
                                <li>Consiliere pentru un stil de viață echilibrat și sănătos</li>
                            </ul>
                        </div>
                    </div>
                </td>
            </tr>
        </table>
    </main>
    <?php include 'includes/footer.php'; ?> <!-- Include fișierul de subsol -->
</body>
</html>
