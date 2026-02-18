<?php
if(session_status() === PHP_SESSION_NONE){
    session_start();
}

if(!isset($_SESSION['user_id']) || !$_SESSION['user_id']){
    header("Location: ./../index.php");
    exit();
}

include_once __DIR__ . '/../database/create_initial_state.php';

if($_SERVER['REQUEST_METHOD'] === "POST"){
    $_id=PDO_::initializer()->itemPost($_POST, $_FILES , 'Found');
    header("Location: ./../item/item.php?_id=".$_id);
    exit();

}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Upload Found Item</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://unpkg.com/maplibre-gl/dist/maplibre-gl.css" rel="stylesheet">

<style>
body { background-color: #e9ecef; }

.form-control {
  border: 2px solid #333;
  box-shadow: none;
}

.form-control:focus {
  border-color: #1a73e8;
  box-shadow: 0 0 0 0.2rem rgba(26,115,232,.25);
}

.card { background-color: #f8f9fa; }

#map {
  width: 100%;
  height: 100%;
  min-height: 400px;
  border: 1px solid #ccc;
  border-radius: 5px;
}

.container { max-width: 1200px; }
</style>
</head>

<body>

<nav class="navbar navbar-dark" style="background-color:#1a73e8">
  <div class="container-fluid">
    <a href="../index.php" class="btn btn-outline-light btn-sm">Home</a>
  </div>
</nav>

<div class="container mt-5">
<h4 class="mb-4 text-center">Upload Found Item</h4>

<div class="row g-4 justify-content-center">

<div class="col-md-5 col-lg-5">
<form action="" method="POST" class="card p-3 shadow-sm" id="UploadFormData" enctype="multipart/form-data">

<label>User Gmail</label>
<input class="form-control mb-2" type="text" value="<?= $_SESSION['gmail']?>" name="gmail" readonly>

<label>Product Title</label>
<input class="form-control mb-2" type="text" name="ProductTitle">

<label>Product Keywords</label>
<input class="form-control mb-2" type="text" name="productKeywords">

<label>Found Location (Click on Map)</label>
<input class="form-control mb-2" type="text" id="placeProduct" readonly>

<input type="hidden" name="location_name" id="location_name">
<input type="hidden" name="latitude" id="latitude">
<input type="hidden" name="longitude" id="longitude">

<label>About</label>
<textarea class="form-control mb-2" rows="3" name="About"></textarea>

<label>Upload Product Image</label>
<input class="form-control mb-3" type="file" name="imageFile">

<button class="btn btn-primary w-100">Save</button>

</form>
</div>

<div class="col-md-5 col-lg-5">
<h4 id="Location_shown"></h4>
<div id="map" style="min-height:350px;border-radius:5px;"></div>
</div>

</div>
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
    try {
        const res = await fetch(`proxy.php?lat=${lat}&lng=${lng}`);
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

    } catch (err) {
        console.error("Error fetching location:", err);
        document.getElementById("Location_shown").innerText = "Error fetching location";
    }
}

updateLocation(defaultLat, defaultLng);

marker.on('dragend', () => {
    const lngLat = marker.getLngLat();
    updateLocation(lngLat.lat, lngLat.lng);
});

map.on('click', (e) => {
    const lngLat = e.lngLat;
    marker.setLngLat(lngLat);
    updateLocation(lngLat.lat, lngLat.lng);
});
</script>

</body>
</html>
