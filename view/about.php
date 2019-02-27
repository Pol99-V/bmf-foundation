<hr class="h5">
<div id="about" class="about">
  <div class="container">
  	<h1 class="color"><?=$data->v1?></h1><hr class="h2">
		<img src="img/about2.jpg" class="w30 toright round desk" style="margin: 0 0 10% 10%">
		<div class="text toleft w60 adapt">
			<img src="img/about2.jpg" class="w40 toright round mob" style="margin: 0 0 10% 10%">
      <div class="rel">
  			<div <?=$ce?>>
          <?=$data->about?>
        </div>
        <? if ($admin): ?>
          <form action="save_var" class="right abs">
            <input type="hidden" name="lang" value="<?=$router->lang?>">
            <input type="hidden" name="data" value="<?=$router->data?>">
            <input type="hidden" name="page" value="<?=$router->page?>">
            <input type="hidden" name="var" value="about"><hr>
            <button type="submit" class="save">Save</button>
          </form>
        <? endif ?>
        <hr class="h3">
      </div>
		</div>
	</div>
</div>
