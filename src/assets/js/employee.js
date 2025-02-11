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
              console.log(data)
              if (data) {
                  try {
                  const getData = JSON.parse(data);
                  document.getElementById('id').value = getData.employee_id;
                  document.getElementById('edit_employee_name').value = getData.fullname;
                  document.getElementById('edit_email').value = getData.email;
                  document.getElementById('edit_number').value = getData.contact_number;
                  document.getElementById('edit_address').value = getData.address;
                  document.getElementById('edit_gender').value = getData.gender;
                  document.getElementById('edit_department_id').value = getData.department_id;
                  document.getElementById('edit_position_id').value = getData.position_id;
                  document.getElementById('edit_salary').value = getData.hourly_rate;
                  document.getElementById('edit_schedule_id').value = getData.schedule_id;
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