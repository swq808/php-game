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

        .modal {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.7);
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 30;
            display: none;
        }

        .modal-content {
            background: white;
            padding: 40px;
            border-radius: 10px;
            text-align: center;
            min-width: 350px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.3);
        }

        .modal-content h2 {
            color: #333;
            margin-bottom: 20px;
            font-size: 28px;
        }

        .modal-content p {
            color: #666;
            margin-bottom: 20px;
            font-size: 18px;
        }

        .modal-content input {
            width: 100%;
            padding: 12px;
            margin-bottom: 20px;
            font-size: 16px;
            border: 2px solid #ddd;
            border-radius: 5px;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }

        .modal-content input:focus {
            outline: none;
            border-color: #667eea;
        }

        .modal-buttons {
            display: flex;
            gap: 10px;
        }

        .modal-buttons button {
            flex: 1;
            padding: 12px;
            font-size: 16px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-weight: bold;
            transition: all 0.3s;
        }

        .modal-buttons .save-btn {
            background: #667eea;
            color: white;
        }

        .modal-buttons .save-btn:hover {
            background: #764ba2;
        }

        .modal-buttons .skip-btn {
            background: #ddd;
            color: #333;
        }

        .modal-buttons .skip-btn:hover {
            background: #ccc;
        }

        .modal-links {
            margin-top: 20px;
            display: flex;
            gap: 10px;
            justify-content: center;
        }

        .modal-links a {
            padding: 10px 20px;
            background: #f0f0f0;
            color: #333;
            text-decoration: none;
            border-radius: 5px;
            transition: all 0.3s;
            font-size: 14px;
        }

        .modal-links a:hover {
            background: #667eea;
            color: white;
        }

        .status-message {
            display: none;
            margin-top: 10px;
            padding: 10px;
            border-radius: 5px;
            font-size: 14px;
        }

        .status-message.success {
            background: #d4edda;
            color: #155724;
            display: block;
        }

        .status-message.error {
            background: #f8d7da;
            color: #721c24;
            display: block;
        }

        .leaderboard-btn {
            position: absolute;
            top: 20px;
            right: 20px;
            padding: 10px 15px;
            background: #667eea;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            font-size: 12px;
            z-index: 10;
            transition: all 0.3s;
        }

        .leaderboard-btn:hover {
            background: #764ba2;
        }

        .about-btn {
            position: absolute;
            top: 20px;
            right: 130px;
            padding: 10px 15px;
            background: #764ba2;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            font-size: 12px;
            z-index: 10;
            transition: all 0.3s;
        }

        .about-btn:hover {
            background: #5a3a85;
        }
    </style>
