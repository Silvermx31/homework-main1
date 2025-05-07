<?php
require_once 'Database.php';
$db = new Database();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name = trim($_POST["name"] ?? '');
    $email = trim($_POST["email"] ?? '');
    $message = trim($_POST["message"] ?? '');

    if ($name && $email && $message) {
        $timestamp = date("Y-m-d H:i:s");
        $safe_name = htmlspecialchars($name);
        $safe_email = htmlspecialchars($email);
        $safe_message = str_replace(["\r", "\n", ";"], " ", htmlspecialchars($message));

        // CSV salvestus
        $line = "$timestamp;$safe_name;$safe_email;$safe_message\n";
        file_put_contents("feedback.csv", $line, FILE_APPEND | LOCK_EX);

        // Andmebaasi salvestus
        $stmt = $db->prepare("INSERT INTO feedback (name, email, message, created_at) VALUES (?, ?, ?, ?)");
        if (!$stmt) {
            die("Prepare ebaõnnestus: " . $db->conn->error);
        }

        $stmt->bind_param("ssss", $name, $email, $message, $timestamp);
        if (!$stmt->execute()) {
            die("Execute ebaõnnestus: " . $stmt->error);
        }
        $stmt->close();

        echo "<h3>Aitäh! Teie sõnum on salvestatud.</h3>";
        echo "<a href='index.php'>Avalehele</a>";
    } else {
        echo "<h3>Palun täida kõik väljad.</h3>";
        echo "<a href='javascript:history.back()'>Tagasi</a>";
    }
} else {
    header("Location: contact.php");
    exit;
}
