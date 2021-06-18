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
interface Delete {

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

    public function join($join);

    /**
     * @param Array String $join Specific sql for join
     * 
     * eg JOIN table2 USE(column);
     * 
     * join(["table2"=>"column"]);
     * 
     * @return $this Object Use Method exec to finish;
     */
    public function joinOuter($join);

    /**
     * @param Array String $join Specific sql for join
     * 
     * eg JOIN table2 USE(column);
     * 
     * join(["table2"=>"column"]);
     * 
     * @return $this Object Use Method exec to finish;
     */
    public function joinLeft($join);

    /**
     * @param Array String $join Specific sql for join
     * 
     * eg JOIN table2 USE(column);
     * 
     * join(["table2"=>"column"]);
     * 
     * @return $this Object Use Method exec to finish;
     */
    public function joinRight($join);

    /**
     * @param Array String $join Specific sql for join
     * 
     * eg JOIN table2 USE(column);
     * 
     * join(["table2"=>"column"]);
     * 
     * @return $this Object Use Method exec to finish;
     */
    public function joinInner($join);

    /**
     * @param String $column Specific sql for Grouping
     * 
     * eg GROUP BY column;
     * 
     * group("column");
     * 
     * @return $this Object Use Method exec to finish;
     */
    public function exec();
}

class Remove implements Delete {

    private $writeSQL;
    private $sql;
    private $table;

    public function view() {
        echo $this->sql;
    }

    public function __construct($table, $prefix = true) {

        $this->table = $table;

        $this->writeSQL = new SQL();
    }

    public function where($where = array()) {
        $this->sql = $this->writeSQL->delete($this->table);
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

    public function join($join) {
        $this->sql .= $this->writeSQL->join($join);
        return $this;
    }

    public function joinInner($join) {
        $this->sql .= $this->writeSQL->join($join, "inner");
        return $this;
    }

    public function joinLeft($join) {
        $this->sql .= $this->writeSQL->join($join, "left");
        return $this;
    }

    public function joinOuter($join) {
        $this->sql .= $this->writeSQL->join($join, "outer");
        return $this;
    }

    public function joinRight($join) {
        $this->sql .= $this->writeSQL->join($join, "right");
        return $this;
    }

}
