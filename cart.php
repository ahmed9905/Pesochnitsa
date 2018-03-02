<?php
session_start();
require_once 'conectdb.php';
$host  = $_SERVER['HTTP_HOST'];
$uri   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
$quantityall=0;// сумма заказа
// Корзина
foreach ($_SESSION['cart'] as $key => $value) {
$table[]= $value;
}
$kol = count($table);
// Изменение количества
if (isset($_GET['deletq']) || isset($_GET['addq'])) {
if(isset($_GET['deletq'])){
$id= intval ($_GET['deletq']);
if ($_SESSION['cart'][$id]['quantity']<1){
  $_SESSION['cart'][$id]['quantity']=0;
  }else{
    $_SESSION['cart'][$id]['quantity']--;
    $_SESSION['quantity']--;
  }
}elseif(isset($_GET['addq'])){
$_SESSION['quantity']++;
$id=$_GET['addq'];
$_SESSION['cart'][$id]['quantity']++;
}
$extra = "cart.php";
header("Location: http://$host$uri/$extra");
}
// Удаление товара
if(isset($_GET['action']) && $_GET['action']=='delet' && isset($table)){
$id = intval($_GET['id']);
$_SESSION['quantity']-= $_SESSION['cart'][$id]['quantity'];
unset($_SESSION['cart'][$id]);
$extra = "cart.php";
header("Location: http://$host$uri/$extra");
}
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Корзина</title>
    <link rel="stylesheet" href="path/to/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Bootstrap CSS <--></-->
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/css/bootstrap.min.css" integrity="sha384-/Y6pD6FV/Vv2HJnA6t+vslU6fwYXjCFtcEpHbNJ0lyAFsXTsjBbfaDjzALeQsN6M" crossorigin="anonymous">
  </head>
  <body>
    
    <div class="head">
      <div class="head-cent"> <a href="index.php"><img src="img/logo.png" alt=""></a>
    </div>
  </div>
  
  <div class="body">
    <div class="search">
      
      <a href="cart.php"><div class="form2">
        <button> </button><span><?=$_SESSION['quantity'];?></span>
      </div></a>
    </div>
    
    <div class="body-main">
      <div class="half3">
         <h5>Ваши товары</h5>

        <?if(isset($table)>0){ ?>
        <table border="0">
          
          <caption></caption>
          <tr>
            <th scope="col" class="table-tov">Товар</th>
            <th scope="col" scope="col" class="table-name"></th>
            <th scope="col" class="table-color"></th>
            <th scope="col" class="table-size">Размер</th>
            <th scope="col" class="table-col">Кол-во</th>
            <th scope="col" class="table-cost">Цена</th>
            <th scope="col" class="table-all">Сумма</th>
          </tr>
          <?php for($i=0; $i < $kol; $i++){?>
          <tr>
            <td><img src="<?=$table[$i][Image_Name]; ?>" alt="" width="100px" height="100px"></td>
            <td><?=$table[$i][Name]; ?><br> <h6>Цвет:</h6> <?=$table[$i][Color];?></td>
            <td>
              <a href="cart.php?action=delet&id=<?=$table[$i][id];?>"><div class="cross"></div></a>
            </td>
            <td><?php echo $table[$i][Size]; ?></td>
            <td><div class="chto">
              <a href="cart.php?deletq=<?=$table[$i][id];?>"><div class="strelki1">
              </div></a>
                  <input type="text" size="1px"  maxlength="2" value="<?=$table[$i][quantity];?>">
              <a href="cart.php?addq=<?=$table[$i][id]?>"><div class="strelki2">
                </div></a>
              </div>
            </td>
            <td><?php echo $table[$i][NewCost].' '.$table[$i][Currency]; ?> </td>
            <td><?php echo $table[$i][NewCost]*$table[$i][quantity].' '.$table[$i][Currency];?></td>
          </tr>
          <?$quantityall += $table[$i][NewCost]*$table[$i][quantity];}?>
          
        </table>

      </div>
      <div class="half4">
          <div class="summm"><h5><?echo "Итого:";?></h5></div>  
          <div class="summ-cost"><h4><? round($quantityall,2); echo "{$quantityall} {$table[0][Currency]}";?></h4></div>
           <? }else{?> 
           <?  echo "Корзина пуста"; ?>
           <?}?>

           <div class="continue"><p>продолжить покупки</p></div><br>
           <div class="end"><p>оплатить</p></div>
        </div>
      </div>
    </div>
    <div class="fott">
      <div class="row ">
        <div class="col  col-sm-2"><div class=" widget1">
          <h3 class="widget-title">Категории</h3>
          <ul class="widget-list1">
            <li><a href="">lorem</a></li>
            <li><a href="">lorem</a></li>
            <li><a href="">lorem</a></li>
            <li><a href="">lorem</a></li>
            <li><a href="">lorem</a></li>
            <li><a href="">lorem</a></li>
            <li><a href="">lorem</a></li>
          </ul>
        </div></div>
        <div class="col col-sm-2"><div class=" widget1">
          <h3 class="widget-title">Категории</h3>
          <ul class="widget-list1">
            <li><a href="">lorem</a></li>
            <li><a href="">lorem</a></li>
            <li><a href="">lorem</a></li>
            <li><a href="">lorem</a></li>
            <li><a href="">lorem</a></li>
            <li><a href="">lorem</a></li>
            <li><a href="">lorem</a></li>
          </ul>
        </div></div>
        <div class="col col-sm-2"><div class=" widget1">
          <h3 class="widget-title">Категории</h3>
          <ul class="widget-list1">
            <li><a href="">lorem</a></li>
            <li><a href="">lorem</a></li>
            <li><a href="">lorem</a></li>
            <li><a href="">lorem</a></li>
            <li><a href="">lorem</a></li>
            <li><a href="">lorem</a></li>
            <li><a href="">lorem</a></li>
          </ul>
        </div></div>
        <div class="col  col-sm-2"><div class=" widget1">
          <h3 class="widget-title">Категории</h3>
          <ul class="widget-list1">
            <li><a href="">lorem</a></li>
            <li><a href="">lorem</a></li>
            <li><a href="">lorem</a></li>
            <li><a href="">lorem</a></li>
            <li><a href="">lorem</a></li>
            <li><a href="">lorem</a></li>
            <li><a href="">lorem</a></li>
          </ul>
        </div></div>
        <div class="col  col-sm-3"><div class=" widget1"><script type="text/javascript" charset="utf-8" async src="https://api-maps.yandex.ru/services/constructor/1.0/js/?um=constructor%3A76dab686422f2afba303b83792d8ef2e4e8dd2c37b5ab45586731af47b1176f2&amp;width=500&amp;height=400&amp;lang=ru_RU&amp;scroll=true"></script></div>
      </div>
    </div>
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js" integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/js/bootstrap.min.js" integrity="sha384-h0AbiXch4ZDo7tp9hKZ4TsHbi047NrKGLO3SEJAg45jXxnGIfYzk4Si90RDIqNm1" crossorigin="anonymous"></script>
  </body>
</html>