<?php
if(session_status() === PHP_SESSION_NONE){
    session_start();
}   
if(!isset($_GET['page']) || ((int)$_GET['page'])<1){
    header("Location: foundItems.php?page=1");
    exit();
}
include_once __DIR__ . "/../database/create_initial_state.php";
$page_count = PDO_::initializer()->getMaxPageCount('Found');
$page = (int)$_GET['page'];
if($page > $page_count){
    header("Location: foundItems.php?page=".$page_count);
    exit();
}
$arrays = PDO_::initializer()->getCurrentPage($page ,"Found");
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
body {
    background-color: #f8f9fa;
    font-family: "Segoe UI", sans-serif;
}

#navbar {
    background-color: #1a73e8;
    color: white;
    padding: 10px 20px;
    display: flex;
    align-items: center;
    justify-content: space-between;
}

#navbar a {
    color: white;
    text-decoration: none;
    margin-left: 12px;
    font-size: 0.95rem;
}

#logoHolder {
    display: flex;
    align-items: center;
    font-weight: 600;
    font-size: 1.1rem;
}

#logoHolder img {
    width: 32px;
    margin-right: 8px;
}

.container {
    max-width: 1100px;
}

#searchInput {
    font-size: 0.95rem;
    padding: 8px;
    margin-bottom: 15px;
}

.crumbs {
    display: flex;
    flex-wrap: wrap;
    gap: 6px;
    margin-bottom: 20px;
}

.crumbs a {
    display: inline-block;
    padding: 6px 14px;
    font-size: 0.85rem;
    text-decoration: none;
    background: #0d6efd;
    color: #fff;
    border-radius: 20px;
    border: 1px solid #0d6efd;
    transition: background 0.2s ease, transform 0.15s ease, box-shadow 0.2s ease;
}

.crumbs a:hover {
    background: #0954b1;
    transform: translateY(-2px);
}

.card {
    border-radius: 10px;
    box-shadow: 0 6px 18px rgba(0,0,0,0.12);
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.card:hover {
    transform: translateY(-5px);
    box-shadow: 0 12px 30px rgba(0,0,0,0.2);
}

.card-img-top {
    height: 200px;
    object-fit: cover;
    border-radius: 10px 10px 0 0;
}

.card-title {
    font-size: 1rem;
    margin-bottom: 6px;
}

.card-text {
    font-size: 0.85rem;
    margin-bottom: 5px;
}

.card-body .badge {
    font-size: 0.75rem;
    margin-right: 5px;
}
</style>
</head>

<body>

<header id="navbar">
    <div id="logoHolder">
        <img src="../lost.png" alt="Logo">
        Lost and Found
    </div>
    <div>
        <a href="../index.php">Home</a>
        <a href="../profile/profile.php">Profile</a>
    </div>
</header>

<div class="container my-4">


    <div id="breadcrumb">
        <a href="foundItems.php" class="fw-bold text-primary">Found Items</a>
    </div>


    <input type="text" id="searchInput" class="form-control" placeholder="Search items...">

    <div id="crumbContainer" class="crumbs">
        <?php
        $keywords = ['laptop','fruit','folder','id','charger','tiffin','notebook'];
        foreach($keywords as $k){
            echo "<a href='foundItems.php?id=+$k'>$k</a>";
        }
        ?>
    </div>

    <div class="row g-4" id="itemsContainer">
        <?php
        $chunks = array_chunk($arrays, 3);
        foreach($chunks as $rowItems){
            foreach($rowItems as $item){
        ?>
        <div class="col-md-4">
            <a href="<?= './../item/item.php?_id='.$item['item_id'] ?>" class="text-decoration-none text-dark">
                <div class="card h-100">
                    <img src="<?= htmlspecialchars($item['imageURL']) ?>" class="card-img-top" alt="<?= htmlspecialchars($item['title']) ?>">
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title"><?= htmlspecialchars($item['title']) ?></h5>
                        <p class="card-text text-muted"><?= htmlspecialchars($item['description']) ?></p>
                        <div class="mt-auto">
                            <span class="badge <?= $item['itemType']=='Found'?'bg-primary':'bg-danger' ?>">
                                <?= htmlspecialchars($item['itemType']) ?>
                            </span>
                            <span class="text-success ms-2"><?= htmlspecialchars($item['isResolved']) ?></span>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        <?php
            }
        }
        ?>
    </div>

</div>
<div class="container d-flex justify-content-center gap-3 my-4">
    <?php if($page > 1): ?>
        <a href="foundItems.php?page=<?= $page-1 ?>" class="btn btn-primary">Prev</a>
    <?php endif; ?>
    
    
        <a href="foundItems.php?page=<?= $page+1 ?>" class="btn btn-primary">Next</a>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
</script>

</body>
</html>
