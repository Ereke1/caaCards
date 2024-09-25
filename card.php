<?php

class Card
{
    private $conn;
    public $id;
    public $name;
    public $surname;
    public $groups2;
    public $studyperiod;
    public $barcodes;
    public $photo;
    public $img;
    public $status;
    public $spisok;
    public $zapis;
    public $no_foto;
    public $zapis2;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    function getforid($id)
    {
        $query = 'SELECT img, id AS id, first_name AS name, last_name AS surname, code13 AS barcodes, departament AS groups2,  
		CONCAT(begin_date,"-",DATE_FORMAT(end_date, "%d.%m.%Y")) AS  studyperiod, status ,photo FROM 1_ochnoe WHERE id=' . $id;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    function getall()
    {
        /*$query = "select uc.id AS id, first_name AS name, last_name AS surname, uc.identifier AS barcodes, ui.image AS photo, division AS groups 
		CONCAT(DATE_FORMAT(begin_date, '%d.%m.%Y'),'-',DATE_FORMAT(end_date, '%d.%m.%Y')) AS  studyperiod from user
		left join user_card uc on uc.user_id = user.id
		left join user_image ui on user.id = ui.user_id
		WHERE uc.identifier IS NOT NULL;";*/
        $query = 'select img, id AS id, first_name AS name, last_name AS surname, code13 AS barcodes, departament AS groups2,  
		CONCAT(begin_date,"-",DATE_FORMAT(end_date, "%d.%m.%Y")) AS  studyperiod, status, photo from 1_ochnoe
		WHERE code13 IS NOT NULL and course=1 order by departament, surname;';
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }
    function getallCol()
    {
        /*$query = "select uc.id AS id, first_name AS name, last_name AS surname, uc.identifier AS barcodes, ui.image AS photo, division AS groups 
		CONCAT(DATE_FORMAT(begin_date, '%d.%m.%Y'),'-',DATE_FORMAT(end_date, '%d.%m.%Y')) AS  studyperiod from user
		left join user_card uc on uc.user_id = user.id
		left join user_image ui on user.id = ui.user_id
		WHERE uc.identifier IS NOT NULL;";*/
        $query = 'select img, id AS id, first_name AS name, last_name AS surname, code13 AS barcodes, departament AS groups2,  
		CONCAT(begin_date,"-",DATE_FORMAT(end_date, "%d.%m.%Y")) AS  studyperiod, status, photo from colege
		WHERE code13 IS NOT NULL order by surname;';
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }
    function getall1Course(){
        /*$query = "select uc.id AS id, first_name AS name, last_name AS surname, uc.identifier AS barcodes, ui.image AS photo, division AS groups 
		CONCAT(DATE_FORMAT(begin_date, '%d.%m.%Y'),'-',DATE_FORMAT(end_date, '%d.%m.%Y')) AS  studyperiod from user
		left join user_card uc on uc.user_id = user.id
		left join user_image ui on user.id = ui.user_id
		WHERE uc.identifier IS NOT NULL;";*/
        $query = 'select img, id AS id, first_name AS name, last_name AS surname, code13 AS barcodes, departament AS groups2,  
		CONCAT(begin_date,"-",DATE_FORMAT(end_date, "%d.%m.%Y")) AS  studyperiod, status, photo from 1_ochnoe
		WHERE code13 IS NOT NULL order by surname;';
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }
    function safePhotos(){
        $query = 'select img, id AS id, first_name AS name, last_name AS surname, code13 AS barcodes, departament AS groups2,  
		CONCAT(begin_date,"-",DATE_FORMAT(end_date, "%d.%m.%Y")) AS  studyperiod, status, photo from 1_ochnoe
		WHERE code13 IS NOT NULL and photo IS NOT NULL  order by surname;';
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }
}
