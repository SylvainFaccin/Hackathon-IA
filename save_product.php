<?php
// Script PHP pour sauvegarder les produits consultés dans une base MySQL
// Compatible avec InfinityFree et autres hébergeurs gratuits

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

// Gestion des requêtes OPTIONS (CORS)
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

// Vérification de la méthode POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['error' => 'Méthode non autorisée']);
    exit();
}

// Configuration de la base de données
// Remplace ces valeurs par tes propres paramètres InfinityFree
$host = 'sqlXXX.infinityfree.com';
$dbname = 'if0_40235611_eco_shop';
$username = 'if0_40235611';         
$password = 'ZnNi7reJmhz';    // Remplace par ton mot de passe

try {
    // Connexion à la base de données
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Récupération des données JSON
    $input = file_get_contents('php://input');
    $data = json_decode($input, true);
    
    if (!$data) {
        throw new Exception('Données JSON invalides');
    }
    
    // Validation des données requises
    $required_fields = ['code_barres', 'nom', 'marque', 'categorie', 'ecoscore'];
    foreach ($required_fields as $field) {
        if (!isset($data[$field]) || empty($data[$field])) {
            throw new Exception("Champ requis manquant: $field");
        }
    }
    
    // Préparation de la requête d'insertion
    $sql = "INSERT INTO produits_consultes (
        code_barres, 
        nom, 
        marque, 
        categorie, 
        ecoscore, 
        labels, 
        date_consultation,
        ip_utilisateur
    ) VALUES (
        :code_barres, 
        :nom, 
        :marque, 
        :categorie, 
        :ecoscore, 
        :labels, 
        NOW(),
        :ip_utilisateur
    )";
    
    $stmt = $pdo->prepare($sql);
    
    // Exécution avec les paramètres
    $result = $stmt->execute([
        ':code_barres' => $data['code_barres'],
        ':nom' => $data['nom'],
        ':marque' => $data['marque'],
        ':categorie' => $data['categorie'],
        ':ecoscore' => $data['ecoscore'],
        ':labels' => $data['labels'] ?? '',
        ':ip_utilisateur' => $_SERVER['REMOTE_ADDR'] ?? 'unknown'
    ]);
    
    if ($result) {
        echo json_encode([
            'success' => true,
            'message' => 'Produit sauvegardé avec succès',
            'id' => $pdo->lastInsertId()
        ]);
    } else {
        throw new Exception('Erreur lors de la sauvegarde');
    }
    
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode([
        'error' => 'Erreur de base de données',
        'message' => $e->getMessage()
    ]);
} catch (Exception $e) {
    http_response_code(400);
    echo json_encode([
        'error' => 'Erreur de validation',
        'message' => $e->getMessage()
    ]);
}
?>
