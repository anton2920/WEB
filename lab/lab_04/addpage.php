<?php
    // ---- includes ----
    require_once 'includes/functions.php';
    require_once 'includes/headerHTML.php';
    session_start();
?>

    <section class="main__board">
        <div class="container-sm">
        <a class="btn btn-primary" href="index.php" role="button">Назад</a>
            <div class="add__interview">
            <form action="add.php" method="POST">
                   <br><h1>Добавление опроса</h1><br>        
                   <h4>Название опроса</h4>
                   <input type="text" name="title_interview" required/>
                   <br><br><br>

                    <?php   $value = 1;
                            $number__question = 1;
                            for($i = 0; $i < $COUNT_QUESTIONS_IN_INTERVIEW; $i++):?>
                        <div class="question">
                            <p>
                            <h5>Вопрос №<? echo $number__question?>:</h5>
                            <input type="text" name="text__question__<? echo $number__question;  ?>" class="text__question" required>
                            </p>
                            <div class="answer">
                                <div class="row">
                                    <div class="column">Ответ №1 <br>
                                        <input type="text" name="answer__one__question__<? echo $number__question;  ?>" required>
                                        <input type="radio" name="radio__question__<? echo $number__question;  ?>" value="<? echo $value; $value++; ?>" required>
                                    </div>
                                    <div class="column">Ответ №2 <br>
                                        <input type="text" name="answer__two__question__<? echo $number__question;  ?>" required>
                                        <input type="radio" name="radio__question__<? echo $number__question;  ?>" value="<? echo $value; $value++; ?>" required>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="column">Ответ №3 <br>
                                        <input type="text" name="answer__three__question__<? echo $number__question;  ?>" required>
                                        <input type="radio" name="radio__question__<? echo $number__question;  ?>""value="<? echo $value; $value++; ?>" required >

                                    </div>
                                    <div class="column">Ответ №4 <br>
                                        <input type="text" name="answer__four__question__<? echo $number__question;  ?>" required>
                                        <input type="radio" name="radio__question__<? echo $number__question; $number__question++; ?>" value="<? echo $value; $value++; ?>" required>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endfor; ?>
                     <input name="token" type="hidden" value="<? echo GetToken(); ?>"">
                   <input class="btn btn-primary" type="submit" value="Сохранить">      
               </form>
            </div>
        </div>
    </section>
<?php
    require_once "includes/endHTML.php";
?>