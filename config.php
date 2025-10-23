<?php
/**
 * Configuration de la base de données EcoShop
 * Connexion MySQL locale
 */

// Paramètres de connexion
$host = 'localhost';
$dbname = 'ecoshop_db';
$username = 'root';
$password = '';

// Création de la connexion MySQLi
$conn = new mysqli($host, $username, $password, $dbname);

// Vérification de la connexion
if ($conn->connect_error) {
    die('Erreur de connexion à la base de données : ' . $conn->connect_error);
}

// Définir l'encodage UTF-8
$conn->set_charset('utf8mb4');
?>
