<!doctype html>
<html>
    <body>
        <?php
            if($_SERVER["REQUEST_METHOD"]=="POST")
            {
                require_once("dbhelper.php");
                DBHelper::initializeDatabase();
                
                // $sql = new DBHelper();
                // $sql->execute("INSERT INTO users(name,email,phone,province) VALUES('Khushi', 'khushi@shah.com', '111-222-3334', 'ON')");
                
                echo "<h3>Database Initialized</h3>";
            }
        ?>
        <form method="POST">
            <input type="submit" value="Initialize Database" >
        </form>
    </body>
</html>
    








