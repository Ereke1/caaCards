<?php
include_once 'ean13.php';
include_once "database.php";
include_once "card.php";
require('tfpdf.php');
/*$dir='upload';
$files=scandir($dir);
//var_dump($files);
$rez=explode(".",$files[3]);
$rez2=explode(" ",$rez[0]);
echo $rez2[1];*/



$database = new Database;
$db = $database->getConnectionMysql();
$card = new Card($db);
$stmtAllPdf = $card->getall();

if(isset($_POST['safePhotos'])){
    $stmt = $card->safePhotos();
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        extract($row);
        if (strlen($photo) != 0) {
            file_put_contents("img/" . $surname . "_" . $name . ".jpeg", $photo);
        }
    }
}

if (isset($_POST['createOnePdf']) || isset($_POST['createAllPdf'])) {

    if (isset($_POST['createOnePdf'])) {
        $stmtOnePdf = $card->getforid($_POST['idforpdf']);
        $stmt = $stmtOnePdf;
    } elseif (isset($_POST['createAllPdf'])) {
        $stmt = $stmtAllPdf;
    }

    $no_foto_txt = 'upload/no_foto.txt';
    $spisok_txt = 'upload/spisok.txt';

    if (file_exists($no_foto_txt))
        unlink('upload/no_foto.txt');

    if (file_exists($spisok_txt))
        unlink('upload/spisok.txt');

    $pdf = new tFPDF('L', 'mm', array(54, 86));

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        extract($row);
        $image="img/" . $surname . "_" . $name . ".jpeg";
        if (strlen($image) == 0 || file_exists($image) == false || strlen($photo) == 0) {
            echo "ФОТО ЖОҚ -" . $surname . " " . $name . "<br>";
            $no_foto = 'upload/no_foto.txt';
            $zapis2 = ($surname . " " . $name . "\n");
            file_put_contents($no_foto, $zapis2, FILE_APPEND);
            continue;
            //$img="image/png.png";
        }

        $barcode = new Barcode($barcodes, 3);
        $barcode->save($barcodes . ".png");
       
        $pdf->AddPage();
        $pdf->Image('template.png', -1, -1, 88);

        $pdf->AddFont('DejaVu', '', 'DejaVuSansCondensed.ttf', true);
        $pdf->AddFont('DejaVu', 'B', 'DejaVuSansCondensed-Bold.ttf', true);
        $pdf->SetFont('DejaVu', '', 14);

        //$img = explode(',',$photo,2)[1];
        //$pic = 'data://text/plain;base64,'. $img;
        //echo $photo;
        //file_put_contents('photo.jpeg', base64_encode($photo));

        $pdf->Image($image, 3, 11, 19, 0);
        $pdf->SetFont('DejaVu', '', 5);
        // Move to the right
        $pdf->Cell(12, 0.7, '', 0, 1, 'L');
        $pdf->Cell(12, 0.7, '', 0, 1, 'L');
        $pdf->Cell(12, 0.7, '', 0, 1, 'L');

        $pdf->Cell(12);
        // Title
        $pdf->Cell(12, 1.5, 'ATY/NAME', 0, 1, 'L');
        $pdf->SetFont('DejaVu', 'B', 10);
        $pdf->Cell(12, 0.7, '', 0, 1, 'L');
        $pdf->Cell(12);
        $pdf->Cell(12, 1.5, $name, 0, 1, 'L');
        $pdf->Cell(12);
        $pdf->Cell(12, 0.7, '', 0, 1, 'L');
        $pdf->Cell(12);
        $pdf->SetFont('DejaVu', '', 5);
        $pdf->Cell(12, 1.5, 'TEGI/SURNAME', 0, 1, 'L');
        $pdf->SetFont('DejaVu', 'B', 10);
        $pdf->Cell(12);
        $pdf->Cell(12, 0.7, '', 0, 1, 'L');
        $pdf->Cell(12);
        $pdf->Cell(12, 1.5, $surname, 0, 1, 'L');
        $pdf->SetFont('DejaVu', '', 5);
        $pdf->Cell(12);
        $pdf->Cell(12, 0.7, '', 0, 1, 'L');
        $pdf->Cell(12);
        $pdf->Cell(12, 1.5, 'MARTEBESI/STATUS', 0, 1, 'L');
        // Add a Unicode font (uses UTF-8)
        $pdf->SetFont('DejaVu', 'B', 8);
        $pdf->Cell(12);
        $pdf->Cell(12, 0.7, '', 0, 1, 'L');
        $pdf->Cell(12);
        $pdf->Cell(12, 1.5, $status, 0, 1, 'L');
        $pdf->SetFont('DejaVu', '', 5);
        $pdf->Cell(12);
        $pdf->Cell(12, 0.7, '', 0, 1, 'L');
        $pdf->Cell(12);
        $pdf->Cell(12, 1.5, 'TOBY/GROUP', 0, 1, 'L');
        $pdf->SetFont('DejaVu', 'B', 8);
        $pdf->Cell(12);
        $pdf->Cell(12, 0.7, '', 0, 1, 'L');
        $pdf->Cell(12);
        $pdf->Cell(12, 1.5, $groups2, 0, 1, 'L');
        $pdf->SetFont('DejaVu', '', 5);
        $pdf->Cell(12);
        $pdf->Cell(12, 0.7, '', 0, 1, 'L');
        $pdf->Cell(12);
        $pdf->Cell(12, 1.5, 'OQY KEZENI/STUDY PERIOD', 0, 1, 'L');
        $pdf->SetFont('DejaVu', 'B', 6);
        $pdf->Cell(12);
        $pdf->Cell(12, 0.7, '', 0, 1, 'L');
        $pdf->Cell(12);
        $pdf->Cell(12, 1.5, $studyperiod, 0, 1, 'L');

        $pdf->Image($barcodes . ".png", 2, 38, 40);

        $filename = 'upload/' . $id . ".pdf";
        if (isset($_POST['createOnePdf'])) {
            $pdf->Output($filename, 'D');
            break;
        } 
       
        $spisok = 'upload/spisok.txt';
        $zapis = ($surname . " " . $name . "\n");
        file_put_contents($spisok, $zapis, FILE_APPEND);
        //echo $surname ." ".$name." готова <br>";$success = '<div class="alert alert-success alert-dismissible fade show" role="alert">
        if (isset($_POST['createOnePdf'])) {
            $pdfCreated =  'Файл: "' . $id . " " . $surname . " " . $name . '.pdf" создана';
        } elseif (isset($_POST['createAllPdf'])) {
            $pdfCreated =  'Файлы pdf созданы';
        }
        unlink($barcodes . ".png");
    }
    if (isset($_POST['createAllPdf'])) {
            $pdf->Output("allStudents.pdf", 'D');
        }
}
/*if (strlen($img)==0 || file_exists($img)==false){
		$p='naruto.png';
		$f=imagecreatefrompng("$p");
		Header("Content-type: image/png");
		Imagepng($f);;
	}*/

function getImage($dataURI)
{
    $img = explode(',', $dataURI, 2);
    $pic = 'data://text/plain;base64,' . $img[1];
    $type = explode("/", explode(':', substr($dataURI, 0, strpos($dataURI, ';')))[1])[1]; // get the image type
    if ($type == "png" || $type == "jpeg" || $type == "gif") return array($pic, $type);
    return false;
}
