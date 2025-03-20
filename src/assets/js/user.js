document.addEventListener('DOMContentLoaded', function() {
    const openModal = document.getElementById("openModal");
    const closeModal = document.getElementById("closeModal");
    const modal = document.getElementById("modal");
    const closeEditModal = document.getElementById("closeEditModal");
  
    // Open the modal
    openModal.addEventListener("click", function() {
      modal.classList.remove("hidden");
    });
  
    // Close the modal
    closeModal.addEventListener("click", function() {
      modal.classList.add("hidden");
    });
  
    // Handle Edit Form Modal
    document.querySelectorAll('.edit-link').forEach(link => {
        link.addEventListener('click', function(event) {
            const data = event.currentTarget.getAttribute('data');
            if (data) {
                try {
                    const getData = JSON.parse(data);
                    document.getElementById('editmodal').classList.remove('hidden');
                    document.getElementById('id').value = getData.id;
                    document.getElementById('edit_user_type').value = getData.user_type;
                } catch (e) {
                    console.error('Error parsing JSON:', e);
                }
            } else {
                console.error('No data attribute found');
            }
        });
    });
  
    // Close Edit Modal
    closeEditModal.addEventListener("click", function() {
        document.getElementById("editmodal").classList.add("hidden");
    });

    // Validation
  document.getElementById("addForm").addEventListener("submit", function (event) {
    var password = document.getElementById("user_password").value;
    var confirmPassword = document.getElementById("confirm_password").value;

    if (password !== confirmPassword) {
      event.preventDefault();
      alert("Passwords do not match!");
    }
  });
  
});
  