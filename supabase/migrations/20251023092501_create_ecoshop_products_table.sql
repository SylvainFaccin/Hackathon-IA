/*
  # Create EcoShop Products Table

  1. New Tables
    - `produits`
      - `id_produit` (bigint, primary key, auto-increment)
      - `nom` (varchar, product name)
      - `description` (text, product description)
      - `categorie` (varchar, product category)
      - `prix` (decimal, price)
      - `empreinte_carbone` (decimal, carbon footprint in kg CO₂)
      - `score_ecologique` (smallint, ecological score 1-10)
      - `image` (varchar, image filename)
      - `created_at` (timestamptz, creation date)

  2. Sample Data
    - Inserts 5 eco-friendly products with their ecological metrics

  3. Security
    - Enable RLS on `produits` table
    - Add policy for public read access (product catalog is public)
*/

-- Create products table
CREATE TABLE IF NOT EXISTS produits (
  id_produit BIGSERIAL PRIMARY KEY,
  nom VARCHAR(100) NOT NULL,
  description TEXT,
  categorie VARCHAR(50),
  prix DECIMAL(6,2) NOT NULL DEFAULT 0.00,
  empreinte_carbone DECIMAL(5,2) DEFAULT 0.00,
  score_ecologique SMALLINT CHECK (score_ecologique BETWEEN 1 AND 10),
  image VARCHAR(255),
  created_at TIMESTAMPTZ DEFAULT now()
);

-- Insert sample products
INSERT INTO produits (nom, description, categorie, prix, empreinte_carbone, score_ecologique, image)
VALUES 
  ('Shampoing Bio', 'Shampoing naturel aux huiles essentielles, sans sulfates ni parabènes. Idéal pour tous types de cheveux.', 'Hygiène', 12.90, 0.85, 9, 'shampoing-bio.jpg'),
  ('Savon Naturel', 'Savon artisanal à l''huile d''olive et au karité. Fabriqué à la main en France.', 'Hygiène', 6.50, 0.70, 8, 'savon-naturel.jpg'),
  ('Thé Vert Bio', 'Thé vert biologique cultivé en agriculture raisonnée. Récolte manuelle et séchage traditionnel.', 'Alimentation', 9.80, 1.10, 9, 'the-vert-bio.jpg'),
  ('Dentifrice Solide', 'Dentifrice solide zéro déchet au fluor naturel. Durée de vie équivalente à 2 tubes classiques.', 'Hygiène', 8.90, 0.65, 10, 'dentifrice-solide.jpg'),
  ('Riz Local', 'Riz complet cultivé localement en Camargue. Agriculture biologique certifiée.', 'Alimentation', 5.40, 2.30, 6, 'riz-local.jpg')
ON CONFLICT DO NOTHING;

-- Enable Row Level Security
ALTER TABLE produits ENABLE ROW LEVEL SECURITY;

-- Create policy for public read access (product catalog is public)
CREATE POLICY "Anyone can view products"
  ON produits FOR SELECT
  TO anon, authenticated
  USING (true);
