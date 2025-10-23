// Configuration de l'API OpenFoodFacts v2
const API_BASE_URL = "https://world.openfoodfacts.net/api/v2/product/";
const API_AUTH = "Basic " + btoa("off:off");

// Éléments DOM
const barcodeInput = document.getElementById("barcode");
const searchBtn = document.getElementById("searchBtn");
const resultatDiv = document.getElementById("resultat");
const errorDiv = document.getElementById("error");

// Fonction principale pour récupérer les informations du produit
async function fetchProduit() {
    const code = barcodeInput.value.trim();
    
    // Validation de l'entrée
    if (!code) {
        showError("⚠️ Veuillez entrer un code-barres.");
        return;
    }

    // Validation du format du code-barres (8-20 chiffres)
    if (!/^\d{8,20}$/.test(code)) {
        showError("⚠️ Le code-barres doit contenir entre 8 et 20 chiffres.");
        return;
    }

    // Interface utilisateur pendant la recherche
    setLoadingState(true);
    hideError();
    hideResult();

    try {
        console.log(`🔍 Recherche du produit avec le code: ${code}`);
        
        const response = await fetch(`${API_BASE_URL}${code}.json`, {
            method: "GET",
            headers: { 
                "Authorization": API_AUTH,
                "Accept": "application/json"
            }
        });

        console.log(`📡 Réponse reçue: ${response.status} ${response.statusText}`);

        if (!response.ok) {
            throw new Error(`Erreur HTTP: ${response.status}`);
        }

        const data = await response.json();
        console.log("📦 Données reçues:", data);

        // Vérification de la réponse
        if (data.status === 0 || !data.product) {
            showError("❌ Produit non trouvé dans la base de données OpenFoodFacts.");
            return;
        }

        // Debug : afficher les données reçues
        console.log("🔍 Données produit reçues:", data.product);
        console.log("🌱 Éco-score brut:", data.product.ecoscore_grade);
        console.log("🌱 Type de l'éco-score:", typeof data.product.ecoscore_grade);
        
        // Affichage des résultats
        displayProductInfo(data.product, code);
        
        // Sauvegarde optionnelle (si backend disponible)
        await saveProductToHistory(data.product, code);

    } catch (error) {
        console.error("🚨 Erreur lors de la récupération:", error);
        showError(`🚨 Erreur de connexion: ${error.message}`);
    } finally {
        setLoadingState(false);
    }
}

// Fonction pour afficher les informations du produit
function displayProductInfo(product, code) {
    const ecoscoreGrade = product.ecoscore_grade;
    const hasEcoscore = ecoscoreGrade && ecoscoreGrade !== "Non disponible";
    const ecoscoreColor = hasEcoscore ? getEcoscoreColor(ecoscoreGrade) : 'ecoscore-unknown';
    const ecoscoreDisplay = hasEcoscore ? ecoscoreGrade.toUpperCase() : "Non disponible";
    const ecoscoreDescription = hasEcoscore ? getEcoscoreDescription(ecoscoreGrade) : "Score non disponible";
    
    const labels = product.labels_tags ? 
        product.labels_tags.map(label => label.replace('en:', '')).join(", ") : 
        "Aucun label écologique";

    const resultHTML = `
        <div class="product-card">
            <div class="product-header">
                <h2>${product.product_name || "Nom non disponible"}</h2>
                <div class="product-code">Code: ${code}</div>
            </div>
            
            <div class="product-content">
                <div class="product-image">
                    <img src="${product.image_front_small_url || 'https://via.placeholder.com/200x200?text=Image+non+disponible'}" 
                         alt="Image du produit" 
                         onerror="this.src='https://via.placeholder.com/200x200?text=Image+non+disponible'">
                </div>
                
                <div class="product-info">
                    <div class="info-row">
                        <span class="label">🏷️ Marque:</span>
                        <span class="value">${product.brands || "Non spécifiée"}</span>
                    </div>
                    
                    <div class="info-row">
                        <span class="label">📂 Catégorie:</span>
                        <span class="value">${product.categories || "Non spécifiée"}</span>
                    </div>
                    
                    <div class="info-row">
                        <span class="label">🌍 Pays:</span>
                        <span class="value">${product.countries || "Non spécifié"}</span>
                    </div>
                    
                    <div class="ecoscore-section">
                        <div class="ecoscore-badge ${ecoscoreColor}">
                            <span class="ecoscore-label">🌱 Éco-Score</span>
                            <span class="ecoscore-grade">${ecoscoreDisplay}</span>
                        </div>
                        <div class="ecoscore-description">
                            ${ecoscoreDescription}
                        </div>
                    </div>
                    
                    <div class="labels-section">
                        <h4>🏅 Labels écologiques:</h4>
                        <div class="labels-list">${labels}</div>
                    </div>
                    
                    ${product.ingredients_text ? `
                    <div class="ingredients-section">
                        <h4>🥘 Ingrédients:</h4>
                        <p class="ingredients-text">${product.ingredients_text.substring(0, 200)}${product.ingredients_text.length > 200 ? '...' : ''}</p>
                    </div>
                    ` : ''}
                </div>
            </div>
        </div>
    `;

    resultatDiv.innerHTML = resultHTML;
    resultatDiv.style.display = "block";
}

