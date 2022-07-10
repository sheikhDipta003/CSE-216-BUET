<?php

class crud{
    private $db;
    function __construct($conn){
        $this->db = $conn;
    }

    public function getStudentDetails($id){
        $query = 'SELECT sid, Student.name, aid, Department.name dept_name, reg_id, reg_status
        FROM Student JOIN Department USING(did) JOIN Registration USING(sid,did)
        WHERE sid=:ibv';
        $s = oci_parse($this->db, $query);
        oci_bind_by_name($s, ":ibv", $id);
        oci_execute($s);
        return oci_fetch_array($s, OCI_NUM+OCI_RETURN_NULLS);
    }

    public function getCoursesForReg($id){
        $query = 'SELECT C.cid, C.name, C.credit_hr
        FROM Course C
        WHERE C.cid IN (
        SELECT T.cid
        FROM Student S JOIN Takes T ON(S.sid = T.sid AND S.did = T.std_in_did)
        WHERE T.sid = :stdbv
        )';
        $s = oci_parse($this->db, $query);
        oci_bind_by_name($s, ":stdbv", $id);
        oci_execute($s);

        $result = [];$i = 0;
        while($row = oci_fetch_array($s, OCI_NUM+OCI_RETURN_NULLS)){
            $result[$i++] = $row;
        }
        return $result;
    }

    public function getRegisteredCourses($id){
        $query = "SELECT C.cid, C.name
        FROM Takes T JOIN Course C ON(T.cid = C.cid) JOIN Student S ON(T.sid = S.sid)
        WHERE S.sid = :stdbv
        AND T.reg_req = 'sent'";
        $s = oci_parse($this->db, $query);
        oci_bind_by_name($s, ":stdbv", $id);
        oci_execute($s);

        $result = [];$i = 0;
        while($row = oci_fetch_array($s, OCI_NUM+OCI_RETURN_NULLS)){
            $result[$i++] = $row;
        }
        return $result;
    }

    public function getRegStatus($id){
        $query = 'SELECT reg_status FROM Registration WHERE sid = :stdbv';
        $s = oci_parse($this->db, $query);
        oci_bind_by_name($s, ":stdbv", $id);
        oci_execute($s);
        return oci_fetch_array($s, OCI_NUM+OCI_RETURN_NULLS);
    }

    public function getTeacherDetails($id){
        $query = 'SELECT T.tid, (SELECT D.name FROM Department D WHERE T.did = D.did) dept_name, T.name, T.contact_no, T.email, TA.street_address, TA.district
        FROM Teacher T JOIN TAddress TA ON(T.tid = TA.id)
        WHERE T.tid = :ibv';
        $s = oci_parse($this->db, $query);
        oci_bind_by_name($s, ":ibv", $id);
        oci_execute($s);
        return oci_fetch_array($s, OCI_NUM+OCI_RETURN_NULLS);
    }

    public function getAdvisee($tid){
        $query = 'SELECT S.sid, S.name
        FROM Teacher T JOIN Student S ON(T.tid = S.aid)
        WHERE T.tid = :tchbv';
        $s = oci_parse($this->db, $query);
        oci_bind_by_name($s, ":tchbv", $tid);
        oci_execute($s);

        $result = [];$i = 0;
        while($row = oci_fetch_array($s, OCI_NUM+OCI_RETURN_NULLS)){
            $result[$i++] = $row;
        }
        return $result;
    }

    public function updateRegStatus($sid){
        $query = "UPDATE Registration SET reg_status = 'approved' WHERE sid = :sbv";
        $s = oci_parse($this->db, $query);
        oci_bind_by_name($s, ":sbv", $sid);
        oci_execute($s);
    }

    public function generateRegID($std_id){
        $randID = rand(100000, 999999);
        while(true){
            $query = "SELECT sid FROM Registration WHERE reg_id = :rndbv";
            $s = oci_parse($this->db, $query);
            oci_bind_by_name($s, ":rndbv", $randID);
            oci_execute($s);
            $result = oci_fetch_row($s);

            if(!$result) break;

            $randID = rand(100000, 999999);
        }

        return $randID;
    }

    public function updateRegID($sid){
        $regID = $this->generateRegID($sid);
        $query = "UPDATE Registration SET reg_id = :rbv WHERE sid = :sbv";
        $s = oci_parse($this->db, $query);
        oci_bind_by_name($s, ":rbv", $regID);
        oci_bind_by_name($s, ":sbv", $sid);
        oci_execute($s);
    }

    public function updateRegReq($sid, $selected_courses){
        for($i = 0; $i < count($selected_courses); $i++){
            $query = "UPDATE Takes SET reg_req = 'sent' WHERE sid = :sbv AND cid = :cbv";
            $s = oci_parse($this->db, $query);
            $course = (int) $selected_courses[$i];
            oci_bind_by_name($s, ":sbv", $sid);
            oci_bind_by_name($s, ":cbv", $course);
            oci_execute($s);
        }
    }
}

?>
