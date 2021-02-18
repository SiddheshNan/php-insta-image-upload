<?php
error_reporting(0);
session_start();
$valid_passwords = array("admin" => "admin");
$user = $_SERVER['PHP_AUTH_USER'];
$pass = $_SERVER['PHP_AUTH_PW'];
$valid_users = array_keys($valid_passwords);
$validated = (in_array($user, $valid_users)) && ($pass == $valid_passwords[$user]);
if (!$validated) {
  header('WWW-Authenticate: Basic realm="Please Enter Your Credentials"');
  header('HTTP/1.0 401 Unauthorized');
  session_destroy();
  die("Not Authorized");
  exit;
}
include("./db.php");

$sql = "SELECT * FROM uploads";
$result = $db->query($sql);
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
  <style>
    .img {
      height: 150px;
      width: '100%';
    }
  </style>
</head>

<body>
  <div class="container text-center">
    <h3 style="margin-top: 40px">Admin Page</h3>

    <table class="table mt-md-5">
      <thead>
        <tr>
          <th scope="col">Image</th>
          <th scope="col">Caption</th>
          <th scope="col">Tags</th>
          <th scope="col">Location</th>
          <th scope="col">Hashtags</th>
          <th scope="col">Facebook</th>
          <th scope="col">Twitter</th>
          <th scope="col">Tumbler</th>
          <th scope="col">Date</th>
          <th scope="col">Time</th>
        </tr>
      </thead>
      <tbody>
        <?php
        while ($row = $result->fetch_assoc()) {
          echo "<tr>";
          echo '<td><img src="./images/' . $row["image"] . '" class="img" alt="PBJeuSN1GgdURqYH"></td>';

          echo '<td>' . $row["caption"] . '</td>';
          echo '<td>' . $row["tags"] . '</td>';
          echo '<td>' . $row["location"] . '</td>';
          echo '<td>' . $row["hashtags"] . '</td>';

          echo '<td>' . ($row["facebook"] == 1 ? '<span class="badge badge-success">Yes</span>' : '<span class="badge badge-danger">No</span>') . '</td>';
          echo '<td>' . ($row["twitter"] == 1 ? '<span class="badge badge-success">Yes</span>' : '<span class="badge badge-danger">No</span>') . '</td>';
          echo '<td>' . ($row["tumbler"] == 1 ? '<span class="badge badge-success">Yes</span>' : '<span class="badge badge-danger">No</span>') . '</td>';

          echo '<td>' . $row["date"] . '</td>';
          echo '<td>' . $row["time"] . '</td>';

          echo "<tr>";
        }
        ?>


      </tbody>
    </table>
  </div>
</body>

</html>

<?php
session_destroy();
?>