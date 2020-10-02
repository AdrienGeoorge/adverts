<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="<?= ROOT ?>/assets/css/main.css">
    <title>Adverts</title>
</head>
<body id="body">
<div class="container__padding">
    <?php
    include_once 'includedParts/header.php';
    if (!empty($returnedTemplate)) {
        require_once $returnedTemplate . '.php';
    } else {
        require_once 'home.php';
    }
    ?>
</div>
</body>
</html>
