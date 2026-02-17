<?php

function emit_userbox(): string{
    if($_SESSION['gmail']){
    return '<div class="d-flex align-items-center">
        <a id="UserProfile" href="./profile/profile.php">
            <div id="UserProfileText">
                <p id="UserProfileName">'.$_SESSION['username']. '</p>
                <p id="UserProfileGmail">'.$_SESSION['gmail'].'</p>
            </div>
            <img id="UserProfileImage" src='.$_SESSION['userimage'].' alt="user">
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