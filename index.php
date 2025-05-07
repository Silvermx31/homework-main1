
<?php
$page = $_GET['page'] ?? 'home';
$allowed_pages = ['home', 'contact', 'admin', 'thanks'];
if (!in_array($page, $allowed_pages)) {
    $page = 'home';
}
?>
<!DOCTYPE html>
<html lang="et">
<head>
    <meta charset="UTF-8">
    <title>Tagasiside süsteem</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container">
    <a class="navbar-brand" href="index.php">Tagasiside</a>
    <div class="collapse navbar-collapse">
      <ul class="navbar-nav ms-auto">
        <li class="nav-item"><a class="nav-link<?= $page === 'home' ? ' active' : '' ?>" href="index.php?page=home">Avaleht</a></li>
        <li class="nav-item"><a class="nav-link<?= $page === 'contact' ? ' active' : '' ?>" href="index.php?page=contact">Kontakt</a></li>
        <li class="nav-item"><a class="nav-link<?= $page === 'admin' ? ' active' : '' ?>" href="index.php?page=admin&key=admin123">Admin</a></li>
      </ul>
    </div>
  </div>
</nav>

<div class="container mt-4">
<?php
switch ($page) {
    case 'contact':
        include 'contact.html';
        break;
    case 'admin':
        include 'admin.php';
        break;
    case 'thanks':
        echo "<h3>Aitäh! Teie sõnum on salvestatud.</h3>";
        break;
    default:
        echo "<h1>Tere tulemast!</h1><p>See on lihtne tagasisidesüsteem Bootstrapiga ja PHP abil.</p>";
        break;
}
?>
</div>
</body>
</html>
