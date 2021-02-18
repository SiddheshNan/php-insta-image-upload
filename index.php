<?php
session_start();
include("./db.php");

function generateRandomString($length = 10)
{
  $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
  $charactersLength = strlen($characters);
  $randomString = '';
  for ($i = 0; $i < $length; $i++) {
    $randomString .= $characters[rand(0, $charactersLength - 1)];
  }
  return $randomString;
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {

  $error = false;

  $facebook = 0;
  $twitter = 0;
  $tumbler = 0;
  if (isset($_POST['facebook'])) $facebook = 1;
  if (isset($_POST['twitter'])) $twitter = 1;
  if (isset($_POST['tumbler'])) $tumbler = 1;

  $caption = NULL;
  $tag = NULL;
  $hashtags = NULL;
  $location = NULL;


  if (isset($_POST['caption']) && $_POST['caption'] !== "")
    $caption =  mysqli_real_escape_string($db, $_POST['caption']);


  if (isset($_POST['tag']) && $_POST['tag'] !== "")
    $tag =  mysqli_real_escape_string($db, $_POST['tag']);

  if (isset($_POST['location']) && $_POST['location'] !== "")
    $location =  mysqli_real_escape_string($db, $_POST['location']);

  if (isset($_POST['hashtags']) && $_POST['hashtags'] !== "")
    $hashtags =  mysqli_real_escape_string($db, $_POST['hashtags']);


  $date =  mysqli_real_escape_string($db, $_POST['date']);
  $time =  mysqli_real_escape_string($db, $_POST['time']);

  $mainimg = $_FILES['imgInp']['tmp_name'];
  $imgpath = dirname(__FILE__) . '/./images/';
  $extension = pathinfo($_FILES['imgInp']['name'], PATHINFO_EXTENSION);

  $filename_final = generateRandomString(16) . '.' . $extension;

  move_uploaded_file($mainimg, $imgpath . $filename_final);

  $sql = "INSERT INTO `uploads` (`caption`, `tags`, `location`, `hashtags`, `facebook`, `twitter`, `tumbler`, `date`, `time`, `image`)
   VALUES ('{$caption}', '{$tag}' , '{$location}', '{$hashtags}', '{$facebook}' , '{$twitter}', '{$tumbler}', '{$date}', '{$time}', '{$filename_final}')";

  if (mysqli_query($db, $sql)) {
    echo "<script> alert('Success'); </script>";
  } else {
    echo "Error: " . $sql . "<br>" . mysqli_error($db);
  }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Instagram Post</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
  <style>
    #img {
      height: 200px;
      width: '100%';
      margin: 50px;
    }
  </style>
  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
</head>

<body>
  <div class="container  text-center">
    <h3 style="margin-top: 40px">Instagram Post</h3>
    <form class="border border-danger mt-md-5" enctype="multipart/form-data" method="POST">
      <div class="row p-4 m-6">
        <div class="col-sm border border-dark">
          <img id="img" src="data:image/gif;base64,R0lGODlhAQABAIAAAP///wAAACH5BAEAAAAALAAAAAABAAEAAAICRAEAOw==" alt="your image" />
          <div class="form-group">
            <input id="imgInp" name="imgInp" type="file" accept="image/*" class="btn btn-info form-control-file" required />
          </div>
        </div>
        <div class="col-sm">
          <div class="form-group">
            <textarea class="form-control border-dark" name="caption" rows="3" placeholder="Caption"></textarea>
          </div>
          <div class="form-group border-dark">
            <div class="btn-toolbar mb-2" role="toolbar">
              <div class="btn-group mr-2" role="group">
                <button onclick="addTaggedName('Ajay')" type="button" class="btn btn-secondary">Ajay</button>
              </div>
              <div class="btn-group mr-2" role="group">
                <button onclick="addTaggedName('Ranveer')" type="button" class="btn btn-secondary">Ranveer</button>
              </div>
              <div class="btn-group mr-2" role="group">
                <button onclick="addTaggedName('Akhsay')" type="button" class="btn btn-secondary">Akhsay</button>
              </div>
              <div class="btn-group mr-2" role="group">
                <button onclick="addTaggedName('Dipika')" type="button" class="btn btn-secondary">Dipika</button>
              </div>
              <div class="btn-group" role="group">
                <button onclick="addTaggedName('Rani')" type="button" class="btn btn-secondary">Rani</button>
              </div>

            </div>
            <textarea class="form-control border-dark" name="tag" id="tag" rows="3" placeholder="Tag People"></textarea>
          </div>

          <div class="form-group row border-dark">
            <label for="location" class="col-sm-2 col-form-label">Location</label>
            <div class="col-sm-10">
              <input type="text" class="form-control border-dark" maxlength="128" name="location" placeholder="Lonavala, Pune">
            </div>
          </div>

          <div class="form-group">
            <textarea class="form-control border-dark" name="hashtags" rows="3" placeholder="#HashTags"></textarea>
          </div>


          <div class="form-check form-check-inline mb-3 mt-1">
            <input class="form-check-input" type="checkbox" id="facebook" name="facebook" value="facebook" />
            <label class="form-check-label" for="facebook">facebook</label>
          </div>
          <div class="form-check form-check-inline">
            <input class="form-check-input" type="checkbox" id="twitter" name="twitter" value="twitter" />
            <label class="form-check-label" for="twitter">twitter</label>
          </div>
          <div class="form-check form-check-inline">
            <input class="form-check-input" type="checkbox" id="tumbler" name="tumbler" value="tumbler" />
            <label class="form-check-label" for="tumbler">tumbler</label>
          </div>

          <div class="container mb-4">
            <div class="row">
              <div class="col-sm">
                <input type="date" class="form-control border-dark" name="date" placeholder="Date Picker" required />
              </div>
              <div class="col-sm">
                <input type="time" class="form-control border-dark" name="time" placeholder="Time Picker" required />
              </div>

            </div>
          </div>

          <button type="button" onclick="close_window();" class="btn btn-danger mt-2 text-center float-right ml-2">Cancel</button>
          <button type="submit" class="btn btn-success mt-2 text-center float-right">Submit</button>
        </div>

      </div>





    </form>




  </div>

  <script>
    const addTaggedName = (name) => {
      document.getElementById("tag").value += (name + ", ");
    }

    function close_window() {
      if (confirm("Exit Page?")) {
        window.location.href = "https://google.com";
      }
    }


    const readURL = (input) => {
      if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function(e) {
          $('#img').attr('src', e.target.result);
        }

        reader.readAsDataURL(input.files[0]);
      }
    }

    $("#imgInp").change(function() {
      readURL(this);
    });
  </script>
</body>

</html>