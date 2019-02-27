<hr class="h5">
<div class="regs">
  <div class="container">
    <h1>Registrations</h1><hr class="h3">

    <div class="breadcrumbs accent f15">
    	<a href="/admin" class="exit">Admin panel</a>&nbsp;&nbsp;/&nbsp;
    	Registrations
    </div><hr class="h3">

    <div class="hscroll-mob">
	    <table>
	    	<? $i = 0 ?>
		    <? foreach ($data->regs as $id => $person): ?>
		    	<? if ($id == 'id0' ): ?>
		    		<thead>
		    			<tr>
		    				<td>#</td>
				    		<? foreach ($person as $key => $val): ?>
				    			<td><?=$val?></td>
				    		<? endforeach ?>
			    		</tr>
		    		</thead>
		    	<? else: ?>
		    		<tbody>
		    			<tr>
		    				<td class="num"><?=$i?></td>
				    		<? foreach ($data->regs['id0'] as $field => $fieldName): ?>
				    			<td class="<?=$field?>" title="<?=$fieldName?>">
				    				<? if (isset($person[$field])) echo $person[$field]; ?>
			    				</td>
				    		<? endforeach ?>
				    		<td>
				    			<a href="/admin/adduser/<?=$id?>" class="modal-link">Add User</a>
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
