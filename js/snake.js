const GLOBALSNAKE = {

  EVENTS: () => {
    const settings = {
      gameSpeed: 50,
      borderColor: 'black',
      backGroundColor: 'white',
      snakeColor: 'white',
      snakeBorderColor: 'darkgreen',
      targetEatColor: 'yellow',
      targetEatBorderColor: 'darkred',
    };
    let actions = {
      snake: [
        { x: 150, y: 150 },
        { x: 140, y: 150 },
        { x: 130, y: 150 },
        { x: 120, y: 150 },
        { x: 110, y: 150 }
      ],
      score: 0,
      changingDirection: false,
      foodX: null,
      foodY: null,
      dx: 10,
      dy: 0,
    };
    const gameCanvas = document.getElementById("gameCanvas");
    const ctx = gameCanvas.getContext("2d");
    const didGameEnd = () => {
      for (let i = 4; i < actions.snake.length; i++) {
        if (actions.snake[i].x === actions.snake[0].x && actions.snake[i].y === actions.snake[0].y) return true
      }
      const hitLeftWall = actions.snake[0].x < 0;
      const hitRightWall = actions.snake[0].x > gameCanvas.width - 10;
      const hitToptWall = actions.snake[0].y < 0;
      const hitBottomWall = actions.snake[0].y > gameCanvas.height - 10;
      return hitLeftWall || hitRightWall || hitToptWall || hitBottomWall;
    };
    const clearCanvas = () => {
      ctx.fillStyle = settings.backgroundColor;
      ctx.strokestyle = settings.borderColor;
      ctx.fillRect(0, 0, gameCanvas.width, gameCanvas.height);
      ctx.strokeRect(0, 0, gameCanvas.width, gameCanvas.height);
    };
    const drawFood = () => {
      ctx.fillStyle = settings.targetEatColor;
      ctx.strokestyle = settings.targetEatBorderColor;
      ctx.fillRect(actions.foodX, actions.foodY, 10, 10);
      ctx.strokeRect(actions.foodX, actions.foodY, 10, 10);
    };
    const advanceSnake = () => {
      const head = {x: actions.snake[0].x + actions.dx, y: actions.snake[0].y + actions.dy};
      actions.snake.unshift(head);
      const didEatFood = actions.snake[0].x === actions.foodX && actions.snake[0].y === actions.foodY;
      if (didEatFood) {
        actions.score += 1;
        document.getElementById('score').innerHTML = actions.score;
        createFood();
      } else {
        actions.snake.pop();
      }
    };
    const drawSnakePart = (snakePart) => {
      ctx.fillStyle = settings.snakeColor;
      ctx.strokestyle = settings.snakeBorderColor;
      ctx.fillRect(snakePart.x, snakePart.y, 10, 10);
      ctx.strokeRect(snakePart.x, snakePart.y, 10, 10);
    };
    const drawSnake = () => {
      actions.snake.forEach(drawSnakePart)
    };

    const randomNumbers = (min, max) => {
      return Math.round((Math.random() * (max - min) + min) / 10) * 10;
    };
    const createFood = () => {
      actions.foodX = randomNumbers(0, gameCanvas.width - 10);
      actions.foodY = randomNumbers(0, gameCanvas.height - 10);
      actions.snake.forEach((part) => {
        const foodIsoNsnake = part.x == actions.foodX && part.y == actions.foodY;
        if (foodIsoNsnake) createFood();
      });
    };
    const changeDirection = (event) => {
      const keys = {
        leftKey: 37,
        rightKey: 39,
        upKey: 38,
        downKey: 40,
      };
      const keyPressed = event.keyCode;
      const actionKey = {
        goingUp: actions.dy === -10,
        goingDown: actions.dy === 10,
        goingRight: actions.dx === 10,
        goingLeft: actions.dx === -10,
      };
      if (actions.changingDirection) return;
      actions.changingDirection = true;
      if (keyPressed === keys.leftKey && !actionKey.goingRight) {
        actions.dx = -10;
        actions.dy = 0;
      }
      if (keyPressed === keys.upKey && !actionKey.goingDown) {
        actions.dx = 0;
        actions.dy = -10;
      }
      if (keyPressed === keys.rightKey && !actionKey.goingLeft) {
        actions.dx = 10;
        actions.dy = 0;
      }
      if (keyPressed === keys.downKey && !actionKey.goingUp) {
        actions.dx = 0;
        actions.dy = 10;
      }
    };

    const main = () => {
      if (didGameEnd()){
        gameCanvas.style.display = 'none';
        document.getElementById('score').innerHTML = `<p>GAME OVER</p>`;
        $.ajax({
          type: 'post',
          url: '../backend/backend.php',
          data: {
            name: localStorage.getItem('name'),
            score: actions.score,
          }
        }).done(() => {
          setTimeout(() => {
            localStorage.removeItem('name');
            window.location.href = "/";
          }, 2000);
        });
        return false; 
      }
      setTimeout(() => {
        actions.changingDirection = false;
        clearCanvas();
        drawFood();
        advanceSnake();
        drawSnake();
        main();
      }, settings.gameSpeed);
    };

    main();
    createFood();
    document.addEventListener("keydown", changeDirection);
  },
};
