<?php
session_start();
$limit_n=4; // Количество записей на странице
require_once 'conectdb.php';// подключение к баззе данных
?>
<!DOCTYPE html>
<html lang="en">
  <head>
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
      <div class="sort"><span>Сортировать:</span>
      <a href="index.php?sort=id<?php if ($query != ""){?>&search=<?php echo "$query";} if(isset($idClass)){?>&id_class=<? echo $idClass; } if(isset($id_type)){?>&id_type=<? echo $id_type;}?>">Новизна</a>|
      <a href="index.php?sort=Name<?php if ($query != ""){?>&search=<?php echo "$query";} if(isset($idClass)){?>&id_class=<? echo $idClass; } if(isset($id_type)){?>&id_type=<? echo $id_type;}?>">Название</a> |
      <a href="index.php?sort=NewCost<?php if ($query != ""){?>&search=<?php echo "$query";} if(isset($idClass)){?>&id_class=<? echo $idClass; } if(isset($id_type)){?>&id_type=<? echo $id_type;} ?>">Цена</a>
      <? if($page_n>0){ ?>
      <a href="index.php?sort=<? echo $sort;?>&page=<? echo $page_n-1; if(isset($idClass)){?>&id_class=<? echo $idClass; } if(isset($id_type)){?>&id_type=<? echo $id_type;} if(isset($query)){?>&search=<? echo $query;}?>"><<</a>
      <?}?>
      <? for($i_page=0;$i_page < $kol_page; $i_page++){ ?>
      
      <a href="index.php?cort=<? echo $sort;?>&page=<? echo $i_page; if(isset($idClass)){?>&id_class=<? echo $idClass; } if(isset($id_type)){?>&id_type=<? echo $id_type;} if(isset($query)){?>&search=<? echo $query;} ?>">
        <?if($i_page == $page_n){?> <strong> <?}?>
        <? echo $i_page+1; ?>
        <?if($i_page == $page_n){?> </strong> <?}?>
      </a>
      <? }?>
      <? if($page_n+1<$kol_page){ ?>
      <a href="index.php?sort=<? echo $sort;?>&page=<? echo $page_n+1; if(isset($idClass)){?>&id_class=<? echo $idClass; } if(isset($id_type)){?>&id_type=<? echo $id_type;} if(isset($query)){?>&search=<? echo $query;}?>">>>></a>
      <?}?>
    </div>
    <a href="cart.php"><div class="form2">
      <button> </button><span><?=$_SESSION['quantity']; ?></span>
    </div></a>
    
 <?require_once 'search.php'; /// Поиск ?>

  </div>
  
  <div class="body-main">
   <? require_once 'categories.php'; //категории товара ?> 
   
    <div class="half2"><div class = "vvod"><p><?php echo $text;?></p></div>
    <ol class="row">
      <? if($kol_page >= $page_n){?>
      <?php for ($i=0; $i < $limit_n; $i++) {
      if(isset($table[$i])){
      ?>
      <li class="tovar col-xs-12 col-sm-5">
        <a href="tovar.php?id_tovar=<?php echo($table[$i][id_tovar]);?>">
          <?php if($table[$i][Discounts] > 0){ ?> <p>sale</p><?php }?>
          <img src="<?php echo $table[$i][Image_Name]; ?>" alt="" >
          <div class="name-tovar"><h5><?php  echo "{$table[$i][Name]}";?></h5></div></a>
          <?php if($table[$i][Discounts] > 0){?>
          <div class="old-cost cost"><strike> <?php echo $table[$i][Cost].' ';?> </strike> <?php echo $table[$i][Currency]; ?> </div>
          <div class="tovar-cost cost"><?php echo $table[$i][NewCost].' '.$table[$i][Currency]; ?></div>
          <?php }?>
          <?php if($table[$i][Discounts] == 0){ ?>
          <div class="tovar-cost"><?php echo $table[$i][NewCost].' '.$table[$i][Currency]; ?></div>
          <?php }?>
          
        </li>
        <?php }}
        }else{ ?>
        <? echo "Ошибка 404"; ?>
        <? }?>
        
      </ol>
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