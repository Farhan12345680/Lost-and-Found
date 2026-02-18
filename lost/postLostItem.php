<?php
    if(session_status() === PHP_SESSION_NONE){
        session_start();
    }   

    if(!isset($_SESSION['user_id'])  ){
        header("Location: ./../index.php");
        exit();
    }
    if(!$_SESSION['user_id']){
        header("Location: ./../index.php");
        exit();
    }

?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Post Found Item</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://unpkg.com/maplibre-gl/dist/maplibre-gl.js" defer></script>
  <link href="https://unpkg.com/maplibre-gl/dist/maplibre-gl.css" rel="stylesheet"/>
  <style>
    body {
      background-color: #e9ecef;
    }

    .form-control {
      border: 2px solid #333;
      box-shadow: none;
    }

    .form-control:focus {
      border-color: #1a73e8;
      box-shadow: 0 0 0 .2rem rgba(26,115,232,.25);
    }

    .result-img {
      height: 120px;
      object-fit: cover;
    }
  </style>
</head>

<body>

<nav class="navbar navbar-dark" style="background-color:#1a73e8">
  <div class="container-fluid">
    <a href="../index.php" class="btn btn-outline-light btn-sm">Home</a>
  </div>
</nav>

<div class="container mt-5">
  <div class="row g-4">

    <div class="col-md-5">
      <form action="" method="POST" class="card p-4 shadow-sm" id="FOUND_FORM" enctype="multipart/form-data">
        <h5 class="mb-3">Upload a Lost item Description</h5>

        <label for="gmail">User Gmail</label>
        <input class="form-control mb-2" type="text" value="gmail" name='gmail' id="gmail" readonly>
        <input class="form-control mb-2" type="text" value="LOST" name='type' id="gmail" readonly>

        <label for="ProductTitle">Product title</label>
        <input class="form-control mb-2" type="text" placeholder="Product Title" id="ProductTitle" name="ProductTitle">
        <label for="productKeywords">Product Keys</label>

        <input class="form-control mb-2" type="text" placeholder="write space seperated keywords" id="productKeywords" name="productKeywords">
        <label for="placeProduct">Found Location</label>
        <input class="form-control mb-2" type="text" placeholder="Product Title" id="placeProduct" name="placeProduct">

        <label for="About">About</label>
        
        <textarea class="form-control mb-2" rows="3" placeholder="Write something the product" id="About" name="About"></textarea>
        <label for="imageFile" class="">Upload Product Image</label>

        <input class="form-control mb-3" type="file" id='imageFile' name="imageFile" text="Upload profile image">
        <button class="btn btn-outline-primary w-100" style="margin-bottom: 5px;" id="Search">Search</button>
        <button class="btn btn-primary w-100" id="Save">Save</button>
      </form>
    </div>

    <div class="col-md-7">
      <div class="card p-3 shadow-sm">
        <h6 class="mb-3">Relevant Products</h6>

        <div class="row g-3" id="itemsContainer">



        </div>
      </div>
    </div>

  </div>
</div>

<script src="../javascript/postlostItems.js" defer></script>
</body>
</html>