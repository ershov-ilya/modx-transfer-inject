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

header('Content-Type: text/html; charset=utf-8');
error_reporting(E_ERROR | E_WARNING);
ini_set("display_errors", 1);
define('DEBUG', true);
define('WRITE', false);

require_once('../../../core/config/core.config.php');
require_once(API_CORE_PATH.'/class/database/database.class.php');
require_once(API_CORE_PATH.'/class/transfer/transfer.class.php');
//require_once(API_CORE_PATH.'/class/recurse-modx/recurse-modx.class.php');

/* @var Database $sbs*/
$sbs = new Database(API_CONFIG_PATH.'/acceptor.pdo.config.php');
/* @var Transfer $import */
$transfer = new Transfer($sbs);
/* @var Database $base*/
$base = new Database(API_CONFIG_PATH.'/donor.pdo.config.php');

// Script config
$tablename='modx_site_snippets';
$name_field='name';
$entity='snippet';

// Init
$output='';
$response=array();
$response['content']='';
$response['buttons']='';
$response['json']=array();

$snippets=$base->getTable($tablename);

//print $transfer->ptr('template', 3);

// Управление циклом
$i=0;
$start=$stop=0;
$stop=5000;

foreach($snippets as $snippet){
    if($i<$start) {$i++; continue;}
    if($i>$stop) break;
    $output.= "\n$i) $entity $snippet[$name_field]:\t";

    if($transfer->is_exist($entity, $snippet['id'] ))  {$i++; $output.= "Done before\n"; continue;} // Предотвратить дубликаты

    $map_link=array( $entity=>$entity, 'name'=>$snippet[$name_field], 'donor_id' => $snippet['id']);

    unset($snippet['id']);

    // Проверка на конфликт имён
    // ВНИМАНИЕ: в случае конфликта имён TV переменных, новая TV переменная добавляться не будет
    // Все значения будут привязаны к уже существующей TV переменной
    // В настоящий момент не видится возможным, корректная подмена имени TVшки в коде сайта
    $name_conflict=false;
    $conflict = $sbs->getOne($tablename, $snippet[$name_field], 'id,name', $name_field);
    if(!empty($conflict)){
        $name_conflict=true;
        $newID=$conflict['id'];
        if(DEBUG)
        {
            $output .= "\tNAME CONFLICT\n";
            continue;
        }
    }

    $newID='';
    // Вносим в новый сайт
    if(WRITE) {
        try {
            $newID=$sbs->putOne($tablename, $snippet);
            print "$tablename insert:".$newID."\n";
        } catch (Exception $e) {
            $output .= 'Выброшено исключение: '.$e->getMessage()."\n";
        }
    }
    $map_link['aceptor_id']=$newID;

    // Вносим строку в карту
    if(WRITE && $newID) {
        $res=$transfer->save($map_link);
        $output.= (!empty($res))?'OK':'Fail';
        $output.= "\n";
    }
    else{
        $output.= "Test\n";
//        print_r($snippets);
//        print_r($map_link);
    }

    $i++;
//    break;
}

    if($response['json']['status']=='OK')
    {
        $response['buttons'].= '<p><a href="values" class="btn btn-primary">Следующий шаг &gt;</a></p>';
    }

// Вывод шаблона
if(!empty($response['json'])) $response['json']=json_encode($response['json']);
else $response['json']='{}';
include(API_BASE_PATH.'/assets/templates/base.tpl.php');
exit(0);
