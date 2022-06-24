This is the term project for L2-T2. Created with PHP and SQL.


Project Discription:

Relation Schemas                                                          Primary Key                                       Foreign Key
Student (sid, name, aid, did, reg_id, password)                           sid
Teacher (tid, did, name, contact_no, email, password)                     tid                                               Department(did)
Department (did, name)                                                    did
Address (id, street_address, district)                                    id
Course (cid, tid, did, name, credit_hr)                                   id
Takes (sid, cid, year, term, grade)                                       (sid,cid)                                         Student(sid), Course(cid)
Registration (reg_id, reg_status)                                         reg_id
Club (club_id, club_name, total_members, vacancy)                         club_id
Contact_person (NID, name, contact_no)                                    NID
enrollsIn (sid, club_id, date_of_enrolment)                               (sid,club_id)                                     Student(sid), Club(club_id)

Data Types:

Student:
 SID            NUMBER(7)
 NAME           CHAR(50)
 AID            NUMBER(3)
 DID            NUMBER(2)
 REG_STATUS     CHAR(20)
 PASSWORD       VARCHAR2(100)

Teacher:
 TID            NUMBER(3)
 DID            NUMBER(2)
 NAME           CHAR(50)
 CONTACT_NO     NUMBER(11)
 EMAIL          CHAR(50)
 PASSWORD       VARCHAR2(100)
 
Department:
 DID            NUMBER(2)
 NAME           CHAR(50)
 
Address:
 ID                NUMBER(7)
 STREET_ADDRESS    CHAR(80)
 DISTRICT          CHAR(50)
 
Course:
 CID               NUMBER(5)
 TID               NUMBER(3)
 DID               NUMBER(2)
 NAME              CHAR(50)
 CREDIT_HR         NUMBER(3,2)
 
Takes:
 SID               NUMBER(7)
 CID               NUMBER(5)
 YEAR              CHAR(1)
 TERM              CHAR(1)
 GRADE             NUMBER(3,2)


Assumptions:
* There are total four batches - 17, 18, 19, 20.
* 10 students per batch and 2 students per department.
* Total 4 teachers per department who deliver 2 courses each.
* Each department offers two courses per term, i.e. total 8 courses are offered by each department.






