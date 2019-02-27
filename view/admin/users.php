<hr class="h5">
<div class="users">
  <div class="container">
    <h1>Users</h1><hr class="h3">

    <div class="breadcrumbs accent f15">
    	<a href="/admin" class="exit">Admin panel</a>&nbsp;&nbsp;/&nbsp;
    	Users
    </div><hr class="h3">

    <a href="/admin/adduser" class="modal-link button">Add User</a>
    <hr class="h2">
    
    <div style="overflow-x: scroll; -webkit-overflow-scrolling: touch">
	    <table>
	    	<? $i = 0 ?>
		    <? foreach ($data->users as $id => $person): ?>
		    	<? if ($id == 'id0' ): ?>
		    		<thead>
		    			<tr>
		    				<td>#</td>
				    		<? foreach ($person as $key => $val): ?>
				    			<? if (in_array($key, ['password', 'table'])) continue; ?>
				    			<td><?=$val?></td>
				    		<? endforeach ?>
			    		</tr>
		    		</thead>
		    	<? else: ?>
		    		<tbody>
		    			<tr>
		    				<td class="num"><?=$i?></td>
				    		<? foreach ($data->users['id0'] as $field => $fieldName): ?>
				    			<? if (in_array($field, ['password', 'table'])) continue; ?>
				    			<td class="<?=$field?>" title="<?=$fieldName?>">
				    				<? if ($field == 'name'): ?>
				    					<a href="/profile/<?=$id?>"><?=$person[$field]?></a>
				    				<? elseif ($field == 'ref'): ?>
				    					<?=$data->users[$person[$field]]['name']?>
				    				<? else: ?>
				    					<? if (isset($person[$field])) echo $person[$field]; ?>
				    				<? endif ?>
			    				</td>
				    		<? endforeach ?>
				    		<td>
				    			<? if (!isset($person['group']) || $person['group'] != 'admin'): ?>
				    				<a href="/admin/removeuser/<?=$id?>" class="modal-link" id="<?=$id?>">Remove</a>
				    			<? endif ?>
				    		</td>
			    		</tr>
		    		</tbody>
		    	<? endif ?>
		    	<? $i++ ?>
		    <? endforeach ?>
		  </table><hr>
		</div>
  </div>
</div>
