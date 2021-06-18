<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of DBM
 *
 * @author BC
 */
interface Update {

    /**
     * @param Array String $select  Specific sql for select param
     * 
     * eg select column  ;
     * 
     * @return $this Object Use Method exec to finish;
     */
    public function only($select = []);

    /**
     * @param Array String $where Specific sql for where
     * 
     * eg where column = this ;
     * 
     * where("AND",["column"=>"this"]); AND
     * where(["OR","column"=>"#this"]); OR
     * @return $this Object Use Method exec to finish;
     */
    public function where($where = array());

    /**
     * 
     * 
     * eg RUN SQL;
     * 
     * ->sort("column DESC");
     * 
     * @return $this Object Use Method exec to finish;
     */
    public function exec();
}

class Change implements Update {

    private $writeSQL;
    private $sql;
    private $table;

    public function __construct($table) {

        $this->table = $table;

        $this->writeSQL = new SQL();
    }

    public function only($select = []) {

        $this->sql = $this->writeSQL->update($this->table, $select);
        return $this;
    }

    public function where($where = array()) {
        $this->sql .= $this->writeSQL->where($where, null);
        return $this;
    }

    public function exec($debug = 0, $dbname = null) {
        $db = new DB();

        if (!empty($dbname)) {
            $db->setDatabase($dbname);
        }

        if ($debug > 3) {
            return $this->view();
        }

        return $db->runSql($this->sql)[1];
    }

    public function view() {
        echo $this->sql;
    }

}
