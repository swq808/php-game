<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dig out of Prison - Escape Game</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Arial', sans-serif;
            background: linear-gradient(135deg, #1a1a2e 0%, #16213e 100%);
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            color: #fff;
        }

        .game-container {
            position: relative;
            width: 600px;
            height: 800px;
            background: linear-gradient(180deg, #2a2a3e 0%, #0f0f1e 100%);
            border: 3px solid #ff6b00;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 0 30px rgba(255, 107, 0, 0.5);
        }

        .game-board {
            position: relative;
            width: 100%;
            height: 100%;
            background: repeating-linear-gradient(
                90deg,
                #1a1a2e 0px,
                #1a1a2e 10px,
                #252541 10px,
                #252541 20px
            );
            cursor: crosshair;
        }

        .prison-cell {
            position: absolute;
            top: 20px;
            left: 50%;
            transform: translateX(-50%);
            width: 120px;
            height: 80px;
            background: #333;
            border: 2px solid #666;
            border-radius: 5px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 12px;
            text-align: center;
            color: #ff6b00;
            font-weight: bold;
        }

        .excavation-site {
            position: absolute;
            left: 50%;
            top: 150px;
            width: 400px;
            height: 600px;
            transform: translateX(-50%);
            background: repeating-linear-gradient(
                0deg,
                #3d2817 0px,
                #3d2817 30px,
                #4a3220 30px,
                #4a3220 60px
            );
            border: 2px solid #5a4a3a;
            border-radius: 5px;
            overflow: hidden;
        }

        .dig-particle {
            position: absolute;
            background: radial-gradient(circle, #8b6914 0%, #5a4a2a 100%);
            border-radius: 50%;
            animation: fall 2s ease-in forwards;
        }

        @keyframes fall {
            to {
                transform: translateY(500px);
                opacity: 0;
            }
        }

        .obstacle {
            position: absolute;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            font-weight: bold;
            border-radius: 3px;
        }

        .obstacle.guard {
            background: #8B0000;
            border: 2px solid #ff0000;
            color: #fff;
        }

        .obstacle.trap {
            background: #FFD700;
            border: 2px solid #FFA500;
            color: #000;
        }

        .obstacle.rock {
            background: #696969;
            border: 2px solid #808080;
            color: #fff;
        }

        .obstacle.gold {
            background: #FFD700;
            border: 2px solid #FFA500;
            color: #fff;
            box-shadow: 0 0 10px rgba(255, 215, 0, 0.8);
        }

        .ui {
            position: absolute;
            top: 10px;
            left: 10px;
            right: 10px;
            display: flex;
            justify-content: space-between;
            font-size: 16px;
            font-weight: bold;
            z-index: 100;
            color: #ff6b00;
        }

        .stat {
            background: rgba(0, 0, 0, 0.7);
            padding: 8px 15px;
            border-radius: 5px;
            border: 1px solid #ff6b00;
        }

        .game-over-screen {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.95);
            display: none;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            z-index: 200;
            border-radius: 10px;
        }

        .game-over-screen.active {
            display: flex;
        }

        .game-over-content {
            text-align: center;
        }

        .game-over-title {
            font-size: 48px;
            margin-bottom: 20px;
            color: #ff6b00;
            font-weight: bold;
        }

        .game-over-subtitle {
            font-size: 24px;
            margin-bottom: 30px;
            color: #fff;
        }

        .score-display {
            font-size: 32px;
            margin-bottom: 10px;
            color: #FFD700;
        }

        .depth-display {
            font-size: 20px;
            margin-bottom: 30px;
            color: #aaa;
        }

        .input-group {
            margin: 20px 0;
        }

        .input-group input {
            padding: 10px 15px;
            font-size: 16px;
            border: 2px solid #ff6b00;
            border-radius: 5px;
            background: #222;
            color: #fff;
            width: 250px;
        }

        .input-group input::placeholder {
            color: #888;
        }

        .button {
            padding: 12px 30px;
            font-size: 16px;
            background: linear-gradient(135deg, #ff6b00 0%, #ff8533 100%);
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin: 10px;
            font-weight: bold;
            transition: transform 0.2s, box-shadow 0.2s;
        }

        .button:hover {
            transform: scale(1.05);
            box-shadow: 0 0 20px rgba(255, 107, 0, 0.6);
        }

        .button:active {
            transform: scale(0.98);
        }

        .tutorial {
            font-size: 14px;
            color: #aaa;
            margin-top: 20px;
            max-width: 400px;
        }
    </style>
</head>
<body>
    <div class="game-container">
        <div class="game-board" id="gameBoard">
            <div class="ui">
                <div class="stat">Health: <span id="health">3</span></div>
                <div class="stat">Depth: <span id="depth">0</span>m</div>
                <div class="stat">Score: <span id="score">0</span></div>
            </div>

            <div class="prison-cell">PRISON CELL<br>ESCAPE!</div>
            
            <div class="excavation-site" id="excavationSite"></div>

            <div class="game-over-screen" id="gameOverScreen">
                <div class="game-over-content">
                    <div class="game-over-title" id="gameOverTitle">ESCAPED!</div>
                    <div class="game-over-subtitle">Prison Break Success!</div>
                    <div class="score-display">Score: <span id="finalScore">0</span></div>
                    <div class="depth-display">Max Depth: <span id="finalDepth">0</span>m</div>
                    <div class="input-group">
                        <input type="text" id="playerName" placeholder="Enter your name" maxlength="20">
                    </div>
                    <button class="button" onclick="submitScore()">Save Score</button>
                    <button class="button" onclick="location.reload()">Play Again</button>
                    <button class="button" onclick="goToLeaderboard()">View Leaderboard</button>
                    <div class="tutorial">
                        <p id="gameOverMessage">You dug your way out!</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        const gameBoard = document.getElementById('gameBoard');
        const excavationSite = document.getElementById('excavationSite');
        const gameOverScreen = document.getElementById('gameOverScreen');
        
        const ESCAPE_DEPTH = 2000;
        const GAME_WIDTH = 400;
        const GAME_HEIGHT = 600;

        let gameState = {
            depth: 0,
            score: 0,
            health: 3,
            gameOver: false,
            escaped: false,
            maxDepth: 0
        };

        const obstacleTypes = [
            { type: 'guard', symbol: '👮', damage: 1, points: 50 },
            { type: 'trap', symbol: '💣', damage: 1, points: 40 },
            { type: 'rock', symbol: '🪨', damage: 0, points: 20 },
            { type: 'gold', symbol: '💰', damage: 0, points: 100 }
        ];

        function createObstacle() {
            if (gameState.gameOver) return;
            
            const types = obstacleTypes.filter(t => t.type !== 'gold' || Math.random() > 0.7);
            const selected = types[Math.floor(Math.random() * types.length)];
            
            const obstacle = document.createElement('div');
            obstacle.className = `obstacle ${selected.type}`;
            obstacle.textContent = selected.symbol;
            obstacle.dataset.type = selected.type;
            obstacle.dataset.damage = selected.damage;
            obstacle.dataset.points = selected.points;
            
            const size = 40;
            obstacle.style.width = size + 'px';
            obstacle.style.height = size + 'px';
            obstacle.style.left = Math.random() * (GAME_WIDTH - size) + 'px';
            obstacle.style.top = Math.random() * (GAME_HEIGHT - size) + 'px';
            
            excavationSite.appendChild(obstacle);
            
            setTimeout(() => {
                if (obstacle.parentElement) {
                    obstacle.remove();
                }
            }, 4000);
        }

        function updateDepth() {
            gameState.depth += 10;
            if (gameState.depth > gameState.maxDepth) {
                gameState.maxDepth = gameState.depth;
            }
            document.getElementById('depth').textContent = gameState.depth;
            
            if (gameState.depth >= ESCAPE_DEPTH) {
                endGame(true);
            }
        }

        function dig(x, y) {
            if (gameState.gameOver) return;
            
            // Particle effect
            for (let i = 0; i < 3; i++) {
                const particle = document.createElement('div');
                particle.className = 'dig-particle';
                particle.style.left = x + 'px';
                particle.style.top = y + 'px';
                particle.style.width = Math.random() * 10 + 5 + 'px';
                particle.style.height = particle.style.width;
                gameBoard.appendChild(particle);
                
                setTimeout(() => particle.remove(), 2000);
            }
            
            // Check for obstacles hit
            const excavationRect = excavationSite.getBoundingClientRect();
            const gameRect = gameBoard.getBoundingClientRect();
            
            const clickX = x - (excavationRect.left - gameRect.left);
            const clickY = y - (excavationRect.top - gameRect.top);
            
            const obstacles = excavationSite.querySelectorAll('.obstacle');
            obstacles.forEach(obs => {
                const obsRect = obs.getBoundingClientRect();
                const obsX = obsRect.left - excavationRect.left;
                const obsY = obsRect.top - excavationRect.top;
                const obsW = obsRect.width;
                const obsH = obsRect.height;
                
                if (clickX >= obsX && clickX <= obsX + obsW && 
                    clickY >= obsY && clickY <= obsY + obsH) {
                    handleObstacleHit(obs);
                }
            });
            
            updateDepth();
        }

        function handleObstacleHit(obstacle) {
            const damage = parseInt(obstacle.dataset.damage);
            const points = parseInt(obstacle.dataset.points);
            
            if (damage > 0) {
                gameState.health -= damage;
                document.getElementById('health').textContent = gameState.health;
                
                if (gameState.health <= 0) {
                    endGame(false);
                    return;
                }
            }
            
            gameState.score += points;
            document.getElementById('score').textContent = gameState.score;
            
            obstacle.style.opacity = '0.5';
            setTimeout(() => obstacle.remove(), 200);
        }

        function endGame(escaped) {
            gameState.gameOver = true;
            gameState.escaped = escaped;
            
            const title = document.getElementById('gameOverTitle');
            const message = document.getElementById('gameOverMessage');
            
            if (escaped) {
                title.textContent = 'ESCAPED!';
                message.textContent = 'You dug your way to freedom!';
                gameState.score += 500;
            } else {
                title.textContent = 'CAUGHT!';
                message.textContent = 'You were caught trying to escape.';
                document.querySelector('.game-over-subtitle').textContent = 'Game Over';
            }
            
            document.getElementById('finalScore').textContent = gameState.score;
            document.getElementById('finalDepth').textContent = gameState.maxDepth;
            gameOverScreen.classList.add('active');
        }

        function submitScore() {
            const playerName = document.getElementById('playerName').value || 'Anonymous';
            
            fetch('game.php?action=saveScore', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({
                    playerName: playerName,
                    score: gameState.score
                })
            }).then(() => {
                goToLeaderboard();
            });
        }

        function goToLeaderboard() {
            window.location.href = 'leaderboard.php';
        }

        gameBoard.addEventListener('click', (e) => {
            const rect = gameBoard.getBoundingClientRect();
            dig(e.clientX - rect.left, e.clientY - rect.top);
        });

        // Spawn obstacles periodically
        setInterval(() => {
            if (!gameState.gameOver && Math.random() > 0.3) {
                createObstacle();
            }
        }, 800);
    </script>
</body>
</html>
