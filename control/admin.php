<?

  if (!$admin && !$editor) {
    $data = new New_Data('data/signin.json', 'signin');
    $views[] = 'view/signin.php';

  } else {
  	if ($router->page == 'admin') {
  		$data->regs = $model->getData('regs', 'admin/regs.json')['regs'];
  		$data->users = $model->getData('users', 'admin/users.json')['users'];

  	} elseif ($router->page == 'adduser') {
  		if (isset($router->itemId)) {
  			$data->person = $model->getData('regs', 'admin/regs.json')['regs'][$router->itemId];
  			$data->personId = $router->itemId;
  		}

  	} elseif ($router->page == 'removeuser') {
  		if (isset($router->itemId)) {
  			$data->person = $model->getData('users', 'admin/users.json')['users'][$router->itemId];
  			$data->personId = $router->itemId;
  		}
  	}

  	$views[] = "view/admin/$router->page.php";
  }
    
?>




