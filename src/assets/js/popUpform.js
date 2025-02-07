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

// EDIT FORM
const editModal = document.getElementById("editmodal");
    document.querySelectorAll('.edit-link').forEach(link => {
        link.addEventListener('click', function(event) {
            const getData = JSON.parse(event.target.getAttribute('data-schedule'));
            const data = getData[0];

            document.getElementById('edit_schedule_name').value = data.schedule_id;
            document.getElementById('edit_time_start').value = data.time_start;
            document.getElementById('edit_time_end').value = data.time_end;
    
            editModal.classList.remove("hidden");
            
            console.log(data);
        });
    });

    const closeEditModal = document.getElementById("closeEditModal");
    
    closeEditModal.addEventListener("click", function() {
        editModal.classList.add("hidden");
    });