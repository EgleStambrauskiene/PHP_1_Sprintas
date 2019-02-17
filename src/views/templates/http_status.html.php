<!DOCTYPE html>
<html lang="lt">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>The First Sprint at BT</title>
<link rel="stylesheet" href="<?= BASE_URL . '/public/css/uikit/uikit.min.css';?>">
<!--<link rel="stylesheet" href="">-->
</head>
<body>

<nav class="uk-navbar-container uk-background-secondary uk-light uk-margin-bottom uk-navbar-transparent" uk-navbar>
<div class="uk-navbar-left">
<?php /*Site title*/;?>
<a href="<?= BASE_URL; ?>" class="uk-navbar-item uk-logo">The First Sprint</a>
</div>

<div class="uk-navbar-center">

<?php /*Menu block*/;?>

</div>

<div class="uk-navbar-right">

<?php /*Lang switcher, login button*/;?>

</div>
</nav>


<div class="uk-container">
<h2 class="uk-text-center"><?= $httpStatusCode;?></h2>
<h3 class="uk-text-center"><?= $httpStatusDescription;?></h3>
</div>

<script defer type="text/javascript" src="<?= BASE_URL . '/public/js/uikit/uikit.min.js';?>"></script>
</body>
</html>

