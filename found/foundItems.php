<?php
    if(session_status() === PHP_SESSION_NONE){
        session_start();
    }   



?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Found Items</title>

    <link rel="icon" type="image/png" href="../images/lost.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>

        .crumbs {
            margin-top: 10px;
            display: flex;
            flex-wrap: wrap;
            gap: 8px;

            opacity: 1;
            transform: translateY(0);
            max-height: 200px;

            transition:
                opacity 0.25s ease,
                transform 0.25s ease,
                max-height 0.25s ease;
        }

        .crumbs.hidden {
            opacity: 0;
            transform: translateY(-6px);
            max-height: 0;
            overflow: hidden;
            pointer-events: none;
        }

        .crumbs a {
            display: inline-block;
            padding: 6px 12px;
            font-size: 0.85rem;
            text-decoration: none;

            background: #e9ecef;
            color: #333;

            border-radius: 20px;
            border: 1px solid #dee2e6;

            transition:
                background 0.2s ease,
                color 0.2s ease,
                transform 0.15s ease;
        }

        .crumbs a:hover {
            background: #0d6efd;
            color: #fff;
            transform: translateY(-1px);
        }

        .crumbs a.active {
            background: #0d6efd;
            color: #fff;
            border-color: #0d6efd;
        }


        #breadcrumb a.crumb {
            margin-right: 10px;
            text-decoration: none;
            color: #0d6efd;
        }

        #breadcrumb a.crumb::after {
            content: "›";
            margin-left: 10px;
            color: #999;
        }

        #breadcrumb a.crumb:last-child::after {
            content: "";
        }
        body {
            background-color: #f8f9fa;
            font-size: 14px;
        }

        
        #navbar {
            background-color: #1a73e8;
            color: white;
            padding: 8px 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        #navbar a {
            color: white;
            text-decoration: none;
            margin-left: 12px;
            font-size: 0.9rem;
        }

        #logoHolder {
            display: flex;
            align-items: center;
            font-weight: 600;
            font-size: 1rem;
        }

        #logoHolder img {
            width: 32px;
            margin-right: 8px;
        }

        .container {
            max-width: 1100px;
        }

        #searchInput {
            font-size: 0.9rem;
            padding: 8px;
        }

        .card {
            border-radius: 10px;
        }

        .card-img-top {
            height: 110px;
            object-fit: cover;
        }

        .card-body {
            padding: 12px;
        }

        .card-title {
            font-size: 0.95rem;
            margin-bottom: 5px;
        }

        .card-text {
            font-size: 0.85rem;
            margin-bottom: 4px;
        }

        .text-muted {
            font-size: 0.8rem;
        }
        .card-img-top {
    height: 220px;
    object-fit: cover;
}

.card-img-top {
    height: 220px;
    object-fit: cover;
    border-radius: 8px 8px 0 0;
}

.card {
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    border-radius: 10px;
    box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
}

.card:hover {
    transform: translateY(-8px);
    box-shadow: 0 12px 30px rgba(0, 0, 0, 0.25);
}

    </style>
</head>

<body>

<header id="navbar">
    <div id="logoHolder">
        <img src="../images/lost.png" alt="Logo">
        Lost and Found
    </div>
    <div>
        <a href="../index.html">Home</a>
        <a href="profile.html">Profile</a>
    </div>
</header>

<div class="container my-4">
    <div id="breadcrumb" class="mb-3">
        <a style="text-decoration:none" href="foundItems.php" target="_self">Found Items</a>
    </div>

<div class="mb-3">
    <input
        type="text"
        id="searchInput"
        class="form-control"
        placeholder="Search items..."
    >

<div id="crumbContainer" class="crumbs">
    <a  class ='lp' href="http://localhost:5500/html/foundItems.html?id=+laptop" 
       style="display:inline-block; padding:6px 14px; font-size:0.85rem; text-decoration:none; 
              background:#0d6efd; color:#ffffff; border-radius:20px; border:1px solid #0d6efd; 
              transition: background 0.2s ease, transform 0.15s ease, box-shadow 0.2s ease;">
        laptop
    </a>
    <a class="lp" href="http://localhost:5500/html/foundItems.html?id=+fruit" 
       style="display:inline-block; padding:6px 14px; font-size:0.85rem; text-decoration:none; 
              background:#0d6efd; color:#ffffff; border-radius:20px; border:1px solid #0d6efd; 
              transition: background 0.2s ease, transform 0.15s ease, box-shadow 0.2s ease;">
        fruit
    </a>
    <a class="lp" href="http://localhost:5500/html/foundItems.html?id=+folder" 
       style="display:inline-block; padding:6px 14px; font-size:0.85rem; text-decoration:none; 
              background:#0d6efd; color:#ffffff; border-radius:20px; border:1px solid #0d6efd; 
              transition: background 0.2s ease, transform 0.15s ease, box-shadow 0.2s ease;">
        folder
    </a>
    <a class="lp" href="http://localhost:5500/html/foundItems.html?id=+id" 
       style="display:inline-block; padding:6px 14px; font-size:0.85rem; text-decoration:none; 
              background:#0d6efd; color:#ffffff; border-radius:20px; border:1px solid #0d6efd; 
              transition: background 0.2s ease, transform 0.15s ease, box-shadow 0.2s ease;">
        id
    </a>
    <a class='lp' href="http://localhost:5500/html/foundItems.html?id=+Charger" 
       style="display:inline-block; padding:6px 14px; font-size:0.85rem; text-decoration:none; 
              background:#0d6efd; color:#ffffff; border-radius:20px; border:1px solid #0d6efd; 
              transition: background 0.2s ease, transform 0.15s ease, box-shadow 0.2s ease;">
        charger
    </a>
    <a class="lp" href="http://localhost:5500/html/foundItems.html?id=+tiffin" 
       style="display:inline-block; padding:6px 14px; font-size:0.85rem; text-decoration:none; 
              background:#0d6efd; color:#ffffff; border-radius:20px; border:1px solid #0d6efd; 
              transition: background 0.2s ease, transform 0.15s ease, box-shadow 0.2s ease;">
        tiffin
    </a>
    <a class="lp" href="http://localhost:5500/html/foundItems.html?id=+notebook" 
       style="display:inline-block; padding:6px 14px; font-size:0.85rem; text-decoration:none; 
              background:#0d6efd; color:#ffffff; border-radius:20px; border:1px solid #0d6efd; 
              transition: background 0.2s ease, transform 0.15s ease, box-shadow 0.2s ease;">
        notebook
    </a>
    <a class="lp" href="http://localhost:5500/html/foundItems.html?id=+notebook" 
       style="display:inline-block; padding:6px 14px; font-size:0.85rem; text-decoration:none; 
              background:#0d6efd; color:#ffffff; border-radius:20px; border:1px solid #0d6efd; 
              transition: background 0.2s ease, transform 0.15s ease, box-shadow 0.2s ease;">
        notebook
    </a>
</div>

</div>

    <div class="row g-3" id="itemsContainer">


</div>
<script>
    const link = document.querySelectorAll('.lp');

    link.forEach(element => 
    {
        const url = new URL(element.href);
        
        const params = new URLSearchParams(window.location.search);
        const secondParams= new URLSearchParams(url.search);

        const curr = params.get("id") || "";
        const secCurr = secondParams.get('id') || "";
        
        params.set("id" , curr+secCurr);
        
        url.search=params.toString();
        element.href=url.toString();
        console.log(url.toString());

    });


</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="../javascript/foundItems.js" defer></script>
<script>

</script>

</body>
</html>
