<?php
require_once('/library/class.fileio.php');
require_once('/library/class.send.php');
if (isset($_POST['save']) && $_POST['nameTplSave'] != null) {
    fileio::save($_POST['nameTplSave']);
}
if (isset($_POST['testExplode'])) {
    fileio::save('text');
}
if ((isset($_POST['testExplode'])) && ($_POST['mailsList'] != null)) {
    $mailArray = explode(";", $_POST['mailsList']);
    $sender = new send();
    $sender->setFrom($_POST['from'])
        ->setSubject($_POST['subject'])
        ->setMessage($_POST['text'])
        ->setReplyMail($_POST['replyMail'])
        ->setReplyName($_POST['replyName']);
    $stats = $sender->massSender($mailArray);
    header("Location: index.php?success=" . $stats['success'] . "&error=" . $stats['error']);
}
$success = (isset($_GET['success'])) ? $_GET['success'] : null;
$error = (isset($_GET['error'])) ? $_GET['error'] : null;
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
    <script src="plugins/jquery.min.js"></script>
    <script src="plugins/js/bootstrap.js"></script>
    <script src="js/tinymce/tinymce.min.js"></script>
    <script src="js/loader.js"></script>
</head>
<body>
<nav role="navigation" class="navbar navbar-default navbar-fixed-top">
    <div class="container-fluid">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" data-target="#navbarCollapse" data-toggle="collapse" class="navbar-toggle">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
        </div>
        <!-- Collection of nav links and other content for toggling -->
        <div id="navbarCollapse" class="collapse navbar-collapse">
            <ul class="nav navbar-nav">
                <li class="active"><a href="/">Рассылка</a></li>
                <li><a href="/stat.php">Статистика</a></li>
            </ul>
        </div>
    </div>
</nav>
<input type="hidden" id="result" data-result="<?= $success . "," . $error ?>">
<div class="container">
    <div class="col-lg-12">
        <div class="main" class="form-group">
            <form method="POST">
                <div class="form-group">
                    <label for="subject">Тема:</label>
                    <input name="subject" id="subject" class="form-control" type="text" value="qweqw">
                </div>
                <div class="form-group">
                    <label for="from">От кого:</label>
                    <input name="from" id="from" class="form-control" type="text" value="qweqw">
                </div>
                <div class="form-group">
                    <label for="replyMail">Почта для ответа:</label>
                    <input name="replyMail" id="replyMail" class="form-control" type="text"
                           value="qweqw@mail.ru">
                </div>
                <div class="form-group">
                    <label for="replyName">Имя для ответа:</label>
                    <input name="replyName" id="replyName" class="form-control" type="text"
                           value="qweqw">
                </div>
                <div class="form-group">
                    <label for="mailsList">Cписок рассылки:</label>
                    <textarea name="mailsList" id="mailslist"
                              class="form-control">dietrich1892@gmail.com;</textarea>
                </div>
                <div class="form-group">
                    <label for="message">Текст сообщения:</label>
                    <textarea name="text" id="message"><?= fileio::$text ?></textarea>
                </div>
                <div class="row">
                    <div class="col-lg-6 col-xs-12">
                        <div class="form-group">
                            <input type="submit" class="btn-default form-control" name="testExplode"
                                   value="Send"/>
                        </div>
                        <div class="input-group">
                                <span class="input-group-btn">
                                    <input type="submit" class="btn btn-secondary" name="save"
                                           value="Сохранить шаблон"/>
                                </span>
                            <input name="nameTplSave" class="form-control" value=""/>
                        </div>
                        <br>
                        <div class="input-group mbpx">
                            <span class="input-group-addon"
                                  id="basic-addon3">Открыть шаблон&nbsp;&nbsp;&nbsp;&nbsp;</span>
                            <select name="drop_down" class="form-control" size="1">
                                <option value=""></option>
                                <?php
                                $csvFiles = fileio::search();
                                $countCSVFiles = count($csvFiles);
                                for ($i = 0; $i < $countCSVFiles; $i++) {
                                    ?>
                                    <option value="<?php echo($csvFiles[$i]); ?>"><?php echo($csvFiles[$i]); ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-6 col-xs-12">
                        <div id="piechart" style="width: 100%; height: 135px;"></div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="js/main.js"></script>
</body>
</html>