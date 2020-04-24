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
      <div class="row">
        <div class="col-lg-2"></div>
        </div class="col-lg-8">
          <div class="row">
            <div class="col-lg-12">
              <div class="card mt-5 card-border">
                <div class="card-body">
                  <h1>Welcome to Papathors Snake Game</h1><hr>
                  <p>Would you like to play? Enter your name first!</p>
                  <div class="form-group">
                    <input type="text" class="form-control" name="name" placeholder="Enter name">
                  </div>
                  <div class="form-group">
                    <button type="button" class="btn btn-success play-now" data-url="<?= $config['base_url']?>game.php">Play!</button>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </body>
  <?php require('./template/footer.php') ?>
</html>