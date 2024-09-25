$loadfile = $_POST['file_name']; // получаем имя загруженного файла
require_once $_SERVER['DOCUMENT_ROOT']."/Classes/PHPExcel/IOFactory.php"; // подключаем класс для доступа к файлу
$objPHPExcel = PHPExcel_IOFactory::load($_SERVER['DOCUMENT_ROOT']."/uploads/".$loadfile);
foreach ($objPHPExcel->getWorksheetIterator() as $worksheet) // цикл обходит страницы файла
{
  $highestRow = $worksheet->getHighestRow(); // получаем количество строк
  $highestColumn = $worksheet->getHighestColumn(); // а так можно получить количество колонок

  for ($row = 1; $row <= $highestRow; ++ $row) // обходим все строки
  {
    $cell1 = $worksheet->getCellByColumnAndRow(0, $row); //Фамилия
    $cell2 = $worksheet->getCellByColumnAndRow(1, $row); //Имя
    $cell3 = $worksheet->getCellByColumnAndRow(2, $row); //Статус
    $cell4 = $worksheet->getCellByColumnAndRow(3, $row); //Должность
    $cell5 = $worksheet->getCellByColumnAndRow(4, $row); //Подразделение
    $cell6 = $worksheet->getCellByColumnAndRow(5, $row); //Штрих код
	$cell7 = $worksheet->getCellByColumnAndRow(5, $row); //Путь к фото
    $sql = "INSERT INTO `price` (`secondname`,`firstname`,`status`,`position`,`departament`,`code13`,`img`) VALUES
('$cell1','$cell2','$cell3','$cell4','$cell5','$cell6','$cell7')";
    $query = mysql_query($sql) or die('Ошибка чтения записи: '.mysql_error());
  }
}