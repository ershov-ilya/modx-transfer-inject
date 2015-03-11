<?php
/**
 * Created by PhpStorm.
 * Author:   ershov-ilya
 * GitHub:   https://github.com/ershov-ilya/
 * About me: http://about.me/ershov.ilya (EN)
 * Website:  http://ershov.pw/ (RU)
 * Date: 10.03.2015
 * Time: 15:25
 */

header('Content-Type: text/plain; charset=utf-8');
error_reporting(E_ERROR | E_WARNING);
ini_set("display_errors", 1);
define('DEBUG', true);
define('WRITE', false);

require_once('../../../core/config/core.config.php');
require_once(API_CORE_PATH.'/class/database/database.class.php');
//require_once(API_CORE_PATH.'/class/recurse-modx/recurse-modx.class.php');
require_once(API_CORE_PATH.'/class/transfer/transfer.class.php');

/* @var Database $sbs*/
$sbs = new Database(API_CONFIG_PATH.'/acceptor.pdo.config.php');
/* @var Transfer $import */
$transfer = new Transfer($sbs);
/* @var Database $base*/
$base = new Database(API_CONFIG_PATH.'/donor.pdo.config.php');

$tablename='modx_site_templates';
$name_field='templatename';

//// Проверка на уникальность имён шаблонов
//$templates=$sbs->get("SELECT templatename FROM $tablename");
//foreach($templates as $el){
//    print $el['templatename']."\n";
//}
//print "\n";
//$templates=$base->get("SELECT templatename FROM $tablename");
//foreach($templates as $el){
//    print $el['templatename']."\n";
//}

$templates=$base->getTable($tablename);
//unset($templates[0]);
foreach($templates as $template){
    if($transfer->is_exist('template', $template['id'] ))  {$i++; continue;} // Предотвратить дубликаты

    $map_link=array( 'entity'=>'template', 'name'=>$template[$name_field], 'donor_id' => $template['id']);
    
    unset($template['id']);
    $res='';

    if(WRITE) {
        $res=$sbs->putOne($tablename, $template);
        print "$tablename insert:".$res."\n";
    }
    $map_link['aceptor_id']=$res;
    if(WRITE) {
        $res=$sbs->putOne('import_map', $map_link);
        print "import_map insert:".$res."\n";
    }
    else{
        print_r($map_link);
    }
//    break;
}