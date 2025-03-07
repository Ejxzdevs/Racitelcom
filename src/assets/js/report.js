document.addEventListener('DOMContentLoaded', function() {

    const openModal = document.getElementById("openModal");
    const closeModal = document.getElementById("closeModal");
    const modal = document.getElementById("modal");
    const closeEditModal = document.getElementById("closeEditModal");
  
  openModal.addEventListener("click", function() {
    modal.classList.remove("hidden");
  });
  
  closeModal.addEventListener("click", function() {
    modal.classList.add("hidden");
  });
  
  // HANDLE EDIT MODAL
  
  // EDIT FORM
  const editModal = document.getElementById("editmodal");
      document.querySelectorAll('.edit-link').forEach(link => {
        link.addEventListener('click', function(event) {
            const data = event.currentTarget.getAttribute('data');
            if (data) {
                try {
                    const getData = JSON.parse(data);
                    document.getElementById('id').value = getData.report_id;
                    document.getElementById('edit_report_type').value = getData.report_type;
                    editModal.classList.remove("hidden");
                } catch (e) {
                    console.error('Error parsing JSON:', e);
                }
            } else {
                console.error('No data attribute found');
            }
        });
    });
      
    closeEditModal.addEventListener("click", function() {
        editModal.classList.add("hidden");
    });
  });