<?php 
    if(session_status() === PHP_SESSION_NONE){
        header("Location: ./../index.php");
        exit();
    }   

    if(!isset($_SESSION['error'])){
        header("Location: "."/../index.php");
        exit();
    }
    
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Error</title>

    <style>
        * {
            box-sizing: border-box;
            font-family: "Segoe UI", sans-serif;
        }

        body {
            margin: 0;
            height: 100vh;
            background: linear-gradient(135deg, #ff5f6d, #ffc371);
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .card {
            background: white;
            padding: 30px 40px;
            border-radius: 12px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.2);
            text-align: center;
            width: 360px;
        }

        .card h1 {
            color: #e74c3c;
            margin-bottom: 15px;
        }

        .card p {
            color: #555;
            font-size: 16px;
            margin-bottom: 25px;
        }

        .card button {
            background: #3498db;
            color: white;
            border: none;
            padding: 12px 22px;
            border-radius: 6px;
            cursor: pointer;
            font-size: 15px;
            transition: 0.3s;
        }

        .card button:hover {
            background: #2980b9;
        }
    </style>
</head>

<body>

<div class="card">
    <h1>⚠ Error</h1>
    <p><?= $_GET['error'] ?></p>

    <form action="signUP.php">
        <button type="submit">Go Back</button>
    </form>
</div>

</body>
</html>
<?php 
    unset($_SESSION['error']);
?>