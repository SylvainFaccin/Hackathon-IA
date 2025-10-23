-- =============================================
-- Base de données EcoShop
-- =============================================
-- Ce fichier SQL crée la base de données,
-- la table produits et insère les données de démonstration
-- =============================================

-- Créer la base de données
CREATE DATABASE IF NOT EXISTS ecoshop_db
CHARACTER SET utf8mb4
COLLATE utf8mb4_unicode_ci;

-- Utiliser la base de données
USE ecoshop_db;

-- Créer la table produits
CREATE TABLE IF NOT EXISTS produits (
  id_produit INT AUTO_INCREMENT PRIMARY KEY,
  nom VARCHAR(100) NOT NULL,
  description TEXT,
  categorie VARCHAR(50),
  prix DECIMAL(6,2) NOT NULL DEFAULT 0.00,
  empreinte_carbone DECIMAL(5,2) DEFAULT 0.00,
  score_ecologique TINYINT CHECK (score_ecologique BETWEEN 1 AND 10),
  image VARCHAR(255),
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Insérer les produits de démonstration
INSERT INTO produits (nom, description, categorie, prix, empreinte_carbone, score_ecologique, image)
VALUES
  (
    'Shampoing Bio',
    'Shampoing naturel aux huiles essentielles, sans sulfates ni parabènes. Idéal pour tous types de cheveux. Formule douce et respectueuse du cuir chevelu.',
    'Hygiène',
    12.90,
    0.85,
    9,
    'shampoing-bio.jpg'
  ),
  (
    'Savon Naturel',
    'Savon artisanal à l\'huile d\'olive et au karité. Fabriqué à la main en France. Sans additifs chimiques, parfait pour toute la famille.',
    'Hygiène',
    6.50,
    0.70,
    8,
    'savon-naturel.jpg'
  ),
  (
    'Thé Vert Bio',
    'Thé vert biologique cultivé en agriculture raisonnée. Récolte manuelle et séchage traditionnel. Riche en antioxydants.',
    'Alimentation',
    9.80,
    1.10,
    9,
    'the-vert-bio.jpg'
  ),
  (
    'Dentifrice Solide',
    'Dentifrice solide zéro déchet au fluor naturel. Durée de vie équivalente à 2 tubes classiques. Sans plastique, 100% compostable.',
    'Hygiène',
    8.90,
    0.65,
    10,
    'dentifrice-solide.jpg'
  ),
  (
    'Riz Local',
    'Riz complet cultivé localement en Camargue. Agriculture biologique certifiée. Soutient les producteurs français.',
    'Alimentation',
    5.40,
    2.30,
    6,
    'riz-local.jpg'
  );

-- Afficher les produits insérés
SELECT * FROM produits;
