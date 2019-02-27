<div class="showcase exchange">
  <div class="container">
  	<div class="flex flex-middle flex-1 intro-wrapper">
  		
      <div class="intro center">
        <hr class="h3">
        <div class="big-narrow">

          <h2 class="color f35"><?=$data->v1?></h2><hr>
          <div class="text ilbk">
          	<?=$data->v2?>
          </div><hr class="h3">

          <div class="exchange-form">

          	<div class="rel">
	          	<div class="flex flex-between left">
		          	<a href="#from" class="from-name bk hide-link drop"><?=$data->from['ves']['name']?></a>
		          	<div class="from-code"><?=$data->from['ves']['code']?></div>
		          </div>

	          	<div class="from-drop abs w100 fill-white hide z1 round overhide" id="from">
	          		<div class="flex flex-between flex-3 flex-wrap">
		          		<? foreach ($data->from as $key => $currency): ?>
		          			<a href="#from-<?=$key?>" class="hide-link black left curr-link" name="from" val="<?=$key?>"><?=$currency['name']?></a>
		          		<? endforeach ?>
		          	</div>
	          	</div>
	          </div>

	          <div class="rel">
		          <div class="flex flex-between left">
		          	<a href="#to" class="to-name bk hide-link drop"><?=$data->to['usd']['name']?></a>
		          	<div class="to-code"><?=$data->to['usd']['code']?></div>
		          </div>

	          	<div class="to-drop abs w100 fill-white hide z1 round overhide" id="to">
	          		<div class="flex flex-3 flex-wrap">
		          		<? foreach ($data->to as $key => $currency): ?>
		          			<a href="#to-<?=$key?>" class="hide-link black left curr-link" name="to" val="<?=$key?>"><?=$currency['name']?></a>
		          		<? endforeach ?>
		          	</div>
	          	</div>
	          </div>

          </div><hr class="h2">

          <form id="exchange-form" action="exchange">
          	<select class="hide" name="from">
          		<? foreach ($data->from as $key => $currency): ?>
          			<option value="<?=$key?>" <?=($key=='ves')?'selected':''?>><?=$currency['name']?></option>
          		<? endforeach ?>
          	</select>
          	<select class="hide" name="to">
          		<? foreach ($data->to as $key => $currency): ?>
          			<option value="<?=$key?>"><?=$currency['name']?></option>
          		<? endforeach ?>
          	</select>
          	<input class="hide" name="id" value="<?=($_SESSION['user'])?$_SESSION['user']['id']:''?>">

          	<div class="small-narrow" style="width: 20rem">
              <div class="f15 white light left wpad15"><?=$data->v4?></div><hr class="h05">
              <input type="text" name="name" class="amount req"><hr class="h05">

          		<div class="f15 white light left wpad15"><?=$data->v3?></div><hr class="h05">
          		<input type="number" name="amount" class="amount req"><hr>

              <div class="f15 white light left wpad15">WhatsApp</div><hr class="h05">
              <input type="text" name="whatsapp" class="amount req" value="<?=($_SESSION['user'])?$_SESSION['user']['whatsapp']:''?>"><hr class="h3">

          		<button type="submit" class="button big w100"><?=($lang)?'Continuar':'Continue'?></button><hr>
		          <a href="<?=$lang?>/" class="button big fill-gray exit w100"><?=($lang)?'Volver':'Back'?></a>
		        </div>

          </form><hr class="h3">

        </div>
        <hr class="h3">
        <hr class="h6 desk">
		  </div>

		</div>
  </div>
</div>
