<?php
session_start();
$host  = $_SERVER['HTTP_HOST'];
$uri   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
require_once 'conectdb.php';
// Берем с бд нужный нам товар по id
    if(isset($_GET['id_tovar'])){
      $id_tovar = (int)$_GET['id_tovar'];
      $table = tableInputid($tab_name_product,$id_tovar);// массив таваров
      if(isset($_GET['id'])){$id = $_GET['id'];}else{$id = $table[0][id];}
      $tableTovar = tableInputTovarid($tab_name_product,$id_tovar,$id);// текущий товар
      $table_color = tableUnicVal(Color,$id_tovar); //массив цветов и картинок
      $number_color = count($table_color); //Количество цветов
      for ($i=0; $i < $number_color; $i++) {
        $color = $table_color[$i][Color]; //цвета
        $result_set = $mysqli->query("SELECT `id`,`id_tovar`,`Size`,`Image_Name`,`Color` FROM `efim_product_` WHERE `id_tovar` = $id_tovar and `Color` = '$color'");  // запрас на размеры по цвету
         while (($row=$result_set->fetch_assoc()) != false) {
            $table_size[$color][] = $row[Size]; // сохранение размеров  
            $table_size[Size][$color][$row[Size]] = $row[id];  // Сохранение id размеров
          }
      }
  }
 // print_r($tableTovar);
//Добовление товара в корзину
if(isset($_GET['action']) && $_GET['action']=='add' && isset($_GET['id'])){
  $_SESSION['quantity']++;
  $id = intval($_GET['id']);
  if(isset($_SESSION['cart'][$id])){
    $_SESSION['cart'][$id]['quantity']++;
    $extra = "tovar.php?id_tovar={$id_tovar}&id={$id}";
   header("Location: http://$host$uri/$extra");
  }else{
    $result_set = $mysqli->query("SELECT `id`,`Name`,`Cost`,`Image_Name`,`Text`,`Discounts`,`Color`,`Currency`,`Size`,(`Cost`-`Discounts`) AS 'NewCost' FROM `$tab_name_product` WHERE id ='$id'");
    if (count($result_set)!=0){
      while (($row=$result_set->fetch_assoc()) != false) {
        $_SESSION['cart'][$id]=$row;
      }
    $_SESSION['cart'][$id]['quantity']='1';
    $extra = "tovar.php?id_tovar={$id_tovar}&id={$id}";
   header("Location: http://$host$uri/$extra");
    }

  }
}
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <title><?=$table[Name];?></title>
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
      <div class="head-cent"> <a href="index.php"><img src="img/logo.png" alt=""></a></div>
    </div>
    
    <div class="body">
      <div class="search">
        <a href="cart.php"><div class="form2">
          <button> </button><span><?=$_SESSION['quantity'];?></span>
        </div></a>
      </div>
      
      <div class="body-main">
        
        
        <? require_once 'categories.php'; //категории товара ?> 
        <?php if(isset($tableTovar)){?>
        <div class="half2">
          <div class="half2-1 body-pump"><img src="<?=$tableTovar[Image_Name];?>" alt="" ></div>
          <div class="half2-2 body-pump">
            <form action="<?=$_SERVER['PHP_SELF']?>">
              <?php if($tableTovar[Discounts] > 0){ ?>
              <p>sale</p>
              <?php }?>
              <div class="name-tovar2"> <h3><?php  echo($tableTovar[Name]);?></h3></div>
              <div class="about"> <?php  echo($tableTovar[Text]);?> </div>
              
              <div class="color">
                <dl>
                  <dt>Цвет:</dt>
                  <dd><?php for($i=0; $i<$number_color;$i++){ ?>
                  <a href="tovar.php?id_tovar=<?=$id_tovar;?>&id=<?=$table_color[$i][id];?>"><?php echo $table_color[$i][Color];?></a>
                  <?php }?></dd>
                  <dt>Размер:</dt>
                  <select name="id" >
                    <option disabled="">Пожалуйста выберите</option>
                    <?php   
                    for($i=0;$i< count($table_size[$tableTovar[Color]]);$i++){?>
                    <option value = "<?=$table_size[Size][$tableTovar[Color]][$table_size[$tableTovar[Color]][$i]];?>"><?=$table_size[$tableTovar[Color]][$i];?></option>
                    <?php }?>
                  </select>
                  </dd>
                </dl>
              </div>
              <?if($tableTovar[Discounts] > 0){ ?>
              <div class="old"> <strike> <?php echo $tableTovar[Cost].' ';?> </strike>
              <?=$tableTovar[Currency]; ?></div>
              <div class="new"><?=$tableTovar[NewCost].' '.$tableTovar[Currency]; ?></div>
              <?php }
              else
              {?>
              <div class="new"><?=$tableTovar[NewCost].' '.$tableTovar[Currency];?>
              </div>
              <?php }?>
              <input style="display: none" name="id_tovar" value="<?=$tableTovar[id_tovar]?>">
              <button name = action value = 'add'>Добавить в корзину</button>
            </div>
          </form>
        </div>
      </div>
    </div>
    <?php }else{ ?>
    <?php echo "Извините но данный товар не существует"; ?>
    <?php }?>
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
    <script type="text/javascript">
    </script>
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js" integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/js/bootstrap.min.js" integrity="sha384-h0AbiXch4ZDo7tp9hKZ4TsHbi047NrKGLO3SEJAg45jXxnGIfYzk4Si90RDIqNm1" crossorigin="anonymous"></script>
  </body>
</html>