document.addEventListener('DOMContentLoaded', function() {
    const openModal = document.getElementById("openModal");
    const closeModal = document.getElementById("closeModal");
    const modal = document.getElementById("modal");
  
    // Open the modal
    openModal.addEventListener("click", function() {
      modal.classList.remove("hidden");
    });
  
    // Close the modal
    closeModal.addEventListener("click", function() {
      modal.classList.add("hidden");
    });
  });
  