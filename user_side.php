<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sports</title>
</head>
<body align="center">
    <form action="" method="POST">
        <h1>Players Form</h1>
        
        <div>
            <label for="name">Name</label><br>
            <input type="text" name="name" required>
        </div><br>

        <div>
            <label for="team">Team</label><br>
            <input type="text" name="team">
        </div><br>

        <div>
            <label for="run">Run</label><br>
            <input type="number" name="run">
        </div><br>

        <div>
            <label for="MVP_rank">MVP Rank</label><br>
            <input type="number" name="MVP_rank">
        </div><br>
    
        
        <div>
            <input type="submit" name="submit" value="Save">
        </div><br>
        <a href="total_players.php">View Players</a>
    </form>

<?php 
require "connection.php";

if(isset($_POST['submit'])){
    $name = $_POST["name"];
    $team = $_POST["team"];
    $run = $_POST["run"];
    $MVP_rank = $_POST["MVP_rank"];


    $sql = $con->prepare("INSERT INTO Players (name, team, run, MVP_rank) VALUES (?, ?, ?, ?)");
    $sql->bind_param("ssii", $name, $team, $run, $MVP_rank);

    if($sql->execute()){
        echo "Inserted...";
    } else {
        echo "Not Inserted: " . $sql->error;
    } 
    $sql->close();    
}
$con->close();
?>
</body>
</html>
