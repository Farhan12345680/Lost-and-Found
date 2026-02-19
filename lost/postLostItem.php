<?php
if(session_status() === PHP_SESSION_NONE){
    session_start();
}

if(!isset($_SESSION['user_id']) || !$_SESSION['user_id']){
    header("Location: ./../index.php");
    exit();
}

include_once __DIR__ . '/../database/create_initial_state.php';

$array = [];

if($_SERVER['REQUEST_METHOD'] === "POST" && isset($_POST['save'])){
    $_id = PDO_::initializer()->itemPost($_POST, $_FILES , 'Lost');
    header("Location: ./../item/item.php?_id=".$_id);
    exit();
}

if($_SERVER['REQUEST_METHOD'] === "POST" && isset($_POST['search'])){
    $array = PDO_::initializer()->SearchItem($_POST);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Lost Item</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://unpkg.com/maplibre-gl/dist/maplibre-gl.css" rel="stylesheet">

<style>
body { background:#f2f4f8; }

.card { border-radius:14px; }

#map {
  min-height: 380px;
  border-radius: 12px;
}

.section-title {
  font-weight:600;
  text-align:center;
  margin-bottom:1rem;
}

.form-control:focus {
  border-color:#1a73e8;
  box-shadow:0 0 0 .15rem rgba(26,115,232,.25);
}
</style>
</head>

<body>

<nav class="navbar navbar-dark bg-primary">
  <div class="container justify-content-between">
    <a href="../index.php" class="btn btn-outline-light btn-sm">Home</a>
    <span class="text-white fw-semibold">Lost Item Portal</span>
  </div>
</nav>

<div class="container py-4">

<div class="row g-4 align-items-stretch">

<div class="col-lg-5 col-md-12">
<div class="card shadow p-4 h-100">

<h5 class="section-title">Upload / Search Lost Item</h5>

<form method="POST" enctype="multipart/form-data">

<div class="mb-2">
<label>Gmail</label>
<input class="form-control" name="gmail" value="<?= $_SESSION['gmail']?>" readonly>
</div>

<div class="mb-2">
<label>Product Title</label>
<input class="form-control" name="ProductTitle">
</div>

<div class="mb-2">
<label>Product Keywords</label>
<input class="form-control" name="productKeywords">
</div>

<div class="mb-2">
<label>Location</label>
<input class="form-control" id="placeProduct" readonly>
</div>

<input type="hidden" name="location_name" id="location_name">
<input type="hidden" name="latitude" id="latitude">
<input type="hidden" name="longitude" id="longitude">

<div class="mb-2">
<label>Description</label>
<textarea class="form-control" rows="3" name="About"></textarea>
</div>

<div class="mb-3">
<label>Image</label>
<input class="form-control" type="file" name="imageFile">
</div>

<div class="d-grid gap-2">
<button class="btn btn-outline-danger" name="search">Search</button>
<button class="btn btn-primary" name="save">Save</button>
</div>

</form>
</div>
</div>

<div class="col-lg-7 col-md-12">
<div class="card shadow p-3 h-100">

<h5 id="Location_shown" class="text-center fw-semibold mb-2"></h5>
<div id="map"></div>

</div>
</div>

</div>

<?php if (!empty($array)): ?>

<hr class="my-4">

<h4 class="section-title">Search Results</h4>

<div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">

<?php foreach ($array as $item): ?>
<div class="col">

<a href="<?= './../item/item.php?_id='.$item['item_id'] ?>" class="text-decoration-none text-dark">

<div class="card h-100 shadow-sm">

<img src="<?= htmlspecialchars($item['imageURL']) ?>" 
     class="card-img-top" 
     style="height:200px;object-fit:cover;border-top-left-radius:14px;border-top-right-radius:14px;">

<div class="card-body d-flex flex-column">

<h5><?= htmlspecialchars($item['title']) ?></h5>
<p class="text-muted small flex-grow-1"><?= htmlspecialchars($item['description']) ?></p>

<div class="d-flex justify-content-between mt-2">
<span class="badge bg-primary"><?= htmlspecialchars($item['itemType']) ?></span>
<span class="badge <?= $item['isResolved'] ? 'bg-success' : 'bg-danger' ?>">
<?= $item['isResolved'] ? 'Resolved' : 'Unresolved' ?>
</span>
</div>

</div>
</div>

</a>

</div>
<?php endforeach; ?>

</div>
<?php endif; ?>

</div>

<script src="https://unpkg.com/maplibre-gl/dist/maplibre-gl.js"></script>

<script>
const defaultLng = 90.4125;
const defaultLat = 23.8103;

const map = new maplibregl.Map({
    container: 'map',
    style: 'https://tiles.openfreemap.org/styles/liberty',
    center: [defaultLng, defaultLat],
    zoom: 9
});

map.addControl(new maplibregl.NavigationControl());

const marker = new maplibregl.Marker({ draggable: true })
    .setLngLat([defaultLng, defaultLat])
    .addTo(map);

async function updateLocation(lat, lng) {
    const res = await fetch(`./../found/proxy.php?lat=${lat}&lng=${lng}`);
    const data = await res.json();

    let locationText = "";
    if (data.address?.quarter) locationText += data.address.quarter + ", ";
    if (data.address?.city) locationText += data.address.city + ", ";
    if (data.address?.country) locationText += data.address.country;

    document.getElementById("Location_shown").innerText = locationText;
    document.getElementById("placeProduct").value = lat + ", " + lng;
    document.getElementById("location_name").value = locationText;
    document.getElementById("latitude").value = lat;
    document.getElementById("longitude").value = lng;
}

updateLocation(defaultLat, defaultLng);

marker.on('dragend', () => {
    const p = marker.getLngLat();
    updateLocation(p.lat, p.lng);
});

map.on('click', (e) => {
    marker.setLngLat(e.lngLat);
    updateLocation(e.lngLat.lat, e.lngLat.lng);
});
</script>

</body>
</html>
