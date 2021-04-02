<?php require_once '../app/config/config.php'; include_once 'title.php';
    //prevent error if title not set
    if(!isset($title))
        {
            $title = ' ';
        }
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=yes">
        <title><?php echo SITENAME. ' '.$title ?></title>

        <meta name="description" content="description">
        <meta name="author" content="anonymous">
        <meta name="keywords" content="Titanium Communications Application">

        <script src="https://code.jquery.com/jquery-3.4.1.js" integrity="sha256-WpOohJOqMqqyKL9FccASB9O0KwACQJpFTUBLTYOVvVU=" crossorigin="anonymous"></script>
        <script src="<?php echo URLROOT; ?>/assets/bootstrap/js/dist/util.js"></script>
        <script src="<?php echo URLROOT; ?>/assets/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
        
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.1/css/font-awesome.min.css">
        <link rel="stylesheet" href="<?php echo URLROOT; ?>/assets/bootstrap/dist/css/bootstrap.min.css">

        <link rel="stylesheet" href="<?php echo URLROOT; ?>/assets/css/style.css">
    </head>
    <body>
        <?php require APPROOT . '/views/includes/navbar.php'; ?>
        <!--<div class="container-fluid px-0 mt-0">-->