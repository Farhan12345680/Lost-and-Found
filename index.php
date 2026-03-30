<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BD Crop</title>
    <link rel="icon" type="image/x-icon" href="./Bangladesh.png">
    <link rel="stylesheet" href="./css/component.css">
    <link rel="stylesheet" href="./css/index.css">
</head>
<body>



    <?php

        readfile("navbar.php");
    ?>

<div class="container">
  <div class="card image-card">
    <img src="./paddy-harvest.webp" alt="A picture of farmers">
  </div>

  <div class="card map-card">
    <h3>Select a District</h3>
    <h3 id="district_name"></h3>
    <?php readfile("Bangladesh District svg.svg"); ?>
  </div>
</div>



<script >
  let path = document.querySelectorAll("path");
  path.forEach((element) => {
    element.style.fill="white";
    element.style.stroke = "black";
    element.style.strokeWidth = "0.5";

    element.addEventListener("mouseover" ,(e)=>{
      element.style.fill="black";
      district_name.textContent=element.id; 
    });

    element.addEventListener("mouseleave" ,(e)=>{
      element.style.fill="white";
    });

  });

  let path1 = document.querySelectorAll("g>g");
  
  path1.forEach((element)=>{
    element.style.fill="white";
    element.style.stroke = "black";
    element.style.strokeWidth = "0.5";

    element.addEventListener("mouseover" ,(e)=>{
        element.style.fill="black";

        district_name.textContent=element.id; 
        
        let ui = element.children;

        Array.from(ui).forEach((element)=>{
          element.style.fill="black";
        });

    });

    element.addEventListener("mouseleave" ,(e)=>{
      element.style.fill="white";
      district_name.textContent=element.id;
        
      let ui = element.children;

      Array.from(ui).forEach((element)=>{
          element.style.fill="white";
        });
    });
    

  });





  
</script>
</body>
</html>