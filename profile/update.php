<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['user_id']) || !$_SESSION['user_id']) {
    header("Location: ../login/signUP.php");
    exit();
}

include_once __DIR__ . "/../database/create_initial_state.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    PDO_::initializer()->UpdateUser($_POST, $_FILES);
    header("Location: update.php");
    exit();
}

$user = PDO_::initializer()->giveUserInfo();
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Edit Profile</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
body {
    background: linear-gradient(to right, #e3f2fd, #f8f9fa);
}

.profile-card {
    border-radius: 15px;
}

.profile-img {
    width: 140px;
    height: 140px;
    object-fit: cover;
    border-radius: 50%;
    border: 3px solid #1a73e8;
    margin-bottom: 15px;
}

.form-control:focus {
    border-color: #1a73e8;
    box-shadow: 0 0 0 0.2rem rgba(26,115,232,.25);
}
</style>
</head>

<body>

<nav class="navbar navbar-dark" style="background-color:#1a73e8;">
  <div class="container">
    <a href="../index.php" class="btn btn-outline-light btn-sm">Home</a>
    <a href="profile.php" class="btn btn-outline-light btn-sm">Back</a>
  </div>
</nav>

<div class="container mt-5">
  <div class="row justify-content-center">
    <div class="col-md-6">

      <div class="card shadow profile-card p-4">

        <div class="text-center">
          <img src="<?= htmlspecialchars($user['imageURL']) ?>" class="profile-img" alt="Profile Image">
          <h5 class="mt-2">Edit Your Profile</h5>
          <hr>
        </div>

        <form method="POST" enctype="multipart/form-data">

          <div class="mb-3">
            <label class="form-label">Email</label>
            <input class="form-control" type="text" 
                   value="<?= htmlspecialchars($user['email']) ?>" 
                   name="gmail" readonly>
          </div>

          <div class="mb-3">
            <label class="form-label">Work Title</label>
            <input class="form-control" type="text" 
                   value="<?= htmlspecialchars($user['workTitle']) ?>" 
                   name="WorkTitle" placeholder="Your job title">
          </div>

          <div class="mb-3">
            <label class="form-label">Phone Number</label>
            <input class="form-control" type="text" 
                   value="<?= htmlspecialchars($user['Phone']) ?>" 
                   name="PhoneNumber" placeholder="Your phone number">
          </div>

          <div class="mb-3">
            <label class="form-label">Address</label>
            <input class="form-control" type="text" 
                   value="<?= htmlspecialchars($user['Address']) ?>" 
                   name="Address" placeholder="Your address">
          </div>

          <div class="mb-3">
            <label class="form-label">About Me</label>
            <textarea class="form-control" rows="3" name="AboutMe" placeholder="Write something about yourself"><?= htmlspecialchars($user['Description']) ?></textarea>
          </div>

          <div class="mb-4">
            <label class="form-label">Profile Image</label>
            <input class="form-control" type="file" name="imageFile">
          </div>

          <button type="submit" class="btn btn-primary w-100">Save Changes</button>

        </form>

      </div>

    </div>
  </div>
</div>

</body>
</html>
