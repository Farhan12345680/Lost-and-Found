<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BD Crop</title>
    <link rel="icon" type="image/x-icon" href="./Bangladesh.png">
</head>
<body>
    <?php

        readfile("Bangladesh District svg.svg");
    ?>

    <div >
        <canvas id = "myChart">  </canvas>
    </div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>


 <script>
      const myChart = document.getElementById('myChart');

      new Chart(myChart, {
    type: 'bar',
    data: {
      labels: ['Red', 'Blue', 'Yellow', 'Green', 'Purple', 'Orange'],
      datasets: [{
        label: '# of Votes',
        data: [12, 19, 3, 5, 2, 3],
        borderWidth: 1
      }]
    },
    options: {
      scales: {
        y: {
          beginAtZero: true
        }
      }
    }
  });
</script>
</body>
</html>