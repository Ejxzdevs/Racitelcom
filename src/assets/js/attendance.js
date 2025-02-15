// MODAL

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
                    document.getElementById('edit_schedule_id').value = getData.schedule_id;
                    document.getElementById('edit_schedule_name').value = getData.schedule_name;
                    document.getElementById('edit_time_start').value = getData.time_start;
                    document.getElementById('edit_time_end').value = getData.time_end;
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
  
  // for import excel file
  function updateFileName() {
    var fileInput = document.getElementById('file');
    var fileName = fileInput.files[0] ? fileInput.files[0].name : "Choose File";
    var fileLabel = document.getElementById('file_choose');
    fileLabel.textContent = fileName;
  }
  
  