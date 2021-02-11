<?php
    // ---- includes ----
    require_once 'includes/connectDB.php';
    // ------------------
if(!isset($_SESSION['user'])){
    header('Location: /');
    exit();
}
// Receive data from Global GET/POST
    $id    = ReceivingIDfromGET($_GET['id']);
    $title = ReceiveTitleInterview($pdo, $id);


// Creating SQL query for receive data about questions of interview
    $sql = 'SELECT * 
        FROM questionsinterview 
        WHERE interviewcode=?';

    $query = $pdo->prepare($sql);
    $query->execute([$id]);
    $data = $query->fetchAll(PDO::FETCH_ASSOC);
    foreach($data as $item){
        $questions[] = $item['questioncode'];
    }

    // Create string from array for query, type "1,2,3,4"
    $place_holders = implode(',', $questions);
    $sql = 'SELECT * FROM question WHERE questioncode IN (' . $place_holders . ')';

    // Receive data about answers and essence of questions
    $i = 0;
    foreach ($pdo->query($sql) as $row)
    {
        $var[$i][] = $row['var1'];
        $var[$i][] = $row['var2'];
        $var[$i][] = $row['var3'];
        $var[$i][] = $row['var4'];
        $essence[] = $row['essence'];
        $i++;
    }
    $count_questions = count($essence);
    $html = <<<HERE
            <input type="hidden" name="count_questions"  value="$count_questions"/>
HERE;
    $randnumbers = range(0,3);
    // Main layout
    require_once "includes/headerHTML.php";
?>

    <section class="main__board">
        <div class="container-sm">
        <a class="btn btn-primary" href="index.php" role="button">Назад</a>
            <div class="interview">
                 <form action="result.php? id=<?php echo $id?>"  method="POST">
                    <div class="title"><h2>Опрос: <?php echo $title; ?></h2></div>
                     <?php for($i=0; $i < $count_questions; $i++):?>
                         <? shuffle($randnumbers) ?>
                        <div class="question__radio">
                            <label for="input"><? echo $essence[$i]; ?></label><br>
                            <?php foreach($randnumbers as $randnumber):?>
                                <p>
                                    <input type="radio" required value="<? echo $randnumber ?>" name="<? echo $i ?>"><? echo $var[$i][$randnumber] ?>
                                </p>
                            <?php endforeach; ?>
                        </div>
                     <?php endfor; ?>
                     <? echo $html ?>
                    <input class="btn btn-primary" type="submit" value="Отправить">

               </form>
            </div>
        </div>
    </section>
<?php
    require_once "includes/endHTML.php";
?>