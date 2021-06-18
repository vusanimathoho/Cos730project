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
interface Select{
    
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
     * @param Array String $join Specific sql for join
     * 
     * eg JOIN table2 USE(column);
     * 
     * join(["table2"=>"column"]);
     * 
     * @return $this Object Use Method exec to finish;
     */
    public function like($where = array()); 
    /**
     * @param Array String $join Specific sql for join
     * 
     * eg JOIN table2 USE(column);
     * 
     * join(["table2"=>"column"]);
     * 
     * @return $this Object Use Method exec to finish;
     */
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
    public function group($column);
    /**
     * @param Array $having Specific sql for having
     * 
     * eg HAVING Count(column) > 9;
     * 
     * have(["COUNT(column)"=>"9"]);
     * 
     * @return $this Object Use Method exec to finish;
     */
    public function have($having);
    /**
     * @param Array $having Specific sql for having
     * 
     * eg HAVING Count(column) > 9;
     * 
     * have(["COUNT(column)"=>"9"]);
     * 
     * @return $this Object Use Method exec to finish;
     */
    public function limit($number);
    /**
     * @param Array String $sort Specific sql for Order by
     * 
     * eg ORDER BY column DESC;
     * 
     * ->sort("column DESC");
     * 
     * @return $this Object Use Method exec to finish;
     */
    public function sort($sort);
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

class Find implements Select{
    private $writeSQL;
    private $sql;
    private $table;


    public function __construct($table,$prefix = true) {
     
            $this->table = $table;

        
        $this->writeSQL = new SQL();
    }
    
    public function view(){
        echo $this->sql;
    }

    public function custom($sql){
        
        $this->sql = $sql;
        return $this;
    }
    
    public function only($select =[]){
        
        $this->sql = $this->writeSQL->select($this->table,$select);
        return $this;
    }
    
    public function group($column){
        $this->sql .= $this->writeSQL->group($column);
        return $this;
    }

    public function have($having){
        $this->sql .= $this->writeSQL->having($having);
        return $this;
    }

    public function join($join){
        $this->sql .= $this->writeSQL->join($join);
        return $this;
    }

    public function sort($sort){
        $this->sql .= $this->writeSQL->sort($sort);
        return $this;
    }

    public function where($where = array()){
        $this->sql .= $this->writeSQL->where($where, null);
        return $this;
    }
    
    public function like($where = array()){
        $this->sql .= $this->writeSQL->where($where, "LIKE");
        return $this;
    }
    public function limit($number){
        $this->sql .= $this->writeSQL->limit($number);
        return $this;
    }
    
    public function exec($debug=0,$dbname = null){
        $db = new DB();
        
        if(!empty($dbname)){
            $db->setDatabase($dbname);
        }
        
        if($debug>3){
            return $this->view();
        }
        
        return $db->fetchAll($db->runSql($this->sql)[1]);
    }

    public function joinInner($join) {
        $this->sql .= $this->writeSQL->join($join,"inner");
        return $this;
    }

    public function joinLeft($join) {
        $this->sql .= $this->writeSQL->join($join,"left");
        return $this;
    }

    public function joinOuter($join) {
        $this->sql .= $this->writeSQL->join($join,"outer");
        return $this;
    }

    public function joinRight($join) {
        $this->sql .= $this->writeSQL->join($join,"right");
        return $this;
    }

}
    
