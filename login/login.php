<?php
    if(session_status() === PHP_SESSION_NONE){
        session_start();

    }   
    if(isset($_SESSION['gmail']) && $_SESSION['gmail']!=='none'){
        header("Location: ./../profile/profile.php");
        exit();
    }
    
    include_once __DIR__."/../database/create_initial_state.php";

$message = "";
$status = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $email = trim($_POST['email'] ?? "");
    $password = trim($_POST['password'] ?? "");

    $result=PDO_::initializer()->checkLogin($email, $password);
            if ($result['status'] === "error") {
                $status = "error";
                $message = $result['message'];
                $_SESSION['error']=$message;
                header("Location: error_page.php");
                exit();
            } else {
                $status = "success";
                $message = "Account created successfully!";
                header("Location: ./../index.php");
                exit();
            }

}

?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign In</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        #modal{
            width: 40vw;
            height: 40vh;
            position: absolute !important;
            margin: 50% 50%;
            z-index: 2;
            font-size:2rem ;
            background-color: white;
            text-align: center;
            align-content: center;
            box-sizing: border-box;
            border: 1px dashed black;
            margin: 2rem;
            display: none;
        }
        body {
            height: 100vh;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            background: #f1f5f9;
        }

        .card {
            border-radius: 18px;
            padding: 30px 35px;
            box-shadow: 0 8px 25px rgba(0,0,0,0.08);
        }

        .title {
            font-weight: 700;
        }

        .btn-primary {
            border-radius: 30px;
        }
    </style>
</head>

<body>
    <div id="modal">
        <p id="ppp"></p>
    <button id="modalButton" class="btn btn-primary ">Close Modal</button>
    </div>
    <div class="container" style="max-width: 420px;">
        <div class="card">

            <h3 class="text-center title mb-1">Welcome Back</h3>
            <p class="text-center text-muted mb-4">Sign in to continue</p>

            <form id='form1' action='' method='POST' enctype="multipart/form-data">

                <div class="mb-3">
                    <label for="email" class="form-label">Email Address</label>
                    <input type="email" name="email" class="form-control" id="emailInput" placeholder="Enter email">
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" name="password" class="form-control" id="passwordInput" placeholder="Enter password">
                </div>

                <button type="submit" id="Save" class="btn btn-primary w-100 mt-2" >Sign In</button>
            </form>

        </div>
    </div>

</body>
</html>
