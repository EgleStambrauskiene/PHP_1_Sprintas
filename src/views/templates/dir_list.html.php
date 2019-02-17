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

<h1>Directories</h1>

<ul class="uk-breadcrumb">
<li><a href="<?= BASE_URL ?>">Root</a></li>
<?php foreach ($crumbs as $crumb):?>

<li><a href="<?= BASE_URL . '/' . $crumb['path']?>"><?= $crumb['title'];?></a></li>

<?php endforeach;?>
</ul>

<h2>Actions</h2>

<div uk-grid class="uk-grid">

<div>
<span uk-icon="trash"></span>&nbsp;
<button type="button" uk-toggle="target: #trash-confirm" class="uk-button uk-button-default">Trash</button>
</div>

<form method="POST" id="mkdir-form">
<input type="text" name="mkdir" class="uk-input uk-width-1-2">
<button type="button" onclick="event.preventDefault();submitForm('mkdir-form');" class="uk-button uk-button-default">Create directory</button>
</form>



<form method="POST" id="upload-form" enctype="multipart/form-data">
<input type="file" name="file_upload">
<button type="button" onclick="event.preventDefault();submitForm('upload-form');" class="uk-button uk-button-default">Upload file</button>
</form>
</div>
<?php if (isset($_SESSION['messages']) and !empty($_SESSION['messages'])):?>
<div class="uk-alert-warning" uk-alert>
<a class="uk-alert-close" uk-close></a>
<ul class="uk-list">
<?php foreach ($_SESSION['messages'] as $message):?>
<li><?= $message;?></li>
<?php endforeach;?>
</ul>
</div>
<?php unset($_SESSION['messages']);?>
<?php endif;?>

<h2>List</h2>

<form method="POST" id="batch-form" class="uk-form-stacked">
<ul class="uk-list">
<?php foreach ($directoryContents['DIR'] as $content):?>
<li>

<span uk-icon="icon: folder; ratio: 1.25"></span>&nbsp;

<input type="checkbox" name="batch[]" value="<?= FILE_PATH . DIRECTORY_SEPARATOR . $content['title'];?>" class="uk-checkbox">&nbsp;

<a href="<?= $content['url'];?>"><?= $content['title'];?></a>

</li>
<?php endforeach;?>

<?php foreach ($directoryContents['FILE'] as $content):?>
<li>

<span uk-icon="icon: file-text; ratio: 1.25"></span>&nbsp;

<input type="checkbox" name="batch[]" value="<?= FILE_PATH . DIRECTORY_SEPARATOR . $content['title'];?>" class="uk-checkbox">&nbsp;

<a href="<?= $content['url'];?>" target="_blank"><?= $content['title'];?></a>

</li>
<?php endforeach;?>

</ul>
</form>

</div>


<div id="trash-confirm" uk-modal class="uk-flex-top">
<div class="uk-modal-dialog uk-modal-body uk-margin-auto-vertical">
<h2 class="uk-modal-title">Trash</h2>
<p>This action can't to be undo. Are You sure to trash selected items?</p>
<p class="uk-text-center">
<button class="uk-button uk-button-default uk-modal-close" type="button">Cancel</button>
<button class="uk-button uk-button-danger" type="button" onclick="event.preventDefault();submitForm('batch-form')">Trash</button>
</p>
</div>


</div>

<script defer type="text/javascript" src="<?= BASE_URL . '/public/js/commons.js';?>"></script>
<script defer type="text/javascript" src="<?= BASE_URL . '/public/js/uikit/uikit.min.js';?>"></script>
<script defer type="text/javascript" src="<?= BASE_URL . '/public/js/uikit/uikit-icons.min.js';?>"></script>
</body>
</html>

