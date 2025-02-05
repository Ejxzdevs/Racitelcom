<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/global.css">
    <script src="https://unpkg.com/@tailwindcss/browser@4"></script>
    <title>Payroll Management System</title>
</head>
<body class="h-full">
    <div class="flex h-full">
        <nav class="h-full">
            <?php require_once '../components/sidebar.php'; ?>
        </nav>
        <div class="w-full flex flex-col">
            <header class="h-[11%] bg-gray-800 text-white flex items-center justify-center">
                i am header
            </header>
            <main class="border h-[89%]">
                <?php require_once $page; ?>
            </main>
        </div>
    </div>
</body>
</html>
