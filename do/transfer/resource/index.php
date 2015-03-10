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
define('WRITE', false);

require_once('../../../core/config/core.config.php');
require_once(API_CORE_PATH.'/class/database/database.class.php');
require_once(API_CORE_PATH.'/class/recurse-modx/recurse-modx.class.php');

/* @var Database $sbs*/
$sbs = new Database(API_CONFIG_PATH.'/sbs.pdo.config.php');
/* @var Database $base*/
$base = new Database(API_CONFIG_PATH.'/base.pdo.config.php');

$tablename='modx_site_content';
$name_field='pagetitle';

$resources=$base->getTable($tablename);
$i=0;
foreach($resources as $resource){
    $map_link=array( 'entity'=>'resource', 'name'=>$resource[$name_field], 'donor_id' => $resource['id']);

    unset($resource['id']);
    $res='';

    if(WRITE) {
        $res=$sbs->putOne($tablename, $resource);
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
    $i++;
    if($i>50) break;
}