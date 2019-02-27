<hr class="h5">
<div>
  <div class="container">
  	<div class="flex flex-middle flex-center center" style="min-height: calc(80vh - 17.625rem)">
  		<div>
  			<div class="mess">
  				Remove user with mail: <?=$data->person['mail']?>?
  			</div><hr class="h2">
  			<form action="remove_user">

  				<div class="mess">
		    		<!-- <div class="success">You have successfully registered.<hr class="h05">We will contact you within 24 hours.</div> -->
		    		<div class="error">Something is wrong. Try again in a few minutes&ellip;</div>
		    	</div>
		    	
  				<input type="hidden" name="id" value="<?=$data->personId?>">
	   			<button type="submit" class="button submit fill-red">Remove</button><hr>
    			<a href="/admin/users" class="button modal-link">Cancel</a>
		  	</form>
		  </div>
		</div>
  </div>
</div>