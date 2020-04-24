<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
  	<title>Torino Snake game</title>
    <?php require('./template/header.php') ?>
  </head>
  <body>
    <div class="container">
      <h2>Player name: <strong class="playerName"></strong></h2>
      <p style="font-size: 30px;">HighScore: <span id="highScore">0 (name)</span></p>
      <p style="font-size: 30px;">Score: <span id="score">0</span></p>
      <div class="row">
        <div class="col-lg-2"></div>
        <div class="col-lg-8">
          <canvas id="gameCanvas" width="1000" height="400"></canvas>
        </div>
      </div>
    </div>
  </body>
  <?php require('./template/footer.php') ?>
</html>