<?php
class Func
{
    private $conn;
    public $id;
	public $first_name;
	public $last_name;
	public $code13;

    public function __construct($db)
    {
        $this->conn = $db;
    }


// Create
function createPerson()
{
	$name = $_POST['first_name'];
	$last_name = $_POST['last_name'];
	$code13 = $_POST['code13'];
if (isset($_POST['submit'])) {
	$sql = ("INSERT INTO `users`(`name`, `last_name`, `pos`) VALUES(?,?,?)");
	$query = $this->conn->prepare($sql);
	$query->execute([$name, $last_name, $code13]);
	$success = '<div class="alert alert-success alert-dismissible fade show" role="alert">
  <strong>Данные успешно отправлены!</strong> Вы можете закрыть это сообщение.
  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
</div>';
	return $success;
}
}

// Read
function getPerson()
{
	$query = "SELECT * FROM `1_ochnoe` order by departament";
	$stmt = $this->conn->prepare($query);
	$stmt->execute();
	return $stmt;
}

function getPersonCol()
{
	$query = "SELECT * FROM `colege`";
	$stmt = $this->conn->prepare($query);
	$stmt->execute();
	return $stmt;
}

// Update
function updatePerson()
{
$edit_name = @$_POST['edit_name'];
$edit_last_name = @$_POST['edit_last_name'];
$edit_pos = @$_POST['edit_pos'];
$get_id = @$_GET['id'];
if (isset($_POST['edit-submit'])) {
	$sqll = "UPDATE 1_ochnoe SET first_name=?, last_name=?, code13=? WHERE id=?";
	$querys = $this->conn->prepare($sqll);
	$querys->execute([$edit_name, $edit_last_name, $edit_pos, $get_id]);
	header('Location: '. $_SERVER['HTTP_REFERER']);
}
}

// DELETE
function deletePerson()
{
if (isset($_POST['delete_submit'])) {
	$sql = "DELETE FROM users WHERE id=?";
	$query = $this->conn->prepare($sql);
	$query->execute([$get_id]);
	header('Location: '. $_SERVER['HTTP_REFERER']);
}
}
}
