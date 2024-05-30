<!-- includes/nav.php -->
<!-- Navigarea principală a site-ului -->
<nav class="main-nav">
    <a href="/Proiect/index.php">Home</a> <!-- Link către pagina principală -->
    <a href="/Proiect/sections.php">Secții</a> <!-- Link către pagina secțiilor -->
    <a href="/Proiect/teams.php">Echipe</a> <!-- Link către pagina echipelor -->
    <a href="/Proiect/announcements.php">Anunțuri</a> <!-- Link către pagina anunțurilor -->
    <a href="/Proiect/gallery.php">Galerie</a> <!-- Link către pagina galeriei -->
    <div class="animation start-home"></div> <!-- Element pentru animație de navigare -->
</nav>

<!-- Navigarea pentru autentificare -->
<nav class="auth-nav">
    <?php if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true): ?>
        <a href="/Proiect/php/logout.php">Logout</a> <!-- Link pentru deconectare dacă utilizatorul este autentificat -->
    <?php else: ?>
        <a href="/Proiect/php/login.php">Login</a> <!-- Link pentru autentificare dacă utilizatorul nu este autentificat -->
        <a href="/Proiect/register.php">Register</a> <!-- Link pentru înregistrare dacă utilizatorul nu este autentificat -->
    <?php endif; ?>
</nav>
