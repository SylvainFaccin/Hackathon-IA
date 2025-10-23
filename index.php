<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EcoShop - Consommez mieux, vivez mieux</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
</head>
<body>

    <!-- Header / Navbar -->
    <header class="header">
        <div class="container">
            <div class="navbar">
                <div class="logo">
                    <h1>🌿 EcoShop</h1>
                </div>
                <nav class="nav-menu">
                    <a href="#accueil" class="nav-link active">Accueil</a>
                    <a href="#produits" class="nav-link">Produits</a>
                    <a href="#valeurs" class="nav-link">À propos</a>
                    <a href="#contact" class="nav-link">Contact</a>
                    <a href="#connexion" class="nav-link btn-connexion">Connexion</a>
                </nav>
            </div>
        </div>
    </header>

    <!-- Section Héros -->
    <section id="accueil" class="hero">
        <div class="hero-content">
            <h2 class="hero-title">Consommez mieux, vivez mieux.</h2>
            <p class="hero-subtitle">Des produits éco-responsables pour un avenir durable</p>
            <a href="#produits" class="btn btn-primary">Découvrir nos produits</a>
        </div>
    </section>

    <!-- Section Produits -->
    <section id="produits" class="produits">
        <div class="container">
            <h2 class="section-title">Nos Produits Écologiques</h2>
            <p class="section-subtitle">Une sélection rigoureuse pour respecter la planète</p>

            <div class="produits-grid">
                <!-- Produit 1 -->
                <div class="produit-card">
                    <div class="produit-image">
                        <div class="placeholder-image">🌱</div>
                    </div>
                    <div class="produit-info">
                        <h3 class="produit-titre">Sac en Coton Bio</h3>
                        <p class="produit-description">Sac réutilisable 100% coton biologique, parfait pour vos courses zéro déchet.</p>
                        <div class="produit-footer">
                            <span class="produit-prix">15,90 €</span>
                            <a href="#" class="btn btn-secondary">Voir plus</a>
                        </div>
                    </div>
                </div>

                <!-- Produit 2 -->
                <div class="produit-card">
                    <div class="produit-image">
                        <div class="placeholder-image">♻️</div>
                    </div>
                    <div class="produit-info">
                        <h3 class="produit-titre">Bouteille Isotherme</h3>
                        <p class="produit-description">Gourde en inox recyclé, garde vos boissons chaudes ou froides pendant 24h.</p>
                        <div class="produit-footer">
                            <span class="produit-prix">24,90 €</span>
                            <a href="#" class="btn btn-secondary">Voir plus</a>
                        </div>
                    </div>
                </div>

                <!-- Produit 3 -->
                <div class="produit-card">
                    <div class="produit-image">
                        <div class="placeholder-image">🌍</div>
                    </div>
                    <div class="produit-info">
                        <h3 class="produit-titre">Kit Hygiène Zéro Déchet</h3>
                        <p class="produit-description">Ensemble complet : brosse à dents bambou, savon naturel et cotons réutilisables.</p>
                        <div class="produit-footer">
                            <span class="produit-prix">32,50 €</span>
                            <a href="#" class="btn btn-secondary">Voir plus</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Section Valeurs -->
    <section id="valeurs" class="valeurs">
        <div class="container">
            <h2 class="section-title">Nos Valeurs</h2>
            <p class="section-subtitle">Ce qui nous guide au quotidien</p>

            <div class="valeurs-grid">
                <!-- Valeur 1 -->
                <div class="valeur-card">
                    <div class="valeur-icon">🌿</div>
                    <h3 class="valeur-titre">Écologique</h3>
                    <p class="valeur-description">Tous nos produits sont sélectionnés pour leur faible impact environnemental et leur durabilité.</p>
                </div>

                <!-- Valeur 2 -->
                <div class="valeur-card">
                    <div class="valeur-icon">📍</div>
                    <h3 class="valeur-titre">Local</h3>
                    <p class="valeur-description">Nous privilégions les producteurs locaux et les circuits courts pour réduire notre empreinte carbone.</p>
                </div>

                <!-- Valeur 3 -->
                <div class="valeur-card">
                    <div class="valeur-icon">♻️</div>
                    <h3 class="valeur-titre">Durable</h3>
                    <p class="valeur-description">Des produits conçus pour durer, réparables et recyclables en fin de vie.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Section Contact -->
    <section id="contact" class="contact">
        <div class="container">
            <h2 class="section-title">Contactez-nous</h2>
            <p class="section-subtitle">Une question ? Une suggestion ? Nous sommes à votre écoute</p>

            <div class="contact-wrapper">
                <form class="contact-form">
                    <div class="form-group">
                        <label for="nom">Nom complet</label>
                        <input type="text" id="nom" name="nom" placeholder="Votre nom" required>
                    </div>

                    <div class="form-group">
                        <label for="email">Adresse e-mail</label>
                        <input type="email" id="email" name="email" placeholder="votre@email.com" required>
                    </div>

                    <div class="form-group">
                        <label for="message">Message</label>
                        <textarea id="message" name="message" rows="6" placeholder="Votre message..." required></textarea>
                    </div>

                    <button type="submit" class="btn btn-primary btn-full">Envoyer</button>
                </form>
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
