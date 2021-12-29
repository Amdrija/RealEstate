<?php
/**
 * @var string $title Page title
 * @var string $view The view that the page should render
 */

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title><?php echo $title ?></title>
    <!-- UIkit CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/uikit@3.9.4/dist/css/uikit.min.css" />
    <link rel="stylesheet" href="/css/header.css">

    <!-- UIkit JS -->
    <script src="https://cdn.jsdelivr.net/npm/uikit@3.9.4/dist/js/uikit.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/uikit@3.9.4/dist/js/uikit-icons.min.js"></script>
</head>
<body>
<?php include __DIR__ . '/../templates/header.php' ?>
<div class="uk-container-large uk-margin-auto">
    <?php include $view . '.php' ?>
</div>

<?php if (file_exists(__DIR__ . "/../../public/js/{$view}.js")): ?>
    <script src="/js/<?= $view ?>.js"></script>
<?php endif; ?>
</body>
</html>
