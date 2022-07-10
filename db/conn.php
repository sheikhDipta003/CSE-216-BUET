<?php
$c = oci_pconnect("hr", "hr", "localhost/orcl");
if (!$c) {
 $e = oci_error();
 trigger_error('Could not connect to database: '. $e['message'],E_USER_ERROR);
}
require_once 'crud.php';
require_once 'student.php';
require_once 'teacher.php';
$crud = new crud($c);
$std = new student($c);
$teach = new teacher($c);
?>