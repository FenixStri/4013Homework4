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
            <th></th>
            <th></th>
          </tr>
        </thead>
        <tbody>
          
<?php
$sql = "SELECT cat_id, cat_breed, cat_lifeexpectancy from Cats";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
  // output data of each row
  while($row = $result->fetch_assoc()) {
?>
          
          <tr>
            <td><?=$row["cat_id"]?></td>
            <td><a href="cats2.php?id=<?=$row["cat_id"]?>"><?=$row["cat_breed"]?></a></td>
            <td>
              <button type="button" class="btn" data-bs-toggle="modal" data-bs-target="#editCat<?=$row["cat_id"]?>">
                Edit
              </button>
              <div class="modal fade" id="editCat<?=$row["cat_id"]?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="editCat<?=$row["cat_id"]?>Label" aria-hidden="true">
                <div class="modal-dialog">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h1 class="modal-title fs-5" id="editCat<?=$row["cat_id"]?>Label">Edit Cat</h1>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                      <form method="post" action="">
                        <div class="mb-3">
                          <label for="editCat<?=$row["cat_id"]?>Name" class="form-label">Name</label>
                          <input type="text" class="form-control" id="editCat<?=$row["cat_id"]?>Name" aria-describedby="editCat<?=$row["cat_id"]?>Help" name="iName" value="<?=$row['cat_breed']?>">
                          <div id="editCat<?=$row["cat_id"]?>Help" class="form-text">Enter the cat's breed.</div>
                        </div>
                        <input type="hidden" name="iid" value="<?=$row['cat_id']?>">
                        <input type="hidden" name="saveType" value="Edit">
                        <input type="submit" class="btn btn-primary" value="Submit">
                      </form>
                    </div>
                  </div>
                </div>
              </div>
            </td>
            <td>
              <form method="post" action="">
                <input type="hidden" name="iid" value="<?=$row["cat_id"]?>" />
                <input type="hidden" name="saveType" value="Delete">
                <input type="submit" class="btn" onclick="return confirm('Are you sure?')" value="Delete">
              </form>
            </td>
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
      <br />
      <!-- Button trigger modal -->
      <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addCat">
        Add New
      </button>

      <!-- Modal -->
      <div class="modal fade" id="addCat" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="addCatLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h1 class="modal-title fs-5" id="addCatLabel">Add Cat Breed</h1>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              <form method="post" action="">
                <div class="mb-3">
                  <label for="catName" class="form-label">Name</label>
                  <input type="text" class="form-control" id="catName" aria-describedby="nameHelp" name="iName">
                  <div id="nameHelp" class="form-text">Enter the cat's breed.</div>
                </div>
                <input type="hidden" name="saveType" value="Add">
                <button type="submit" class="btn btn-primary">Submit</button>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-A3rJD856KowSb7dwlZdYEkO39Gagi7vIsF0jrRAoQmDKKtQBHUuLZ9AsSv4jD4Xa" crossorigin="anonymous"></script>
  </body>
</html>
