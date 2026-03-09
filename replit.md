# Flappy Bird Game

A fully-featured Flappy Bird game built with PHP and vanilla JavaScript, featuring score tracking, a sortable leaderboard, and persistent data storage.

## Tech Stack
- **Backend**: PHP (built-in server)
- **Frontend**: HTML5, CSS3, vanilla JavaScript
- **Data Storage**: JSON files (gamePlay.json, gameConfig.json)
- **Environment**: Nix (for environment management)

## Features
- 🎮 **Game Mechanics**: Gravity-based bird physics with pipe obstacles
- 📊 **Score Tracking**: Real-time score updates during gameplay
- 🎨 **Visual Effects**: Bird rotation animation based on velocity
- 💾 **Persistent Leaderboard**: Save player scores with names
- 🏆 **Sortable Leaderboard**: Sort by score, player name, or date
- 📖 **About Page**: Game rules, credits, and AI usage documentation

## File Structure
- `index.php` - Main game interface with game logic
- `game.php` - API endpoints for saving and retrieving scores
- `leaderboard.php` - Leaderboard display with sorting
- `about.php` - Game information and documentation
- `functions.php` - Reusable PHP utility functions
- `data/gamePlay.json` - Player scores storage
- `data/gameConfig.json` - Game configuration and metadata

## Functions Available
- `loadGameData()` - Load gameplay data from JSON
- `saveGameData()` - Save gameplay data to JSON
- `saveScore()` - Add a new score entry
- `getAllScores()` - Retrieve all scores
- `sortScoresBy()` - Sort scores by score/name/date
- `getTopScores()` - Get top N scores
- `getPlayerStats()` - Get player statistics
- `loadGameConfig()` - Load game configuration
- `saveGameConfig()` - Save game configuration

## Game Rules
1. Click or press SPACE to make the bird fly upward
2. Navigate through gaps between pipes
3. Each pipe passed increases score by 1
4. Collision with pipes or ground ends the game
5. Save your score with your name to the leaderboard

## Setup & Running
The project runs on the PHP built-in server configured in the `.replit` file.

## Leaderboard Features
- Sort by score (highest first)
- Sort by player name (alphabetical)
- Sort by date (most recent first)
- Displays player name, score, and timestamp

## AI Usage
AI was used to:
- Design game mechanics and physics
- Optimize collision detection algorithms
- Structure the PHP backend functions
- Create responsive user interface design
- Develop sorting and data management logic
