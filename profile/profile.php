<?php 
    if(session_status() === PHP_SESSION_NONE){
        session_start();
    }   

    if(!isset($_SESSION['user_id']) && $_SESSION['user_id']){
        header("Location: "."/../login/signUP.php");
        exit();
    }


    



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
        <a class="navbar-brand fw-bold" href="../index.html">Home</a>
    </nav>

    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">

                <div class="card shadow border-0">
                    <div class="card-body text-center">

                        <img src="../images/lost.png"
                             class="rounded-circle mb-3" id="ProfileImage"
                             width="150" height="150" alt="Profile">

                        <h3 class="fw-bold" id="name">John Doe</h3>
                        <p class="text-muted" id="workTitle">Frontend Developer</p>

                        <a class=" btn btn-primary me-2" id="edit" href="update.html">Edit Profile</a>
                            
                        <!-- <a href="chatting.html" id="chat" class="btn btn-primary me-2">Chat</a> -->

                        <button class="btn btn-outline-danger" id="Logout">Logout</button>

                        <hr class="my-4">

                        <div class="row text-start px-3">
                            <div class="col-md-6 mb-3">
                                <label class="fw-bold">Email</label>
                                <div class="text-secondary" id="Email">johndoe@example.com</div>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="fw-bold">Phone</label>
                                <div class="text-secondary" id="Phone">+880 1712 345678</div>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="fw-bold">Address</label>
                                <div class="text-secondary" id="Address">Dhaka, Bangladesh</div>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="fw-bold">Joined</label>
                                <div class="text-secondary" id="JoinedDate">January 2025</div>
                            </div>
                        </div>

                        <hr class="my-4">

                        <h5 class="fw-bold text-start px-3">About Me</h5>
                        <p class="text-secondary px-3" id="Description">
                            Passionate web developer with experience in HTML, CSS,
                            JavaScript, and Bootstrap. Love building beautiful UI.
                        </p>

                    </div>
                </div>

            </div>
        </div>
    </div>
    <script src="../javascript/profile.js" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
