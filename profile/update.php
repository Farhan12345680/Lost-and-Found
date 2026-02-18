<?php
    if(session_status() === PHP_SESSION_NONE){
        session_start();
    }   

    if(!isset($_SESSION['user_id']) && $_SESSION['user_id']){
        header("Location: "."/../login/signUP.php");
        exit();
    }


    include_once __DIR__ . "/../database/create_initial_state.php";

    if($_SERVER['REQUEST_METHOD']==='POST'){
      PDO_::initializer()->UpdateUser($_POST ,$_FILES);
      header("Location: profile.php");
      exit();
    }



    $user=PDO_::initializer()->giveUserInfo(); 




?>



<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Edit Profile</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    .form-control {
      border: 2px solid #333; 
      box-shadow: none;       
    }

    .form-control:focus {
      border-color: #1a73e8; 
      box-shadow: 0 0 0 0.2rem rgba(26, 115, 232, 0.25);
    }

    .card {
      background-color: #f8f9fa; 
    }

    body {
      background-color: #e9ecef; 
    }
  </style>
</head>
<body>

<nav class="navbar navbar-dark" style="background-color: #1a73e8">
  <div class="container-fluid">
    <div>
      <a href="../index.html" class="btn btn-outline-light btn-sm me-2">Home</a>
      <a href="./profile.html" class="btn btn-outline-light btn-sm">Back</a>
    </div>
  </div>
</nav>

<div class="container mt-5">
  <div class="row justify-content-center">
    <div class="col-md-6">

      <form action="" method="POST" class="card p-4 shadow-sm" id="UpdateFormData" enctype="multipart/form-data">
        <h5 class="mb-3">Edit Profile</h5>
        <input class="form-control mb-2" type="text" value=<?= $user['email']?>                         name='gmail' id="gmail" readonly>
        <input class="form-control mb-2" type="text" value=<?= $user['workTitle']?> placeholder="Work Title" id="WorkTitle" name="WorkTitle">
        <input class="form-control mb-2" type="text" value=<?= $user['Phone']?> placeholder="Phone Number" id="PhoneNumber" name="PhoneNumber">
        <input class="form-control mb-2" type="text" value=<?= $user['Address']?> placeholder="Address" id="Address" name="Address">

        <textarea class="form-control mb-2" rows="3"  placeholder="About Me" id="AboutMe" name="AboutMe"><?= $user['Description']?></textarea>
        <label for="imageFile" class="">Upload Profile Image</label>

        <input class="form-control mb-3" type="file" name="imageFile" text="Upload profile image">

        <button class="btn btn-primary w-100" id="Save">Save</button>
      </form>

    </div>
  </div>
</div>
  <!-- <script src="../javascript/update.js"></script> -->
</body>
</html>
