-- Script SQL pour créer la table des produits consultés
-- À exécuter dans ton panneau de contrôle InfinityFree

CREATE TABLE IF NOT EXISTS produits_consultes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    code_barres VARCHAR(20) NOT NULL,
    nom VARCHAR(255) NOT NULL,
    marque VARCHAR(100),
    categorie VARCHAR(100),
    ecoscore CHAR(1),
    labels TEXT,
    date_consultation TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    ip_utilisateur VARCHAR(45),
    INDEX idx_code_barres (code_barres),
    INDEX idx_date_consultation (date_consultation),
    INDEX idx_ecoscore (ecoscore)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Table optionnelle pour les statistiques
CREATE TABLE IF NOT EXISTS statistiques_ecoscore (
    id INT AUTO_INCREMENT PRIMARY KEY,
    ecoscore CHAR(1) NOT NULL,
    nombre_consultations INT DEFAULT 1,
    date_mise_a_jour TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    UNIQUE KEY unique_ecoscore (ecoscore)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Insertion des éco-scores de base
INSERT IGNORE INTO statistiques_ecoscore (ecoscore, nombre_consultations) VALUES
('A', 0),
('B', 0),
('C', 0),
('D', 0),
('E', 0);

-- Vue pour les statistiques globales
CREATE OR REPLACE VIEW vue_statistiques AS
SELECT 
    COUNT(*) as total_consultations,
    COUNT(DISTINCT code_barres) as produits_uniques,
    AVG(CASE 
        WHEN ecoscore = 'A' THEN 1
        WHEN ecoscore = 'B' THEN 2
        WHEN ecoscore = 'C' THEN 3
        WHEN ecoscore = 'D' THEN 4
        WHEN ecoscore = 'E' THEN 5
        ELSE NULL
    END) as score_moyen,
    DATE(date_consultation) as date_consultation
FROM produits_consultes
GROUP BY DATE(date_consultation)
ORDER BY date_consultation DESC;
