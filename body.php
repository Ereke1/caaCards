<?php
include_once 'ean13.php';
include_once "database.php";
include_once "card.php";

$database=new Database;
$db = $database->getConnectionMysql();
$card = new Card($db);
//$id = $_GET['id'];
$id=1;
$student = array();
$stmt = $card->getforid($id);
while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
    extract($row);
    ?>
    <table>
        <tr>
            <td>
                ATY/NAME<br>
                <?=$name?> <br>
                TEGI/SURNAME<br>
                <?=$surname?><br>
                BITIRGEN JYLY/YEAR OF ISSUE:<br>
                <?=$studyperiod?>
            </td>
        </tr>
        
    </table>


   <?php
}
