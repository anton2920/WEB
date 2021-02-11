<?php
    // ---- includes ----
    require 'includes/connectDB.php';
    // ------------------
    if(!isset($_SESSION['user'])){
        header('Location: /');
        exit();
    }
    // Receive data from Global GET/POST
    $id    = ReceivingIDfromGET($_GET['id']);
    $title = ReceiveTitleInterview($pdo, $id);

    // Creating SQL Query for receive data about numbers  of interviews
    $sql = 'SELECT * FROM questionsinterview WHERE interviewcode='.$id;

    // Executing query and receive data about number questions
    foreach ($pdo->query($sql) as $row)
        $questions[] = $row['questioncode'];

    // Create string from array for query, type "1,2,3,4"
    $place_holders = implode(',', $questions);
    $sql = 'SELECT * FROM question WHERE questioncode IN (' . $place_holders . ')';


    // Receive data about answers and essence of questions
    $i = 0;
    foreach ($pdo->query($sql) as $row){
        $var[$i][] = $row['var1'];
        $var[$i][] = $row['var2'];
        $var[$i][] = $row['var3'];
        $var[$i][] = $row['var4'];
        $vartrue[] = $row['vartrue'];
        $i++;
    }

    // Main layout
    require_once 'includes/headerHTML.php';
?>
    <section class="main__board">
        <div class="container-sm">
        <a class="btn btn-primary" href="index.php" role="button">Назад</a>
            <div class="result">
                <div class="title"><h2>Опрос: <?php echo $data['title']; ?></h2><br>
                    <h3>Ваш результат</h3>
                </div>
                <?php
                    $counter = 0;
                    $randnumbers = range(0,3);
                    
                    for ($i=0; $i < $_POST['count_questions']; $i++) {
                        echo "<div class=\"question__radio\">";
                        echo "<label for=\"input\">$essence[$i]</label><br>";

                       // Output on screen result
                        foreach($randnumbers as $randnumber){
                            if($_POST[$i] == $randnumber && ($randnumber+1) == $vartrue[$i]){
                                $part = " style=\"color:green\" ";
                                ++$counter;
                            }
                            else if($_POST[$i] == $randnumber && ($randnumber+1) != $vartrue[$i]){
                                $part = " style=\"color:red\" ";
                            }
                            else{
                                $part = "";
                            }
                             
                            echo "<p><li type=\"radio\"" . $part . "required value=\"$randnumber\" name=\"$i\">";
                            echo $var[$i][$randnumber] . "</p>";
                        }
                        echo "</div>";

                    }
                    // Checking result interview
                    if($counter > 3) {
                        echo "<div><h4>Результат:</h4><h3>Молодец!</h3></div><br><br><br>";
                        $sql = "UPDATE interviews SET victories = victories + 1 WHERE interviewcode=" . $id;
                    }
                    else{
                        echo "<div><h4>Результат:</h4><h3>У тебя обязательно получится в следующий раз!</h3></div><br><br><br>";
                        $sql = "UPDATE interviews SET defeats = defeats + 1 WHERE interviewcode=" . $id;
                    }
                    $pdo->query($sql);
                ?>
            </div>
        </div>
    </section>
<?php
    require_once "includes/endHTML.php";
?>