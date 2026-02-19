<?php 
    if(session_status() === PHP_SESSION_NONE){
        session_start();
    }

    if($_SERVER['REQUEST_METHOD']==="POST"){
        session_unset();
        session_destroy();
        header("Location: ./../index.php");
        exit();
    }
    $other_user=$_GET['other_id']??null;   
    
    if(!isset($_SESSION['user_id']) && $_SESSION['user_id'] && !$other_user ){
        header("Location: "."/../login/signUP.php");
        exit();
    }
    
    include_once __DIR__ . "/../database/create_initial_state.php";

    $user=PDO_::initializer()->giveOtherUserInfo($other_user);


    if(!$other_user){
        $user=PDO_::initializer()->giveUserInfo(); 
    }

    $_SESSION['userimage']=$user['imageURL'];

    
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile Page</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

    <nav class="navbar navbar-expand-lg navbar-dark bg-primary px-4">
        <a class="navbar-brand fw-bold" href="../index.php">Home</a>
    </nav>

    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">

                <div class="card shadow border-0">
                    <div class="card-body text-center">

                        <img src=<?= $user['imageURL'] ?>
                             class="rounded-circle mb-3" id="ProfileImage"
                             
                             width="150" height="150" alt="Profile">

                        <h3 class="fw-bold" id="name"><?= $user['name'] ?></h3>
                        <p class="text-muted" id="workTitle"><?= $user['workTitle'] ?></p>
                        <?php
                            if(!$other_user){
                                ?>
                                <a class=" btn btn-primary me-2" id="edit" href="update.php">Edit Profile</a>
                                    
                                <form style="display:inline" action="" method="POST">
                                <input style="display:inline" type='submit' value="Logout" class="btn btn-outline-danger" id="Logout">

                                </form>
                                <?php
                            }
                        ?>

                        <hr class="my-4">

                        <div class="row text-start px-3">
                            <div class="col-md-6 mb-3">
                                <label class="fw-bold">Email</label>
                                <div class="text-secondary" id="Email"><?= $user['email'] ?></div>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="fw-bold">Phone</label>
                                <div class="text-secondary" id="Phone"><?= $user['Phone'] ?></div>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="fw-bold">Address</label>
                                <div class="text-secondary" id="Address"><?= $user['Address'] ?></div>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="fw-bold">Joined</label>
                                <div class="text-secondary" id="JoinedDate"><?= $user['JoinedDate'] ?></div>
                            </div>
                        </div>

                        <hr class="my-4">

                        <h5 class="fw-bold text-start px-3">About Me</h5>
                        <p class="text-secondary px-3" id="Description">
                <?= $user['Description'] ?>                        </p>

                    </div>
                </div>

            </div>
        </div>
    </div>
    <script src="../javascript/profile.js" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
