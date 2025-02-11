<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'Visitor Tracker' ?></title>

    <!-- TailwindCSS (CDN) -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Bootstrap Icons (for visuals) -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">

    <link href="/assets/css/styles.css" rel="stylesheet">
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center p-6">

<div class="max-w-4xl w-full bg-white shadow-lg rounded-lg p-6">
	<?= $content ?>
</div>

</body>
</html>
