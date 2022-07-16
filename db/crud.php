<?php

class crud{
    private $db;
    function __construct($conn){
        $this->db = $conn;
    }

    public function getStudentDetails($id){
        $query = 'SELECT S.sid, S.name, aid, D.name dept_name, reg_id, reg_status, S.curr_level, S.curr_term, SA.street_address, SA.district
        FROM Student S JOIN Department D ON(S.did = D.did) JOIN Registration R ON(S.sid = R.sid AND S.did = R.did) JOIN SAddress SA ON(S.sid = SA.id AND S.did = SA.did)
        WHERE S.sid=:ibv';
        $s = oci_parse($this->db, $query);
        oci_bind_by_name($s, ":ibv", $id);
        oci_execute($s);
        return oci_fetch_array($s, OCI_NUM+OCI_RETURN_NULLS);
    }

    public function getStdPersonalInfo($sid){
        $query = 'SELECT S.name, S.password, SA.street_address, SA.district
        FROM Student S JOIN SAddress SA ON(S.sid = SA.id AND S.did = SA.did)
        WHERE S.sid = :sbv';
        $s = oci_parse($this->db, $query);
        oci_bind_by_name($s, ":sbv", $sid);
        oci_execute($s);
        return oci_fetch_array($s, OCI_NUM+OCI_RETURN_NULLS);
    }

    public function getStudentsOf($tid, $cid){
        $query = "SELECT T.sid, (SELECT D.name FROM Department D WHERE D.did = T.std_in_did) dept_name, T.year, T.term
        FROM Takes T JOIN Course C ON(T.cid = C.cid AND T.tid = C.tid AND T.OFFEER_BY_DID = C.did) JOIN Registration R ON(T.sid = R.sid AND T.std_in_did = R.did)
        WHERE T.tid = :tchbv
        AND T.cid = :coursebv
        AND R.reg_status = 'approved'";
        $s = oci_parse($this->db, $query);
        oci_bind_by_name($s, ":tchbv", $tid);
        oci_bind_by_name($s, ":coursebv", $cid);
        oci_execute($s);

        $result = [];$i = 0;
        while($row = oci_fetch_array($s, OCI_NUM+OCI_RETURN_NULLS)){
            $result[$i++] = $row;
        }
        return $result;
    }

    public function getGradesOf($sid, $level, $term){
        $query = "SELECT T.cid, C.name, C.credit_hr, T.grade, (C.credit_hr * T.grade)
        FROM Takes T JOIN Course C ON(T.cid = C.cid)
        WHERE T.sid = :stdbv
        AND T.year = :levelbv
        AND T.term = :termbv
        AND T.grade IS NOT NULL";         //assuming that grade is null if registration is not approved
        $s = oci_parse($this->db, $query);
        oci_bind_by_name($s, ":stdbv", $sid);
        oci_bind_by_name($s, ":levelbv", $level);
        oci_bind_by_name($s, ":termbv", $term);
        oci_execute($s);

        $result = [];$i = 0;
        while($row = oci_fetch_array($s, OCI_NUM+OCI_RETURN_NULLS)){
            $result[$i++] = $row;
        }
        return $result;
    }

    public function getTeachPersonalInfo($tid){
        $query = 'SELECT T.name, T.contact_no, T.email, T.password, TA.street_address, TA.district
        FROM Teacher T JOIN TAddress TA ON(T.tid = TA.id)
        WHERE T.tid = :tbv';
        $s = oci_parse($this->db, $query);
        oci_bind_by_name($s, ":tbv", $tid);
        oci_execute($s);
        return oci_fetch_array($s, OCI_NUM+OCI_RETURN_NULLS);
    }

    public function getCoursesForReg($id, $level, $term){
        $query = 'SELECT C.cid, C.name, C.credit_hr
        FROM Course C
        WHERE C.cid IN (
        SELECT T.cid
        FROM Student S JOIN Takes T ON(S.sid = T.sid AND S.did = T.std_in_did)
        WHERE T.sid = :stdbv
        AND T.year = :lbv
        AND T.term = :tbv
        )';
        $s = oci_parse($this->db, $query);
        oci_bind_by_name($s, ":stdbv", $id);
        oci_bind_by_name($s, ":lbv", $level);
        oci_bind_by_name($s, ":tbv", $term);
        oci_execute($s);

        $result = [];$i = 0;
        while($row = oci_fetch_array($s, OCI_NUM+OCI_RETURN_NULLS)){
            $result[$i++] = $row;
        }
        return $result;
    }

    public function getCoursesDeliveredBy($tid){
        $query = 'SELECT C.cid, C.name, C.credit_hr
        FROM Course C
        WHERE C.tid = :tchbv';
        $s = oci_parse($this->db, $query);
        oci_bind_by_name($s, ":tchbv", $tid);
        oci_execute($s);

        $result = [];$i = 0;
        while($row = oci_fetch_array($s, OCI_NUM+OCI_RETURN_NULLS)){
            $result[$i++] = $row;
        }
        return $result;
    }

    public function getCoursesOfferedBy($did){
        $query = 'SELECT *
        FROM Course
        WHERE did = :dbv';
        $s = oci_parse($this->db, $query);
        oci_bind_by_name($s, ":dbv", $did);
        oci_execute($s);

        $result = [];$i = 0;
        while($row = oci_fetch_array($s, OCI_NUM+OCI_RETURN_NULLS)){
            $result[$i++] = $row;
        }
        return $result;
    }

