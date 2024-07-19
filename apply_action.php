<?php 
require "connection.php";


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!empty($_POST['selected_ids']) && !empty($_POST['action'])) {
        $selected_ids = $_POST['selected_ids'];
        $action = $_POST['action'];

        echo "Action: $action<br>";
        echo "Selected IDs: " . implode(', ', $selected_ids) . "<br>";

        foreach ($selected_ids as $id) {
            $id = intval($id);

            if ($action == "Trash") {
                $sql = "DELETE FROM Players WHERE id = ?";
                if ($stmt = $con->prepare($sql)) {
                    $stmt->bind_param("i", $id);
                    if ($stmt->execute()) {
                        echo "Deleted player with ID $id<br>";
                    } else {
                        echo "Error deleting player with ID $id: " . $stmt->error . "<br>";
                    }
                    $stmt->close();
                } else {
                    echo "Error preparing delete statement: " . $con->error . "<br>";
                }
            } elseif ($action == "status_change") {
                $sql = "SELECT active FROM Players WHERE id = ?";
                if ($stmt = $con->prepare($sql)) {
                    $stmt->bind_param("i", $id);
                    $stmt->execute();
                    $stmt->bind_result($current_status);
                    $stmt->fetch();
                    $stmt->close();

                    echo "Current status of player with ID $id: $current_status<br>";

                    $new_status = ($current_status == 1) ? 0 : 1;

                    $update_sql = "UPDATE Players SET active = ? WHERE id = ?";
                    if ($update_stmt = $con->prepare($update_sql)) {
                        $update_stmt->bind_param("ii", $new_status, $id);
                        if ($update_stmt->execute()) {
                            echo "Updated status of player with ID $id to $new_status<br>";
                        } else {
                            echo "Error updating status of player with ID $id: " . $update_stmt->error . "<br>";
                        }
                        $update_stmt->close();
                    } else {
                        echo "Error preparing update statement: " . $con->error . "<br>";
                    }
                } else {
                    echo "Error preparing select statement: " . $con->error . "<br>";
                }
            }
        }
    } else {
        echo "No action or selected IDs provided.<br>";
    }
}

$con->close();
header("Location: total_players.php");
exit();
?>
