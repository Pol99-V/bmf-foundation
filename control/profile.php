<?

	if (!isset($_SESSION['user'])) {
		$data = new New_Data('data/signin.json', 'signin');
    $views[] = 'view/signin.php';

  } elseif ($router->itemId) {
  	$data->user = json_decode(file_get_contents('data/admin/users.json'), true)['users']['users'][$router->itemId];
  	$data->user['id'] = $router->itemId;
  	if (!$admin && $data->user['group'] == 'admin') $ce = '';
  	if (!$admin && $data->user['group'] == 'editor') $ce = '';

		$views[] = "view/$router->page.php";
		
	} else {
		$data->user['id'] = $_SESSION['user']['id'];
		if (!$admin && $editor)
			$ce = '';

		$views[] = "view/$router->page.php";
	}

?>