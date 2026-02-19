<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$page = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
$filter = $_GET['filter'] ?? '';
$type= $_GET['type']??'Found';

include_once __DIR__ . "/../database/create_initial_state.php";

$page_count = PDO_::initializer()->getMaxPageCount($type, $filter);

$page = min($page_count ,$page );

$arrays = PDO_::initializer()->getCurrentPage($page, $type, $filter);
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
}

.crumbs {
    display: flex;
    flex-wrap: wrap;
    gap: 8px;
    margin-bottom: 20px;
}

.crumbs a {
    padding: 6px 14px;
    font-size: 0.85rem;
    text-decoration: none;
    background: #e9ecef;
    color: #333;
    border-radius: 20px;
    border: 1px solid #ccc;
    transition: all 0.2s ease;
}

.crumbs a:hover {
    background: #0d6efd;
    color: white;
}

.active-crumb {
    background: #0d6efd !important;
    color: white !important;
    font-weight: bold;
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
}
</style>
</head>

<body>

<header id="navbar">
    <div><strong>Lost and Found</strong></div>
    <div>
        <a href="../index.php">Home</a>
        <a href="../profile/profile.php">Profile</a>
    </div>
</header>

<div class="container my-4">

    <h3 class="mb-3"><?= $type ?> Items</h3>

    <form action="foundItems.php" method="GET" class="mb-3">
        <input type="hidden" name="page" value="1">

        <div class="input-group">
            <input type="text"
                   class="form-control"
                   name="filter"
                   placeholder="Search items..."
                   value="<?= htmlspecialchars($filter) ?>">
            <button class="btn btn-primary" type="submit">Search</button>
        </div>
    </form>

    <div class="crumbs">
        <?php
        $keywords = ['laptop','fruit','folder','id','charger','tiffin','notebook'];

        foreach ($keywords as $k) {
            $active = ($filter === $k) ? 'active-crumb' : '';
            echo "<a class='$active' href='foundItems.php?page=1&filter=" . urlencode($k) . "&type=".urlencode($type)."'>$k</a>";
        }
        ?>
        <a href="foundItems.php?page=1&filter=" class="text-danger fw-bold">Clear</a>
    </div>

    <div class="row g-4">
        <?php if (!empty($arrays)): ?>
            <?php foreach ($arrays as $item): ?>
                <div class="col-md-4">
                    <a href="<?= './../item/item.php?_id=' . $item['item_id'] ?>" class="text-decoration-none text-dark">
                        <div class="card h-100">
                            <img src="<?= htmlspecialchars($item['imageURL']) ?>" class="card-img-top" alt="<?= htmlspecialchars($item['title']) ?>">
                            <div class="card-body d-flex flex-column">
                                <h5 class="card-title"><?= htmlspecialchars($item['title']) ?></h5>
                                <p class="card-text text-muted"><?= htmlspecialchars($item['description']) ?></p>
                                <div class="mt-auto">
                                    <span class="badge bg-primary"><?= htmlspecialchars($item['itemType']) ?></span>
                                    <span class="ms-2 text-success">
                                        <?= $item['isResolved'] ? 'Resolved' : 'Unresolved' ?>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p class="text-center text-muted">No items found.</p>
        <?php endif; ?>
    </div>

    <div class="d-flex justify-content-center gap-3 my-4">

        <?php if ($page > 1): ?>
            <a href="foundItems.php?page=<?= $page-1 ?>&filter=<?= urlencode($filter) ?>&type=<?= urlencode($type)?>"
               class="btn btn-outline-primary">Prev</a>
        <?php endif; ?>

        <span class="align-self-center fw-bold">
            Page <?= $page ?> of <?= max($page_count,1) ?>
        </span>

  
            <a href="foundItems.php?page=<?= $page+1 ?>&filter=<?= urlencode($filter) ?>&type=<?= urlencode($type)?>"
               class="btn btn-outline-primary">Next</a>


    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
