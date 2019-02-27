<hr class="h5">
<div class="regs">
  <div class="container">
    <h1>Add User</h1><hr class="h3">

    <div class="breadcrumbs accent f15">
    	<a href="/admin" class="exit">Admin panel</a>&nbsp;&nbsp;/&nbsp;
    	<a href="/admin/users" class="modal-link">Users</a>&nbsp;&nbsp;/&nbsp;
    	Add User
    </div><hr class="h3">

    <form action="add_user" class="ilbk">
    	<div class="mess">
    		<div class="success">User successfully added</div>
    		<div class="error">Something is wrong. Try again in a few minutes&ellip;</div>
    	</div>

    	<div class="flex flex-2 flex-wrap">
    		<div class="box">
		      <label class="req">Name</label>
			    <input type="text" name="name" class="req" value="<?=(isset($data->person['name']))?$data->person['name']:''?>"><hr class="h075">
		    	<label class="req">Email</label>
			    <input type="text" name="mail" class="req" value="<?=(isset($data->person['mail']))?$data->person['mail']:''?>"><hr class="h075">
		    	<label>WhatsApp</label>
			    <input type="text" name="whatsapp" value="<?=(isset($data->person['whatsapp']))?$data->person['whatsapp']:''?>"><hr class="h075">
					<label class="req">Password</label>
			    <input type="text" name="pass" class="req"><hr class="h15">
			  </div>
			  <div class="box">
			  	<label>Country</label>
			    <input type="text" name="country"><hr class="h075">
			  	<label>National ID</label>
			    <input type="text" name="national-id"><hr class="h075">
			    <label>Banking Info</label>
			    <input type="text" name="bank"><hr class="h15">
			    <!-- <label>Account Number</label>
			    <input type="text" name="number"><hr class="h075">
			    <label>Account Type</label>
			    <input type="text" name="type"><hr class="h15"> -->
			  </div>
			  <div class="box">
			  	<input type="hidden" name="balance" value="0">
			  	<input type="hidden" name="table" value="<tr><td>–</td><td>–</td><td>–</td><td>–</td><td>–</td></tr>">
			  	<input type="hidden" name="id" value="<?=$data->personId?>">
			  	<? if ($data->person['ref']): ?>
			  		<input type="hidden" name="ref" value="<?=$data->person['ref']?>">
			  	<? endif ?>
	    		<button type="submit" class="button submit">Add User</button>
			  </div>
			</div>

			

    </form>

  </div>
</div>