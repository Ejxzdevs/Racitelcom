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
                    console.log(getData)
                    document.getElementById('editmodal').classList.remove('hidden');
                    document.getElementById('id').value = getData.file_leave_id;
                    document.getElementById('edit_employee_id').value = getData.employee_id;
                    document.getElementById('edit_leave_id').value = getData.leave_id;
                    document.getElementById('edit_start_date').value = getData.start_date;
                    document.getElementById('edit_end_date').value = getData.end_date;
                    document.getElementById('edit_reason').value = getData.reason;
                    document.getElementById('edit_leave_status').value = getData.file_status;
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
  