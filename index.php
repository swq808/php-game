!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Flappy Bird</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            background: #70c5ce;
            font-family: Arial, sans-serif;
        }

        .game-container {
            position: relative;
            width: 400px;
            height: 600px;
            background: linear-gradient(to bottom, #70c5ce 0%, #70c5ce 80%, #90ee90 80%, #90ee90 100%);
            border: 3px solid #333;
            overflow: hidden;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.3);
        }

        .bird {
            position: absolute;
            width: 34px;
            height: 24px;
            left: 50px;
            background: #FFD700;
            border-radius: 50%;
            border: 2px solid #FFA500;
            z-index: 10;
        }

        .bird::before {
            content: '';
            position: absolute;
            width: 8px;
            height: 8px;
            background: black;
            border-radius: 50%;
            right: 6px;
            top: 6px;
        }

        .bird::after {
            content: '';
            position: absolute;
            width: 0;
            height: 0;
            border-left: 6px solid transparent;
            border-top: 4px solid transparent;
            border-bottom: 4px solid transparent;
            border-right: 6px solid #FFA500;
            right: -8px;
            top: 8px;
        }

        .pipe {
            position: absolute;
            background: #2d5016;
            border: 2px solid #1a3009;
            width: 80px;
        }

        .pipe-top {
            background: linear-gradient(to bottom, #2d5016 0%, #1a3009 100%);
        }

        .pipe-bottom {
            background: linear-gradient(to top, #2d5016 0%, #1a3009 100%);
        }

        .score {
            position: absolute;
            top: 20px;
            left: 20px;
            font-size: 32px;
            font-weight: bold;
            color: white;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
            z-index: 20;
        }

        .game-over {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background: rgba(0, 0, 0, 0.9);
            color: white;
            padding: 40px;
            border-radius: 10px;
            text-align: center;
            z-index: 100;
            display: none;
            min-width: 250px;
        }

        .game-over h1 {
            font-size: 36px;
            margin-bottom: 20px;
        }

        .game-over p {
            font-size: 24px;
            margin-bottom: 10px;
        }

        .game-over button {
            margin-top: 20px;
            padding: 10px 30px;
            font-size: 18px;
            background: #FFD700;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background 0.3s;
        }

        .game-over button:hover {
            background: #FFA500;
        }

        .instructions {
            position: absolute;
            bottom: 20px;
            right: 20px;
            background: rgba(0, 0, 0, 0.7);
            color: white;
            padding: 10px 15px;
            border-radius: 5px;
            font-size: 12px;
            text-align: right;
            z-index: 20;
        }

        .instructions a {
            color: #FFD700;
            text-decoration: none;
            transition: opacity 0.3s;
        }

        .instructions a:hover {
            opacity: 0.8;
        }
    </style>
</head>
<body>
    <div class="game-container" id="gameContainer">
        <div class="score" id="score">Score: 0</div>
        <div class="game-over" id="gameOver">
            <h1>Game Over!</h1>
            <p id="finalScore">Final Score: 0</p>
            <input type="text" id="playerName" placeholder="Enter your name" maxlength="30" style="
                width: 100%;
                padding: 10px;
                margin: 10px 0;
                border: none;
                border-radius: 3px;
                font-size: 14px;
            ">
            <div style="display: flex; gap: 10px;">
                <button onclick="saveScore()" style="flex: 1; padding: 10px 15px; background: #90EE90; border: none; border-radius: 5px; cursor: pointer; font-weight: bold;">Save Score</button>
                <button onclick="location.reload()" style="flex: 1; padding: 10px 15px; background: #FFD700; border: none; border-radius: 5px; cursor: pointer; font-weight: bold;">Play Again</button>
            </div>
            <a href="leaderboard.php" style="display: block; margin-top: 10px; color: #FFD700; text-decoration: none; text-align: center; font-size: 14px;">View Leaderboard</a>
        </div>
        <div class="instructions">
            <div>Click or Press SPACE to fly</div>
            <div style="margin-top: 10px; font-size: 11px;">
                <a href="leaderboard.php" style="color: white; margin-right: 15px;">Leaderboard</a>
                <a href="about.php" style="color: white;">About</a>
            </div>
        </div>
    </div>

    <script>
        const gameContainer = document.getElementById('gameContainer');
        const gameOverScreen = document.getElementById('gameOver');
        const scoreDisplay = document.getElementById('score');
        const finalScoreDisplay = document.getElementById('finalScore');

        const GRAVITY = 0.5;
        const JUMP_STRENGTH = -10;
        const PIPE_WIDTH = 80;
        const PIPE_GAP = 120;
        const PIPE_SPEED = -5;
        const GAME_WIDTH = 400;
        const GAME_HEIGHT = 600;

        let bird = {
            x: 50,
            y: 150,
            width: 34,
            height: 24,
            velocityY: 0
        };

        let pipes = [];
        let score = 0;
        let gameRunning = true;
        let pipeCounter = 0;

        function createBirdElement() {
            const birdDiv = document.createElement('div');
            birdDiv.className = 'bird';
            birdDiv.id = 'bird';
            gameContainer.appendChild(birdDiv);
            updateBirdPosition();
        }

        function updateBirdPosition() {
            const birdDiv = document.getElementById('bird');
            if (birdDiv) {
                birdDiv.style.top = bird.y + 'px';
                birdDiv.style.left = bird.x + 'px';

                const angle = Math.min(Math.max(bird.velocityY * 2, -20), 30);
                birdDiv.style.transform = `rotate(${angle}deg)`;
            }
        }

        function createPipe() {
            const gapStart = Math.random() * (GAME_HEIGHT - PIPE_GAP - 100) + 50;

            const pipeTop = document.createElement('div');
            pipeTop.className = 'pipe pipe-top';
            pipeTop.style.left = GAME_WIDTH + 'px';
            pipeTop.style.top = '0px';
            pipeTop.style.height = gapStart + 'px';
            pipeTop.setAttribute('data-x', GAME_WIDTH);
            pipeTop.setAttribute('data-scored', 'false');
            gameContainer.appendChild(pipeTop);

            const pipeBottom = document.createElement('div');
            pipeBottom.className = 'pipe pipe-bottom';
            pipeBottom.style.left = GAME_WIDTH + 'px';
            pipeBottom.style.top = (gapStart + PIPE_GAP) + 'px';
            pipeBottom.style.height = (GAME_HEIGHT - gapStart - PIPE_GAP) + 'px';
            pipeBottom.setAttribute('data-x', GAME_WIDTH);
            pipeBottom.setAttribute('data-scored', 'false');
            gameContainer.appendChild(pipeBottom);

            pipes.push({
                x: GAME_WIDTH,
                topHeight: gapStart,
                bottomStart: gapStart + PIPE_GAP,
                scored: false,
                topElement: pipeTop,
                bottomElement: pipeBottom
            });
        }

        function updatePipes() {
            pipes = pipes.filter(pipe => pipe.x > -PIPE_WIDTH);

            pipes.forEach(pipe => {
                pipe.x += PIPE_SPEED;
                pipe.topElement.style.left = pipe.x + 'px';
                pipe.bottomElement.style.left = pipe.x + 'px';

                if (!pipe.scored && pipe.x < bird.x) {
                    pipe.scored = true;
                    score++;
                    scoreDisplay.textContent = 'Score: ' + score;
                }

                if (checkCollision(pipe)) {
                    endGame();
                }
            });
        }

        function checkCollision(pipe) {
            const birdRight = bird.x + bird.width;
            const birdBottom = bird.y + bird.height;
            const pipeRight = pipe.x + PIPE_WIDTH;

            if (birdRight > pipe.x && bird.x < pipeRight) {
                if (bird.y < pipe.topHeight || birdBottom > pipe.bottomStart) {
                    return true;
                }
            }
            return false;
        }

        function updateBird() {
            bird.velocityY += GRAVITY;
            bird.y += bird.velocityY;

            if (bird.y <= 0 || bird.y + bird.height >= GAME_HEIGHT) {
                endGame();
            }

            updateBirdPosition();
        }

        function jump() {
            bird.velocityY = JUMP_STRENGTH;
        }

        function endGame() {
            gameRunning = false;
            gameOverScreen.style.display = 'block';
            finalScoreDisplay.textContent = 'Final Score: ' + score;
        }

        function gameLoop() {
            if (!gameRunning) return;

            updateBird();
            updatePipes();

            pipeCounter++;
            if (pipeCounter > 90) {
                createPipe();
                pipeCounter = 0;
            }

            requestAnimationFrame(gameLoop);
        }

        document.addEventListener('click', jump);
        document.addEventListener('keydown', (e) => {
            if (e.code === 'Space') {
                e.preventDefault();
                jump();
            }
        });

        function saveScore() {
            const playerNameInput = document.getElementById('playerName');
            const playerName = playerNameInput.value.trim() || 'Anonymous';

            fetch('game.php?action=saveScore', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    playerName: playerName,
                    score: score
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    playerNameInput.style.borderTop = '3px solid #90EE90';
                    playerNameInput.placeholder = 'Score saved!';
                    playerNameInput.disabled = true;
                    setTimeout(() => {
                        window.location.href = 'leaderboard.php';
                    }, 1500);
                }
            })
            .catch(error => console.error('Error:', error));
        }

        createBirdElement();
        createPipe();
        gameLoop();
    </script>
</body>
</html>
