<?php
header('Content-Type: application/json');
require 'functions.php';

$action = $_GET['action'] ?? '';
$method = $_SERVER['REQUEST_METHOD'];

if ($method === 'POST' && $action === 'saveScore') {
    $data = json_decode(file_get_contents('php://input'), true);
    $playerName = $data['playerName'] ?? 'Anonymous';
    $score = $data['score'] ?? 0;
    
    if (saveScore($playerName, $score)) {
        echo json_encode(['success' => true, 'message' => 'Score saved']);
    } else {
        http_response_code(400);
        echo json_encode(['success' => false, 'message' => 'Failed to save score']);
    }
} elseif ($method === 'GET' && $action === 'getScores') {
    $sortBy = $_GET['sortBy'] ?? 'score';
    $scores = sortScoresBy($sortBy);
    echo json_encode(['success' => true, 'scores' => $scores]);
} elseif ($method === 'GET' && $action === 'getTopScores') {
    $limit = (int)($_GET['limit'] ?? 10);
    $scores = getTopScores($limit);
    echo json_encode(['success' => true, 'scores' => $scores]);
} elseif ($method === 'GET' && $action === 'getPlayerStats') {
    $playerName = $_GET['playerName'] ?? '';
    $stats = getPlayerStats($playerName);
    if ($stats) {
        echo json_encode(['success' => true, 'stats' => $stats]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Player not found']);
    }
}
?>
