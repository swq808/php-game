<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RocketGoal.io - Rocket Soccer</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Arial', sans-serif;
            background: linear-gradient(135deg, #0f0f1e 0%, #1a1a2e 100%);
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            color: #fff;
            padding: 20px;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
        }

        .header h1 {
            font-size: 2.5em;
            margin-bottom: 10px;
            background: linear-gradient(135deg, #ff6b00, #ffa500);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .instructions {
            color: #aaa;
            font-size: 0.9em;
            margin-bottom: 10px;
        }

        .game-wrapper {
            position: relative;
        }

        .game-container {
            position: relative;
            width: 800px;
            height: 600px;
            background: linear-gradient(180deg, #1a1a2e 0%, #0f0f1e 100%);
            border: 3px solid #ff6b00;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 0 30px rgba(255, 107, 0, 0.5);
            cursor: crosshair;
        }

        .game-field {
            position: relative;
            width: 100%;
            height: 100%;
            background: linear-gradient(180deg, #1a1a3e 0%, #0a0a1e 100%);
        }

        .goal-area {
            position: absolute;
            width: 150px;
            height: 200px;
            border: 3px dashed;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.2em;
            font-weight: bold;
            top: 50%;
            transform: translateY(-50%);
        }

        .goal-left {
            left: 10px;
            border-color: #00ff00;
            background: rgba(0, 255, 0, 0.1);
        }

        .goal-right {
            right: 10px;
            border-color: #ff00ff;
            background: rgba(255, 0, 255, 0.1);
        }

        .ball {
            position: absolute;
            width: 30px;
            height: 30px;
            background: radial-gradient(circle at 30% 30%, #ffff00, #ff8800);
            border-radius: 50%;
            box-shadow: 0 0 20px rgba(255, 136, 0, 0.8);
            z-index: 10;
        }

        .boost-indicator {
            position: absolute;
            bottom: 20px;
            left: 20px;
            font-size: 0.9em;
            color: #ffa500;
        }

        .boost-bar {
            width: 200px;
            height: 15px;
            background: #333;
            border: 1px solid #ffa500;
            margin-top: 5px;
            border-radius: 5px;
            overflow: hidden;
        }

        .boost-fill {
            height: 100%;
            background: linear-gradient(90deg, #ff6b00, #ffaa00);
            width: 100%;
            transition: width 0.1s;
        }

        .score-board {
            position: absolute;
            top: 20px;
            left: 50%;
            transform: translateX(-50%);
            text-align: center;
            z-index: 20;
        }

        .score-board h2 {
            font-size: 2em;
            color: #ffff00;
            margin: 0;
        }

        .player-scores {
            display: flex;
            gap: 30px;
            margin-top: 10px;
            font-size: 1.2em;
        }

        .player-score {
            padding: 10px 20px;
            background: rgba(0, 0, 0, 0.5);
            border-radius: 5px;
            min-width: 100px;
        }

        .player-score.left {
            border-left: 3px solid #00ff00;
        }

        .player-score.right {
            border-right: 3px solid #ff00ff;
        }

        .controls {
            margin-top: 20px;
            padding: 20px;
            background: rgba(255, 107, 0, 0.1);
            border: 1px solid #ff6b00;
            border-radius: 10px;
            text-align: center;
            max-width: 800px;
        }

        .controls h3 {
            margin-bottom: 10px;
            color: #ffaa00;
        }

        .control-item {
            margin: 8px 0;
            color: #ddd;
        }

        .reset-btn {
            margin-top: 20px;
            padding: 12px 30px;
            background: linear-gradient(135deg, #ff6b00, #ffa500);
            border: none;
            color: white;
            font-size: 1em;
            border-radius: 5px;
            cursor: pointer;
            transition: transform 0.2s;
        }

        .reset-btn:hover {
            transform: scale(1.05);
        }

        .reset-btn:active {
            transform: scale(0.95);
        }

        .goal-flash {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            pointer-events: none;
            z-index: 30;
        }

        @keyframes flash {
            0% { background: transparent; }
            50% { background: rgba(255, 255, 0, 0.3); }
            100% { background: transparent; }
        }

        .goal-flash.active {
            animation: flash 0.5s;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>🚀 RocketGoal.io</h1>
        <p class="instructions">Click and drag to aim, release to boost the ball toward the goal!</p>
    </div>

    <div class="game-wrapper">
        <div class="game-container">
            <div class="game-field" id="gameField">
                <div class="score-board">
                    <h2>ROCKET SOCCER</h2>
                    <div class="player-scores">
                        <div class="player-score left">
                            🟢 <span id="leftScore">0</span>
                        </div>
                        <div class="player-score right">
                            🟣 <span id="rightScore">0</span>
                        </div>
                    </div>
                </div>

                <div class="goal-area goal-left">🟢<br>GOAL</div>
                <div class="goal-area goal-right">🟣<br>GOAL</div>

                <div class="ball" id="ball"></div>

                <div class="boost-indicator">
                    <div>Boost Power</div>
                    <div class="boost-bar">
                        <div class="boost-fill" id="boostFill"></div>
                    </div>
                </div>
            </div>
            <div class="goal-flash" id="goalFlash"></div>
        </div>
    </div>

    <div class="controls">
        <h3>HOW TO PLAY</h3>
        <div class="control-item">1. Click inside the field and drag to charge your boost</div>
        <div class="control-item">2. Release to launch the ball toward the opposite goal</div>
        <div class="control-item">3. Score by getting the ball into the opposite colored goal area</div>
        <div class="control-item">4. The ball moves with physics - gravity affects it!</div>
        <button class="reset-btn" onclick="resetGame()">Reset Game</button>
    </div>

    <script>
        const gameField = document.getElementById('gameField');
        const ball = document.getElementById('ball');
        const boostFill = document.getElementById('boostFill');
        const goalFlash = document.getElementById('goalFlash');
        const leftScoreEl = document.getElementById('leftScore');
        const rightScoreEl = document.getElementById('rightScore');

        let ballX = 400;
        let ballY = 300;
        let ballVX = 0;
        let ballVY = 0;
        const ballRadius = 15;
        const gravity = 0.3;
        const friction = 0.98;
        const boostMax = 50;
        let boostPower = 0;
        let isCharging = false;
        let chargeStartX = 0;
        let chargeStartY = 0;
        let leftScore = 0;
        let rightScore = 0;

        const fieldWidth = 800;
        const fieldHeight = 600;
        const goalLeftX = 10;
        const goalLeftY = 200;
        const goalLeftW = 150;
        const goalLeftH = 200;
        const goalRightX = fieldWidth - 160;
        const goalRightY = 200;
        const goalRightW = 150;
        const goalRightH = 200;

        function updateBall() {
            ballX += ballVX;
            ballY += ballVY;

            ballVX *= friction;
            ballVY *= friction;
            ballVY += gravity;

            // Bounce off walls
            if (ballX - ballRadius < 0) {
                ballX = ballRadius;
                ballVX = -ballVX * 0.8;
            }
            if (ballX + ballRadius > fieldWidth) {
                ballX = fieldWidth - ballRadius;
                ballVX = -ballVX * 0.8;
            }
            if (ballY - ballRadius < 0) {
                ballY = ballRadius;
                ballVY = -ballVY * 0.8;
            }
            if (ballY + ballRadius > fieldHeight) {
                ballY = fieldHeight - ballRadius;
                ballVY = -ballVY * 0.8;
            }

            ball.style.left = (ballX - ballRadius) + 'px';
            ball.style.top = (ballY - ballRadius) + 'px';

            checkGoals();
        }

        function checkGoals() {
            // Left goal (green)
            if (ballX > goalLeftX && ballX < goalLeftX + goalLeftW &&
                ballY > goalLeftY && ballY < goalLeftY + goalLeftH) {
                rightScore++;
                rightScoreEl.textContent = rightScore;
                triggerGoal();
                resetBall(false);
            }

            // Right goal (magenta)
            if (ballX > goalRightX && ballX < goalRightX + goalRightW &&
                ballY > goalRightY && ballY < goalRightY + goalRightH) {
                leftScore++;
                leftScoreEl.textContent = leftScore;
                triggerGoal();
                resetBall(true);
            }
        }

        function triggerGoal() {
            goalFlash.classList.remove('active');
            setTimeout(() => {
                goalFlash.classList.add('active');
            }, 10);
        }

        function resetBall(forLeft = true) {
            ballX = forLeft ? 150 : fieldWidth - 150;
            ballY = fieldHeight / 2;
            ballVX = 0;
            ballVY = 0;
            boostPower = 0;
            updateBoostBar();
        }

        function resetGame() {
            leftScore = 0;
            rightScore = 0;
            leftScoreEl.textContent = '0';
            rightScoreEl.textContent = '0';
            resetBall(true);
        }

        function updateBoostBar() {
            const percentage = (boostPower / boostMax) * 100;
            boostFill.style.width = percentage + '%';
        }

        gameField.addEventListener('mousedown', (e) => {
            if (isCharging) return;
            isCharging = true;
            const rect = gameField.getBoundingClientRect();
            chargeStartX = e.clientX - rect.left;
            chargeStartY = e.clientY - rect.top;
            boostPower = 0;
            updateBoostBar();
        });

        gameField.addEventListener('mousemove', (e) => {
            if (!isCharging) return;
            const rect = gameField.getBoundingClientRect();
            const currentX = e.clientX - rect.left;
            const currentY = e.clientY - rect.top;
            const dx = currentX - chargeStartX;
            const dy = currentY - chargeStartY;
            const distance = Math.sqrt(dx * dx + dy * dy);
            boostPower = Math.min(distance, boostMax);
            updateBoostBar();
        });

        gameField.addEventListener('mouseup', (e) => {
            if (!isCharging) return;
            isCharging = false;
            const rect = gameField.getBoundingClientRect();
            const endX = e.clientX - rect.left;
            const endY = e.clientY - rect.top;
            const dx = endX - chargeStartX;
            const dy = endY - chargeStartY;
            const distance = Math.sqrt(dx * dx + dy * dy);
            const angle = Math.atan2(dy, dx);
            const power = Math.min(distance, boostMax);
            ballVX = Math.cos(angle) * power * 0.3;
            ballVY = Math.sin(angle) * power * 0.3;
            boostPower = 0;
            updateBoostBar();
        });

        // Touch support
        gameField.addEventListener('touchstart', (e) => {
            if (isCharging) return;
            isCharging = true;
            const rect = gameField.getBoundingClientRect();
            chargeStartX = e.touches[0].clientX - rect.left;
            chargeStartY = e.touches[0].clientY - rect.top;
            boostPower = 0;
            updateBoostBar();
        });

        gameField.addEventListener('touchmove', (e) => {
            if (!isCharging) return;
            const rect = gameField.getBoundingClientRect();
            const currentX = e.touches[0].clientX - rect.left;
            const currentY = e.touches[0].clientY - rect.top;
            const dx = currentX - chargeStartX;
            const dy = currentY - chargeStartY;
            const distance = Math.sqrt(dx * dx + dy * dy);
            boostPower = Math.min(distance, boostMax);
            updateBoostBar();
        });

        gameField.addEventListener('touchend', (e) => {
            if (!isCharging) return;
            isCharging = false;
            const rect = gameField.getBoundingClientRect();
            const endX = e.changedTouches[0].clientX - rect.left;
            const endY = e.changedTouches[0].clientY - rect.top;
            const dx = endX - chargeStartX;
            const dy = endY - chargeStartY;
            const distance = Math.sqrt(dx * dx + dy * dy);
            const angle = Math.atan2(dy, dx);
            const power = Math.min(distance, boostMax);
            ballVX = Math.cos(angle) * power * 0.3;
            ballVY = Math.sin(angle) * power * 0.3;
            boostPower = 0;
            updateBoostBar();
        });

        function gameLoop() {
            updateBall();
            requestAnimationFrame(gameLoop);
        }

        // Initialize
        resetBall(true);
        gameLoop();
    </script>
</body>
</html>
