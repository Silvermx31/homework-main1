<?php
require_once 'Database.php';
$db = new Database();

$success = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'] ?? '';
    $email = $_POST['email'] ?? '';
    $message = $_POST['message'] ?? '';
    $date = date('Y-m-d H:i:s');

    // Andmebaasi
    $stmt = $db->prepare("INSERT INTO feedback (name, email, message, created_at) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $name, $email, $message, $date);
    $stmt->execute();
    $stmt->close();

    // CSV faili
    $csv = fopen('feedback.csv', 'a');
    if ($csv) {
        fputcsv($csv, [$name, $email, $message, $date]);
        fclose($csv);
    }

    $success = true;
}
?>

<!DOCTYPE html>
<html lang="et">
<head>
    <meta charset="UTF-8">
    <title>Kontakt</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="index.php">Avaleht</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
        </div>
    </nav>

    <div class="container mt-5">
        <h2 class="mb-4">Võta meiega ühendust</h2>

        <?php if ($success): ?>
            <div class="alert alert-success">Aitäh tagasiside eest!</div>
        <?php endif; ?>

        <form action="contact.php" method="POST" class="needs-validation" novalidate>
            <div class="mb-3">
                <label for="name" class="form-label">Nimi</label>
                <input type="text" class="form-control" id="name" name="name" required>
                <div class="invalid-feedback">Palun sisesta oma nimi.</div>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">E-post</label>
                <input type="email" class="form-control" id="email" name="email" required>
                <div class="invalid-feedback">Palun sisesta kehtiv e-post.</div>
            </div>
            <div class="mb-3">
                <label for="message" class="form-label">Sõnum</label>
                <textarea class="form-control" id="message" name="message" rows="4" required></textarea>
                <div class="invalid-feedback">Palun kirjuta sõnum.</div>
            </div>
            <button type="submit" class="btn btn-primary">Saada</button>
        </form>
    </div>

    <script>
        (() => {
            'use strict';
            const forms = document.querySelectorAll('.needs-validation');
            Array.from(forms).forEach(form => {
                form.addEventListener('submit', event => {
                    if (!form.checkValidity()) {
                        event.preventDefault();
                        event.stopPropagation();
                    }
                    form.classList.add('was-validated');
                }, false);
            });
        })();
    </script>
</body>
</html>