// Fonction pour obtenir la couleur de l'éco-score
function getEcoscoreColor(grade) {
    // Normaliser le grade (enlever espaces, convertir en majuscule)
    const normalizedGrade = String(grade).trim().toUpperCase();
    
    const colors = {
        'A': 'ecoscore-a',
        'B': 'ecoscore-b', 
        'C': 'ecoscore-c',
        'D': 'ecoscore-d',
        'E': 'ecoscore-e'
    };
    
    return colors[normalizedGrade] || 'ecoscore-unknown';
}

// Fonction pour obtenir la description de l'éco-score
function getEcoscoreDescription(grade) {
    // Normaliser le grade (enlever espaces, convertir en majuscule)
    const normalizedGrade = String(grade).trim().toUpperCase();
    
    const descriptions = {
        'A': 'Excellent impact environnemental 🌟',
        'B': 'Bon impact environnemental ✅',
        'C': 'Impact environnemental moyen ⚠️',
        'D': 'Impact environnemental élevé ❌',
        'E': 'Impact environnemental très élevé 🚫'
    };
    
    return descriptions[normalizedGrade] || 'Score non disponible';
}

// Fonction pour sauvegarder le produit dans l'historique
async function saveProductToHistory(product, code) {
    try {
        const response = await fetch("save_product.php", {
            method: "POST",
            headers: { "Content-Type": "application/json" },
            body: JSON.stringify({
                code_barres: code,
                nom: product.product_name || "Nom inconnu",
                marque: product.brands || "Marque inconnue",
                categorie: product.categories || "Catégorie inconnue",
                ecoscore: product.ecoscore_grade || "Non disponible",
                labels: product.labels_tags ? product.labels_tags.join(", ") : "Aucun"
            })
        });
        
        const result = await response.json();
        
        if (result.success) {
            console.log("💾 Produit sauvegardé avec succès:", result.message);
        } else {
            console.log("⚠️ Erreur de sauvegarde:", result.message);
        }
    } catch (error) {
        console.log("⚠️ Sauvegarde non disponible:", error.message);
    }
}

// Fonctions utilitaires pour l'interface
function setLoadingState(loading) {
    const btnText = searchBtn.querySelector('.btn-text');
    const btnLoading = searchBtn.querySelector('.btn-loading');
    
    if (loading) {
        btnText.style.display = 'none';
        btnLoading.style.display = 'inline';
        searchBtn.disabled = true;
    } else {
        btnText.style.display = 'inline';
        btnLoading.style.display = 'none';
        searchBtn.disabled = false;
    }
}

function showError(message) {
    errorDiv.innerHTML = `<div class="error-message">${message}</div>`;
    errorDiv.style.display = "block";
    hideResult();
}

function hideError() {
    errorDiv.style.display = "none";
}

function hideResult() {
    resultatDiv.style.display = "none";
}

// Gestion des événements
document.addEventListener('DOMContentLoaded', function() {
    // Recherche avec la touche Entrée
    barcodeInput.addEventListener('keypress', function(e) {
        if (e.key === 'Enter') {
            fetchProduit();
        }
    });

    // Nettoyage automatique de l'input
    barcodeInput.addEventListener('input', function(e) {
        // Garde seulement les chiffres
        e.target.value = e.target.value.replace(/\D/g, '');
    });

    // Focus automatique sur l'input
    barcodeInput.focus();
});

// Gestion des erreurs globales
window.addEventListener('error', function(e) {
    console.error("Erreur JavaScript:", e.error);
    showError("Une erreur inattendue s'est produite. Veuillez réessayer.");
});
