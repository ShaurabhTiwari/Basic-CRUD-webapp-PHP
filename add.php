<?php 
    require_once "pdo.php";
    session_start();
    if ( ! isset($_SESSION['name']) ) {
        die('ACCESS DENIED');
    }

    if ( isset($_POST['cancel']) ) {
        header('Location: index.php');
        return;
    }
    
    if( isset($_POST['make']) && isset($_POST['model']) && isset($_POST['year']) && isset($_POST['mileage'])){
        if(strlen($_POST['make'])<1 || strlen($_POST['model'])<1 || strlen($_POST['year'])<1 || strlen($_POST['mileage'])<1){
            $_SESSION['failure'] = "<div style='color: red;'>All fields are required</div>";
            header("Location: add.php");
            return;
        }
        elseif(! (is_numeric($_POST['year']) && is_numeric($_POST['mileage']))){
            $_SESSION['failure'] = "<div style='color: red;'>Mileage and year must be numeric</div>";
            header("Location: add.php");
            return;
        }
        else {
            $stmt = $pdo->prepare('INSERT INTO autos
                (make, model, year, mileage) VALUES ( :mk, :md, :yr, :mi)');
            $stmt->execute(array(
                ':mk' => $_POST['make'],
                ':md' => $_POST['model'],
                ':yr' => $_POST['year'],
                ':mi' => $_POST['mileage']));
            $_SESSION['success'] = "Record Added";
            header("Location: index.php");
            return;
        }
    }
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Shaurabh Tiwari</title>
    </head>
    <body>
        <h1> Tracking Autos for
        <?php if(isset($_SESSION['name']))
                echo htmlentities($_SESSION['name']);
        ?>
        </h1>
        <?php 
            if(isset($_SESSION['failure'])){
                echo $_SESSION['failure'];
                unset($_SESSION['failure']);
            }
        ?>
        <form method='post'>
        <label for='mak'>Make</label>
        <input id='mak' name='make' type='text'><br>
        <label for='mod'>Model</label>
        <input id='mod' type='text' name='model'><br>
        <label for='yr'>Year</label>
        <input id='yr' name='year' type='text'><br>
        <label for='mlg'>Mileage</label>
        <input id='mlg' name='mileage' type='text'><br>
        <input type='submit' value='Add'>
        <input type='submit' name='cancel' value='Cancel'>
        </form>
    </body>
</html>