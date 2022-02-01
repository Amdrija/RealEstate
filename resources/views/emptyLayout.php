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
    <title><?php echo $title ?></title>
    <link rel="stylesheet" type="text/css" href="/css/main.css">
    <link rel="stylesheet" type="text/css" href="/css/productCard.css">
    <link rel="stylesheet" type="text/css" href="/css/layout.css">
    <link rel="stylesheet" type="text/css" href="/css/navigation.css">
    <link rel="stylesheet" type="text/css" href="/css/<?php echo $view ?>.css">
</head>
<body>
<div class="container">
    <?php include $view . '.php' ?>
</div>
</body>
</html>