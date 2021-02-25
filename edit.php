<?php
    require_once "pdo.php";
    session_start();

    if (isset($_POST['cancel'])){
        header('Location: index.php');
        return;
    }

    if ( isset($_POST['make']) && isset($_POST['model']) && isset($_POST['year']) && isset($_POST['mileage']) && isset($_POST['autos_id']) ) {

        if ( strlen($_POST['make']) < 1 || strlen($_POST['model']) < 1) {
            $_SESSION['error'] = 'All fields are required';
            header("Location: edit.php?autos_id=".$_POST['autos_id']);
            return;
        }

        if (! (is_numeric($_POST['year']) && is_numeric($_POST['mileage']))) {
            $_SESSION['error'] = 'Mileage and Year must be Numeric';
            header("Location: edit.php?autos_id=".$_POST['autos_id']);
            return;
        }

        $sql = "UPDATE autos SET make = :make,
                model = :model, year= :year, mileage = :mileage
                WHERE autos_id = :autos_id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(array(
            ':make' => $_POST['make'],
            ':model' => $_POST['model'],
            ':year' => $_POST['year'],
            ':mileage' => $_POST['mileage'],
            ':autos_id' => $_POST['autos_id']));
        $_SESSION['success'] = 'Record edited';
        header( 'Location: index.php' ) ;
        return;
    }

    if ( ! isset($_GET['autos_id']) ) {
        $_SESSION['error'] = "Bad value for id";
        header('Location: index.php');
        return;
    }

    $stmt = $pdo->prepare("SELECT * FROM autos where autos_id = :xyz");
    $stmt->execute(array(":xyz" => $_GET['autos_id']));
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    if ( $row === false ) {
        $_SESSION['error'] = 'Bad value for autos_id';
        header( 'Location: index.php' ) ;
        return;
    }

    $n = htmlentities($row['make']);
    $m = htmlentities($row['model']);
    $y = htmlentities($row['year']);
    $autos_id = $row['autos_id'];
    $l = htmlentities($row['mileage']);
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Shaurabh Tiwari</title>
    </head>
    <body>
        <h1>Editing Automobile</h1>
        <?php
            if(isset($_SESSION['error'])){
                echo ("<p style='color: red;'>".$_SESSION['error']."</p>");
                unset($_SESSION['error']);
            }
        ?>

        <form method='post'>
        <label for='mak'>Make</label>
        <input id='mak' name='make' type='text' value="<?= $n ?>"><br>
        <label for='mod'>Model</label>
        <input id='mod' type='text' name='model' value="<?= $m ?>"><br>
        <label for='yr'>Year</label>
        <input id='yr' name='year' type='text' value="<?= $y ?>"><br>
        <label for='mlg'>Mileage</label>
        <input id='mlg' name='mileage' type='text' value="<?= $l ?>"><br>
        <input type="hidden" name="autos_id" value="<?= $autos_id ?>">
        <input type='submit' value='Save'>
        <input type='submit' name='cancel' value='Cancel'>
        </form>
    </body>
</html>