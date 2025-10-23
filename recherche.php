<?php
require_once 'config.php';

// Récupération du terme de recherche
$search_query = isset($_GET['q']) ? trim($_GET['q']) : '';
$products = [];

// Si une recherche est effectuée
if (!empty($search_query)) {
    // Préparation de la requête sécurisée
    $search_term = '%' . $conn->real_escape_string($search_query) . '%';

    $sql = "SELECT * FROM produits
            WHERE nom LIKE ?
            OR description LIKE ?
            OR categorie LIKE ?
            ORDER BY score_ecologique DESC, nom ASC";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param('sss', $search_term, $search_term, $search_term);
    $stmt->execute();
    $result = $stmt->get_result();

    while ($row = $result->fetch_assoc()) {
        $products[] = $row;
    }

    $stmt->close();
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recherche de Produits - EcoShop</title>
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
                    <a href="recherche.php" class="nav-link active">Recherche</a>
                    <a href="index.php#valeurs" class="nav-link">À propos</a>
                    <a href="index.php#contact" class="nav-link">Contact</a>
                    <a href="#connexion" class="nav-link btn-connexion">Connexion</a>
                </nav>
            </div>
        </div>
    </header>

    <!-- Section Recherche -->
    <section class="recherche-section">
        <div class="container">
            <h1 class="section-title">Recherche de Produits Écologiques</h1>
            <p class="section-subtitle">Trouvez les produits qui correspondent à vos valeurs</p>

            <!-- Formulaire de recherche -->
            <div class="search-box">
                <form method="GET" action="recherche.php" class="search-form">
                    <input
                        type="text"
                        name="q"
                        class="search-input"
                        placeholder="Rechercher par nom, catégorie ou description..."
                        value="<?php echo htmlspecialchars($search_query); ?>"
                        required
                    >
                    <button type="submit" class="btn btn-primary">🔍 Rechercher</button>
                </form>
            </div>

            <?php if (!empty($search_query)): ?>
                <!-- Résultats de recherche -->
                <div class="search-results">
                    <h2 class="results-title">
                        <?php if (count($products) > 0): ?>
                            <?php echo count($products); ?> résultat<?php echo count($products) > 1 ? 's' : ''; ?> pour "<?php echo htmlspecialchars($search_query); ?>"
                        <?php else: ?>
                            Aucun résultat pour "<?php echo htmlspecialchars($search_query); ?>"
                        <?php endif; ?>
                    </h2>

                    <?php if (count($products) > 0): ?>
                        <div class="produits-grid">
                            <?php foreach ($products as $product): ?>
                                <div class="produit-card">
                                    <div class="produit-image">
                                        <div class="placeholder-image">🌱</div>
                                        <?php if ($product['score_ecologique'] >= 8): ?>
                                            <span class="eco-badge">⭐ Excellent</span>
                                        <?php endif; ?>
                                    </div>
                                    <div class="produit-info">
                                        <span class="produit-categorie"><?php echo htmlspecialchars($product['categorie']); ?></span>
                                        <h3 class="produit-titre"><?php echo htmlspecialchars($product['nom']); ?></h3>
                                        <p class="produit-description">
                                            <?php
                                            $desc = htmlspecialchars($product['description']);
                                            echo strlen($desc) > 100 ? substr($desc, 0, 100) . '...' : $desc;
                                            ?>
                                        </p>

                                        <!-- Informations écologiques -->
                                        <div class="eco-info">
                                            <div class="eco-metric">
                                                <span class="eco-label">Empreinte carbone</span>
                                                <span class="eco-value"><?php echo number_format($product['empreinte_carbone'], 2, ',', ' '); ?> kg CO₂</span>
                                            </div>
                                            <div class="eco-metric">
                                                <span class="eco-label">Score écologique</span>
                                                <span class="eco-score"><?php echo $product['score_ecologique']; ?>/10</span>
                                            </div>
                                        </div>

                                        <div class="produit-footer">
                                            <span class="produit-prix"><?php echo number_format($product['prix'], 2, ',', ' '); ?> €</span>
                                            <a href="produit.php?id=<?php echo $product['id_produit']; ?>" class="btn btn-secondary">Voir plus</a>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php else: ?>
                        <div class="no-results">
                            <p>Essayez avec d'autres mots-clés comme "bio", "savon", "alimentation" ou "hygiène".</p>
                        </div>
                    <?php endif; ?>
                </div>
            <?php else: ?>
                <!-- Suggestions si pas de recherche -->
                <div class="search-suggestions">
                    <h3>Suggestions de recherche :</h3>
                    <div class="suggestion-tags">
                        <a href="recherche.php?q=hygiène" class="suggestion-tag">🧼 Hygiène</a>
                        <a href="recherche.php?q=alimentation" class="suggestion-tag">🍃 Alimentation</a>
                        <a href="recherche.php?q=bio" class="suggestion-tag">🌱 Bio</a>
                        <a href="recherche.php?q=savon" class="suggestion-tag">🧴 Savon</a>
                        <a href="recherche.php?q=local" class="suggestion-tag">📍 Local</a>
                    </div>
                </div>
            <?php endif; ?>

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
