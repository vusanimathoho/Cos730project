<?php


class Model {
    
    var $table;
    var $fld;
    
    function __construct($table){
        $this->table = $table;
    }

    public function find(): Select {
        return new Find($this->table);
    }
    
    public function insert(): Add {
        return new Add($this->table);
    }
    
    public function update(): Update {
        return new Change($this->table);
    }
    
    public function remove(): Delete {
        return new Remove($this->table);
    }
    
    public function custom(): Custom {
        return new Custom($this->table);
    }
 
    
}
