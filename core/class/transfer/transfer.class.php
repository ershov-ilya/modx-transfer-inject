<?php
/**
 * Created by PhpStorm.
 * Author:   ershov-ilya
 * GitHub:   https://github.com/ershov-ilya/
 * About me: http://about.me/ershov.ilya (EN)
 * Website:  http://ershov.pw/ (RU)
 * Date: 10.03.2015
 * Time: 16:13
 */

class Transfer {
    private $dbc;
    private $table_name;

    function __construct($DBC, $table_name='import_map'){
        /* @var Database $DBC */
        $this->dbc=$DBC;
        $this->table_name=$table_name;
    }

    public static function test(){
        return "Transfer class: OK\n";
    }

    public function ptr($entity, $oldID){
        $sql="SELECT * FROM $this->table_name WHERE entity='$entity' AND donor_id='$oldID'";
        $res=$this->dbc->get($sql);
        return $res[0]["aceptor_id"];
    }

    public function is_exist($entity, $oldID){
        $sql="SELECT * FROM $this->table_name WHERE entity='$entity' AND donor_id='$oldID'";
        $res=$this->dbc->get($sql);
        if(empty($res)) return false;
        return true;
    }

    public function not($entity, $oldID){
        $sql="SELECT * FROM $this->table_name WHERE entity='$entity' AND donor_id='$oldID'";
        $res=$this->dbc->get($sql);
        if(empty($res)) return true;
        return false;
    }

    public function save($map_link){
        $res=$this->dbc->putOne('import_map', $map_link);
        return $res;
    }
}