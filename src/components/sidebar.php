<?php 
    // List of allowed routes (pages)
    $allowedRoutes = ['home', 'dashboard','employee','schedule'];
    $route = isset($_GET['route']) ? $_GET['route'] : 'home';
    $route = strip_tags($route);
    $route = preg_replace("/[^a-zA-Z0-9_-]/", "", $route);
    // Validate: Ensure the route is valid
    if (!in_array($route, $allowedRoutes)) {
        $route = 'home';
    }
    $page = $route . '.php';
?>
<aside class="h-full border transition-all duration-300 ease-in-out w-[250px] bg-[#282A36]" id="sidebar">
    <header class="flex justify-between items-center pr-4 h-16 pl-4">
        <label class="text-xl font-[Rubik Vinyl]">
            TaskUs
        </label>
        <a class="cursor-pointer" id="toggle-btn">
            x
        </a>
    </header>
    <ul class="flex flex-col gap-2 pt-3">
        <li class="ps-4 h-10 flex items-center">
            <a href="?route=dashboard">dashboard</a>
        </li>
        <li class="ps-4 h-10 flex items-center">
            <a href="?route=home">home</a>
        </li>
        <li class="ps-4 h-10 flex items-center">
            <a href="?route=employee">Employees</a>
        </li>
        <li class="ps-4 h-10 flex items-center">
            <a href="?route=schedule">Schedule</a>
        </li>
    </ul>
</aside>
<script>
    const sidebar = document.getElementById('sidebar');
    const toggleBtn = document.getElementById('toggle-btn');
    const pathElements = document.querySelectorAll('.path');
    let isMinimized = false;

    function toggleSidebar() {
        isMinimized = !isMinimized;
        sidebar.style.width = isMinimized ? '80px' : '250px';
        pathElements.forEach(path => {
            path.style.display = isMinimized ? 'none' : 'inline';
        });
    }
    toggleBtn.addEventListener('click', toggleSidebar);
</script>