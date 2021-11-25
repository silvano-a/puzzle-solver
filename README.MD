## Sliding block / Maze solver ##

### Currently supported puzzles: ###
- Maze

### Feature supported puzzles: ### 
- rush hour / car park
- sliding puzzle 
- sliding block puzzle


### To run the script: ###
- `composer install`
- `php console solve`

### To create your own maze: ###
- Navigate to `src/Game/Field.php`
- Find the function `get10x10`
- Modify the maze. 
  - `.` (period) resembles an empty space.
  - letters `a` through `g` resemble moving objects / cars
  - any other character resembles a wall
    
### To Modify the win condition ###
- Navigate to `src/Game/GameConfig.php`
- Find the function `isSolution`
- Modify the `if` statement to accurately represent the wincondition
- Modify the string in `getSolutionAsString()` to visually show the correct wincondition