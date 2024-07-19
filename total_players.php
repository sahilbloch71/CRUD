<?php 
require "connection.php";

$sq = "SELECT id, name, team, run, MVP_rank, active FROM Players";
$res = mysqli_query($con, $sq);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Total Players</title>
</head>
<body>
    <h1>View Players</h1>
    <form action="apply_action.php" method="post">

    <select name="action">
            <option value="Trash">Trash</option>
            <option value="status_change">Status Change</option>
        </select>
        <button type="submit">Apply</button>

        <table border="1">
            <tr>
                <th>Select</th>
                <th>Id</th>
                <th>Name</th>
                <th>Team</th>
                <th>Run</th>
                <th>MVP Rank</th>
                <th>Active/Inactive</th>
                <th>Edit</th>
                <th>Delete</th>
            </tr>
            <?php
            if ($res->num_rows > 0) {
                while ($row = $res->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td><input type='checkbox' name='selected_ids[]' value='" . $row["id"] . "'></td>";
                    echo "<td>" . $row["id"] . "</td>";
                    echo "<td>" . $row["name"] . "</td>";
                    echo "<td>" . $row["team"] . "</td>";
                    echo "<td>" . $row["run"] . "</td>";
                    echo "<td>" . $row["MVP_rank"] . "</td>";
                    echo "<td>" . ($row["active"] == 1 ? "Active" : "Inactive") . "</td>";
                    echo "<td><a href='edit.php?id=" . $row["id"] . "'>Edit</a></td>";
                    echo "<td><a href='delete.php?id=" . $row["id"] . "'>Delete</a></td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='9'>No players found.</td></tr>";
            }
            ?>
        </table>
        
    </form>
    <a href="user_side.php">Back to Add User</a>
</body>
</html>
<?php
$con->close();
?>
