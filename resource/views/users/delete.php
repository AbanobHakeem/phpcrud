
<?php require_once '/xampp/htdocs/phpcrud/database/connection.php' ?>
<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $statment = $pdo->prepare('DELETE FROM USERS WHERE ID = :ID');
    $statment->bindValue(":ID", $_REQUEST['id']);
    $statment->execute();
}
header('Location:index.php');
