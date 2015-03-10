<?php
/**
 * Created by PhpStorm.
 * Author:   ershov-ilya
 * GitHub:   https://github.com/ershov-ilya/
 * About me: http://about.me/ershov.ilya (EN)
 * Website:  http://ershov.pw/ (RU)
 * Date: 10.03.2015
 * Time: 12:16
 */

class RecurseMODX {
    private $dbh;

    public static function test(){
        return "OK";
    }

    function __construct($dbh){
        $this->dbh=$dbh;
    }

    function get($parent){
        return $this->dbh->getOne('modx_site_content', $parent, 'id,pagetitle,parent');
    }
}