# Flappy Bird Game

A classic Flappy Bird game built with HTML5 Canvas, vanilla JavaScript, and PHP backend for leaderboard management.

## How to Play

- **Click** or **press SPACE** to make the bird flap/jump
- Avoid the green pipes
- Score points by successfully passing through the gaps
- Enter your name to save your score to the leaderboard
- Game ends when you hit a pipe or the ground

## Features

- ✅ Smooth physics and gravity mechanics
- ✅ Randomly generated pipe obstacles  
- ✅ Score tracking with visual display
- ✅ Game over modal with save functionality
- ✅ Responsive controls (mouse click or keyboard)
- ✅ Persistent leaderboard (JSON-based)
- ✅ Sortable by: Score, Player Name, Date
- ✅ Visual effects: Gradient pipes, animated bird eyes
- ✅ About page with game rules and documentation

## Technical Stack

- **Frontend**: HTML5 Canvas, vanilla JavaScript
- **Backend**: PHP for score management
- **Data**: JSON files (gamePlay.json, gameConfig.json)
- **Styling**: Pure CSS3
- **No external dependencies required**

## Project Files

- `index.php` - Main game page with Canvas rendering
- `leaderboard.php` - Score leaderboard with sorting
- `about.php` - Game rules, features, and credits
- `game.php` - API endpoint for saving/retrieving scores
- `functions.php` - Reusable PHP functions (8 functions)
  - loadGameData()
  - saveGameData()
  - saveScore()
  - getAllScores()
  - sortScoresBy()
  - getTopScores()
  - getPlayerStats()
  - loadGameConfig()
  - saveGameConfig()
- `data/gamePlay.json` - Player scores database
- `data/gameConfig.json` - Game configuration and credits

## Gameplay Requirements Met

✅ Score tracking that updates as the player progresses
✅ Game over state with restart capability
✅ Visual effects: gradient pipes and animated bird
✅ Sortable leaderboard by 3+ criteria (score, name, date)
✅ Save gameplay using a player name
✅ No login system required

## Technical Requirements Met

✅ Two JSON data files (gamePlay.json, gameConfig.json)
✅ Reusable PHP functions in functions.php (9 functions)
✅ About page with rules and credits
✅ Complete leaderboard system with sorting
