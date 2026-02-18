<?php
    if(session_status() === PHP_SESSION_NONE){
        session_start();
        $_SESSION['gmail']=$_SESSION['gmail']??null;
        $_SESSION['password'] = $_SESSION['password'] ?? null;
        $_SESSION['userimage']=$_SESSION['userimage']??null;
        $_SESSION['username']=$_SESSION['username']??null;
        $_SESSION['user_id']=$_SESSION['user_id']??null;
    }  
    include_once __DIR__ . "/../database/create_initial_state.php";



function emit_userbox(): string{
    if(isset($_SESSION['user_id'])){
    $user=PDO_::initializer()->giveUserInfo();
    $_SESSION['userimage']=$user['imageURL'];
    return '<div class="d-flex align-items-center">
        <a id="UserProfile" href="./profile/profile.php">
            <div id="UserProfileText">
                <p id="UserProfileName">'.htmlspecialchars($_SESSION['username']). '</p>
                <p id="UserProfileGmail">'.htmlspecialchars($_SESSION['gmail']).'</p>
            </div>
            <img id="UserProfileImage" src='.htmlspecialchars($_SESSION['userimage']).' alt="user">
        </a>
    </div>'; 
    }
    return '<div class="d-flex align-items-center">
        <a href="./login/signUP.php" id="signUP" class="btn btn-light btn-sm" style="background-color: green;">Sign Up</a>
        <a id="UserProfile" href="./login/signUP.php">
            <div id="UserProfileText">
                <p id="UserProfileName">User</p>
                <p id="UserProfileGmail">none</p>
            </div>
            <img id="UserProfileImage" src="https://res.cloudinary.com/dvpwqtobj/image/upload/v1757076286/user_xhxvc9.png" alt="user">
        </a>
    </div>';
}




?>