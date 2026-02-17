<?php
    if(session_status() === PHP_SESSION_NONE){
        header("Location: ./../index.php");
        exit();
    }   


$message = "";
$status = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $name = trim($_POST['name'] ?? "");
    $email = trim($_POST['email'] ?? "");
    $password = trim($_POST['password'] ?? "");

    if ($name === "" || $email === "" || $password === "") {
        $status = "error";
        $message = "All fields are required.";
        $_SESSION['error']=$message;
        header("Location: error_page.php");
        exit();
    } else {
        $result = NewUser(['name'=>$name,'email'=>$email,'password'=> $password]); 
        if ($result['status'] === "error") {
            $status = "error";
            $message = $result['message'];
            header("Location: error_page.php?error=".$message);
            exit();
        } else {
            $status = "success";
            $message = "Account created successfully!";
            header("Location: ./../index.php?error=".urlencode($message));
            exit();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Sign Up</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
html, body {
    height: 100%;
    margin: 0;
    background: #f1f5f9;
    display: flex;
    justify-content: center;
    align-items: center;
}

.signup-card {
    background: #fff;
    border-radius: 18px;
    padding: 40px 35px;
    box-shadow: 0 8px 25px rgba(0,0,0,0.08);
    width: 100%;
    max-width: 420px;
}

.btn-primary, .btn-outline-primary {
    border-radius: 30px;
}
#modal {
    display: <?= $message ? "block" : "none" ?>;
    position: fixed;
    top: 50%;
    left: 50%;
    transform: translate(-50%,-50%);
    background: #fff;
    padding: 25px 30px;
    border-radius: 12px;
    box-shadow: 0 6px 20px rgba(0,0,0,0.15);
    text-align: center;
}
</style>
</head>

<body>

<div id="modal">
    <p><?= htmlspecialchars($message) ?></p>
    <button onclick="document.getElementById('modal').style.display='none'" class="btn btn-primary">Close</button>
</div>

<div class="signup-card">
<h3 class="text-center mb-1">Create Account</h3>
<p class="text-center text-muted mb-4">Sign up to continue</p>

<form method="POST">

<div class="mb-3">
<label>Full Name</label>
<input type="text" name="name" class="form-control" placeholder="Enter full name" required>
</div>

<div class="mb-3">
<label>Email</label>
<input type="email" name="email" class="form-control" placeholder="Enter email" required>
</div>

<div class="mb-3">
<label>Password</label>
<input type="password" name="password" class="form-control" placeholder="Enter password" required>
</div>

<button type="submit" class="btn btn-primary w-100 mt-2">Sign Up</button>
<a href="login.html" class="btn btn-outline-primary w-100 mt-3">Already have an account? Sign In</a>

</form>
</div>

</body>
</html>
