<?php 
    function session_starter(){
        session_start();
        $_SESSION['gmail']=$_SESSION['gmail']??null;
        $_SESSION['password'] = $_SESSION['password'] ?? null;
        $_SESSION['userimage']=$_SESSION['userimage']??null;
        $_SESSION['username']=$_SESSION['username']??null;
        $_SESSION['user_id']=$_SESSION['user_id']??null;

    
    }
    include __DIR__ . "/database/create_initial_state.php";

    PDO_::initializer();
 

    if(session_status() === PHP_SESSION_NONE){
        session_starter();
    }   

    


    include_once __DIR__ . "/utility/user_emiter.php"; 

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>UIU Lost and Found</title>
    <link rel="icon" type="image/png" href="images/lost.png">
    <link rel="stylesheet" href="./css/index.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f4f6f8;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
        }

        #navbar {
            background-color: #1a73e8;
            color: white;
            padding: 12px 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 2px 6px rgba(0,0,0,0.2);
        }

        #navbar a {
            color: white;
            text-decoration: none;
            margin-left: 20px;
            font-weight: 500;
        }

        #navbar a:hover {
            text-decoration: underline;
        }

        #logoHolder {
            display: flex;
            align-items: center;
            font-weight: bold;
            font-size: 1.3rem;
        }

        #logoHolder img {
            width: 45px;
            margin-right: 12px;
        }

        #UserProfile {
            display: flex;
            align-items: center;
            gap: 10px;
            background-color: rgba(255,255,255,0.1);
            padding: 5px 10px;
            border-radius: 25px;
            transition: background 0.3s;
        }

        #UserProfile:hover {
            background-color: rgba(255,255,255,0.2);
        }

        #UserProfileText p {
            margin: 0;
            line-height: 1rem;
            font-size: 0.85rem;
        }

        #UserProfileImage {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            object-fit: cover;
        }

        #main-section {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 40px;
            padding: 60px 20px;
        }

        .card-item {
            background-color: white;
            border-radius: 15px;
            padding: 30px 20px;
            width: 280px;
            text-align: center;
            box-shadow: 0 8px 20px rgba(0,0,0,0.1);
            transition: transform 0.3s, box-shadow 0.3s;
        }

        .card-item:hover {
            transform: translateY(-5px);
            box-shadow: 0 12px 25px rgba(0,0,0,0.2);
        }

        .card-item img {
            width: 80px;
            height: 80px;
            object-fit: contain;
            margin-bottom: 20px;
        }

        .card-item h3 {
            margin-bottom: 20px;
            font-size: 1.2rem;
            color: #333;
        }

        .card-item .btn {
            margin: 5px 0;
            width: 100%;
            border-radius: 50px;
            padding: 10px 0;
            font-weight: 500;
        }

        .btn-primary {
            background-color: #1a73e8;
            border: none;
        }

        .btn-primary:hover {
            background-color: #155ab6;
        }

        .btn-outline-primary {
            border-color: #1a73e8;
            color: #1a73e8;
        }

        .btn-outline-primary:hover {
            background-color: #1a73e8;
            color: white;
        }

        @media(max-width: 600px){
            #main-section {
                flex-direction: column;
                align-items: center;
            }
        }
    </style>
</head>
<body>
<header id="navbar">
    <div id="logoHolder">
        <img src="lost.png" alt="Logo icon">
        Lost & Found
    </div>
    <?= emit_userbox() ?>
</header>

<section id="main-section">
    <div class="card-item">
        <img src="./lost.png" alt="Lost Items">
        <h3>Lost Items</h3>
        <a href="./html/lostItems.html" class="btn btn-primary">View Lost Items</a>
        <a href="./html/postLostitem.html" class="btn btn-outline-primary">Submit Lost Item</a>
    </div>

    <div class="card-item">
        <img src="./lost.png" alt="Found Items">
        <h3>Found Items</h3>
        <a href="./html/foundItems.html" class="btn btn-primary">View Found Items</a>
        <a href="./html/postFoundItem.html" class="btn btn-outline-primary">Submit Found Item</a>
    </div>
</section>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
