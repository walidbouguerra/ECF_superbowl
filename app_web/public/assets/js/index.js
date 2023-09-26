// Confirmation des paris pour la sélection
betsForm = document.getElementById("betsForm");
if (betsForm) {
  betsForm.addEventListener("submit", (e)=>{
      if (window.confirm("Confirmez-vous les mises ?")) {
        } else {
          e.preventDefault();
        }
  });
}

// Confirmation de la suppression de pari
const deleteBetBtn = document.getElementById("deleteBetBtn");
if (deleteBetBtn) {
  deleteBetBtn.addEventListener("click", (e)=>{
    if (window.confirm("Voulez-vous vraiment supprimer la mise ?")) {
      } else {
        e.preventDefault();
      }
});
}
