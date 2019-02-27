<hr class="h5">
<div class="register">
  <div class="container">
  	<div class="flex flex-middle flex-center" style="min-height: calc(80vh - 17.625rem)">
  		<div>

		    <form action="register">
		    	<h2><?=$data->v1?></h2><hr class="h15">
		    	<div class="mess">
		    		<div class="success"><?=$data->v2?></div>
		    		<div class="error"><?=$data->v3?></div>
		    	</div>
		    	<label>Full Name</label>
			    <input type="text" name="name" class="req"><hr class="h075">
		    	<label>Email</label>
			    <input type="text" name="mail" class="req"><hr class="h075">
		    	<label>WhatsApp</label>
			    <input type="text" name="whatsapp" class="req"><hr class="h15">
			    <input type="hidden" name="lang" value="<?=$router->lang?>">
			    <? if ($_SESSION['ref']): ?>
			    	<input type="hidden" name="ref" value="<?=$_SESSION['ref']?>">
			    <? endif ?>
			    <button type="submit" class="button submit"><?=($router->lang=='ru')?'Отправить':'Register'?></button>
		    </form><hr class="h2">

		    <div class="f1">
		    	<?=$data->v4?>
			    <hr>

			    <!-- <span class="f125 link">&larr;</span>&nbsp;<a href="/" class="exit">Back to the site</a> -->
			  </div>

		  </div>
		</div>
  </div>
</div>
