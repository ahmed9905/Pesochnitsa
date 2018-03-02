<?php
if($_POST['search'] != "" or $_GET['search'] != ""){
if(isset($_POST['search'])){$query = $_POST['search'];}elseif(isset($_GET['search'])){$query = $_GET['search'];}
$query = trim($query);
$query = htmlspecialchars($query);
if ($query != '') {
if (strlen($query) < 2) {$f=0;
$text ='Слишком короткий поисковый запрос.';
}elseif (strlen($query)>128) {$f=0;
$text = 'Слишком длинный поисковый запрос.';
}else {
	$table=[];
	if(!isset($_GET['sort'])){$sort='id';}else{$sort = $_GET['sort'];}
	if(isset($_GET['page'])){
      $page_n=$_GET['page'];
      $position_n = $limit_n*$page_n;
      }else{
       $position_n=0;
       $page_n = 0; //текущая страница
     }
$q = "SELECT `id`,`id_tovar`,`Name`,`Cost`,`Image_Name`,`Text`,`Discounts`,`Color`,`Currency`,(`Cost`-`Discounts`) AS 'NewCost'  FROM `efim_product_` WHERE `Name` LIKE '%$query%'
OR `Text` LIKE '%$query%' GROUP BY Name  HAVING COUNT(Name) ORDER BY `$sort` LIMIT $position_n,$limit_n";
$result = $mysqli->query($q);
$table=[];
while (($row=$result->fetch_assoc()) != false) {
$table[]=$row;
}
$numberValsearch= searchUnicValCount($query);
$kol= $numberValsearch;
$kol_page = $kol/$limit_n;
if($kol>0){$f=1;
$text ='По запросу "'.$query.'" найдено совпадений: '.$kol;
}else{$text = 'По вашему запросу ничего не найдено.';$f=1;}
}
}else{ $text = 'Задан пустой поисковый запрос.';$f=1;}
}
?>
<div class="form">
      <form name="search" method="post" action="<?=$_SERVER['PHP_SELF']?>">
        <input type="search" name="search" placeholder="Искать здесь...">
        <button type="submit"></button>
      </form>
 </div>