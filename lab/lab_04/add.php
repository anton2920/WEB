<?php

    // ---- includes ----
    require_once 'includes/connectDB.php';
    require_once 'includes/functions.php';
    // ------------------
    session_start();
    // Receive data from POST about interview
    if(!CheckToken($_POST['token'], $_SESSION['token']))
        header("Location: /");

    foreach ($_POST as $key => $value) {
        if(substr_count($key, 'text__question'))
            $essence[] = FixXSS($value);
        elseif(substr_count($key, 'answer__one__question'))
            $var1[] = FixXSS($value);
        elseif(substr_count($key, 'answer__two__question'))
            $var2[] = FixXSS($value);
        elseif(substr_count($key, 'answer__three__question'))
            $var3[] = FixXSS($value);
        elseif(substr_count($key, 'answer__four__question'))
            $var4[] = FixXSS($value);
        elseif(substr_count($key, 'radio__question'))
            $vartrue[] = FixXSS($value);
        elseif(substr_count($key, 'title_interview'))
            $title = FixXSS($value);
    }

    // Check on 'is empty'
    if(empty($essence) ||
        empty($title) ||
        empty($var1) ||
        empty($var2) ||
        empty($var3) ||
        empty($var4) ||
        empty($vartrue))
        header("Location: /");

    // SQL Query for add interview in database
    $sql = 'INSERT INTO interviews(title, victories, defeats ) 
                VALUES(:title, :victories, :defeats)';

    // Preparing and execute query to database in table 'interviews'
    $query = $pdo->prepare($sql);
    // Checking, that query is completed correct
    if(!$query->execute(['title'     => $title,
                         'victories' => 0,
                         'defeats'   => 0]))
        header("Location: /");
    // Receive last insert ID
    $lastInsertIdInterview = $pdo->lastInsertId();


    // Create query for add data in table 'question'
    $sql = 'INSERT INTO question(essence, var1, var2, var3, var4, vartrue) 
                VALUES(:essence, :var1, :var2, :var3, :var4, :vartrue)';


// Loop for add questions in table 'questions'
    for($i = 0; $i<count($essence); $i++)
    {
        // Determining right answer from 1 to 4
        $vartrue[$i] = ((int)$vartrue[$i])%4;
        if($vartrue[$i] == 0)
            $vartrue[$i] = 4;

        // Preparing query for add quiestion in table 'questions' and executing.
        $query = $pdo->prepare($sql);
        $query->execute(['essence' => $essence[$i],
            'var1'    => $var1[$i],
            'var2'    => $var2[$i],
            'var3'    => $var3[$i],
            'var4'    => $var4[$i],
            'vartrue' => $vartrue[$i]]);

        // Saving data for table 'questionsinterview'
        $ligament[] = $pdo->lastInsertID();
    }


    // Creating query to table 'questionsinterview'
    $sql = 'INSERT INTO questionsinterview(interviewcode, questioncode) 
                VALUES(:interviewcode, :questioncode)';
    $query = $pdo->prepare($sql);
    foreach ($ligament as $item){
        $query->execute(['interviewcode' => $lastInsertIdInterview, 'questioncode' => $item]);
    }
    header("Location: /");
?>
