<?php 


    function check_user_jump() {
        if(check_annon()){
            include __DIR__.'/__controllers/show_login.php';
            show_login();
        }   
        include_once __DIR__."/match_user.php";
        if(!match_session_user()){
            include __DIR__.'/__controllers/show_login.php';
            show_login();
        
        }

    }


    function check_annon() {
        if(session_status() === PHP_SESSION_NONE){
            session_starter();
            return true;
        }   
        return false;        
    }


    function check_user() {
        // if(check_annon()){
        //     return false;
        // }   

        // include_once __DIR__."/match_user.php";
        // if(!match_session_user()){
        //     return false;
        // }


        return true;

    }



?>