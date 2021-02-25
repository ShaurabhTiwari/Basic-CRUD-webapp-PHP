<?php 
    require_once "pdo.php";
    session_start();
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Shaurabh Tiwari</title>
    </head>
    <body>
        <h1>Welcome to Automobiles Database</h1>
        <?php
            if(isset($_SESSION['error'])){
                echo ("<p style='color: red;'>".$_SESSION['error']."</p>");
                unset($_SESSION['error']);
            }

            if(isset($_SESSION['success'])){
                echo ("<p style='color: green;'>".$_SESSION['success']."</p>");
                unset($_SESSION['success']);
            }
        ?>
        <?php 
            if(isset($_SESSION['name'])){
                $stmt = $pdo->query("SELECT make, model, year, mileage, autos_id FROM autos");
                $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
                if(sizeof($rows)>0){
                    echo "<table style='border: 1px solid black;'><thead><tr><th style='border: 1px solid black;'>Make</th><th style='border: 1px solid black;'>Model</th><th style='border: 1px solid black;'>Year</th><th style='border: 1px solid black;'>Mileage</th><th style='border: 1px solid black;'>Action</th></tr></thead>";
                    foreach ($rows as $row){
                        echo "<tbody><tr><th style='border: 1px solid black;'>";
                        echo htmlentities($row['make'])."</td><td style='border: 1px solid black;'>";
                        echo htmlentities($row['model'])."</td><td style='border: 1px solid black;'>";
                        echo htmlentities($row['year'])."</td><td style='border: 1px solid black;'>";
                        echo htmlentities($row['mileage'])."</td><td style='border: 1px solid black;'>";
                        echo('<a href="edit.php?autos_id='.$row['autos_id'].'">Edit</a> / ');
                        echo('<a href="delete.php?autos_id='.$row['autos_id'].'">Delete</a>');
                        echo("</td></tbody>");
                    }
                    echo "</table>";
                    echo "<div><a href='add.php'>Add New Entry</a></div><br>";
                    echo "<div><a href='logout.php'>Logout</a></div>";
                }
                else{
                    echo "<div>No Rows Found</div>";
                    echo "<div><a href='add.php'>Add New Entry</a></div><br>";
                    echo "<div><a href='logout.php'>Logout</a></div>";
                }
            }
            else
                echo "<div><a href='login.php'>Please log in</a></div>";
        ?>
    </body>
</html>