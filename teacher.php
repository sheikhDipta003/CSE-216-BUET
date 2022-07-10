<?php

class teacher{
    private $db;

    function __construct($conn){
        $this->db = $conn;
    }

    public function getTeacher($id, $pass){
        $query = 'SELECT * FROM Teacher WHERE tid=:ibv AND password=:pbv';
        $s = oci_parse($this->db, $query);
        oci_bind_by_name($s, ":ibv", $id);
        oci_bind_by_name($s, ":pbv", $pass);
        oci_execute($s);
        return oci_fetch_array($s, OCI_ASSOC+OCI_RETURN_NULLS);
    }
}

?>