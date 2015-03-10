<?php
/**
 * Created by PhpStorm.
 * Author:   ershov-ilya
 * GitHub:   https://github.com/ershov-ilya/
 * About me: http://about.me/ershov.ilya (EN)
 * Website:  http://ershov.pw/ (RU)
 * Date: 06.03.2015
 * Time: 15:30
 */

header('Content-Type: text/plain; charset=utf-8');
error_reporting(E_ERROR | E_WARNING);
ini_set("display_errors", 1);
define('DEBUG', true);

require_once('core/config/core.config.php');
require_once(API_CORE_PATH.'/class/database/database.class.php');
require_once(API_CORE_PATH.'/class/recurse-modx/recurse-modx.class.php');

/* @var Database $sbs*/
$sbs = new Database(API_CONFIG_PATH.'/sbs.pdo.config.php');
/* @var Database $base*/
$base = new Database(API_CONFIG_PATH.'/base.pdo.config.php');

//$res=$sbs->getTable('import_map');
//print_r($res);

$rbase=new RecurseMODX($base);
print_r($rbase->recurseFrom(0));

$docList=$rbase->listFrom(0);
//asort($docList);
print_r($docList);