</head>
<body>
    <div class="game-container" id="gameContainer">
        <canvas id="gameCanvas" width="400" height="600"></canvas>
        <div class="info">
            Score: <span id="score">0</span>
        </div>
        <a href="about.php" class="about-btn">About</a>
        <a href="leaderboard.php" class="leaderboard-btn"> Leaderboard</a>
        <div class="game-over" id="gameOver">
            <h1>Game Over!</h1>
            <p>Score: <span id="finalScore">0</span></p>
            <button onclick="resetGame()">Play Again</button>
        </div>
        <div class="instructions">
            Click or press SPACE to flap
        </div>
    </div>

    <div class="modal" id="saveModal">
        <div class="modal-content">
            <h2>Game Over!</h2>
            <p>Final Score: <span id="modalScore">0</span></p>
            <input type="text" id="playerName" placeholder="Enter your name" maxlength="50">
            <div id="statusMessage" class="status-message"></div>
            <div class="modal-buttons">
                <button class="save-btn" onclick="saveScore()">Save Score</button>
                <button class="skip-btn" onclick="skipSaveAndRestart()">Skip</button>
            </div>
            <div class="modal-links">
                <a href="leaderboard.php">View Leaderboard</a>
                <a href="about.php">Game Rules</a>
            </div>
        </div>
    </div>

    <script>
        const canvas = document.getElementById('gameCanvas');
        const ctx = canvas.getContext('2d');
        const gameContainer = document.getElementById('gameContainer');
        const saveModal = document.getElementById('saveModal');
        const scoreDisplay = document.getElementById('score');
        const playerNameInput = document.getElementById('playerName');
        const statusMessage = document.getElementById('statusMessage');

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
        let pipeCounter = 0;
        const pipeGap = 120;
        const pipeWidth = 60;
        const pipeSpacing = 200;

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

            bird.velocity += bird.gravity;
            bird.y += bird.velocity;

            if (bird.y + bird.height > canvas.height) {
                endGame();
                return;
            }

            if (bird.y < 0) {
                bird.y = 0;
            }

            for (let i = pipes.length - 1; i >= 0; i--) {
                pipes[i].x -= 5;

                if (pipes[i].x + pipeWidth < 0) {
                    pipes.splice(i, 1);
                    continue;
                }

                if (
                    bird.x < pipes[i].x + pipes[i].width &&
                    bird.x + bird.width > pipes[i].x &&
                    bird.y < pipes[i].y + pipes[i].height &&
                    bird.y + bird.height > pipes[i].y
                ) {
                    endGame();
                    return;
                }

                if (pipes[i].x + pipeWidth < bird.x && pipes[i].x + pipeWidth > bird.x - 5) {
                    if (pipes[i].height < canvas.height / 2) {
                        score++;
                        scoreDisplay.textContent = score;
                    }
                }
            }

            pipeCounter++;
            if (pipeCounter > pipeSpacing) {
                createPipe();
                pipeCounter = 0;
            }
        }

        function draw() {
            const gradient = ctx.createLinearGradient(0, 0, 0, canvas.height);
            gradient.addColorStop(0, '#87ceeb');
            gradient.addColorStop(1, '#e0f6ff');
            ctx.fillStyle = gradient;
            ctx.fillRect(0, 0, canvas.width, canvas.height);

            pipes.forEach(pipe => {
                const pipeGradient = ctx.createLinearGradient(pipe.x, 0, pipe.x + pipe.width, 0);
                pipeGradient.addColorStop(0, '#27ae60');
                pipeGradient.addColorStop(1, '#2ecc71');
                ctx.fillStyle = pipeGradient;
                ctx.fillRect(pipe.x, pipe.y, pipe.width, pipe.height);
            });

            ctx.strokeStyle = '#27ae60';
            ctx.lineWidth = 2;
            pipes.forEach(pipe => {
                ctx.strokeRect(pipe.x, pipe.y, pipe.width, pipe.height);
            });

            ctx.fillStyle = bird.color;
            ctx.beginPath();
            ctx.arc(bird.x + bird.width / 2, bird.y + bird.height / 2, bird.width / 2, 0, Math.PI * 2);
            ctx.fill();

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
            document.getElementById('modalScore').textContent = score;
            playerNameInput.value = '';
            statusMessage.textContent = '';
            statusMessage.className = 'status-message';
            saveModal.style.display = 'flex';
            playerNameInput.focus();
        }

        function saveScore() {
            const playerName = playerNameInput.value.trim() || 'Anonymous';
            
            if (playerName.length > 50) {
                showStatus('Name must be 50 characters or less', 'error');
                return;
            }

            const data = {
                playerName: playerName,
                score: score
            };

            fetch('game.php?action=saveScore', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(data)
            })
            .then(response => response.json())
            .then(result => {
                if (result.success) {
                    showStatus('Score saved! Redirecting...', 'success');
                    setTimeout(() => {
                        window.location.href = 'leaderboard.php';
                    }, 1500);
                } else {
                    showStatus('Failed to save score', 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showStatus('Error saving score', 'error');
            });
        }

        function skipSaveAndRestart() {
            resetGame();
        }

        function resetGame() {
            bird.y = 150;
            bird.velocity = 0;
            pipes = [];
            score = 0;
            pipeCounter = 0;
            gameRunning = true;
            scoreDisplay.textContent = '0';
            saveModal.style.display = 'none';
            statusMessage.textContent = '';
            statusMessage.className = 'status-message';
        }

        function showStatus(message, type) {
            statusMessage.textContent = message;
            statusMessage.className = `status-message ${type}`;
        }

        function gameLoop() {
            update();
            draw();
            requestAnimationFrame(gameLoop);
        }

        gameLoop();

        playerNameInput.addEventListener('keypress', (e) => {
            if (e.key === 'Enter') {
                saveScore();
            }
        });
    </script>
</body>
</html>