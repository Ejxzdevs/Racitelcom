<?php
session_start();
require_once '../helper/check_token.php' 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/global.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <script src="https://unpkg.com/@tailwindcss/browser@4"></script>
    <title>Payroll Management System</title>
</head>
<body class="h-full">
    <div class="flex h-full">
        <nav class="h-full">
            <?php require_once '../components/sidebar.php'; ?>
        </nav>
        <div class="w-full flex flex-col bg-[#F1F2F4]">
            <header class="h-[10%] p-[5px] ">
                <?php require_once '../components/header.php' ?>
            </header>
            <main class="h-[90%]">
                <?php require_once $page; ?>
            </main>
        </div>
    </div>
</body>
</html>
