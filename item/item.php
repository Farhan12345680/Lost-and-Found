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
$gmail=$_SESSION['gmail'] ?? 'none';
    
$comments;
    
    if($gmail==$item['posterGmail']){
        $comments= PDO_::initializer()->fetchCommentsPoster($_GET['_id'] , $gmail);
    }
    else if($gmail!=='none'){
        $comments= PDO_::initializer()->fetchComments($_GET['_id'] , $gmail);
    }

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
    background: linear-gradient(to bottom, #f4f7fb, #eef2f7);
}

.item-wrapper {
    max-width: 1100px;
    margin: auto;
}

.item-card {
    border-radius: 18px;
}

.item-img {
    width:100%;
    height:100%;
    max-height:380px;
    object-fit:cover;
    border-radius:16px;
}

.status-pill {
    position:absolute;
    top:15px;
    left:15px;
    padding:6px 14px;
    border-radius:20px;
    font-size:14px;
    color:#fff;
}

.status-found { background:#0d6efd; }
.status-lost { background:#dc3545; }

.keyword-pill {
    background:#e7f1ff;
    color:#0d6efd;
    padding:5px 12px;
    border-radius:20px;
    text-decoration:none;
    font-size:13px;
}

.keyword-pill:hover {
    background:#0d6efd;
    color:white;
}

#map {
    height:280px;
    border-radius:16px;
}
</style>
</head>

<body>

<nav class="navbar navbar-dark bg-primary">
<div class="container">
<a href="../index.php" class="btn btn-outline-light btn-sm">Home</a>
<span class="navbar-text text-white fw-semibold">Item Details</span>
</div>
</nav>

<div class="container py-5 item-wrapper">

<div class="card item-card shadow-lg p-4">

<div class="row g-4 align-items-center">

<div class="col-md-5 position-relative">
<img src="<?= htmlspecialchars($item['imageURL']) ?>" class="item-img">

<span class="status-pill <?= $item['itemType']=='Found'?'status-found':'status-lost' ?>">
<?= htmlspecialchars($item['itemType']) ?>
</span>
</div>

<div class="col-md-7">

<h2 class="fw-bold text-primary mb-2"><?= htmlspecialchars($item['title']) ?></h2>

<p class="mb-1"><strong>Status:</strong> 
<span class="<?= $item['isResolved'] ? 'text-success':'text-danger' ?>">
<?= $item['isResolved'] ? 'Resolved':'Unresolved' ?>
</span>
</p>

<p class="mb-1"><strong>Location:</strong> <?= htmlspecialchars($item['location']) ?></p>

<p class="text-muted mt-3"><?= htmlspecialchars($item['description']) ?></p>

<div class="d-flex flex-wrap gap-2 my-3">
<?php
$keywords = explode(" ", $item['keywords']);
foreach($keywords as $k):
?>
<a class="keyword-pill" 
href="itemList.php?page=1&filter=<?= urlencode($k) ?>&type=<?= urlencode($item['itemType']) ?>">
<?= htmlspecialchars($k) ?>
</a>
<?php endforeach; ?>
</div>

<hr>

<p><strong>Posted by:</strong> <?= htmlspecialchars($item['posterGmail']) ?></p>

<div class="d-flex flex-wrap gap-2 mt-3">
<?php
$gmail = $_SESSION['gmail'] ?? 'none';

if($gmail !== $item['posterGmail']){
    echo '<a class="btn btn-primary px-4" href="../profile/profile.php?other_id='.$item['posterGmail'].'">Contact Poster</a>';
}

if($gmail === $item['posterGmail']){
    echo '<button class="btn btn-outline-success px-4">Mark as Resolved</button>';
}

if($gmail !== $item['posterGmail'] && $gmail !== 'none'){
    echo '<a class="btn btn-outline-secondary px-4" href='.$_SERVER['REQUEST_URI']."#Comments".'>Comment</a>';
}
?>
</div>

</div>
</div>

<hr class="my-4">

<h5 class="fw-semibold mb-2">Item Location</h5>
<div id="map"></div>

</div>

<div class="card p-3 shadow-sm mt-4">
    <?php
        if(isset($_POST['comment_submit']) && isset($_SESSION['gmail'])){
            PDO_::initializer()->addComment($_SESSION['gmail'] ,$item['posterGmail'] ,$_GET['_id'],$_POST);
            header("Location: ".$_SERVER['REQUEST_URI']);
            exit();
        }
        if($gmail !== $item['posterGmail'] && $gmail !== 'none'){
            $bytes=readfile("comment.html");
            
        }

    ?>

</div>
<div class="card p-3 shadow-sm mt-4">


    <?php if(!empty($comments)): ?>
        <div class="list-group">
            <?php foreach($comments as $c): ?>
                <div class="list-group-item list-group-item-light mb-2 rounded-3 shadow-sm">
                    <div class="d-flex justify-content-between align-items-center mb-1">
                        <span class="fw-semibold"><?= htmlspecialchars($c['sender_email']) ?></span>
                        <small class="text-muted"><?= date("d M Y H:i", strtotime($c['sent_at'])) ?></small>
                    </div>
                    <p class="mb-0"><?= nl2br(htmlspecialchars($c['message'])) ?></p>
                </div>
            <?php endforeach; ?>
    <?php else: ?>
        <p class="text-muted fst-italic">No comments yet. Be the first to comment!</p>
    <?php endif; ?>
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
