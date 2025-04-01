<?php 
    // List of allowed routes (pages)
    $allowedRoutes = ['home', 'dashboard','employee','schedule','department','position','leave','holiday','fileLeave','attendance','payroll','allowance','deduction','emp_allowance','emp_deduction','report','createUser'];
    $route = isset($_GET['route']) ? $_GET['route'] : 'home';
    $route = strip_tags($route);
    $route = preg_replace("/[^a-zA-Z0-9_-]/", "", $route);

    // Validate: Ensure the route is valid
    if (!in_array($route, $allowedRoutes)) {
        $route = 'home';
    }
    $page = $route . '.php';
?>
<aside class="h-full border transition-all duration-300 ease-in-out w-[250px] bg-[#141B24] text-white text-[14px]" id="sidebar">
    <header class="flex justify-between items-center pr-4 h-16 pl-4 bg-yellow-500 ">
        <div class="p1-3 path ">
            <div class="!flex !flex-row !items-center gap-1">
                <img class="h-[25px] w-[30px]" src="../../src/assets/images/logo/racitel.png" alt="" srcset="">
                <label class="font-rubik text-[22px] text-[#141B24]">Racitelcom</label>
            </div>
        </div>
        <a class="ps-3 cursor-pointer" id="toggle-btn">
            <i class="fas fa-bars text-[#141B24]"></i>
        </a>
    </header>
  <ul class="space-y-4 pt-5 flex flex-col gap-3">

    <li class="ps-6">
        <a href="?route=dashboard" class="flex flex-row items-center items-center gap-3 hover:text-blue-500" >
            <i class="fas fa-columns text-[14px]"></i>
            <span class="path">Dashboard</span>
        </a>
    </li>

    <li class="ps-6">
        <a href="?route=employee" class="flex flex-row items-center gap-3 hover:text-blue-500"> 
            <i class="fas fa-user text-[14px]"></i>
            <span class="path " >Employee</span>
        </a>
    </li>

    <li class="ps-6">
        <a href="?route=attendance" class="flex flex-row items-center gap-3 hover:text-blue-500">
            <i class="fas fa-clipboard-list text-[14px]"></i>
            <span class="path">Attendance</span>
        </a>
    </li>
    
    <!-- Management Menu -->
    <li class="menu-item">
        <a href="#" class="ms-6 toggle-menu flex flex-row items-center justify-between gap-3 hover:text-blue-500">
            <div>
                <i class="fas fa-cogs text-[14px]"></i>
                <span class="path ms-1">Management</span>
            </div> 
            <i class="arrowIcon fas fa-arrow-right transition-transform me-4"></i>
        </a>
        <ul class="bg-gray-600 sub-menu max-h-0 overflow-hidden transition-all duration-300 ease-out flex flex-col gap-1 ps-4">
            <li class="ps-6 pt-1">
                <a href="?route=emp_allowance" class="text-white block p-2 rounded">
                    <i class="fas fa-gift"></i>
                    <span class="path ms-2">Emp Allowance</span>
                </a>
            </li>
            <li class="ps-6">
                <a href="?route=emp_deduction" class="text-white block p-2 rounded">
                    <i class="fas fa-minus-circle"></i>  
                    <span class="path ms-2">Emp Deduction</span>
                </a>
            </li>
        </ul>
    </li>

    <!-- Maintenance Menu -->
    <?php if($token_decoded->user_type === 'admin'):?>
    <li class="menu-item">
        <a href="#" class="ms-6 toggle-menu flex flex-row items-center justify-between gap-3 hover:text-blue-500">
            <div>
                <i class="fas fa-cogs text-[14px]"></i>
                <span class="path ms-1">Maintenance</span>
            </div> 
            <i class="arrowIcon fas fa-arrow-right transition-transform me-4"></i>
        </a>
        <ul class="bg-gray-600 sub-menu max-h-0 overflow-hidden transition-all duration-300 ease-out flex flex-col gap-1 ps-4">
            <li class="ps-5 pt-1">
                <a href="?route=department" class="text-white block p-2 rounded">
                    <i class="fas fa-building text-[14px] ms-1"></i>
                    <span class="path ms-3">Department</span>
                </a>
            </li>
            <li class="ps-6">
                <a href="?route=position" class="text-white block p-2 rounded">
                    <i class="fas fa-user-tie"></i>  
                    <span class="path ms-2">Position</span>
                </a>
            </li>
            <li class="ps-6">
                <a href="?route=schedule" class="text-white block p-2 rounded">
                    <i class="fas fa-clock text-[14px]"></i>
                    <span class="path ms-2">Schedule</span>
                </a>
            </li>
            <li class="ps-6">
                <a href="?route=holiday" class="text-white block p-2 rounded">
                    <i class="fas fa-calendar-day"></i>
                    <span class="path ms-2">Holiday</span>
                </a>
            </li>
            <li class="ps-6">
                <a href="?route=allowance" class="text-white block p-2 rounded">
                    <i class="fas fa-gift"></i>
                    <span class="path ms-2">Allowance</span>
                </a>
            </li>
            <li class="ps-6">
                <a href="?route=deduction" class="text-white block p-2 rounded">
                    <i class="fas fa-minus-circle"></i>
                    <span class="path ms-2">Deduction</span>
                </a>
            </li>

            <li class="ps-6">
                <a href="?route=leave" class="text-white block p-2 rounded">
                    <i class="fas fa-calendar-check"></i>
                    <span class="path ms-2">Leave</span>
                </a>
            </li>

        </ul>
    </li>
    <?php endif; ?>

    <li class="ps-6">
        <a href="?route=fileLeave" class="flex flex-row items-center gap-3 hover:text-blue-500">
            <i class="fa fa-file-alt"></i>
            <span class="path">Leave</span>
        </a>
    </li>

    <li class="ps-6">
        <a href="?route=report" class="flex flex-row items-center gap-3 hover:text-blue-500">
            <i class="fa fa-file-alt"></i>
            <span class="path">Report</span>
        </a>
    </li>

    <li class="ps-6">
        <a href="?route=payroll" class="flex flex-row items-center gap-3 hover:text-blue-500">
            <i class="fa fa-credit-card"></i>
            <span class="path">Payroll</span>
        </a>
    </li>
    
    <?php if($token_decoded->user_type === 'admin'):?>
    <li class="ps-6">
        <a href="?route=createUser" class="flex flex-row items-center gap-3 hover:text-blue-500">
            <i class="fas fa-user"></i>
            <span class="path">User</span>
        </a>
    </li>
    <?php endif; ?>
  </ul>
