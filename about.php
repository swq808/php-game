<?php
require 'functions.php';
$config = loadGameConfig();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($config['gameName']); ?> - About</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #1a1a2e 0%, #16213e 100%);
            min-height: 100vh;
            padding: 20px;
        }
        
        .container {
            max-width: 900px;
            margin: 0 auto;
            background: #2a2a3e;
            border-radius: 10px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.5);
            overflow: hidden;
            border: 2px solid #ff6b00;
        }
        
        .header {
            background: linear-gradient(135deg, #ff6b00 0%, #ff8533 100%);
            color: white;
            padding: 40px 30px;
            text-align: center;
        }
        
        .header h1 {
            font-size: 42px;
            margin-bottom: 10px;
        }
        
        .header p {
            font-size: 16px;
            opacity: 0.9;
        }
        
        .content {
            padding: 40px;
            color: #fff;
        }
        
        .section {
            margin-bottom: 40px;
        }
        
        .section h2 {
            color: #ff6b00;
            font-size: 28px;
            margin-bottom: 15px;
            border-bottom: 3px solid #ff6b00;
            padding-bottom: 10px;
        }
        
        .section h3 {
            color: #ff8533;
            font-size: 18px;
            margin-top: 20px;
            margin-bottom: 10px;
        }
        
        .rules-list {
            list-style: none;
            padding: 0;
        }
        
        .rules-list li {
            padding: 10px 0;
            padding-left: 30px;
            position: relative;
            line-height: 1.6;
            color: #ddd;
        }
        
        .rules-list li:before {
            content: "⚒";
            position: absolute;
            left: 0;
            color: #ff6b00;
            font-weight: bold;
            font-size: 18px;
        }
        
        .credits {
            background: rgba(255, 107, 0, 0.1);
            padding: 20px;
            border-radius: 8px;
            margin-top: 15px;
            border-left: 4px solid #ff6b00;
        }
        
        .credits p {
            margin: 10px 0;
            color: #ddd;
            line-height: 1.6;
        }
        
        .ai-usage {
            background: rgba(255, 107, 0, 0.05);
            padding: 20px;
            border-left: 4px solid #ff6b00;
            border-radius: 8px;
            margin-top: 15px;
        }
        
        .ai-usage h4 {
            color: #ff6b00;
            margin-bottom: 10px;
        }
        
        .ai-usage p {
            color: #ddd;
            line-height: 1.6;
        }
        
        .controls {
            display: flex;
            gap: 10px;
            margin-top: 30px;
            flex-wrap: wrap;
        }
        
        .controls a {
            padding: 12px 30px;
            background: linear-gradient(135deg, #ff6b00 0%, #ff8533 100%);
            color: white;
            text-decoration: none;
            border-radius: 5px;
            transition: all 0.3s;
            font-weight: 500;
            border: 2px solid #ff6b00;
        }
        
        .controls a:hover {
            background: linear-gradient(135deg, #ff8533 0%, #ff6b00 100%);
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(255, 107, 0, 0.6);
        }
        
        .info-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-top: 20px;
        }
        
        .info-card {
            background: rgba(255, 107, 0, 0.1);
            padding: 15px;
            border-radius: 8px;
            border-left: 4px solid #ff6b00;
            color: #ddd;
        }
        
        .info-card strong {
            color: #ff6b00;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>⛏️ <?php echo htmlspecialchars($config['gameName']); ?></h1>
            <p>Version <?php echo htmlspecialchars($config['version']); ?></p>
        </div>
        
        <div class="content">
            <div class="section">
                <h2>📖 Game Rules</h2>
                <ul class="rules-list">
                    <li>Click anywhere or press SPACE to make the bird flap</li>
                    <li>Avoid the green pipes - collision ends the game immediately</li>
                    <li>Safely navigate through the gaps in the pipes</li>
                    <li>Score points by successfully passing through each pipe obstacle</li>
                    <li>Each pipe cleared increases your score by 1 point</li>
                    <li>The bird falls continuously due to gravity - keep it in the air!</li>
                    <li>Game ends when you hit a pipe or the ground</li>
                    <li>Save your score with a name to appear on the leaderboard</li>
                </ul>
            </div>
            
            <div class="section">
                <h2>🏆 Game Features</h2>
                <div class="info-grid">
                    <div class="info-card">
                        <strong>⚡ Randomly Generated Pipes:</strong><br>
                        No two games are the same - new obstacles every time
                    </div>
                    <div class="info-card">
                        <strong>💯 Progressive Scoring:</strong><br>
                        Each pipe you pass increases your score
                    </div>
                    <div class="info-card">
                        <strong>🏅 Competitive Leaderboard:</strong><br>
                        Save your scores and compete with other players
                    </div>
                    <div class="info-card">
                        <strong>💾 Data Persistence:</strong><br>
                        All game scores are saved to the leaderboard
                    </div>
                </div>
            </div>
            
            <div class="section">
                <h2>👥 Credits</h2>
                <div class="credits">
                    <?php foreach ($config['credits'] as $credit): ?>
                        <p>▸ <?php echo htmlspecialchars($credit); ?></p>
                    <?php endforeach; ?>
                </div>
            </div>
            
            <div class="section">
                <h2>🤖 AI Usage Documentation</h2>
                <div class="ai-usage">
                    <h4>How AI Was Used in Development</h4>
                    <p><?php echo htmlspecialchars($config['aiUsage']); ?></p>
                </div>
            </div>
            
            <div class="section">
                <h2>📊 Technical Information</h2>
                <div class="info-grid">
                    <div class="info-card">
                        <strong>Framework:</strong><br>
                        Vanilla PHP & JavaScript
                    </div>
                    <div class="info-card">
                        <strong>Created:</strong><br>
                        <?php echo htmlspecialchars($config['createdDate']); ?>
                    </div>
                    <div class="info-card">
                        <strong>Data Format:</strong><br>
                        JSON-based persistence
                    </div>
                </div>
            </div>
            
            <div class="controls">
                <a href="index.php">🐦 Back to Game</a>
                <a href="leaderboard.php">🏆 View Leaderboard</a>
            </div>
        </div>
    </div>
</body>
</html>
