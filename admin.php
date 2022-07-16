<?php

class admin{
    private $db;

    function __construct($conn){
        $this->db = $conn;
    }

    public function getAdmin($id, $pass){
        $query = 'SELECT * FROM Admin WHERE admin_id=:ibv AND password=:pbv';
        $s = oci_parse($this->db, $query);
        oci_bind_by_name($s, ":ibv", $id);
        oci_bind_by_name($s, ":pbv", $pass);
        oci_execute($s);
        return oci_fetch_array($s, OCI_NUM+OCI_RETURN_NULLS);
    }

    public function getStudentsOfDept($did, $level, $term){
        $query = "SELECT sid
        FROM Student
        WHERE curr_level = :levbv
        AND curr_term = :termbv
        AND did = :deptbv";
        $s = oci_parse($this->db, $query);
        oci_bind_by_name($s, ":deptbv", $did);
        oci_bind_by_name($s, ":levbv", $level);
        oci_bind_by_name($s, ":termbv", $term);
        oci_execute($s);
        
        $result = [];$i = 0;
        while($row = oci_fetch_array($s, OCI_NUM+OCI_RETURN_NULLS)){
            $result[$i++] = $row;
        }
        return $result;
    }
}

?>