<?php
    // CACHE SETTINGS ARE VERY IMPORTANT TO PREVENT THE BROWSER 
    // FROM CACHE USING CACHED RESULTS!!! 
    # dont look at the cache, and dont save anything to cache
    # Cache-Control: check it in local machine only
    header("Cache-Control:private, no-cache, no-store, must-revalidate");
    header("Content-Type:application/json");
    
    
    // echo "This is the index file.";
    $customUrl = $_GET["url"] ?? "";
    // echo $customUrl;
    
    // explode = split
    $pathData = explode("/", $customUrl);
    
    //Permitted API Routes
    $routeClasses=[
            "authors",
            "books"
    ];


    if(in_array($pathData[0], $routeClasses))
    {
       require_once("controllers/{$pathData[0]}.php");
       $routeClassName=ucfirst($pathData[0]) . "RestController"; // ucfirst= uppercase first character of each word
       $routeClassInstance= new $routeClassName();
       
       if(count($pathData)>1 && filter_var($pathData[1], FILTER_VALIDATE_INT))
       {
           if($_SERVER["REQUEST_METHOD"]=="GET")
           echo $routeClassInstance->getOne((int)$pathData[1]);
           else if($_SERVER["REQUEST_METHOD"]=="PUT")
           echo $routeClassInstance->update((int)$pathData[1]);
           
           
           else
           {
                http_response_code(400);
                echo json_encode([
                "status" => "error",
                "message" => "Unsupported HTTP method."
            ]);
           }
       }
       else
        {
            if($_SERVER["REQUEST_METHOD"]=="GET")
                echo $routeClassInstance->getAll();
            else if($_SERVER["REQUEST_METHOD"]=="POST")
                echo $routeClassInstance->insert();
            else
            {
                http_response_code(400);
                echo json_encode([
                    "status" => "error",
                    "message" => "Unsupported HTTP method."
                ]);
            }
        }
    }
    else
    {
        http_response_code(404);
        echo json_encode([
                "status" => "error",
                "message" => "Invalid endpoint."
            ]);
    }






