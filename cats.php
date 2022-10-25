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
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  switch ($_POST['saveType']) {
    case 'Add':
      $sqlAdd = "insert into Cats (cat_breed) value (?)";
      $stmtAdd = $conn->prepare($sqlAdd);
      $stmtAdd->bind_param("s", $_POST['iName']);
      $stmtAdd->execute();
      echo '<div class="alert alert-success" role="alert">New cat breed added.</div>';
      break;
    case 'Edit':
      $sqlEdit = "update Cats set cat_breed=? where cat_id=?";
      $stmtEdit = $conn->prepare($sqlEdit);
      $stmtEdit->bind_param("si", $_POST['iName'], $_POST['iid']);
      $stmtEdit->execute();
      echo '<div class="alert alert-success" role="alert">Cat edited.</div>';
      break;
    case 'Delete':
      $sqlDelete = "delete from Cats where cat_id=?";
      $stmtDelete = $conn->prepare($sqlDelete);
      $stmtDelete->bind_param("i", $_POST['iid']);
      $stmtDelete->execute();
      echo '<div class="alert alert-success" role="alert">Cat deleted.</div>';
      break;
  }
}
?>
    
      <h1>Cats</h1>
      <table class="table table-striped">
        <thead>
          <tr>
            <th>ID</th>
            <th>Cat Breed</th>
            <th>Life Expectancy(years)</th>
            <th></th>
          </tr>
        </thead>
        <tbody>
          
<?php
$sql = "SELECT cat_id, cat_breed, cat_lifeexpectancy from Cats";
$result = $conn->query($sql);

$sql = "SELECT cat_id, cat_breed, cat_lifeexpectancy from Cats";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
  // output data of each row
  while($row = $result->fetch_assoc()) {
?>
  <tr>
    <td><?=$row["cat_id"]?></td>
    <td><?=$row["cat_breed"]?></td>
    <td><?=$row["cat_lifeexpectancy"]?></td>
  </tr>
<?php
  }
} else {
  echo "0 results";
}
$conn->close();
?>
  </tbody>
    </table>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-A3rJD856KowSb7dwlZdYEkO39Gagi7vIsF0jrRAoQmDKKtQBHUuLZ9AsSv4jD4Xa" crossorigin="anonymous"></script>
  </body>
</html>
