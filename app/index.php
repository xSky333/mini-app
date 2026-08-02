<?php

$host = getenv('DB_HOST');
$nazwaBazy = getenv('DB_NAME');
$uzytkownik = getenv('DB_USER');
$haslo = getenv('DB_PASSWORD');

$baza = new mysqli($host, $uzytkownik, $haslo, $nazwaBazy);

if ($baza->connect_error) {
    http_response_code(500);
    die("Błąd połączenia z bazą: " . $baza->connect_error);
}

$baza->set_charset("utf8mb4");

$baza->query("
    CREATE TABLE IF NOT EXISTS odwiedziny (
        id INT AUTO_INCREMENT PRIMARY KEY,
        data_wejscia TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )
");

$baza->query("INSERT INTO odwiedziny () VALUES ()");

$wynik = $baza->query("SELECT COUNT(*) AS liczba FROM odwiedziny");
$wiersz = $wynik->fetch_assoc();

echo "<h1>Mini aplikacja działa!</h1>";
echo "<p>PHP połączył się z MariaDB.</p>";
echo "<p>Liczba odwiedzin: " . $wiersz['liczba'] . "</p>";

$baza->close();
