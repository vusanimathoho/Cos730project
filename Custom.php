<?php



class Custom {
    

    public function exec($sql){
        $db = new DB();
        return $db->fetchAll($db->runSql($sql)[1]);
    }

}
    
