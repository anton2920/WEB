<?php

    require 'config.php';
    session_start();
    // Function for check is empty data from database
    // Result on error - redirect to '/'
    // Returns on success - true
    function CheckEmptyDataFromDatabase($pdo, $id){
        $sql = 'SELECT * 
            FROM interviews 
            WHERE interviewcode=' . $id;
        if($response = $pdo->query($sql)){
            if(!$response->fetch()){
                header("Location: /");
            }
            else{
                return true;
            }
        }
    }

    function DefiningCountPages($pdo){
        // Counting count elements in table 'interviews'
        // Creating SQL query for receive count
        $sql = "SELECT COUNT(*) 
                as title 
                FROM interviews";
        // Executing query and receive count rows
        if(($query=$pdo->query($sql)) == false){
            header("Location: /");
        }
        global $ROWS_ON_PAGE;
        $query->setFetchMode(PDO::FETCH_ASSOC);
        $row=$query->fetch();
        return ($row['title']/$ROWS_ON_PAGE)+1;
    }

    function ReceiveTitleInterview($pdo, $id){
        // Create SQL query for receive data about title interview
        $sql = 'SELECT * 
            FROM interviews 
            WHERE interviewcode=?
            LIMIT 1';
        // Preparing and Executing query
        $query = $pdo->prepare($sql);
        $query->execute([$id]);
        $data = $query->fetchAll(PDO::FETCH_ASSOC);
        foreach($data as $item){
            $title = $item['title'];
        }

        if(empty($title) && $title != 0)
            header("Location: /");
        else
            return $title;

    }

    function ReceivingIDfromGET($id){
        if(is_numeric($id)) {
            return $id;
        }
        else
            header("Location: /");
    }

    function FixXSS($str){
        return htmlspecialchars($str, ENT_QUOTES);
    }

    function GetToken(){
        if(empty($_SESSION['token'])){
            $_SESSION['token'] = uniqid('', true);
            echo "Fff;f;f;f;f; - " . $_SESSION['token'];
        }
        return password_hash($_SESSION['token'], PASSWORD_DEFAULT);
    }

    function CheckToken($token){
        return password_verify($_SESSION['token'], $token);
    }
?>