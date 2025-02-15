<?php 
    session_start();
    // List of allowed routes (pages)
    $allowedRoutes = ['home', 'dashboard','employee','schedule','department','position','leave','holiday','fileLeave','attendance'];
    $route = isset($_GET['route']) ? $_GET['route'] : 'home';
    $route = strip_tags($route);
    $route = preg_replace("/[^a-zA-Z0-9_-]/", "", $route);

    // Validate: Ensure the route is valid
    if (!in_array($route, $allowedRoutes)) {
        $route = 'home';
    }
    $page = $route . '.php';
?>
<aside class="h-full border transition-all duration-300 ease-in-out w-[250px] bg-[#141B24] text-white" id="sidebar">
    <header class="flex justify-between items-center pr-4 h-16 pl-4">
        <label class="ps-3 text-[22px] font-rubik path">
            Paymaster
        </label>
        <a class="ps-3 cursor-pointer" id="toggle-btn">
            <i class="fas fa-bars"></i>
        </a>
    </header>
    <ul class="flex flex-col gap-3 pt-3 text-[16px] ">
        <li class="ms-6 h-10 flex items-center">
            <a href="?route=dashboard" class="flex flex-row gap-2 hover:text-blue-500" >
                <i class="fas fa-columns"></i>
                <span class="path">Dashboard</span>
            </a>
        </li>
        <li class="ms-6 h-10 flex items-center">
            <a href="?route=employee" class="flex flex-row gap-2 hover:text-blue-500"> 
                <i class="fas fa-user"></i>
                <span class="path " >Employee</span>
            </a>
        </li>
        <li class="ms-6 h-10 flex items-center">
            <a href="?route=attendance" class="flex flex-row gap-2 hover:text-blue-500">
                <i class="fas fa-clipboard-list"></i>
                <span class="path">Attendance</span>
            </a>
        </li>
        <li class="ms-6 h-10 flex items-center">
            <a href="?route=schedule" class="flex flex-row gap-2 hover:text-blue-500">
                <i class="fas fa-clock"></i>
                <span class="path">Schedule</span>
            </a>
        </li>
        <li class="ms-6 h-10 flex items-center">
            <a href="?route=holiday" class="flex flex-row gap-2 hover:text-blue-500">
                <i class="fas fa-sun"></i>
                <span class="path">holiday</span>
            </a>
        </li>
        <li class="ms-6 h-10 flex items-center">
            <a href="?route=department" class="flex flex-row gap-2 hover:text-blue-500">
                <i class="fas fa-building"></i> 
                <span class="path">Department</span>
            </a>
        </li>
        <li class="ms-6 h-10 flex items-center">
            <a href="?route=position" class="flex flex-row gap-2 hover:text-blue-500">
                <i class="fas fa-briefcase"></i>
                <span class="path">Position</span>
            </a>
        </li>
        <li class="h-10 inline flex-col cursor-pointer">
            <div onClick="LeaveSub();" class="ms-6 flex justify-between items-center pe-5" >
            <a class="flex flex-row gap-2 hover:text-blue-500">
                <i class="fas fa-file"></i>
                <span class="path">Leave</span>
            </a>
            <i  id="arrowIcon" class="fas fa-arrow-right"></i>
            </div>
            <div id="subDiv" class="bg-[#1F2937] flex flex-col gap-2 ps-12 overflow-hidden max-h-0 transition-max-height duration-300 ease-in-out">
                <a href="?route=leave" class="flex flex-row gap-2 hover:text-blue-500">
                    <i class="fas fa-list"></i>
                    <span class="path">Leave List</span>
                </a>
                <a href="?route=fileLeave" class="flex flex-row gap-2 hover:text-blue-500">
                    <i class="fas fa-file"></i>    
                    <span class="path ">File Leave</span>
                </a>
            </div>
        </li>
    </ul>

</aside>
<script>
 function LeaveSub(){
        const subDiv = document.getElementById('subDiv');
        const arrowIcon = document.getElementById('arrowIcon');
        
        // Toggle 'max-h-0' and 'max-h-[500px]' classes for smooth expansion
        subDiv.classList.toggle('max-h-0');
        subDiv.classList.toggle('max-h-[500px]');
        subDiv.classList.toggle('py-4');
       

        // Toggle rotation of the arrow icon (rotate 90 degrees)
        arrowIcon.classList.toggle('rotate-90');
    }

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
        }else{
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
