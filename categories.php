 <div class="half1"><div class="widget">
      <h3 class="widget-title">Категории</h3>

      <ul class="widget-list">

        <? for ($i=0;$i< $numberClass;$i++){?>
        <li><a href="index.php?id_class=<? echo $productClass[$i][id]; ?>  "><? echo $productClass[$i][Name_class]; ?></a></li>
          <ul class="pod">
            <? $productType = tableInputid($tab_name_product_type,$productClass[$i][id]); ?>
            <?for($k=0;$k < numberValid($tab_name_product_type,$productClass[$i][id]); $k++){?>
            <li><a href="index.php?id_type=<? echo $productType[$k][id]?>"><? echo $productType[$k][Name_product_type]; ?></a></li>
            <?}?>
          </ul>
          <? } ?>

      </ul>

    </div></div>