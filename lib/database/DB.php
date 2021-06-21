<?php


class DB {

    protected $db;
    protected $dbname;
    public $db_type = "mysqli";

    public function __construct() {
        $this->start_db();
        $this->db_type = DB_TYPE;
        $this->dbname = DB_DATABASE;
        return;
    }

    public function setDatabase($dbname) {
        if (!empty($dbname)) {
            $this->dbname = $dbname;
        }
    }

    public function setDatabaseType($type) {
        if (!empty($type)) {
            $this->db_type = $type;
        }
    }

    private function start_db() {

        switch ($this->db_type) {
            case "mysqli" :
                try {
                    $this->db = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, $this->dbname);
                } catch (PDOException $e) {
                    
                    die($e);
                }
                break;
            case "pdo" :
                try {
                    $this->db = new PDO("mysql:host=" . DB_HOST . ";dbname={$this->dbname}", DB_USER, DB_PASSWORD);
                    // set the PDO error mode to exception
                    $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                    $this->db = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, $this->dbname);
                } catch (PDOException $e) {
                    die($e);
                }
                break;
            case "sqlite" :
                try {
                    $this->db = new PDO("sqlite:" . SQLITE_FILE);
                } catch (PDOException $e) {
                    die($e);
                }
                break;
            default :
                try {
                    $this->db = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, $this->dbname);
                } catch (PDOException $e) {
                    die($e);
                }
                break;
        }
    }

    public function fetchAll($res) {
        switch ($this->db_type) {
            case "mysqli":
                $result = [];
                $resu = $res->get_result();
                while ($row = $resu->fetch_object()) {
                    $result[] = $row;
                }
                $res->close();
                return ($result);
            case "pdo":
                return $res->fetchAll(PDO::FETCH_CLASS);
            case "sqlite";
                return $res->fetchAll(PDO::FETCH_CLASS);

            default :
                return null;
        }
    }

    //run sql codes.
    public function runSql($sql, $data = null) {
        switch ($this->db_type) {
            case "mysqli":
                return $this->mysqliQuery($sql);
            case "sqlite":
              set_time_limit(300);
                return $this->sqliteQuery($sql, $data);
                
            case "pdo":
                return $this->pdoQuery($sql);
            default :
                return $this->msqliQuery($sql);
        }
    }

    //run sql codes.
    public function pdoQuery($sql) {
        $this->start_db();
        $query = $this->db->prepare($sql);
        if ($query == false) {
            create_log("error", "{$this->db_type} database error " . $this->db->errorInfo());
            die("error detected check log");
        }
        if ($query->execute()) {
            return array(true, $query);
        }
        return array(false, $query);
    }

    //run sql codes.
    public function sqliteQuery($sql, $data) {
        $this->start_db();
        $query = $this->db->prepare($sql);
        if ($query == false) {
            create_log("error", "{$this->db_type} database error " . $this->db->errorInfo()[0] . " " . $this->db->errorInfo()[1] . " " . $this->db->errorInfo()[2] . " ");
            die("error detected check log");
        }
        if (empty($data)) {
            if ($query->execute()) {
                return array(true, $query);
            }
            return array(false, $query);
        }
        if ($query->execute($data)) {
            return array(true, $query);
        }
        return array(false, $query);
    }

    //run sql codes.
    public function mysqliQuery($sql) {
        $this->start_db();
        
        $query = $this->db->prepare($sql);
        if ($query == false) {
            die("SQL Query Error : ".$sql."<br/>".$this->db->error);
        }
        if ($query->execute()) {

            return array(true, $query);
        }
        return array(false, $query);
    }
    
    function escape($escapestr) {
        return $this->db->escape_string($escapestr);
    }


}
