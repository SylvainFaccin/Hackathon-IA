<?php
require_once 'config.php';

// Récupération de l'ID du produit
$product_id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$product = null;

// Récupération des détails du produit
if ($product_id > 0) {
    $sql = "SELECT * FROM produits WHERE id_produit = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $product_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $product = $result->fetch_assoc();
    }

    $stmt->close();
}

// Si le produit n'existe pas, rediriger vers la recherche
if (!$product) {
    header('Location: recherche.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($product['nom']); ?> - EcoShop</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
</head>
<body>

    <!-- Header / Navbar -->
    <header class="header">
        <div class="container">
            <div class="navbar">
                <div class="logo">
                    <a href="index.php"><h1>🌿 EcoShop</h1></a>
                </div>
                <nav class="nav-menu">
                    <a href="index.php" class="nav-link">Accueil</a>
                    <a href="recherche.php" class="nav-link">Recherche</a>
                    <a href="index.php#valeurs" class="nav-link">À propos</a>
                    <a href="index.php#contact" class="nav-link">Contact</a>
                    <a href="#connexion" class="nav-link btn-connexion">Connexion</a>
                </nav>
            </div>
        </div>
    </header>

    <!-- Section Détail Produit -->
    <section class="produit-detail-section">
        <div class="container">
            <a href="recherche.php" class="back-link">← Retour à la recherche</a>

            <div class="produit-detail">
                <div class="produit-detail-grid">
                    <!-- Image du produit -->
                    <div class="produit-detail-image">
                        <div class="placeholder-image">🌱</div>
                        <?php if ($product['score_ecologique'] >= 8): ?>
                            <span class="eco-badge">⭐ Excellent</span>
                        <?php elseif ($product['score_ecologique'] >= 6): ?>
                            <span class="eco-badge">✓ Bon</span>
                        <?php endif; ?>
                    </div>

                    <!-- Contenu du produit -->
                    <div class="produit-detail-content">
                        <div class="produit-detail-header">
                            <span class="produit-categorie"><?php echo htmlspecialchars($product['categorie']); ?></span>
                            <h1 class="produit-detail-titre"><?php echo htmlspecialchars($product['nom']); ?></h1>
                            <div class="produit-detail-prix"><?php echo number_format($product['prix'], 2, ',', ' '); ?> €</div>
                        </div>

                        <div class="produit-detail-description">
                            <p><?php echo nl2br(htmlspecialchars($product['description'])); ?></p>
                        </div>

                        <!-- Informations écologiques détaillées -->
                        <div class="eco-info-detail">
                            <h3>🌍 Impact Écologique</h3>
                            <div class="eco-metrics-grid">
                                <div class="eco-metric">
                                    <span class="eco-label">Empreinte Carbone</span>
                                    <span class="eco-value"><?php echo number_format($product['empreinte_carbone'], 2, ',', ' '); ?> kg CO₂</span>
                                    <p style="font-size: 12px; color: #666; margin-top: 5px;">
                                        <?php
                                        if ($product['empreinte_carbone'] < 1) {
                                            echo "Très faible impact";
                                        } elseif ($product['empreinte_carbone'] < 2) {
                                            echo "Faible impact";
                                        } else {
                                            echo "Impact modéré";
                                        }
                                        ?>
                                    </p>
                                </div>

                                <div class="eco-metric">
                                    <span class="eco-label">Score Écologique</span>
                                    <span class="eco-score"><?php echo $product['score_ecologique']; ?>/10</span>
                                    <p style="font-size: 12px; color: #666; margin-top: 5px;">
                                        <?php
                                        if ($product['score_ecologique'] >= 9) {
                                            echo "Excellent choix";
                                        } elseif ($product['score_ecologique'] >= 7) {
                                            echo "Très bon choix";
                                        } elseif ($product['score_ecologique'] >= 5) {
                                            echo "Bon choix";
                                        } else {
                                            echo "Choix acceptable";
                                        }
                                        ?>
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- Caractéristiques écologiques -->
                        <div class="eco-info-detail">
                            <h3>✨ Pourquoi ce produit ?</h3>
                            <ul style="color: #b8b8b8; line-height: 2; margin-left: 20px;">
                                <?php if ($product['score_ecologique'] >= 8): ?>
                                    <li>Produit hautement écologique et durable</li>
                                    <li>Fabriqué dans le respect de l'environnement</li>
                                <?php endif; ?>
                                <li>Empreinte carbone réduite</li>
                                <li>Matériaux respectueux de la planète</li>
                                <?php if (stripos($product['description'], 'bio') !== false): ?>
                                    <li>Certifié biologique</li>
                                <?php endif; ?>
                                <?php if (stripos($product['description'], 'local') !== false || stripos($product['nom'], 'local') !== false): ?>
                                    <li>Production locale</li>
                                <?php endif; ?>
                                <li>Sans substances nocives</li>
                            </ul>
                        </div>

                        <!-- Actions -->
                        <div class="produit-actions">
                            <a href="#" class="btn btn-primary">🛒 Ajouter au panier</a>
                            <a href="recherche.php" class="btn btn-secondary">Voir d'autres produits</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="footer-content">
                <div class="footer-left">
                    <p>&copy; 2025 EcoShop &mdash; Tous droits réservés</p>
                </div>
                <div class="footer-right">
                    <a href="#" class="social-link" title="Facebook">📘</a>
                    <a href="#" class="social-link" title="Instagram">📷</a>
                    <a href="#" class="social-link" title="Twitter">🐦</a>
                    <a href="#" class="social-link" title="LinkedIn">💼</a>
                </div>
            </div>
        </div>
    </footer>

</body>
</html>

<?php
$conn->close();
?>
