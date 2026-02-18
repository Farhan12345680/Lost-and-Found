<?php
if(session_status() === PHP_SESSION_NONE){
    session_start();
}

if(!isset($_GET['_id']) || !$_GET['_id']){
    header("Location: ./../index.php");
    exit();
}

include_once __DIR__ . '/../database/create_initial_state.php';
$item = PDO_::initializer()->fetchItem($_GET['_id']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Item Details</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://unpkg.com/maplibre-gl/dist/maplibre-gl.css" rel="stylesheet">

<style>
body {
    background: #f4f7fb;
}

.item-card {
    border-radius: 16px;
}

.item-img {
    object-fit: cover;
    height: 100%;
    max-height: 350px;
    border-radius: 12px;
}

.badge-found { background:#0d6efd; }
.badge-lost { background:#dc3545; }

.keyword-badge {
    background:#e7f1ff;
    color:#0d6efd;
    margin-right:5px;
    margin-bottom:5px;
}

#map {
    width:100%;
    height:250px;
    border-radius:12px;
}
</style>
</head>

<body>

<nav class="navbar navbar-dark" style="background-color:#1a73e8">
<div class="container-fluid">
<a href="../index.php" class="btn btn-outline-light btn-sm">Home</a>
</div>
</nav>

<div class="container py-5">

<div class="card item-card shadow-lg p-4">

<div class="row g-4">

<!-- IMAGE -->
<div class="col-md-5 position-relative">
<img src="<?= $item['imageURL']?>" class="img-fluid item-img w-100">
<span class="badge badge-found position-absolute top-0 start-0 m-3 px-3 py-2">
<?= htmlspecialchars($item['itemType']) ?>
</span>
</div>

<!-- DETAILS -->
<div class="col-md-7">

<h2 class="fw-bold text-primary mb-2"><?= htmlspecialchars($item['title']) ?></h2>

<p class="mb-1">
<strong>Status:</strong> 
<span class="text-success"><?= htmlspecialchars($item['isResolved']) ?></span>
</p>

<p class="mb-2">
<strong>Location:</strong> <?= htmlspecialchars($item['location']) ?>
</p>

<p class="text-muted mb-3">
<?= htmlspecialchars($item['description']) ?>
</p>

<!-- KEYWORDS -->
<div class="mb-3">
<?php
$keywords = explode(" ", $item['keywords']);
foreach($keywords as $k){
    echo "<span class='badge keyword-badge'>$k</span>";
}
?>
</div>

<hr>

<p><strong>Posted by:</strong> <?= htmlspecialchars($item['posterGmail']) ?></p>

<div class="d-flex flex-wrap gap-2">
<a class="btn btn-primary">Contact Poster</a>
<button class="btn btn-outline-primary">Mark as Resolved</button>
<button class="btn btn-outline-secondary">That's Mine</button>
</div>

</div>
</div>

<hr class="my-4">

<!-- MAP -->
<h5 class="mb-2">Item Location</h5>
<div id="map"></div>

</div>
</div>

<script src="https://unpkg.com/maplibre-gl/dist/maplibre-gl.js"></script>

<script>
const defaultLng = <?= $item['longitude']?>;
const defaultLat = <?= $item['latitude']?>;

const map = new maplibregl.Map({
    container: 'map',
    style: 'https://tiles.openfreemap.org/styles/liberty',
    center: [defaultLng, defaultLat],
    zoom: 14
});

map.addControl(new maplibregl.NavigationControl());

new maplibregl.Marker()
.setLngLat([defaultLng, defaultLat])
.addTo(map);
</script>

</body>
</html>
