<?php require_once('header.php');?>
    
<?php
$servername = "localhost";
$username = "fenixouc_suser";
$password = "tAp!bGKJh9u7";
$dbname = "fenixouc_database1";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
$sNumber = $_POST['sNumber'];

$sql = "update section set section_number=? where section_id=?";
//echo $sql;
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("si", $sNumber, $_POST['iid']);
    $stmt->execute();
?>
    
    <h1>Edit Instructor</h1>
<div class="alert alert-success" role="alert">
  Instructor edited.
</div>
    <a href="instructors.php" class="btn btn-primary">Go back</a>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-A3rJD856KowSb7dwlZdYEkO39Gagi7vIsF0jrRAoQmDKKtQBHUuLZ9AsSv4jD4Xa" crossorigin="anonymous"></script>
  </body>
</html>
