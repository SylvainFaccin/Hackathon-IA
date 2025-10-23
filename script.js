document.getElementById("submitBtn").addEventListener("click", () => {
  let totalScore = 0;
  let totalQuestions = 5;

  for (let i = 1; i <= totalQuestions; i++) {
    let answer = document.querySelector(`input[name="q${i}"]:checked`);
    if (answer) totalScore += parseInt(answer.value);
  }

  // Vérifier si toutes les questions ont été répondues
  if (document.querySelectorAll("input:checked").length < totalQuestions) {
    alert("Merci de répondre à toutes les questions !");
    return;
  }

  // Afficher le résultat
  document.getElementById("score").textContent = totalScore;
  document.getElementById("result").classList.remove("hidden");

  // Donner un conseil selon le score
  let advice = "";
  if (totalScore >= 40) {
    advice = "🌟 Excellent ! Ta maison est exemplaire. Continue ainsi !";
  } else if (totalScore >= 25) {
    advice = "👍 Bon début ! Tu peux encore progresser sur quelques points.";
  } else {
    advice = "💧 Attention ! Il y a de la marge pour adopter des gestes plus durables.";
  }

  document.getElementById("advice").textContent = advice;
});
