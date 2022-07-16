<?php

class student{
    private $db;

    function __construct($conn){
        $this->db = $conn;
    }

    public function getStudent($id, $pass){
        $query = 'SELECT * FROM Student WHERE sid=:ibv AND password=:pbv';
        $s = oci_parse($this->db, $query);
        oci_bind_by_name($s, ":ibv", $id);
        oci_bind_by_name($s, ":pbv", $pass);
        oci_execute($s);
        return oci_fetch_array($s, OCI_NUM+OCI_RETURN_NULLS);
    }
}

?>