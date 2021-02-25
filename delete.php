<?php
    require_once "pdo.php";
    session_start();

    if(isset($_POST['autos_id']) && isset($_POST['delete'])){
        $sql = "DELETE FROM autos WHERE autos_id = :autos_id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(array(':autos_id' => $_POST['autos_id']));
        $_SESSION['success'] = "Record Deleted";
        header("Location: index.php");
        return;
    }

    if(! isset($_GET['autos_id'])){
        $_SESSION['error'] = 'Bad value for id';
        header("Location: index.php");
        return;
    }

    $stmt = $pdo->prepare("SELECT * FROM autos WHERE autos_id = :xyz");
    $stmt->execute(array(":xyz" => $_GET['autos_id']));
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    if ( $row === false ) {
        $_SESSION['error'] = 'Bad value for id';
        header( 'Location: index.php' ) ;
        return;
    }

    $id = $row['autos_id'];
    $n = $row['make'];
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Deleting.......</title>
    </head>
    <body>
        <h1>Confirm: Deleting <?= $n ?></h1>
        <form method='post'>
        <input type='hidden' name='autos_id' value="<?= $id ?>">
        <input type='submit' value='Delete' name='delete'>
        <a href='index.php'>Cancel</a>
        </form>
    </body>
</html>