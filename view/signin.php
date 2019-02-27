<hr class="h5">
<div class="signin">
  <div class="container">
  	<div class="flex flex-middle flex-center" style="min-height: calc(80vh - 17.625rem)">
  		<div>

		    <form action="login" method="post">
		    	<h2><?=$data->v1?></h2><hr class="h15">

		    	<div class="mess">
		    		<!-- <div class="success">You have successfully registered.<hr class="h05">We will contact you within 24 hours.</div> -->
		    		<div class="error"><?=$data->v2?></div>
		    	</div>

			    <label>Email</label>
			    <input type="text" name="mail" autofocus="true"><hr>
			    <label><?=$data->v3?></label>
			    <input type="password" name="pass"><hr class="h15">
		    	<button type="submit" class="button submit"><?=$data->v5?></button>
		    </form><hr class="h2">

		    <div class="f1">
		    	<?=$data->v4?>
			    <hr class="h2">

			    <!-- <span class="f125 link">&larr;</span>&nbsp;<a href="/" class="exit">Back to the site</a> -->
			  </div>

		  </div>
		</div>
  </div>
</div>
