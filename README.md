# 🌱 EcoShopper - Hackathon IA BSI 2025

Une application web moderne pour analyser l'impact écologique des produits alimentaires en scannant leur code-barres.

## ✨ Fonctionnalités

- 🔍 **Recherche par code-barres** : Saisie manuelle ou scan de codes-barres
- 🌱 **Éco-Score** : Affichage du score environnemental (A à E)
- 🏷️ **Informations complètes** : Marque, catégorie, pays, labels écologiques
- 💾 **Historique** : Sauvegarde des produits consultés en base MySQL
- 📱 **Responsive** : Interface adaptée mobile et desktop
- 🎨 **Design moderne** : Interface intuitive et attractive

## 🚀 Installation

### 1. Fichiers requis
```
📁 EcoShopper/
├── 📄 index.html          # Page principale
├── 📄 script.js           # Logique JavaScript
├── 📄 style.css           # Styles CSS
├── 📄 save_product.php    # Backend PHP pour MySQL
└── 📄 database_setup.sql  # Script de création de base
```

### 2. Configuration de la base de données

#### Pour InfinityFree :
1. Crée une base de données MySQL
2. Exécute le script `database_setup.sql`
3. Modifie les paramètres dans `save_product.php` :
   ```php
   $host = 'sqlXXX.infinityfree.com';
   $dbname = 'if0_XXXXXXX';
   $username = 'if0_XXXXXXX';
   $password = 'ton_mot_de_passe';
   ```

### 3. Déploiement
- Uploade tous les fichiers sur ton hébergeur
- Assure-toi que PHP est activé
- Teste avec le code-barres : `3274080005003`

## 🔧 API Utilisée

**OpenFoodFacts v2** - API gratuite et ouverte
- URL : `https://world.openfoodfacts.net/api/v2/product/`
- Authentification : `Basic off:off` (optionnel)
- Documentation : https://world.openfoodfacts.org/data

## 📊 Structure de la base de données

### Table `produits_consultes`
```sql
- id (INT, AUTO_INCREMENT, PRIMARY KEY)
- code_barres (VARCHAR(20))
- nom (VARCHAR(255))
- marque (VARCHAR(100))
- categorie (VARCHAR(100))
- ecoscore (CHAR(1))
- labels (TEXT)
- date_consultation (TIMESTAMP)
- ip_utilisateur (VARCHAR(45))
```

## 🎯 Utilisation

1. **Ouvre `index.html`** dans ton navigateur
2. **Saisis un code-barres** (ex: 3274080005003)
3. **Clique sur "Analyser"** ou appuie sur Entrée
4. **Consulte les résultats** : éco-score, labels, ingrédients...

## 🔍 Exemples de codes-barres à tester

| Produit | Code-barres | Éco-Score attendu |
|---------|-------------|-------------------|
| Spaghetti Panzani | 3274080005003 | A |
| Nutella | 3017620422003 | C |
| Coca-Cola | 5449000000996 | D |

## 🛠️ Personnalisation

### Modifier l'apparence
Édite `style.css` pour changer :
- Couleurs (variables CSS)
- Polices
- Espacements
- Animations

### Ajouter des fonctionnalités
Dans `script.js` :
- Nouvelles données à afficher
- Calculs personnalisés
- Intégrations API supplémentaires

## 📱 Responsive Design

L'interface s'adapte automatiquement :
- **Desktop** : Layout en grille
- **Tablet** : Layout adaptatif
- **Mobile** : Layout vertical

## 🔒 Sécurité

- ✅ Aucune clé API privée requise
- ✅ Validation des entrées utilisateur
- ✅ Protection contre l'injection SQL (PDO)
- ✅ Gestion des erreurs complète

## 🚀 Améliorations possibles

- 📊 **Dashboard statistiques** : Graphiques des éco-scores
- 🔔 **Notifications** : Alertes produits non écologiques
- 👥 **Partage social** : Partage des résultats
- 📱 **PWA** : Application mobile native
- 🤖 **IA** : Recommandations personnalisées

## 📞 Support

Pour toute question ou problème :
- Vérifie la console du navigateur (F12)
- Teste avec des codes-barres connus
- Vérifie la configuration de la base de données

---

**Développé avec ❤️ pour le Hackathon IA BSI 2025**