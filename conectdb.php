<?php

define('DB_HOST', 'localhost');
define('DB_USER', 'efidanvs_katalog');
define('DB_PASSWORD','12345678');
define('DB_NAME','efidanvs_katalog');
$mysqli = @new mysqli(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME);
if($mysqli->connect_errno) exit('Ошибка соединения с БД');
$mysqli->set_charset('utf-8');
$host  = $_SERVER['HTTP_HOST'];
$uri   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
if(!isset($_SESSION['quantity'])){
$_SESSION['quantity']=0;
}
	// таблицы
	$tab_name_product_type = 'efim_product_type';
	$tab_name_product_class = 'efim_product_class';
	$tab_name_product_sex = 'efim_product_sex';
	$tab_name_product  = 'efim_product_';
	$tab_name_product_table = 'efim_product_table';

// Категории
  $numberClass = numberVal('efim_product_class'); 
  $productClass = tableInputAll('efim_product_class');
    if(isset($_GET['id_class'])){ // по классу 
    if(!isset($_GET['sort'])){$sort='id';}else{$sort = $_GET['sort'];}
     if(isset($_GET['page'])){
      $page_n=$_GET['page'];
      $position_n = $limit_n*$page_n;
      }else{
       $position_n=0;
       $page_n = 0; //текущая страница
     }
    $idClass = $_GET['id_class'];
    $table = tableInputUnicSortLimitClassid($tab_name_product,$position_n,$limit_n,$sort,$idClass);
     if(isset($table)){
    $numberValTable = UnicValCountClass(Name,$idClass);
    $kol_page = ($numberValTable/$limit_n); // Количество страниц
    }
    }
    if(isset($_GET['id_type'])){ // по типу
    if(!isset($_GET['sort'])){$sort='id';}else{$sort = $_GET['sort'];}
     if(isset($_GET['page'])){
      $page_n=$_GET['page'];
      $position_n = $limit_n*$page_n;
      }else{
       $position_n=0;
       $page_n = 0; //текущая страница
     }
     
    $id_type = $_GET['id_type'];
    $table = tableInputUnicSortLimitTypeid($tab_name_product,$position_n,$limit_n,$sort,$id_type);
    if(isset($table)){
    $numberValTable = UnicValCountType(Name,$id_type);
    $kol_page = ($numberValTable/$limit_n); // Количество страниц
    }
    }


	function tableInputAll($tab = 'efim_product_'){  //вывод всех значений таблицы $tab.
		$mysqli = new mysqli(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME);
		if($tab == 'efim_product_'){
		$result_set = $mysqli->query("SELECT  * ,(Cost-Discounts) AS 'NewCost' FROM `$tab`");
		}else{
		$result_set = $mysqli->query("SELECT  * FROM `$tab`");
		}
		$table=[];
		while (($row=$result_set->fetch_assoc()) != false) {
			$table[] = $row;
		}
		return $table;
	}
		function tableInputPart($tab = 'efim_product_'){  //вывод части значений таблицы .
		$mysqli = new mysqli(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME);
		if($tab == 'efim_product_'){
		$result_set = $mysqli->query("SELECT  `Name`,`id`,`id_tovar`,`Cost`,`Image_Name`,`Discounts`,`Size`,`Currency` ,(Cost-Discounts) AS 'NewCost' FROM `$tab`");
		}else{
		$result_set = $mysqli->query("SELECT  * FROM `$tab`");
		}
		$table=[];
		while (($row=$result_set->fetch_assoc()) != false) {
			$table[] = $row;
		}
		return $table;
	}
	function tableInputid($tab = 'efim_product_',$id_tovar){  //вывод  значений таблицы продуктов по id.
		$mysqli = new mysqli(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME);
		if($tab == 'efim_product_'){
		$result_set = $mysqli->query("SELECT  `Name`,`id`,`id_tovar`,`Cost`,`Text`,`Color`,`Image_Name`,`Discounts`,`Size`,`Currency` ,(Cost-Discounts) AS 'NewCost' FROM `$tab` WHERE `id_tovar` = $id_tovar");
		}elseif($tab == 'efim_product_type'){
		$result_set = $mysqli->query("SELECT  * FROM `$tab` WHERE `id_product_class` = $id_tovar");
		}else{
		$result_set = $mysqli->query("SELECT  * FROM `$tab` WHERE `id` = $id_tovar");
		}
		$table;
		while (($row=$result_set->fetch_assoc()) != false) {
			$table[] = $row;
		}
		return $table;
	}
	function tableInputTovarid($tab = 'efim_product_',$id_tovar,$id){  //вывод  значений таблицы продуктов по id.
		$mysqli = new mysqli(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME);
		$result_set = $mysqli->query("SELECT  `Name`,`id`,`id_tovar`,`Cost`,`Text`,`Color`,`Image_Name`,`Discounts`,`Size`,`Currency` ,(Cost-Discounts) AS 'NewCost' FROM `$tab` WHERE `id` = $id");
		$table;
		while (($row=$result_set->fetch_assoc()) != false) {
			$table= $row;
		}
		return $table;
	}

	function tableInputUnicClassid($tab = 'efim_product_',$idClass){  //вывод  значений таблицы продуктов по классу.
		$mysqli = new mysqli(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME);
		if($tab == 'efim_product_'){
		$result_set = $mysqli->query("SELECT  `Name`,`id`,`id_tovar`,,`Cost`,`Image_Name`,`Discounts`,`Size`,`Currency` ,(Cost-Discounts) AS 'NewCost' FROM `$tab` WHERE `id_class` = $idClass GROUP BY Name  HAVING COUNT(Name) ");
		}elseif($tab == 'efim_product_type'){
		$result_set = $mysqli->query("SELECT  * FROM `$tab` WHERE `id_product_class` = $id");
		}else{
		$result_set = $mysqli->query("SELECT  * FROM `$tab` WHERE `id` = $id");
		}
		$table;
		while (($row=$result_set->fetch_assoc()) != false) {
			$table[] = $row;
		}
		return $table;
	}
	function tableInputUnicSortClassid($tab = 'efim_product_',$sort= 'id',$idClass){  //вывод  значений таблицы продуктов по классу.
		$mysqli = new mysqli(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME);
		if($tab == 'efim_product_'){
		$result_set = $mysqli->query("SELECT  `Name`,`id`,`id_tovar`,`Cost`,`Image_Name`,`Discounts`,`Size`,`Currency` ,(Cost-Discounts) AS 'NewCost' FROM `$tab` WHERE `id_class` = $idClass GROUP BY Name  HAVING COUNT(Name) ORDER BY `$sort`");
		}elseif($tab == 'efim_product_type'){
		$result_set = $mysqli->query("SELECT  * FROM `$tab` WHERE `id_product_class` = $id");
		}else{
		$result_set = $mysqli->query("SELECT  * FROM `$tab` WHERE `id` = $id");
		}
		$table;
		while (($row=$result_set->fetch_assoc()) != false) {
			$table[] = $row;
		}
		return $table;
	}

	function tableInputUnicSortLimitClassid($tab = 'efim_product_',$position_n = 0,$limit_n,$sort= 'id',$idClass){  //вывод  значений таблицы продуктов по классу.
		$mysqli = new mysqli(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME);
		if($tab == 'efim_product_'){
		$result_set = $mysqli->query("SELECT  `Name`,`id`,`id_tovar`,`Cost`,`Image_Name`,`Discounts`,`Size`,`Currency` ,(Cost-Discounts) AS 'NewCost' FROM `$tab` WHERE `id_class` = $idClass GROUP BY Name  HAVING COUNT(Name) ORDER BY `$sort` LIMIT $position_n,$limit_n");
		}elseif($tab == 'efim_product_type'){
		$result_set = $mysqli->query("SELECT  * FROM `$tab` WHERE `id_product_class` = $id");
		}else{
		$result_set = $mysqli->query("SELECT  * FROM `$tab` WHERE `id` = $id");
		}
		$table;
		while (($row=$result_set->fetch_assoc()) != false) {
			$table[] = $row;
		}
		return $table;
	}
	function tableInputUnicSortLimitTypeid($tab = 'efim_product_',$position_n = 0,$limit_n,$sort= 'id',$idType){  //вывод  значений таблицы продуктов по классу.
		$mysqli = new mysqli(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME);
		if($tab == 'efim_product_'){
		$result_set = $mysqli->query("SELECT  `Name`,`id`,`id_tovar`,`Cost`,`Image_Name`,`Discounts`,`Size`,`Currency` ,(Cost-Discounts) AS 'NewCost' FROM `$tab` WHERE `id_type` = $idType GROUP BY Name  HAVING COUNT(Name) ORDER BY `$sort` LIMIT $position_n,$limit_n");
		}elseif($tab == 'efim_product_type'){
		$result_set = $mysqli->query("SELECT  * FROM `$tab` WHERE `id_product_type` = $id");
		}else{
		$result_set = $mysqli->query("SELECT  * FROM `$tab` WHERE `id` = $id");
		}
		$table;
		while (($row=$result_set->fetch_assoc()) != false) {
			$table[] = $row;
		}
		return $table;
	}
   function numberPagesAll($limit_n){ /// определение количество уикальных Name записей в таблице и количество страниц в зависимости от limit_n(макс записей на странице)
   $mysqli = new mysqli(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME);
   $result_set = $mysqli->query("SELECT `Name` FROM `efim_product_` GROUP BY Name  HAVING COUNT(Name)");
  while (($row=$result_set->fetch_assoc()) != false){
  $res[]=$row;
  }
  $kol_page = ceil(count($res)/$limit_n);
  return $kol_page;
  }
  function numberVal($tab = 'efim_product_'){ /// определение количество записей в таблице 
   $mysqli = new mysqli(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME);
   $result_set = $mysqli->query("SELECT COUNT(1) FROM `$tab`");
  while (($row=$result_set->fetch_assoc()) != false){
  $res=$row;
  }
  $kol = ceil($res["COUNT(1)"]);
  return $kol;
  }
  function numberValid($tab = 'efim_product_type',$id){ /// определение количество записей в таблице чье id равное $id

   $mysqli = new mysqli(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME);
   if($tab = 'efim_product_type'){
	$result_set = $mysqli->query("SELECT COUNT(1) FROM `$tab` WHERE `id_product_class`= $id ");
   }else{
   $result_set = $mysqli->query("SELECT COUNT(1) FROM `$tab` WHERE `id`= $id ");
	}
  while (($row=$result_set->fetch_assoc()) != false){
  $res=$row;
  }
  $kol = ceil($res["COUNT(1)"]);
  return $kol;
  }
  function unicVal($val){ // вывод уникальных значений столбца $val 
    $mysqli = new mysqli(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME);
	$result_set = $mysqli->query("SELECT DISTINCT `$val` FROM `efim_product_`");
	$unicVal= [];
	while (($row=$result_set->fetch_assoc()) != false) {
		$unicVal[]=$row;
	}
	return $unicVal;
  }
  function unicValCount($val){ // вывод уникальных значений столбца $val 
    $mysqli = new mysqli(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME);
	$result_set = $mysqli->query("SELECT DISTINCT `$val` FROM `efim_product_`");
	$unicVal= [];
	while (($row=$result_set->fetch_assoc()) != false) {
		$unicVal[]=$row;
	}
	return count($unicVal);
  }
  function unicValCountClass($column = 'Name',$id_class){ // вывод уникальных значений столбца $column по классу
    $mysqli = new mysqli(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME);
	$result_set = $mysqli->query("SELECT DISTINCT `$column` FROM `efim_product_` WHERE `id_class` = '$id_class'");
	$unicVal= [];
	while (($row=$result_set->fetch_assoc()) != false) {
		$unicVal[]=$row;
	}
	return count($unicVal);
  }
  function unicValCountType($column = 'Name',$id_type){ // вывод уникальных значений столбца $column по классу
    $mysqli = new mysqli(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME);
	$result_set = $mysqli->query("SELECT DISTINCT `$column` FROM `efim_product_` WHERE `id_type` = '$id_type'");
	$unicVal= [];
	while (($row=$result_set->fetch_assoc()) != false) {
		$unicVal[]=$row;
	}
	return count($unicVal);
  }
  function searchUnicValCount($query){ //поиск
	$mysqli = new mysqli(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME);
	$result_set = $mysqli->query("SELECT `id`,`id_tovar`,`Name`,`Cost`,`Image_Name`,`Text`,`Discounts`,`Color`,`Currency` FROM `efim_product_` WHERE `Name` LIKE '%$query%'
OR `Text` LIKE '%$query%' GROUP BY Name  HAVING COUNT(Name)");
	$unicVal= [];
	while (($row=$result_set->fetch_assoc()) != false) {
		$unicVal[]=$row;
	}
	return count($unicVal);
  }
  function tableUnicVal($column,$id_tovar){   //вывод таблицы уник значений по колонке и id_tver
	$mysqli = new mysqli(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME);
	$result_set = $mysqli->query("SELECT `id`,`id_tovar`,`Image_Name`,`Color` FROM `efim_product_` WHERE `id_tovar` = $id_tovar GROUP BY $column  HAVING COUNT($column)");
		$unicVal= [];
	while (($row=$result_set->fetch_assoc()) != false) {
		$unicVal[]=$row;
	}
	return $unicVal;
  }
  function tableUnicValSize($column,$id_tovar,$color='Черный'){   //вывод таблицы уник значений по колонке и id_tver
	$mysqli = new mysqli(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME);
	$result_set = $mysqli->query("SELECT `id`,`id_tovar`,`Size`,`Image_Name`,`Color` FROM `efim_product_` WHERE `id_tovar` = $id_tovar and `Color`= $color");
		$unicVal= [];
	while (($row=$result_set->fetch_assoc()) != false) {
		$unicVal[]=$row;
	}
	return $unicVal;
  }
?>