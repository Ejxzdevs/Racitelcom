<?php 
    session_start();
    // List of allowed routes (pages)
    $allowedRoutes = ['home', 'dashboard','employee','schedule','department','position'];
    $route = isset($_GET['route']) ? $_GET['route'] : 'home';
    $route = strip_tags($route);
    $route = preg_replace("/[^a-zA-Z0-9_-]/", "", $route);

    // Validate: Ensure the route is valid
    if (!in_array($route, $allowedRoutes)) {
        $route = 'home';
    }
    $page = $route . '.php';
?>
<aside class="h-full border transition-all duration-300 ease-in-out w-[250px] bg-[#1F2937] text-white" id="sidebar">
    <header class="flex justify-between items-center pr-4 h-16 pl-4">
        <label class="ps-3 text-[22px] font-rubik path">
            Paymaster
        </label>
        <a class="ps-3 cursor-pointer" id="toggle-btn">
            <i class="fas fa-bars"></i>
        </a>
    </header>
    <ul class="flex flex-col gap-2 pt-3 ">
        <li class="ps-6 h-10 flex items-center">
            <a href="?route=dashboard" class="flex flex-row gap-3 hover:text-blue-500" >
                <i class="fas fa-tachometer-alt"></i> 
                <span class="path " >Dashboard</span>
            </a>
        </li>
        <li class="ps-6 h-10 flex items-center">
            <a href="?route=employee" class="flex flex-row gap-3 hover:text-blue-500"> 
                <i class="fas fa-user"></i>
                <span class="path " >Employee</span>
            </a>
        </li>
        <li class="ps-6 h-10 flex items-center">
            <a href="?route=department" class="flex flex-row gap-3 hover:text-blue-500">
                <i class="fas fa-building"></i> 
                <span class="path " >Department</span>
            </a>
        </li>
        <li class="ps-6 h-10 flex items-center">
            <a href="?route=position" class="flex flex-row gap-3 hover:text-blue-500">
                <i class="fas fa-user-tie"></i>
                <span class="path " >Position</span>
            </a>
        </li>
        <li class="ps-6 h-10 flex items-center">
            <a href="?route=schedule" class="flex flex-row gap-3 hover:text-blue-500">
                <i class="fas fa-calendar-alt"></i>
                <span class="path ">Schedule</span>
            </a>
        </li>
    </ul>

</aside>
<script>
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
