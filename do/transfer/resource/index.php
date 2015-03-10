<?php
/**
 * Created by PhpStorm.
 * Author:   ershov-ilya
 * GitHub:   https://github.com/ershov-ilya/
 * About me: http://about.me/ershov.ilya (EN)
 * Website:  http://ershov.pw/ (RU)
 * Date: 10.03.2015
 * Time: 16:08
 */

header('Content-Type: text/plain; charset=utf-8');
error_reporting(E_ERROR | E_WARNING);
ini_set("display_errors", 1);
define('DEBUG', true);
define('WRITE', true);

require_once('../../../core/config/core.config.php');
require_once(API_CORE_PATH.'/class/database/database.class.php');
require_once(API_CORE_PATH.'/class/transfer/transfer.class.php');
//require_once(API_CORE_PATH.'/class/recurse-modx/recurse-modx.class.php');

/* @var Database $sbs*/
$sbs = new Database(API_CONFIG_PATH.'/sbs.pdo.config.php');
/* @var Transfer $import */
$transfer = new Transfer($sbs);
/* @var Database $base*/
$base = new Database(API_CONFIG_PATH.'/base.pdo.config.php');

$tablename='modx_site_content';
$name_field='pagetitle';

$resources=$base->getTable($tablename);

//print $transfer->ptr('template', 3);

// Управление циклом
$i=0;
$start=$stop=0;
$stop=20;

foreach($resources as $resource){
    if($i<$start) {$i++; continue;}
    if($i>$stop) break;
    if($transfer->is_exist('resource', $resource['id'] ))  {$i++; continue;} // Предотвратить дубликаты
    if($transfer->not('resource', $resource['parent'] ))  {$i++; continue;} // Предотвратить запись, если родитель ещё не перенесён

    $map_link=array( 'entity'=>'resource', 'name'=>$resource[$name_field], 'donor_id' => $resource['id']);

    unset($resource['id']);
    $resource['parent'] = $transfer->ptr('resource', $resource['parent']);
    $resource['template'] = $transfer->ptr('template', $resource['template']);

    $newID='';
    // Вносим в новый сайт
    if(WRITE) {
        $newID=$sbs->putOne($tablename, $resource);
        print "$tablename insert:".$newID."\n";
    }
    $map_link['aceptor_id']=$newID;

    // Вносим строку в карту
    if(WRITE && $newID) {
        $res=$transfer->save($map_link);
        print "Transfer save:";
        print (!empty($res))?'OK':'Fail';
        print "\n";
    }
    else{
        print "\n$i) ============================\n";
        print_r($resource);
        print_r($map_link);
    }

    $i++;
}