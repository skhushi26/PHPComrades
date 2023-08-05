<?php
    # Because we are using htaccess, we should give the whole path
    require_once(__DIR__ . "/../../dal/dbhelper.php");
    
    class AuthorsRestController
    {
        function getAll()
        {
            global $pdo;
            $data=[];
            $stmt = $pdo->query("SELECT * FROM author");
            while($row=$stmt->fetch())
            {
                $data[]=[
                    "AuthorId" => $row["AuthorId"],
                    "FirstName" => $row["FirstName"],
                    "LastName" => $row["LastName"]
                ];
            }
            # json_encode convert our data to json, it returns a string represents all the authors
            http_response_code(200);
            return json_encode($data);
        }
        
        
        function getOne($id)
        {
            global $pdo;
            $data=[
                    "AuthorId" => 0,
                    "FirstName" => "None",
                    "LastName" => "None"
                ];
            
            $stmt=$pdo->prepare("SELECT * FROM author WHERE AuthorId=:AuthorId");
            if($stmt->execute(["AuthorId" => $id]))
            {
                if($row=$stmt->fetch())
                {
                    $data=[
                        "AuthorId" => $row["AuthorId"],
                        "FirstName" => $row["FirstName"],
                        "LastName" => $row["LastName"]
                    ];
                }
            }
            
            http_response_code(200);
            return json_encode($data);
        }
        
        function insert()
        {
            //It appears since we used .htaccess to rewrite the request,
            //the POST variables are not sent?
            //Link: https://stackoverflow.com/questions/20725272/do-variables-sent-using-post-get-sent-to-php-if-using-mod-rewrite
            //Comment: It's possibly an Apache 2.4 issue. I needed to add 
            //         parse_str(file_get_contents("php://input"),$_POST); 
            //         to index.php. – rybo111
            parse_str(file_get_contents("php://input"),$_POST);
            
            $firstName=htmlspecialchars($_POST["firstName"]);
            $lastName=htmlspecialchars($_POST["lastName"]);
            
             global $pdo;
            
            $stmt=$pdo->prepare("INSERT INTO author(FirstName, LastName) VALUES (:FirstName, :LastName)");
            $stmt->execute([
                    "FirstName" => $firstName,
                    "LastName" => $lastName
                ]);
            
            if($stmt->rowCount()>0)
            {
               http_response_code(201);
               return json_encode(
                   [
                       "status" => "OK",
                       "message" => "Record inserted.",
                       "newId" => $pdo -> lastInsertId(),
                       "post" => $_POST
                   ]);
            }

           http_response_code(500);
           return json_encode(
               [
                   "status" => "error",
                   "message" => "Error inserting record.",
                   "newId" => $pdo.lastInsertId()
               ]);
            
            
            http_response_code(200);
            return json_encode($data);
        }
        
        
          function update($id)
        {
            //PHP doesn't have a super global for PUT variables, but
            //the query string of the URL can be accessed from the 
            //file path "php://input". We can parse this to an array
            //using parse_str(); 
            parse_str(file_get_contents("php://input"),$_POST);
            
            $firstName=htmlspecialchars($_POST["firstName"]);
            $lastName=htmlspecialchars($_POST["lastName"]);
            
            global $pdo;
            $stmt=$pdo->prepare("update author set FirstName=:FirstName, LastName=:LastName where AuthorId=:AuthorId");
            $stmt->execute([
                "AuthorId" => $id,
                "FirstName" => $firstName,
                "LastName" => $lastName
            ]);
            
            if($stmt->rowCount()>0)
            {
                http_response_code(200);
                return json_encode([
                    "status" => "ok",
                    "message" => "Record updated."
                ]);
            }
            http_response_code(500);
            return json_encode([
                "status" => "error",
                "message" => "Error updating record."
            ]);
        }
    }











