<?php 
require "connection.php";

if (isset($_GET['id'])){
    $id = $_GET['id'];
    
    $sql = "DELETE FROM Players WHERE id = ?";
    $stmt = $con->prepare($sql);
    $stmt->bind_param("i",$id);

    if($stmt->execute()){
        echo "Player deleted successfully.";
        header("Location: total_players.php");
        exit();

    }else{
        echo "Error Not delete." . $con->error;
    }
    $stmt->close();
    $con->close();
}else{
    echo "Invalid Request";
}

?>