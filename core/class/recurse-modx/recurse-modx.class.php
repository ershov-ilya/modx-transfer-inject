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
    /* @var Database $dbh */
    private $dbc;
    public function __construct($dbh){
        $this->dbc=$dbh;
    }

    public static function test($db){
        return "OK";
    }


    public function recurse($id){
        $sql="SELECT id FROM modx_site_content WHERE parent='$id'";
        $children=$this->dbc->get($sql);

        $arr = array();
        if(empty($children)) {
//            $arr = $this->dbc->getOne('modx_site_content',$id,'pagetitle');
            $arr = 'last';
        }else
        {
            foreach($children as $child)
            {
                $res = $this->recurse($child['id']);
                //print $res['id']."\n";
                $arr[$child['id']] = $res;
            }
        }
        return $arr;
    }

    public function listFrom($id){
        $result = array($id);
        $sql="SELECT id FROM modx_site_content WHERE parent='$id'";
        $children=$this->dbc->get($sql);

        if(!empty($children))
        {
            foreach($children as $child)
            {
                $res = $this->listFrom($child['id']);
                //print $res['id']."\n";
                $result = array_merge($result, $res);
            }
        }
        return $result;
    }
}