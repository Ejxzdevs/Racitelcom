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
                    document.getElementById('id').value = getData.deduction_id;
                    document.getElementById('edit_deduction_name').value = getData.deduction_name;
                    document.getElementById('edit_deduction_rate').value = getData.deduction_rate;
                    document.getElementById('edit_deduction_status').value = getData.deduction_status;
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
  });
  