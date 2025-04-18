<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $siteName = trim($_POST['site_name']);

    if (!$siteName) {
        die("Site name required");
    }

    // Generate new site filename (e.g., site6.php)
    $siteFolder = __DIR__ . '/sites/';
    $existing = glob($siteFolder . 'site*.php');
    $nextNumber = count($existing) + 1;
    $newFile = $siteFolder . "site$nextNumber.php";
    $newFileName = "site$nextNumber.php";

    // HTML content for new site page
    $template = <<<HTML
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Site $nextNumber Progress - BuildTrack</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: url('bg.jpg') no-repeat center center fixed;
            background-size: cover;
        }
    </style>
    <script>
        function toggleUpdates() {
            document.getElementById("updatesSection").classList.toggle("hidden");
        }
        window.onload = function() {
            const params = new URLSearchParams(window.location.search);
            if (params.get("success")==="1") alert("Update uploaded successfully!");
            else if (params.get("success")==="0") alert("Failed to upload the update.");
        };
    </script>
</head>
<body class="bg-gray-900 bg-opacity-50 text-white">
    <header class="bg-gray-800 text-white p-5 fixed w-full top-0 z-10">
        <div class="flex justify-between items-center px-8">
            <h1 class="text-2xl font-bold">BUILDTRACK - Site $nextNumber</h1>
            <nav class="space-x-6">
                <a href="../main.html" class="hover:underline">Back to Dashboard</a>
                <a href="../logout.php" class="hover:underline text-red-400">Logout</a>
            </nav>
        </div>
    </header>

    <main class="pt-24 px-8 max-w-3xl mx-auto">
        <h2 class="text-xl font-semibold mb-4">Site: $siteName</h2>
        <form action="upload.php" method="POST" enctype="multipart/form-data"
              class="bg-white text-black p-6 rounded shadow mb-6">
            <label class="block mb-2">Select Date:</label>
            <input type="date" name="date" required class="mb-4 p-2 border rounded w-full">
            <label class="block mb-2">Upload Images:</label>
            <input type="file" name="images[]" accept="image/*" multiple required class="mb-4 block">
            <label class="block mb-2">Describe Progress:</label>
            <textarea name="progress" required placeholder="Describe today's progress..."
                      class="w-full p-3 border rounded mb-4"></textarea>
            <button type="submit"
                    class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded">
                Upload Update
            </button>
        </form>
        <button onclick="toggleUpdates()"
                class="bg-yellow-500 hover:bg-yellow-600 text-black px-4 py-2 rounded mb-4">
            Show / Hide Previous Updates
        </button>
        <section id="updatesSection" class="hidden bg-white text-black p-6 rounded shadow">
            <h3 class="text-lg font-bold mb-4">Previous Updates</h3>
            <?php
                \$updates = file("updates.txt", FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
                rsort(\$updates);
                foreach (\$updates as \$e) {
                    echo "<div class='border p-4 rounded mb-4'>{\$e}</div>";
                }
            ?>
        </section>
    </main>
</body>
</html>
HTML;

    file_put_contents($newFile, $template);

    // Add card to main.html
    $mainPath = __DIR__ . '/main.html';
    $mainContent = file_get_contents($mainPath);
    $insertBefore = '</div>'; // grid container ends here

    $card = <<<HTML
      <a href="http://localhost/projectKT/sites/$newFileName" class="site-card">
        <h3 class="text-2xl font-semibold mb-2">$siteName</h3>
        <p class="text-base text-gray-600">New Site</p>
      </a>
HTML;

    $mainContent = str_replace($insertBefore, $card . "\n" . $insertBefore, $mainContent);
    file_put_contents($mainPath, $mainContent);

    header("Location: main.html");
    exit();
}
?>