    public function getRegisteredCourses($id, $level, $term){
        $query = "SELECT C.cid, C.name
        FROM Takes T JOIN Course C ON(T.cid = C.cid) JOIN Student S ON(T.sid = S.sid)
        WHERE S.sid = :stdbv
        AND T.reg_req = 'sent'
        AND T.year = :lbv
        AND T.term = :tbv";
        $s = oci_parse($this->db, $query);
        oci_bind_by_name($s, ":stdbv", $id);
        oci_bind_by_name($s, ":lbv", $level);
        oci_bind_by_name($s, ":tbv", $term);
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
        $query = "SELECT S.sid, S.name
        FROM Student S JOIN Teacher T ON(T.tid = S.aid) JOIN Registration R ON(R.sid = S.sid)
        WHERE T.tid = :tchbv
        AND R.reg_status = 'pending'";
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

    public function updateGradesOf($sid, $cid, $tid, $newGrade){
        $query = "UPDATE Takes SET grade = :gdbv WHERE sid = :stdbv AND cid = :cbv AND tid = :tchbv";
        $s = oci_parse($this->db, $query);
        oci_bind_by_name($s, ":gdbv", $newGrade);
        oci_bind_by_name($s, ":stdbv", $sid);
        oci_bind_by_name($s, ":tchbv", $tid);
        oci_bind_by_name($s, ":cbv", $cid);
        oci_execute($s);
    }

    public function updateStdInfo($sid, $name, $st_addr, $dstr, $pass){
        $query = "UPDATE Student SET name = :nbv, password = :pbv WHERE sid = :stdbv";
        $s = oci_parse($this->db, $query);
        oci_bind_by_name($s, ":nbv", $name);
        oci_bind_by_name($s, ":pbv", $pass);
        oci_bind_by_name($s, ":stdbv", $sid);
        oci_execute($s);

        $query = "UPDATE SAddress SET street_address = :stbv, district = :dstbv WHERE id = :stdbv";
        $s = oci_parse($this->db, $query);
        oci_bind_by_name($s, ":stbv", $st_addr);
        oci_bind_by_name($s, ":dstbv", $dstr);
        oci_bind_by_name($s, ":stdbv", $sid);
        oci_execute($s);
    }

    public function updateTeachInfo($tid, $name, $phone, $email, $st_addr, $dstr, $pass){
        $query = "UPDATE Teacher SET name = :nbv, contact_no = :cnbv, email = :ebv, password = :pbv WHERE tid = :tbv";
        $s = oci_parse($this->db, $query);
        oci_bind_by_name($s, ":nbv", $name);
        oci_bind_by_name($s, ":cnbv", $phone);
        oci_bind_by_name($s, ":ebv", $email);
        oci_bind_by_name($s, ":pbv", $pass);
        oci_bind_by_name($s, ":tbv", $tid);
        oci_execute($s);

        $query = "UPDATE TAddress SET street_address = :stbv, district = :dstbv WHERE id = :tbv";
        $s = oci_parse($this->db, $query);
        oci_bind_by_name($s, ":stbv", $st_addr);
        oci_bind_by_name($s, ":dstbv", $dstr);
        oci_bind_by_name($s, ":tbv", $tid);
        oci_execute($s);
    }

    public function updateStudentInfo($sid, $did, $lev, $term){
        $query = "UPDATE Student SET curr_level = :lbv, curr_term = :tbv WHERE sid = :stdbv AND did = :deptbv";
        $s = oci_parse($this->db, $query);
        oci_bind_by_name($s, ":stdbv", $sid);
        oci_bind_by_name($s, ":deptbv", $did);
        oci_bind_by_name($s, ":lbv", $lev);
        oci_bind_by_name($s, ":tbv", $term);
        oci_execute($s);

        $query = "UPDATE Registration SET reg_id = -1, reg_status = 'pending' WHERE sid = :stdbv AND did = :deptbv";
        $s = oci_parse($this->db, $query);
        oci_bind_by_name($s, ":stdbv", $sid);
        oci_bind_by_name($s, ":deptbv", $did);
        oci_execute($s);
    }

    public function insertIntoTakes($students, $did, $courses, $levels, $terms){
        for($j = 0; $j < count($courses); $j++){
            $u = $courses[$j];

            for($i = 0; $i < count($students); $i++){
                $v = $students[$i];
                $y = $levels[$i];
                $z = $terms[$i];

                $query = 'SELECT tid, did FROM Course WHERE cid = :cidbv';
                $s = oci_parse($this->db, $query);
                oci_bind_by_name($s, ":cidbv", $u);
                oci_execute($s);
                $course_details = oci_fetch_array($s, OCI_NUM+OCI_RETURN_NULLS);

                $w = $course_details[0];
                $x = $course_details[1];

                $query = "INSERT INTO Takes VALUES (:stdbv, :deptbv, :cbv, :tidbv, :cdeptbv, :lbv, :tbv, null, 'not_sent')";
                $s = oci_parse($this->db, $query);
                oci_bind_by_name($s, ":stdbv", $v);
                oci_bind_by_name($s, ":deptbv", $did);
                oci_bind_by_name($s, ":cbv", $u);
                oci_bind_by_name($s, ":tidbv", $w);
                oci_bind_by_name($s, ":cdeptbv", $x);
                oci_bind_by_name($s, ":lbv", $y);
                oci_bind_by_name($s, ":tbv", $z);
                oci_execute($s);
            }
        }
    }
}

?>
