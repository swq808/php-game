<!DOCTYPE html>
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
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            font-family: Arial, sans-serif;
        }

        .game-container {
            position: relative;
            width: 400px;
            height: 600px;
            background: linear-gradient(to bottom, #87ceeb 0%, #e0f6ff 100%);
            border: 3px solid #333;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
            cursor: pointer;
        }

        canvas {
            display: block;
            width: 100%;
            height: 100%;
        }

        .info {
            position: absolute;
            top: 20px;
            left: 20px;
            color: #333;
            font-size: 24px;
            font-weight: bold;
            z-index: 10;
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
            z-index: 20;
            display: none;
            min-width: 300px;
        }

        .game-over h1 {
            font-size: 48px;
            margin-bottom: 20px;
        }

        .game-over p {
            font-size: 24px;
            margin-bottom: 10px;
        }

        .game-over button {
            margin-top: 20px;
            padding: 12px 30px;
            font-size: 18px;
            background: #667eea;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background 0.3s;
        }

        .game-over button:hover {
            background: #764ba2;
        }

        .instructions {
            position: absolute;
            bottom: 20px;
            left: 50%;
            transform: translateX(-50%);
            color: #333;
            text-align: center;
            font-size: 14px;
            z-index: 10;
        }
    </style>
</head>
<body>
    <div class="game-container" id="gameContainer">
        <canvas id="gameCanvas" width="400" height="600"></canvas>
        <div class="info">
            Score: <span id="score">0</span>
        </div>
        <div class="game-over" id="gameOver">
            <h1>Game Over!</h1>
            <p>Score: <span id="finalScore">0</span></p>
            <button onclick="location.reload()">Play Again</button>
        </div>
        <div class="instructions">
            Click or press SPACE to flap
        </div>
    </div>

    <script>
        const canvas = document.getElementById('gameCanvas');
        const ctx = canvas.getContext('2d');
        const gameContainer = document.getElementById('gameContainer');
        const gameOverScreen = document.getElementById('gameOver');
        const scoreDisplay = document.getElementById('score');
        const finalScoreDisplay = document.getElementById('finalScore');

        // Game variables
        const bird = {
            x: 50,
            y: 150,
            width: 30,
            height: 30,
            velocity: 0,
            gravity: 0.6,
            jumpPower: -12,
            color: '#FFD700'
        };

        let pipes = [];
        let score = 0;
        let gameRunning = true;
        let gameStarted = false;
        let pipeCounter = 0;
        const pipeGap = 120;
        const pipeWidth = 60;
        const pipeSpacing = 200;

        // Event listeners
        document.addEventListener('keydown', (e) => {
            if (e.code === 'Space') {
                e.preventDefault();
                jump();
            }
        });

        gameContainer.addEventListener('click', jump);

        function jump() {
            if (gameRunning) {
                bird.velocity = bird.jumpPower;
            }
        }

        function createPipe() {
            const minHeight = 50;
            const maxHeight = canvas.height - pipeGap - minHeight;
            const pipeY = Math.random() * (maxHeight - minHeight) + minHeight;

            pipes.push({
                x: canvas.width,
                y: 0,
                width: pipeWidth,
                height: pipeY
            });

            pipes.push({
                x: canvas.width,
                y: pipeY + pipeGap,
                width: pipeWidth,
                height: canvas.height - (pipeY + pipeGap)
            });
        }

        function update() {
            if (!gameRunning) return;

            // Apply gravity
            bird.velocity += bird.gravity;
            bird.y += bird.velocity;

            // Check boundaries
            if (bird.y + bird.height > canvas.height) {
                endGame();
                return;
            }

            if (bird.y < 0) {
                bird.y = 0;
            }

            // Update pipes
            for (let i = pipes.length - 1; i >= 0; i--) {
                pipes[i].x -= 5;

                // Remove off-screen pipes
                if (pipes[i].x + pipeWidth < 0) {
                    pipes.splice(i, 1);
                    continue;
                }

                // Check collision
                if (
                    bird.x < pipes[i].x + pipes[i].width &&
                    bird.x + bird.width > pipes[i].x &&
                    bird.y < pipes[i].y + pipes[i].height &&
                    bird.y + bird.height > pipes[i].y
                ) {
                    endGame();
                    return;
                }

                // Score when passing a pipe
                if (pipes[i].x + pipeWidth < bird.x && pipes[i].x + pipeWidth > bird.x - 5) {
                    if (pipes[i].height < canvas.height / 2) {
                        score++;
                        scoreDisplay.textContent = score;
                    }
                }
            }

            // Create new pipes
            pipeCounter++;
            if (pipeCounter > pipeSpacing) {
                createPipe();
                pipeCounter = 0;
            }
        }

        function draw() {
            // Draw background
            const gradient = ctx.createLinearGradient(0, 0, 0, canvas.height);
            gradient.addColorStop(0, '#87ceeb');
            gradient.addColorStop(1, '#e0f6ff');
            ctx.fillStyle = gradient;
            ctx.fillRect(0, 0, canvas.width, canvas.height);

            // Draw pipes
            ctx.fillStyle = '#2ecc71';
            pipes.forEach(pipe => {
                ctx.fillRect(pipe.x, pipe.y, pipe.width, pipe.height);
            });

            // Draw pipe borders for effect
            ctx.strokeStyle = '#27ae60';
            ctx.lineWidth = 2;
            pipes.forEach(pipe => {
                ctx.strokeRect(pipe.x, pipe.y, pipe.width, pipe.height);
            });

            // Draw bird
            ctx.fillStyle = bird.color;
            ctx.beginPath();
            ctx.arc(bird.x + bird.width / 2, bird.y + bird.height / 2, bird.width / 2, 0, Math.PI * 2);
            ctx.fill();

            // Draw bird eye
            ctx.fillStyle = 'white';
            ctx.beginPath();
            ctx.arc(bird.x + bird.width / 2 + 5, bird.y + bird.height / 2 - 5, 4, 0, Math.PI * 2);
            ctx.fill();

            ctx.fillStyle = 'black';
            ctx.beginPath();
            ctx.arc(bird.x + bird.width / 2 + 6, bird.y + bird.height / 2 - 5, 2, 0, Math.PI * 2);
            ctx.fill();
        }

        function endGame() {
            gameRunning = false;
            finalScoreDisplay.textContent = score;
            gameOverScreen.style.display = 'block';
        }

        function gameLoop() {
            update();
            draw();
            requestAnimationFrame(gameLoop);
        }

        // Start game
        gameLoop();
    </script>
</body>
</html>