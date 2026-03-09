<?php
require 'functions.php';

$sortBy = $_GET['sortBy'] ?? 'score';
$scores = sortScoresBy($sortBy);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Flappy Bird - Leaderboard</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: Arial, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            padding: 20px;
        }
        
        .container {
            max-width: 800px;
            margin: 0 auto;
            background: white;
            border-radius: 10px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
            overflow: hidden;
        }
        
        .header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 30px;
            text-align: center;
        }
        
        .header h1 {
            font-size: 36px;
            margin-bottom: 10px;
        }
        
        .header p {
            font-size: 14px;
            opacity: 0.9;
        }
        
        .controls {
            padding: 20px;
            display: flex;
            gap: 10px;
            border-bottom: 2px solid #eee;
            flex-wrap: wrap;
        }
        
        .controls a, .controls button {
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
            font-size: 14px;
            transition: all 0.3s;
        }
        
        .controls a.sort-btn, .controls button.sort-btn {
            background: #f0f0f0;
            color: #333;
        }
        
        .controls a.sort-btn.active, .controls button.sort-btn.active {
            background: #667eea;
            color: white;
            font-weight: bold;
        }
        
        .controls a.sort-btn:hover, .controls button.sort-btn:hover {
            background: #667eea;
            color: white;
        }
        
        .controls a.home-btn {
            background: #764ba2;
            color: white;
            margin-left: auto;
        }
        
        .controls a.home-btn:hover {
            background: #5a3a85;
        }
        
        .leaderboard {
            padding: 20px;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
        }
        
        thead {
            background: #f5f5f5;
            border-bottom: 2px solid #ddd;
        }
        
        th {
            padding: 15px;
            text-align: left;
            font-weight: bold;
            color: #333;
        }
        
        td {
            padding: 12px 15px;
            border-bottom: 1px solid #eee;
        }
        
        tr:hover {
            background: #f9f9f9;
        }
        
        .rank {
            font-weight: bold;
            color: #667eea;
            font-size: 18px;
        }
        
        .player-name {
            font-weight: 500;
            color: #333;
        }
        
        .score {
            font-weight: bold;
            color: #764ba2;
            font-size: 16px;
        }
        
        .date {
            color: #999;
            font-size: 13px;
        }
        
        .empty-state {
            text-align: center;
            padding: 60px 20px;
            color: #999;
        }
        
        .empty-state p {
            font-size: 18px;
            margin-bottom: 20px;
        }
        
        .empty-state a {
            background: #667eea;
            color: white;
            padding: 12px 30px;
            border-radius: 5px;
            text-decoration: none;
            transition: all 0.3s;
            display: inline-block;
        }
        
        .empty-state a:hover {
            background: #764ba2;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>🏆 Leaderboard</h1>
            <p>Top Flappy Bird Scores</p>
        </div>
        
        <div class="controls">
            <a href="leaderboard.php?sortBy=score" class="sort-btn <?php echo $sortBy === 'score' ? 'active' : ''; ?>">
                📊 Sort by Score
            </a>
            <a href="leaderboard.php?sortBy=name" class="sort-btn <?php echo $sortBy === 'name' ? 'active' : ''; ?>">
                👤 Sort by Name
            </a>
            <a href="leaderboard.php?sortBy=date" class="sort-btn <?php echo $sortBy === 'date' ? 'active' : ''; ?>">
                📅 Sort by Date
            </a>
            <a href="index.php" class="home-btn">← Back to Game</a>
        </div>
        
        <div class="leaderboard">
            <?php if (empty($scores)): ?>
                <div class="empty-state">
                    <p>No scores yet. Be the first to play!</p>
                    <a href="index.php">Play Game Now</a>
                </div>
            <?php else: ?>
                <table>
                    <thead>
                        <tr>
                            <th style="width: 10%;">Rank</th>
                            <th style="width: 40%;">Player Name</th>
                            <th style="width: 20%;">Score</th>
                            <th style="width: 30%;">Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($scores as $index => $score): ?>
                            <tr>
                                <td class="rank">#<?php echo $index + 1; ?></td>
                                <td class="player-name"><?php echo htmlspecialchars($score['playerName']); ?></td>
                                <td class="score"><?php echo $score['score']; ?></td>
                                <td class="date"><?php echo date('M d, Y H:i', strtotime($score['date'])); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>