</aside>

<script>
  const menuItems = document.querySelectorAll('.toggle-menu');

  menuItems.forEach(item => {
    item.addEventListener('click', function(e) {
      e.preventDefault();

      const subMenu = this.nextElementSibling;
      const arrowIcon = this.querySelector('.arrowIcon');

      // Toggle the rotation of the arrow icon
      arrowIcon.classList.toggle('rotate-90');

      // Toggle the max-height to animate the expansion/collapse
      if (subMenu.classList.contains('max-h-0')) {
        subMenu.classList.remove('max-h-0');
        subMenu.classList.add('max-h-96'); 
      } else {
        subMenu.classList.remove('max-h-96');
        subMenu.classList.add('max-h-0');
      }
    });
  });

  const sidebar = document.getElementById('sidebar');
  const toggleBtn = document.getElementById('toggle-btn');
  const pathElements = document.querySelectorAll('.path');
  let isMinimized = document.cookie.replace(/(?:(?:^|.*;\s*)toggle\s*=\s*([^;]*).*$)|^.*$/, "$1") === 'false';

  function toggleSidebar() {
    if(isMinimized === false){
        isMinimized = true;
        sidebar.style.width = '80px';
        pathElements.forEach(path => {
            path.style.display ='none';
        });
        document.cookie = "toggle=false; path=/";
    } else {
        isMinimized = false;
        sidebar.style.width = '250px';
        pathElements.forEach(path => {
            path.style.display ='inline';
        });
        document.cookie = "toggle=true; path=/";
    }
  }

  if (isMinimized) {
    sidebar.style.width = '80px';
    pathElements.forEach(path => {
        path.style.display ='none';
    });
  } else {
    sidebar.style.width = '250px';
    pathElements.forEach(path => {
        path.style.display ='inline';
    });
  }

  toggleBtn.addEventListener('click', toggleSidebar);
</script>
