<?php
/**
 * Created by PhpStorm.
 * Author:   ershov-ilya
 * GitHub:   https://github.com/ershov-ilya/
 * About me: http://about.me/ershov.ilya (EN)
 * Website:  http://ershov.pw/ (RU)
 * Date: 10.03.2015
 * Time: 18:28
 */

$output=$_POST['id'];



?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="../../../favicon.ico">

    <title>Cover Template for Bootstrap</title>

    <!-- Bootstrap core CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.min.css">
    <!-- Optional theme -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap-theme.min.css">


    <!-- Custom styles for this template -->
    <link href="../../../cover.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>

<body>

<div class="site-wrapper">

    <div class="site-wrapper-inner">

        <div class="cover-container">

            <div class="masthead clearfix">
                <div class="inner">
                    <h3 class="masthead-brand">TVs</h3>
                    <nav>
                        <ul class="nav masthead-nav">
                            <li><a href="../../../">&lt; Back</a></li>
                        </ul>
                    </nav>
                </div>
            </div>

            <div class="inner cover">
                <div class="row">
                    <div class="col-sm-6">
                        <h1 class="cover-heading">Настройки</h1>
                        <p>Следующим шагом необходиомо в админке сайта акцептора создать новый Источник файлов (Media Source) и прописать пути к картинкам сайта Донора</p>
                        <form action="" class="form-inline" method="post">
                            <div class="form-group">
                                <label for="id">ID нового источника файлов</label>
                                <input type="text" name="id" placeholder="ID" class="form-control">
                                <input type="submit" value="Выполнитиь" class="form-control">
                            </div>
                        </form>
                    </div>
                    <div class="col-sm-6">
                        <?php if(!empty($output))
                        {
                            print '
                        <h1 class="cover-heading">Результат</h1>
                                <pre>'.
                                $output.
                                '</pre>
                            <br>
                            <p><a href="../../../" class="btn btn-primary">&lt; Вернуться назад</a></p>
                            ';
                        }
                        ?>
                    </div>
                </div>
            </div>

            <div class="mastfoot">
                <div class="inner">
                    <p>Project <a href="https://github.com/ershov-ilya/modx-transfer-inject" target="_blank">modx-transfer-inject</a>, by <a href="https://github.com/ershov-ilya" target="_blank">ILYA ERSHOV</a>.</p>
                </div>
            </div>

        </div>

    </div>

</div>

<!-- Bootstrap core JavaScript
================================================== -->
<!-- Placed at the end of the document so the pages load faster -->
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
<!-- Latest compiled and minified CSS -->
<!-- Latest compiled and minified JavaScript -->
<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.2/js/bootstrap.min.js"></script>
</body>
</html>

