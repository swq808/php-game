<?php

function loadGameData($filename = 'data/gamePlay.json') {
    if (!file_exists($filename)) {
        return [];
    }
    $json = file_get_contents($filename);
    return json_decode($json, true) ?: [];
}

function saveGameData($data, $filename = 'data/gamePlay.json') {
    $dir = dirname($filename);
    if (!is_dir($dir)) {
        mkdir($dir, 0755, true);
    }
    file_put_contents($filename, json_encode($data, JSON_PRETTY_PRINT));
    return true;
}

function saveScore($playerName, $score, $date = null) {
    $date = $date ?? date('Y-m-d H:i:s');
    $plays = loadGameData();
    
    if (!is_array($plays)) {
        $plays = [];
    }
    
    $plays[] = [
        'playerName' => htmlspecialchars($playerName),
        'score' => (int)$score,
        'date' => $date,
        'difficulty' => 'normal'
    ];
    
    saveGameData($plays);
    return true;
}

function getAllScores() {
    return loadGameData();
}

function sortScoresBy($sortBy = 'score') {
    $scores = getAllScores();
    
    if (!is_array($scores) || empty($scores)) {
        return [];
    }
    
    usort($scores, function($a, $b) use ($sortBy) {
        switch ($sortBy) {
            case 'score':
                return (int)$b['score'] - (int)$a['score'];
            case 'name':
                return strcmp($a['playerName'], $b['playerName']);
            case 'date':
                return strtotime($b['date']) - strtotime($a['date']);
            default:
                return 0;
        }
    });
    
    return $scores;
}

function getTopScores($limit = 10) {
    $scores = sortScoresBy('score');
    return array_slice($scores, 0, $limit);
}

function getPlayerStats($playerName) {
    $scores = getAllScores();
    $playerScores = array_filter($scores, function($s) use ($playerName) {
        return strcasecmp($s['playerName'], $playerName) === 0;
    });
    
    if (empty($playerScores)) {
        return null;
    }
    
    $sortedByScore = array_values($playerScores);
    usort($sortedByScore, function($a, $b) {
        return (int)$b['score'] - (int)$a['score'];
    });
    
    return [
        'playerName' => $playerName,
        'totalGames' => count($playerScores),
        'bestScore' => (int)$sortedByScore[0]['score'],
        'averageScore' => (int)(array_sum(array_column($playerScores, 'score')) / count($playerScores))
    ];
}

function loadGameConfig($filename = 'data/gameConfig.json') {
    if (!file_exists($filename)) {
        $defaultConfig = [
            'gameName' => 'Flappy Bird',
            'version' => '1.0.0',
            'createdDate' => date('Y-m-d'),
            'aiUsage' => 'AI was used to help design the game mechanics and optimize the collision detection algorithm.',
            'credits' => [
                'Game Concept: Flappy Bird inspired game',
                'Developer: Replit Game Developer',
                'Framework: Vanilla PHP and JavaScript'
            ]
        ];
        saveGameConfig($defaultConfig, $filename);
        return $defaultConfig;
    }
    $json = file_get_contents($filename);
    return json_decode($json, true) ?: [];
}

function saveGameConfig($config, $filename = 'data/gameConfig.json') {
    $dir = dirname($filename);
    if (!is_dir($dir)) {
        mkdir($dir, 0755, true);
    }
    file_put_contents($filename, json_encode($config, JSON_PRETTY_PRINT));
    return true;
}

?>
