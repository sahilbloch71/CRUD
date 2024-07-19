<?php 
require "connection.php";

if (isset($_GET['id'])) {
    $id = $_GET['id'];  

    $stmt = $con->prepare("SELECT * FROM Players WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $player = $result->fetch_assoc();

    if (!$player) {
        echo "Player not found.";
    }
    $stmt->close();
}

if (isset($_POST['update'])) {
    $old_id = $_POST['old_id'];
    $new_id = $_POST['id'];
    $name = $_POST['name'];
    $team = $_POST['team'];
    $run = $_POST['run'];
    $mvp = $_POST['MVP_rank'];
    $active = $_POST['active'];

    $st = $con->prepare("SELECT id FROM Players WHERE id = ? AND id != ?");
    $st->bind_param("ii", $new_id, $old_id);
    $st->execute();
    $result = $st->get_result();

    if ($result->num_rows > 0) {
        echo "Error: The new ID already exists.";
    } else {
        $update = $con->prepare("UPDATE Players SET id = ?, name = ?, team = ?, run = ?, MVP_rank = ?, active = ? WHERE id = ?");
        $update->bind_param("ississi", $new_id, $name, $team, $run, $mvp, $active, $old_id);
        if ($update->execute()) {
            echo "Player updated successfully.";
            header("Location: total_players.php");
            exit;
        } else {
            echo "Error: Could not update. " . $con->error;
        }
        $update->close();
    }
    $st->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Player</title>
</head>
<body>
    <h1>Edit Player</h1>

    <?php if (isset($player)): ?>
    <form action="edit.php?id=<?php echo $player['id']; ?>" method="post">
        <input type="hidden" name="old_id" value="<?php echo ($player['id']); ?>">

        <label>ID:</label>
        <input type="text" name="id" value="<?php echo ($player['id']); ?>" required><br>

        <label>Name:</label>
        <input type="text" name="name" value="<?php echo ($player['name']); ?>" required><br>
       
        <label>Team:</label>
        <input type="text" name="team" value="<?php echo ($player['team']); ?>" required><br>
        
        <label>Run:</label>
        <input type="text" name="run" value="<?php echo ($player['run']); ?>" required><br>
       
        <label>MVP Rank:</label>
        <input type="text" name="MVP_rank" value="<?php echo ($player['MVP_rank']); ?>" required><br>
        
        <label>Status:</label><br>
        <input type="radio" name="active" value="active" <?php echo ($player['active'] == 'active' ? 'checked' : ''); ?>> Active<br>
        <input type="radio" name="active" value="inactive" <?php echo ($player['active'] == 'inactive' ? 'checked' : ''); ?>> Inactive<br>

        <input type="submit" name="update" value="Update">
    </form>
    <?php else: ?>
    <p>Player not found.</p>
    <?php endif; ?>
</body>
</html>
