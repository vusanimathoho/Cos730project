<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Select
 *
 * @author Swift
 */
class SQL {

    public function only($select = null) {
        if ($select == null) {
            $str = '*';
        } else {
            $str = "";
            $x = 1;
            foreach ($select as $se) {
                $str .= $se;
                if ($x < count($select)) {
                    $str .= " , ";
                }
                $x++;
            }
        }

        return $str;
    }

    public function select($table, $select) {

        $sql = "SELECT {$this->only($select)} FROM {$table} ";

        return $sql;
    }

    private function getJoinType($type) {
        switch ($type):
            case "main":
                return " as main ";
            case "left":
                return " LEFT ";
            case "right":
                return " RIGHT ";
            case "inner":
                return " INNER ";
            case "outer":
                return " FULL OUTER ";
        endswitch;
    }

    public function join($join, $type = "main") {
        if (!empty($join)) {
            $str = "";
            foreach ($join as $table => $column) {
                if (is_array($column)){
                    foreach ($column as $col_1 => $col_2) {
                        if ($type != "main") {
                            $str .= $this->getJoinType($type) . " JOIN {$table} ON {$col_1} = {$col_2} ";
                        } else {
                            $str .= " JOIN {$table} ON {$col_1} = {$col_1} ";
                        }
                    }
                } else {
                    if ($type != "main") {
                        $str .= $this->getJoinType($type) . " JOIN {$table} USING({$column}) ";
                    } else {
                        $str .= " JOIN {$table} USING({$column}) ";
                    }
                }
                
            }
        }
        return $str;
    }

    public function where($where, $dd = null) {
        if (!empty($where)) {
            $str = "WHERE ";
            $x = 1;
            foreach ($where as $column => $row) {
                if ($dd == "LIKE") {
                    $str .= "{$column} LIKE '%{$this->escape($row)}%' ";
                } else if ($dd == "SUB") {
                    $str .= "{$column} {$row["opr"]} ({$row["sql"]})";
                } else {
                    if (is_array($row)) {
                        $i = 1;
                        foreach ($row as $var) {
                            $str .= "{$column} = '{$var}' ";
                            if ($i < count($row)) {
                                $str .= "or ";
                            }
                            $i++;
                        }
                    } else {
                        $str .= "{$column} = '{$this->escape($row)}' ";
                    }
                }
                if ($x < count($where)) {
                    $str .= "and ";
                }
                $x++;
            }
        }
        return $str;
    }

    public function limit($number) {
        if (!empty($number)) {
            $sql = " LIMIT {$number} ";
        }
        return $sql;
    }

    public function sort($str) {
        if (!empty($str)) {
            $str = " ORDER BY $str";
        }
        return $str;
    }

    public function group($str) {
        if (!empty($str)) {
            $str = " GROUP BY $str";
        }
        return $str;
    }

    public function having($str) {
        if (!empty($where)) {
            $str = " HAVING ";
            $x = 1;
            foreach ($where as $column => $row) {

                $str .= "{$column} '{$this->escape($row)}' ";

                if ($x < count($where)) {
                    $str .= "AND ";
                }
                $x++;
            }
        }
        return $str;
    }

    public function insert($table, $data) {
        $x = 1;
        $insert_col = "";
        $insert_row = "";

        foreach ($data as $column => $row) {
            $insert_col .= $column;
            $insert_row .= "'{$this->escape($row)}'";

            if ($x < count($data)) {
                $insert_col .= ",";
                $insert_row .= ",";
            }

            $x++;
        }
        $sql = "INSERT INTO {$table} ({$insert_col}) VALUES({$insert_row})";
        return $sql;
    }

    public function update($table, $data) {
        $x = 1;
        $set = "";

        foreach ($data as $column => $row) {
            $set .= "{$column} = '{$this->escape($row)}'";

            if ($x < count($data)) {
                $set .= ",";
            }

            $x++;
        }

        $sql = "UPDATE {$table} SET {$set} ";
        return $sql;
    }

    public function delete($table) {
        $sql = "DELETE FROM {$table} ";
        return $sql;
    }

    private function escape($string) {
        return preg_replace('~[\x00\x0A\x0D\x1A\x22\x27\x5C]~u', '\\\$0', $string);
    }

}
