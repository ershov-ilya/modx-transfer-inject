<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="../../../../favicon.ico">

    <title>Запись значений TV</title>

    <!-- Bootstrap core CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.min.css">
    <!-- Optional theme -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap-theme.min.css">


    <!-- Custom styles for this template -->
    <link href="../../../../cover.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>

<body>
<?php
/**
 * Created by PhpStorm.
 * Author:   ershov-ilya
 * GitHub:   https://github.com/ershov-ilya/
 * About me: http://about.me/ershov.ilya (EN)
 * Website:  http://ershov.pw/ (RU)
 * Date: 11.03.2015
 * Time: 16:50
 */

$output='';
$status='OK';

error_reporting(E_ERROR | E_WARNING);
ini_set("display_errors", 1);
define('DEBUG', true);
define('WRITE', true);

require_once('../../../../core/config/core.config.php');
require_once(API_CORE_PATH.'/class/database/database.class.php');
require_once(API_CORE_PATH.'/class/transfer/transfer.class.php');
//require_once(API_CORE_PATH.'/class/recurse-modx/recurse-modx.class.php');

/* @var Database $sbs*/
$sbs = new Database(API_CONFIG_PATH.'/acceptor.pdo.config.php');
/* @var Transfer $import */
$transfer = new Transfer($sbs);
/* @var Database $base*/
$base = new Database(API_CONFIG_PATH.'/donor.pdo.config.php');

$entity='tmplvar_contentvalue';
$tablename='modx_site_tmplvar_contentvalues';
$name_field='tmplvarid';

$tmplvar_contentvalues=$base->getTable($tablename);

//print $transfer->ptr('template', 3);

// Управление циклом
$i=0;
$start=$stop=0;
$stop=5000;

foreach($tmplvar_contentvalues as $tmplvar_contentvalue){
    if($i<$start) {$i++; continue;}
    if($i>$stop) break;
    if($transfer->is_exist($entity, $tmplvar_contentvalue['id'] )) // Предотвратить дубликаты
    {
        $i++;
        $output .=  "Skipped:".$tmplvar_contentvalue['id']."\n";
        continue;
    }

    // Привязываем к новым id TV
    $tmplvar_contentvalue['tmplvarid'] = $transfer->ptr('tmplvar', $tmplvar_contentvalue['tmplvarid']);

    // Привязываем к новым id документов
    $tmplvar_contentvalue['contentid'] = $transfer->ptr('resource', $tmplvar_contentvalue['contentid']);

    $map_link=array( 'entity'=>$entity, 'name'=>$tmplvar_contentvalue[$name_field], 'donor_id' => $tmplvar_contentvalue['id']);
    unset($tmplvar_contentvalue['id']);
    $newID='';

    // Вносим в новый сайт
    if(WRITE && $newID=='') {
        $newID=$sbs->putOne($tablename, $tmplvar_contentvalue);
        $output .= "$tablename insert:".$newID."\n";
    }
    $map_link['aceptor_id']=$newID;

    // Вносим строку в карту
    if(WRITE && $newID!='') {
        $res=$transfer->save($map_link);
        $output .=  "Transfer save ".$map_link['name']."(".$map_link['donor_id']."): ";
        $output .=  (!empty($res))?'OK':'Fail';
        $output .=  "\n";
    }
    else{
        $output .=  "\n$i) ============================\n   ";
        $output .= $tmplvar_contentvalue['tmplvarid'].":".$tmplvar_contentvalue['contentid']." ";
        $output .=  json_encode($map_link);
    }

    $i++;
}

?>

<div class="site-wrapper">

    <div class="site-wrapper-inner">

        <div class="cover-container">

            <div class="masthead clearfix">
                <div class="inner">
                    <h3 class="masthead-brand">Запись значений TV</h3>
                    <nav>
                        <ul class="nav masthead-nav">
                            <li><a href="../../../../">&lt; Back</a></li>
                        </ul>
                    </nav>
                </div>
            </div>

            <div class="inner cover">
                <div class="row">
                    <div class="col-sm-6">
                    </div>
                    <div class="col-sm-6">
                        <?php
                        if(!empty($output))
                        {
                            print '<h1 class="cover-heading">Результат</h1><pre>'.$output.'</pre><br>';
                        }

                        if($status='OK')
                        {
                            print '<div><a href="../templates" class="btn btn-primary margin-bottom">Следующий шаг &gt;</a></div>';
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

