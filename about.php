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
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            padding: 20px;
        }
        
        .container {
            max-width: 900px;
            margin: 0 auto;
            background: white;
            border-radius: 10px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
            overflow: hidden;
        }
        
        .header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
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
        }
        
        .section {
            margin-bottom: 40px;
        }
        
        .section h2 {
            color: #667eea;
            font-size: 28px;
            margin-bottom: 15px;
            border-bottom: 3px solid #667eea;
            padding-bottom: 10px;
        }
        
        .section h3 {
            color: #764ba2;
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
            color: #333;
        }
        
        .rules-list li:before {
            content: "✓";
            position: absolute;
            left: 0;
            color: #667eea;
            font-weight: bold;
            font-size: 18px;
        }
        
        .credits {
            background: #f5f5f5;
            padding: 20px;
            border-radius: 8px;
            margin-top: 15px;
        }
        
        .credits p {
            margin: 10px 0;
            color: #333;
            line-height: 1.6;
        }
        
        .ai-usage {
            background: #e3f2fd;
            padding: 20px;
            border-left: 4px solid #667eea;
            border-radius: 8px;
            margin-top: 15px;
        }
        
        .ai-usage h4 {
            color: #667eea;
            margin-bottom: 10px;
        }
        
        .ai-usage p {
            color: #333;
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
            background: #667eea;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            transition: all 0.3s;
            font-weight: 500;
        }
        
        .controls a:hover {
            background: #764ba2;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
        }
        
        .info-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-top: 20px;
        }
        
        .info-card {
            background: #f5f5f5;
            padding: 15px;
            border-radius: 8px;
            border-left: 4px solid #667eea;
        }
        
        .info-card strong {
            color: #667eea;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>🎮 <?php echo htmlspecialchars($config['gameName']); ?></h1>
            <p>Version <?php echo htmlspecialchars($config['version']); ?></p>
        </div>
        
        <div class="content">
            <div class="section">
                <h2>📖 Game Rules</h2>
                <ul class="rules-list">
                    <li>Click the mouse or press SPACE to make the bird fly upward</li>
                    <li>Navigate through the gaps between pipes without hitting them</li>
                    <li>Each pipe you pass successfully increases your score by 1 point</li>
                    <li>Colliding with a pipe or hitting the ground ends the game</li>
                    <li>Try to achieve the highest score possible and compete on the leaderboard</li>
                    <li>The bird will fall due to gravity if you don't make it jump</li>
                    <li>Pipes appear at random heights to create different challenges</li>
                </ul>
            </div>
            
            <div class="section">
                <h2>🏆 Game Features</h2>
                <div class="info-grid">
                    <div class="info-card">
                        <strong>📊 Score Tracking:</strong><br>
                        Real-time score updates as you navigate pipes
                    </div>
                    <div class="info-card">
                        <strong>🎨 Visual Effects:</strong><br>
                        Bird rotation animation based on velocity
                    </div>
                    <div class="info-card">
                        <strong>🏅 Leaderboard:</strong><br>
                        Save your scores and compete with others
                    </div>
                    <div class="info-card">
                        <strong>💾 Persistent Data:</strong><br>
                        All scores are saved for future sessions
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
                <a href="index.php">← Back to Game</a>
                <a href="leaderboard.php">View Leaderboard →</a>
            </div>
        </div>
    </div>
</body>
</html>
