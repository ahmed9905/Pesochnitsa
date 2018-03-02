<?php
require_once 'conectdb.php';



$kal =  tableInputAll();
print_r($kal);
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="css/style1.css">
    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/css/bootstrap.min.css" integrity="sha384-/Y6pD6FV/Vv2HJnA6t+vslU6fwYXjCFtcEpHbNJ0lyAFsXTsjBbfaDjzALeQsN6M" crossorigin="anonymous">
    <link rel="stylesheet" href="path/to/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
  </head>
  <body>
    <form name ='inp' action="input.php" method="post" enctype="multipart/form-data">
      <p>
        Имя: <div class="name"> <input type="text" name="Name"></div>
      </p>
      <p>
        Цена: <div class="cost"> <input type="text" name="Cost"></div>
      </p>
      <p>
        Цена со скидкой: <div class="discounts"> <input type="text" name="Discounts"></div>
      </p>
      <p>
        Описание: <div class="Text"> <input type="text" name="Text"></div>
      </p>
      <p>
        <input type="file" name="image">
        <input type="submit" name="inp" value="Отправить ">
      </p>
    </form>
    <?php
    if(isset($_POST['inp'])){
    $name= $mysqli->real_escape_string(htmlspecialchars($_POST['Name']));
    $cost= $mysqli->real_escape_string(htmlspecialchars($_POST['Cost']));
    $text= $mysqli->real_escape_string(htmlspecialchars($_POST['Text']));
    $discounts = $mysqli->real_escape_string(htmlspecialchars($_POST['Discounts']));
    $uploaddir = './img/';
    $uploaddir = $uploaddir.basename($_FILES["image"]["name"]);
    if(copy($_FILES["image"]["tmp_name"],$uploaddir)){
    echo "Файл успешно загружен на сервер";
    }else{
    echo "  Ошибка  ";
    }
    
    $query = "INSERT INTO `efim_product`
    (`Name`, `Cost`,`Image_Name`,`Text`,`Discounts`)
    VALUES ('$name', '$cost', '$uploaddir','$text','$discounts');";
    $result = $mysqli->query($query);
    //header("Location: index.php");
    }
    
    ?>
  </body>
</html>