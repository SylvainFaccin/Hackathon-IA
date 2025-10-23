<?php
/**
 * Script d'insertion des produits de démonstration
 * À exécuter une seule fois pour initialiser la base de données
 */

require_once 'config.php';

// Vérifier si les produits existent déjà
$check_sql = "SELECT COUNT(*) as count FROM produits";
$check_result = $conn->query($check_sql);
$row = $check_result->fetch_assoc();

if ($row['count'] > 0) {
    echo "<!DOCTYPE html>
    <html lang='fr'>
    <head>
        <meta charset='UTF-8'>
        <meta name='viewport' content='width=device-width, initial-scale=1.0'>
        <title>Insertion des produits - EcoShop</title>
        <link rel='stylesheet' href='assets/css/style.css'>
    </head>
    <body style='padding: 50px; text-align: center;'>
        <h1 style='color: #2ecc71;'>⚠️ Produits déjà insérés</h1>
        <p style='color: #f2f2f2; font-size: 18px;'>La base de données contient déjà {$row['count']} produit(s).</p>
        <p style='color: #888;'>Pour réinsérer les produits, videz d'abord la table.</p>
        <br>
        <a href='recherche.php' style='background-color: #2ecc71; color: #121212; padding: 15px 30px; border-radius: 25px; text-decoration: none; font-weight: 600;'>Voir les produits</a>
    </body>
    </html>";
    exit;
}

// Produits de démonstration
$produits = [
    [
        'nom' => 'Shampoing Bio',
        'description' => 'Shampoing naturel aux huiles essentielles, sans sulfates ni parabènes. Idéal pour tous types de cheveux. Formule douce et respectueuse du cuir chevelu.',
        'categorie' => 'Hygiène',
        'prix' => 12.90,
        'empreinte_carbone' => 0.85,
        'score_ecologique' => 9,
        'image' => 'shampoing-bio.jpg'
    ],
    [
        'nom' => 'Savon Naturel',
        'description' => 'Savon artisanal à l\'huile d\'olive et au karité. Fabriqué à la main en France. Sans additifs chimiques, parfait pour toute la famille.',
        'categorie' => 'Hygiène',
        'prix' => 6.50,
        'empreinte_carbone' => 0.70,
        'score_ecologique' => 8,
        'image' => 'savon-naturel.jpg'
    ],
    [
        'nom' => 'Thé Vert Bio',
        'description' => 'Thé vert biologique cultivé en agriculture raisonnée. Récolte manuelle et séchage traditionnel. Riche en antioxydants.',
        'categorie' => 'Alimentation',
        'prix' => 9.80,
        'empreinte_carbone' => 1.10,
        'score_ecologique' => 9,
        'image' => 'the-vert-bio.jpg'
    ],
    [
        'nom' => 'Dentifrice Solide',
        'description' => 'Dentifrice solide zéro déchet au fluor naturel. Durée de vie équivalente à 2 tubes classiques. Sans plastique, 100% compostable.',
        'categorie' => 'Hygiène',
        'prix' => 8.90,
        'empreinte_carbone' => 0.65,
        'score_ecologique' => 10,
        'image' => 'dentifrice-solide.jpg'
    ],
    [
        'nom' => 'Riz Local',
        'description' => 'Riz complet cultivé localement en Camargue. Agriculture biologique certifiée. Soutient les producteurs français.',
        'categorie' => 'Alimentation',
        'prix' => 5.40,
        'empreinte_carbone' => 2.30,
        'score_ecologique' => 6,
        'image' => 'riz-local.jpg'
    ]
];

// Préparer la requête d'insertion
$sql = "INSERT INTO produits (nom, description, categorie, prix, empreinte_carbone, score_ecologique, image)
        VALUES (?, ?, ?, ?, ?, ?, ?)";

$stmt = $conn->prepare($sql);

$inserted_count = 0;
$errors = [];

// Insérer chaque produit
foreach ($produits as $produit) {
    $stmt->bind_param(
        'sssddis',
        $produit['nom'],
        $produit['description'],
        $produit['categorie'],
        $produit['prix'],
        $produit['empreinte_carbone'],
        $produit['score_ecologique'],
        $produit['image']
    );

    if ($stmt->execute()) {
        $inserted_count++;
    } else {
        $errors[] = "Erreur lors de l'insertion de {$produit['nom']}: " . $stmt->error;
    }
}

$stmt->close();
$conn->close();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Insertion des produits - EcoShop</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
</head>
<body>

    <section style="min-height: 100vh; display: flex; align-items: center; justify-content: center; background-color: #121212; padding: 50px 20px;">
        <div style="max-width: 600px; text-align: center; background-color: #1a1a1a; padding: 50px; border-radius: 20px; box-shadow: 0 10px 40px rgba(0, 0, 0, 0.5);">
            <?php if ($inserted_count === count($produits)): ?>
                <div style="font-size: 80px; margin-bottom: 20px;">✅</div>
                <h1 style="color: #2ecc71; font-size: 36px; margin-bottom: 20px;">Succès !</h1>
                <p style="color: #f2f2f2; font-size: 18px; line-height: 1.6; margin-bottom: 30px;">
                    <?php echo $inserted_count; ?> produit(s) ont été insérés avec succès dans la base de données EcoShop.
                </p>
                <div style="background-color: #242424; padding: 20px; border-radius: 10px; margin-bottom: 30px;">
                    <h3 style="color: #2ecc71; margin-bottom: 15px;">Produits ajoutés :</h3>
                    <ul style="color: #b8b8b8; list-style: none; padding: 0;">
                        <?php foreach ($produits as $p): ?>
                            <li style="padding: 8px 0; border-bottom: 1px solid #333;">
                                <?php echo htmlspecialchars($p['nom']); ?> - <?php echo $p['prix']; ?> € (Score: <?php echo $p['score_ecologique']; ?>/10)
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
                <a href="recherche.php" style="display: inline-block; background-color: #2ecc71; color: #121212; padding: 15px 40px; border-radius: 30px; text-decoration: none; font-weight: 600; font-size: 16px; transition: all 0.3s ease;">
                    🔍 Rechercher des produits
                </a>
                <br><br>
                <a href="index.php" style="color: #888; text-decoration: none; font-size: 14px;">
                    ← Retour à l'accueil
                </a>
            <?php else: ?>
                <div style="font-size: 80px; margin-bottom: 20px;">❌</div>
                <h1 style="color: #e74c3c; font-size: 36px; margin-bottom: 20px;">Erreur</h1>
                <p style="color: #f2f2f2; font-size: 18px; line-height: 1.6; margin-bottom: 30px;">
                    Seulement <?php echo $inserted_count; ?> produit(s) sur <?php echo count($produits); ?> ont été insérés.
                </p>
                <?php if (!empty($errors)): ?>
                    <div style="background-color: #242424; padding: 20px; border-radius: 10px; margin-bottom: 30px; text-align: left;">
                        <h3 style="color: #e74c3c; margin-bottom: 15px;">Erreurs :</h3>
                        <ul style="color: #b8b8b8;">
                            <?php foreach ($errors as $error): ?>
                                <li style="margin-bottom: 10px;"><?php echo htmlspecialchars($error); ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php endif; ?>
                <a href="index.php" style="display: inline-block; background-color: #2ecc71; color: #121212; padding: 15px 40px; border-radius: 30px; text-decoration: none; font-weight: 600; font-size: 16px;">
                    Retour à l'accueil
                </a>
            <?php endif; ?>
        </div>
    </section>

</body>
</html>
