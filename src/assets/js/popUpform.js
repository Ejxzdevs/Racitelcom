const openModal = document.getElementById("openModal");
const closeModal = document.getElementById("closeModal");
const modal = document.getElementById("modal");
const popupForm = document.getElementById("popupForm");

openModal.addEventListener("click", function() {
  modal.classList.remove("hidden");
});

closeModal.addEventListener("click", function() {
  modal.classList.add("hidden");
});

// popupForm.addEventListener("submit", function(event) {
//   event.preventDefault(); 
//   alert("Form Submitted!");
//   modal.classList.add("hidden");
// });