<?php
require_once('/library/class.stats.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sender</title>
    <link href="plugins/css/bootstrap.css" rel="stylesheet">
    <link href="css/main.css" rel="stylesheet">
    <link href="css/stat.css" rel="stylesheet">
    <script src="plugins/jquery.min.js"></script>
    <script src="plugins/js/bootstrap.js"></script>
    <script src="js/tinymce/tinymce.min.js"></script>
    <script type="text/javascript" src="js/loader.js"></script>
</head>
<body>
<nav role="navigation" class="navbar navbar-default navbar-fixed-top">
    <div class="container-fluid">
        <div class="navbar-header">
            <button type="button" data-target="#navbarCollapse" data-toggle="collapse" class="navbar-toggle">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
        </div>
        <div id="navbarCollapse" class="collapse navbar-collapse">
            <ul class="nav navbar-nav">
                <li><a href="/">Рассылка</a></li>
                <li class="active"><a href="/stat.php">Статистика</a></li>
            </ul>
        </div>
    </div>
</nav>

<div class="container">
    <?php
    $stat = new stats();
    $stat->showNews();
    ?>
</div>
<script src="js/main.js"></script>
</body>
</html>