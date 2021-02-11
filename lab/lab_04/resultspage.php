<?php
    // Connect to Database
    require_once 'includes/connectDB.php';

    $id = ReceivingIDfromGET($_GET['id']);

    // Checking table of database on empty
    CheckEmptyDataFromDatabase($pdo, $id);

    // Main layout
    require_once "includes/headerHTML.php";
?>
    <section class="main__board">
        <div class="container-sm">
            <a class="btn btn-primary" href="index.php" role="button">Назад</a>
            <div class="resultspage_">

                <?php
                // Create query for output data on screen
                $sql = 'SELECT * 
                        FROM interviews 
                        WHERE interviewcode=? 
                        LIMIT 1';
                $query = $pdo->prepare($sql);
                $query->execute([$id]);
                $data = $query->fetchALL(PDO::FETCH_ASSOC);

                // finding data in received information
                foreach ($data as $row) {
                    $victories = $row['victories'];
                    $defeats = $row['defeats'];
                }

                // Output data on screen
                echo "<h5>Пройденных успешно - " . $victories . "</h5><br>
                    <h5>Завершённых не успешно - " . $defeats . "</h5>";
                ?>
            </div>
        </div>
    </section>
<?php
    require_once "includes/endHTML.php";
?>