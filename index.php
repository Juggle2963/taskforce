<?php
           //Bort tagning av uppgifter
           
           if($_SERVER["REQUEST_METHOD"] === "POST"){
            if(isset($_POST['delete-index'])){

            
            $arr = file('data.txt', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES); //läser in - skapar array, varje rad är ett element

            $index = $_POST["delete-index"] ?? ''; //vid delete vilken rad som ska raderas
          

            unset($arr[$index]);   // tar bort index elementet och omindexerar med array_values

           $arr = array_values($arr); 

            $data = implode(PHP_EOL, $arr) . PHP_EOL;

            file_put_contents('data.txt', $data); //skriver tillbaka uppdaerad lista till filen
            file_put_contents('d.txt', $index, FILE_APPEND);


            header("Location: index.php");
            exit();
            }
        }

        //Hantera inmatning av uppgifter

        if($_SERVER["REQUEST_METHOD"] === "POST"){
            if(isset($_POST['vad'])){

            $vad = trim($_POST['vad'] ?? ''); //Tar bort onödiga space
            // print_r($POST);

            if(!empty($vad)){
                $data = implode(' ', [$vad]) . PHP_EOL;
                file_exists('data.txt') ? file_put_contents('data.txt', $data, FILE_APPEND) : file_put_contents('data.txt', $data); // Skapa fil om den inte finns annars lägg till längst ner - lägger till input från form
            }
            
        }
        //Rensa tomma rader i filen
        if(file_exists('data.txt')){
          $eraseEmpty =  file('data.txt', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES); //Skriver fil till array
          $erased = implode(PHP_EOL, $eraseEmpty) . PHP_EOL;
          file_put_contents('data.txt', $erased);
        }

        }
       

        ?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            background-color: #786a5d;
        }

        .index-container {
            display: flex;
            flex-direction: column;
            max-width: 1140px;
            min-width: 350px;
            margin: 0 auto;
            align-items: center;
            justify-content: center;
            background-color: #786a5d;

        }


        .container {
            display: grid;
            grid-template-columns: 50% 50%;
            justify-content: center;
            border: 1px solid black;
            border-radius: 8px;
            width: 75%;
            padding: 2rem;
            margin-top: 3vh;
            background-color: #5d786a;
            column-gap: 2rem;

        }



        .tasks {
            display: grid;
            place-items: center;
            /* display: flex; */
            background-color:rgb(80, 66, 93);
            min-height: 50vh;
            border-radius: 5%;
            /* justify-content: center;
            align-items: center; */
        }

        .task-box {
            display: flex;
            flex-direction: column;
            width: 80%;
            height: 80%;
            background-color: rgb(219, 215, 222);
            overflow-y: auto;
  
        }

        .form {

            background-color: #6a5d78;
            min-height: 50vh;
            border-radius: 8px;
            padding: 1rem;
             
            display: flex;
        }

        .form-form {
           border-radius: 8px;

           display: flex;
           width: 100%;
           flex-direction: column;
           justify-content: space-between;
        }
        textarea{
            display: flex;
            height: 75%;
            background-color: white;
        }
        .info{
            display: flex;
            justify-content: space-between;
            width: 100%;
            margin-bottom: 0.2rem;
        }


        input[type="submit"] {
            width: 100%;
            background-color: #4CAF50;
            color: white;
            padding: 14px 20px;
            margin: 8px 0;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        input[type=submit]:hover {
            background-color: #45a049;
        }
        .btn:hover{
            background-color: #45a049;
        }
        .btn{
            /* width: 19%; */
            background-color: #4CAF50;
            color: white;
            padding: 5px 5px;
            margin-top: 2px;
            margin-bottom: 2px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        .input{
            width:80%;
            display: flex;
            justify-content: right;
        }
    </style>
</head>

<body>
    <main class="index-container">

        <div class="container">
            <div class="form">
                <form class="form-form" action="" method="POST">
                <label for="name">vad</label>
                <textarea name="vad" id="vad" rows="5" cols="40" placeholder="<---- TaskForce ---> skriv in uppgift"></textarea>

                    <input type="submit" >
                </form>
            </div>

            <div class="tasks">
                <?php

                        $arr = array_filter(file('data.txt'), function($line) {
                        return trim($line) !== ''; //så att allt hamnar på samma rad i output div
                        });
                        ?>
                    <div class="task-box">
                     <?php foreach ($arr as $key => $value): ?>
                        
                         <?php echo "
                         <div class='info' >
                           <div>" 
                             . $value . " 
                           </div>" .
                          "<div class='input'> 
                          <form action='' method='POST'>
                             <input type='hidden' name='delete-index' value='$key'>
                             <button class='btn' type='submit'>Ta bort</button>
                             </form>
                         </div>";
                          ?>
                        
                        <?php unset($_POST['vad']);?>
    
                    
                    </div>
                        <?php endforeach ?>
                </div>

            </div>
            
            
            
            
        </main>
       
    
</body>

</html>