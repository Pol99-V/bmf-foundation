<?

class Model {

	public function getData(
		$page,
		$file = 'pages.json',
		$limit = 0,
		$hidden = false,
		$reverse = false,
		$rnd = false,
		$priority = false,
		$lang = 'en'
	) {

		$dataDir = ($lang == 'ru')? 'data/ru' : 'data';
		$data = json_decode(file_get_contents("$dataDir/$file"), true)[$page];
		
		if (!$hidden)
			foreach ($data as $key => $val)
				if (isset($val['hidden']) && $val['hidden'] === true)
					unset($data[$key]);

		if ($priority)
			foreach ($data as $key => $val)
				if ($val['priority'] != $priority)
					unset($data[$key]);

		if ($reverse)
			$data = array_reverse($data);

		if ($limit)
			$data = array_slice($data, 0, $limit, true);

		if ($rnd)
			$data = $this->rnd($data);
		
		// reset($data);
		return $data;
	}

	public function rnd($data) {
		$rndData = [];
		$numVals = array_values($data);
		$numKeys = array_keys($data);
		$range = range(0, count($data)-1);
		shuffle($range);
		foreach ($range as $id)
			$rndData[$numKeys[$id]] = $numVals[$id];
		unset($numVals, $numKeys, $range);
		return $rndData;
	}

	public function getList($list, $string, $limit = 0) {
		$sorted = [];
		foreach (explode(' ', $string) as $key)
			$sorted[$key] = $list[$key];
		return $sorted;
	}

	public function getListAddData($list, $extraData) {
		$sorted = [];
		foreach ($extraData as $itemKey => $item) {
			$sorted[$itemKey] = $list[$itemKey];
			foreach ($item as $varKey => $val)
				$sorted[$itemKey][$varKey] = $val;
		}
		return $sorted;
	}

	public $blockConstruct = false;

	public function getBlock() {
		$this->blockConstruct = true;
	  ob_start();
	}

	function getSnippet($file, $data) {
		if (is_file($file)) {
			ob_start();
			include $file;
			return ob_get_clean();
		} else return false;
	}

	public $filterFields = [
		'format',
		'allvideos',
		'allalbums',
		'allphotos',
		'hide'
	];
	public function filter($arr, $filter, $limit = 0) {
		if ($filter == 'all')
			return $arr;
		$filter = explode('&', $filter);
		foreach ($filter as $var) {
			$filter[explode('=', $var)[0]] = explode('=', $var)[1];
			unset($filter[$var]);
		}
		$res = [];
		foreach ($arr as $arr_key => $arr_val)
			foreach ($filter as $filter_key => $filter_val)
				if (in_array($filter_key, $this->filterFields))
					if ($arr_val[$filter_key] == $filter_val)
						$res[$arr_key] = $arr_val;
		return ($limit)? array_slice($res, 0, $limit, true) : $res;
	}

	function getMap($list, $field) {
		return array_count_values(array_column($list, $field));
	}

	function imgProps($img) {
    $props = getimagesize("$img");
    $ratio = round($props[0]/$props[1], 2);
    $size = "$props[0]x$props[1]";
    $extpos = strrpos($img,'.');
    $thumb = substr($img,0,$extpos).'.thumb'.substr($img,$extpos);
    $thumb = (file_exists($thumb))? $thumb : $img;
    return array($thumb, $size, $ratio);
  }

  public function getPos($friend) {
  	$prep = ($friend['pos'] == 'President')?' of ' : ' at ';
		if (!$friend['company']) $prep = '';
		$pos = "$friend[pos]$prep$friend[company]";
		if (strlen($pos) > 55) $pos = ($friend['company'])? $friend['company'] : $friend['pos'];
		return $pos;
  }

  function login($post) {
  	$err = false;
	  if (isset($_SESSION['user'])) {
	  	echo json_encode(['status' => true, 'err' => 4]);
	  	exit;
	  }

    if (isset($post['mail']) && trim($post['mail']))
    	$mail = $post['mail']; else $err = 1;
    if (!$err && isset($post['pass']) && trim($post['pass']))
    	$pass = $post['pass']; else $err = 1;
    
    $userData = false;
    if (!$err) {
	    $users = json_decode(file_get_contents('data/admin/users.json'), true)['users']['users'];
	    foreach ($users as $key => $user)
	    	if (array_search($mail, $user)) {
	    		$userData = $user;
	    		$userId = $key;
	    		break;
	    	}
    }
    if (!$err && $userData == false) $err = 2;
    if (!$err && $pass !== $userData['pass']) $err = 2;
  	unset($userData['pass']);

		$res['status'] = ($err)? false : true;
	  if ($err) $res['err'] = $err;
	  else $_SESSION['user'] = ['id' => $userId] + $userData;
		echo json_encode($res);
	  exit;
	  
  }

  // function admin_login($post) {
	 //  if (!isset($_SESSION['admin']) || $_SESSION['admin'] !== true) {
	 //    $err = false;
	 //    if (!isset($post['mail']) || $post['mail'] != 'js@gmail.com') $err = 'mail';
	 //    elseif (!isset($post['pass']) || $post['pass'] != '123') $err = 'pass';
	 //    if (!$err) {
	 //      $_SESSION['admin'] = true;
	 //      echo json_encode(true);
	 //    } else
	 //    	echo json_encode(false);
	 //    unset($err);
	 //  } else echo json_encode(true);
	 //  exit;
  // }

  function logout() {
		session_unset();
    echo json_encode(true);
    exit;
  }

  public $fields = [
		'subject' 	=> 'Subject',
		'title' 		=> 'Project title',
		'email' 		=> 'Email',
		'budget' 		=> 'Budget (BTC)',
		'text' 			=> 'Text'
  ];

  public $userFields = [
  	'mail' 			=> 'Email',
  	'pass' 			=> 'Password',
  	'phone'			=> 'Phone',
  	'whatsapp'	=> 'WhatsApp',
  	'name' 			=> 'Name',
  	'company'		=> 'Company',
  	'national-id' => 'National ID',
  	'pos'  			=> 'Position',
  	'lang'			=> 'Language',
  	'address'   => 'Address',
  	'country'   => 'Country',
  	'balance' 	=> 'Balance',
  	'table' 		=> 'Table',
  	'ref' 			=> 'Referral',
  	'bank'			=> 'Banking Info',
  	'number'		=> 'Account Number',
  	'type'			=> 'Account Type'
  ];


  function register($post) {
  	$err = false;
  	if (isset($_SESSION['user'])) {
	  	echo json_encode(['status' => false, 'err' => 4]);
	  	exit;
	  }

  	if (isset($post['mail']) && trim($post['mail']))
	    $mail = $post['mail']; else $err = 1;
	  if (isset($post['whatsapp']) && trim($post['whatsapp']))
	    $whatsapp = $post['whatsapp']; else $err = 1;
	  if ($err) {
	  	echo json_encode(['status' => false, 'err' => $err]);
	  	exit;
	  }


	  $lang = (isset($post['lang']) && trim($post['lang']))? $post['lang'] : 'en';
	  $users = json_decode(file_get_contents('data/admin/users.json'), true)['users']['users'];
    foreach ($users as $key => $user)
    	if (array_search($mail, $user)) {
    		$err = 5;
    		break;
    	}
    $file = 'data/admin/regs.json';
  	$users = json_decode(file_get_contents($file), true)['regs']['regs'];
    foreach ($users as $key => $user)
    	if (array_search($mail, $user)) {
    		$err = 5;
    		break;
    	}
    if ($err) {
	  	echo json_encode(['status' => false, 'err' => $err]);
	  	exit;
	  }

		end($users);
		$id = ($users && count($users))? intval(substr(key($users), 2))+1 : 1;
	  $time = date("d.m.Y H:i");
	  $ip = $_SERVER['REMOTE_ADDR'];
	  $users["id$id"] = [
	  	'time' => $time,
	    'ip' 	 => $ip,
	    'lang' => $lang
	  ];

	  foreach ($post as $key => $val)
	  	if (array_key_exists($key, $this->userFields)) {
	  		if (!isset($users['id0'][$key]))
		  		$users['id0'][$key] = $this->userFields[$key];
		  	if (trim($val))
		  		$users["id$id"][$key] = trim($val);
	  	}

	  $usersPack = [
	  	'regs' => [
	  		'regs' => $users
	  	]
	  ];
	  file_put_contents($file, json_encode($usersPack, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));

	  $res['status'] = ($err)? false : true;
	  if ($err) $res['err'] = $err;
		echo json_encode($res);

		if ($lang == 'ru') {
			$subj = 'Вы успешно подали заявку на вступление в BMF фонд';
			$mess = 'Вы успешно подали заявку на вступление в BMF фонд. Мы рассмотрим вашу заявку и пришлём уведомление в ближайшее время. <br><br> <a href=\"http://bmf.foundation/ru/about\">Команда BMF</a>';
		} else  {
			$subj = 'You have successfully applied for membership';
			$mess = 'You have successfully applied for membership in the BMF Fund. We will consider your application and send a notification in the near future. <br><br> <a href=\"http://bmf.foundation/about\">BMF Team</a>';
		}
		$this->mail_confirm($subj, $mail, $mess);
		$this->mail_notice('New user registered', $users["id$id"]);

	  exit;

  }


  function add_user($post) {
  	$err = false;
  	$admin = (isset($_SESSION['user']['group']) && $_SESSION['user']['group'] === 'admin');
  	if (!$admin) exit;

  	if (isset($post['mail']) && trim($post['mail']))
	    $mail = $post['mail']; else $err = 1;
	  if (isset($post['pass']) && trim($post['pass']))
	    $pass = $post['pass']; else $err = 1;
	  if ($err) {
	  	echo json_encode(['status' => false, 'err' => $err]);
	  	exit;
	  }

	  $lang = (isset($post['lang']) && trim($post['lang']))? $post['lang'] : 'en';
	  $users = json_decode(file_get_contents('data/admin/users.json'), true)['users']['users'];
    foreach ($users as $key => $user)
    	if (array_search($mail, $user)) {
    		$err = 5;
    		break;
    	}
    if ($err) {
	  	echo json_encode(['status' => false, 'err' => $err]);
	  	exit;
	  }

		end($users);
		$id = ($users && count($users))? intval(substr(key($users), 2))+1 : 1;
	  $time = date("d.m.Y H:i");
	  $ip = $_SERVER['REMOTE_ADDR'];
	  $users["id$id"] = [
	  	'time' => $time,
	    'ip' => $ip
	  ];

	  foreach ($post as $key => $val)
	  	if (array_key_exists($key, $this->userFields)) {
	  		if (!isset($users['id0'][$key]))
		  		$users['id0'][$key] = $this->userFields[$key];
		  	if (trim($val) != '')
		  		$users["id$id"][$key] = trim($val);
	  	}

	  $usersPack = [
	  	'users' => [
	  		'users' => $users
	  	]
	  ];
	  file_put_contents('data/admin/users.json', json_encode($usersPack, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));

	  $regs = json_decode(file_get_contents('data/admin/regs.json'), true)['regs']['regs'];
    unset($regs[$post['id']]);
    $regsPack = ['regs' => ['regs' => $regs ] ];
	  file_put_contents('data/admin/regs.json', json_encode($regsPack, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));

	  $res['status'] = ($err)? false : true;
	  if ($err) $res['err'] = $err;
		echo json_encode($res);

		if ($lang == '/ru') {
			$subj = 'Вы успешно приняты в BMF!';
			$mess = "Вы успешно приняты в BMF! <br><br> Ваши данные для входа: <br><br> Email: $mail <br> Password: $pass <br><br> <a href=\"http://bmf.foundation/signin\">http://bmf.foundation/signin</a> <br><br> <a href=\"http://bmf.foundation/ru/about\">Команда BMF</a>";
		} else  {
			$subj = 'You are successfully accepted into the BMF!';
			$mess = "You are successfully accepted into the BMF! <br><br> Your login details: <br><br> Email: $mail <br> Password: $pass <br><br> <a href=\"http://bmf.foundation/signin\">http://bmf.foundation/signin</a> <br><br> <a href=\"http://bmf.foundation/about\">BMF Team</a>";
		}
		$this->mail_confirm($subj, $mail, $mess);

		// // sendpulse
		// $url = 'https://api.sendpulse.com/addressbooks/{id}/emails';
		// $sp_data = array('emails' => '[{"email":"'.$mail.'"}]');

		// $options = array(
	 //    'http' => array(
  //       'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
  //       'method'  => 'POST',
  //       'content' => http_build_query($sp_data)
	 //    )
		// );
		// $context  = stream_context_create($options);
		// $result = file_get_contents($url, false, $context);
		// // if ($result === FALSE) { /* Handle error */ }
		// // var_dump($result);

	  exit;

  }


  function remove_user($post) {
  	$err = false;
  	$admin = (isset($_SESSION['user']['group']) && $_SESSION['user']['group'] === 'admin');
  	if (!$admin) exit;

  	if (isset($post['id']) && trim($post['id']))
	    $id = $post['id']; else $err = 1;
	  if ($err) {
	  	echo json_encode(['status' => false, 'err' => $err]);
	  	exit;
	  }

	  $users = json_decode(file_get_contents('data/admin/users.json'), true)['users']['users'];
    if (!isset($users[$id])) $err = 2;
    if ($err) {
	  	echo json_encode(['status' => false, 'err' => $err]);
	  	exit;
	  }

		unset($users[$id]);

	  $usersPack = [
	  	'users' => [
	  		'users' => $users
	  	]
	  ];
	  file_put_contents('data/admin/users.json', json_encode($usersPack, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));

	  $res['status'] = ($err)? false : true;
	  if ($err) $res['err'] = $err;
		echo json_encode($res);
	  exit;

  }


  function save_var($post) {
  	// echo json_encode(['status' => true]);
  	$err = false;
  	$admin = (isset($_SESSION['user']['group']) && $_SESSION['user']['group'] === 'admin');
  	if (!$admin) exit;

  	if (isset($post['data']) && trim($post['data']))
	    $data = $post['data']; else $err = 1;
	  if (isset($post['page']) && trim($post['page']))
	    $page = $post['page']; else $err = 1;
	  if (isset($post['var']) && trim($post['var']))
	    $var = $post['var']; else $err = 1;
	  if (isset($post['val']) && trim($post['val']))
	    $val = $post['val']; else $err = 1;
	  if ($err) {
	  	echo json_encode(['status' => false, 'err' => $err, 'val' => $val]);
	  	exit;
	  }

	  $lang = (isset($post['lang']) && trim($post['lang']))? $post['lang'] : 'en';
	  $dataDir = ($lang == 'ru')? 'data/ru' : 'data';
	  $fileData = json_decode(file_get_contents("$dataDir/$data"), true);
	  
	  if (stripos($var, '->') !== false) {
	  	$varArr = explode('->', $var);
	  	if (count($varArr) == 2)
	  		$fileData[$page][$varArr[0]][$varArr[1]] = trim($val);
	  	elseif (count($varArr) == 3) {
	  		$fileData[$page][$varArr[0]][$varArr[1]][$varArr[2]] = trim($val);
	  		if ($varArr[0] == 'users' && $varArr[1] == 'id1')
	  			$_SESSION['user'][$varArr[2]] = trim($val);
	  	}
	  } else
		  $fileData[$page][$var] = trim($val);

	  file_put_contents("$dataDir/$data", json_encode($fileData, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));

	  $res['status'] = ($err)? false : true;
	  if ($err) $res['err'] = $err;
	  // $res['val'] = $val;
		echo json_encode($res);
		
	  exit;

  }

  function contact($post) {
  	$this->mail_confirm($post['subject'], $post['email'], '');
		$this->mail_notice($post['subject'], $post);
		exit;
  }

  function mail_confirm($subj, $to, $mess, $from = 'BMF <info@bmf.foundation>') {
		$from = "MIME-Version: 1.0\r\nContent-type: text/html; charset=UTF-8\r\nFrom: $from";
		$mail = "
			<html>
				<head>
					<style>
						@import url('https://fonts.googleapis.com/css?family=Roboto:400');
						body {font: 18px/32px 'Roboto', sans-serif; color: #222222; max-width: 560px}
					</style>
				</head>
				<body>
					$mess
				</body>
			</html>";
		$res = mail($to, $subj, $mail, $from);
  }


  function mail_notice($subj, $mess, $to = 'bmf.foundation@protonmail.com', $from = 'BMF <info@bmf.foundation>') {
  	$from = "MIME-Version: 1.0\r\nContent-type: text/html; charset=UTF-8\r\nFrom: $from";
  	$mail = "
  		<html>
				<head>
					<style>
						@import url('https://fonts.googleapis.com/css?family=Roboto:400,700');
						.body {font: 400 18px/1.25em 'Roboto', sans-serif; color: #222222; max-width: 560px}
						.key {font-size: 14px; font-weight: 700}
						.val {margin-bottom: 10px}
					</style>
				</head>
				<body class=\"body\">";
					foreach ($mess as $key => $val) {
						if ($key == 'subject' || !$this->userFields[$key]) continue;
						$mail .= '<span class="key">'.$this->userFields[$key].':</span><br>';
						$mail .= '<div class="val">'.$this->adapt_val($val, $key).'</div>';
					}
					$mail .= "
				</body>
			</html>";
		$res = mail($to, $subj, $mail, $from);
  }

  function adapt_val($val, $key) {
  	if (!trim($val))
  		return '&mdash;';
    elseif ($key == 'email')
      return "<a href=\"mailto:$val\">$val</a>";
    elseif ($key == 'phone' || $key == 'phone2')
      return "<a href=\"tel:+".preg_replace('/\D/', '', $val)."\">$val</a>";
    elseif ($key == 'time')
      return date_format(date_create($val), 'd.m H:i');
    elseif (in_array($key, ['ceo', 'cto', 'sales']))
    	return ucfirst($val);
    elseif ($key == 'url')
    	return "<a href=\"$val\" target=\"_blank\">".strstr(substr(strstr($val,'//'),2),'/',true)."/&hellip;</a>";
    else
    	return preg_replace('@(http(s)?)?(://)?(([a-zA-Z])([-\w]+\.)+([^\s\.]+[^\s]*)+[^,.\s])@', '<a href="http$2://$4" target="_blank">$0</a>', trim($val));
  }

  function external($link) {
  	return ($link && (
  						substr($link, 0, 2) == '//' ||
  						substr($link, 0, 1) != '/'
  				 ))? true : false;
  }

  function upload_img($post) {
  	$name = $_POST['name'];
  	$res = [];
  	$id = 0;

  	// $res['test'] = $_FILES['img'];

		foreach ($_FILES['img']['error'] as $key => $err) {



			// load check
			if ($err != UPLOAD_ERR_OK) {
				$res['error'][] = $err;
				break;
			}
			$ext = strtolower(pathinfo($_FILES['img']['name'][$key])['extension']);
			$path = "img/$name.$ext";
			$res['path'] = $path.'?v='.date('zHis');
			// if (!is_dir("img/$page")) mkdir("img/$page");
			if (move_uploaded_file($_FILES['img']['tmp_name'][$key], $path) == false) {
				$res['error'][] = 'File '.$_FILES['img']['name'][$key].' upload is not possible';
				continue;
			}

			// $id++;
		}

		echo json_encode($res);
		exit;
  }

  function exchange($post) {

	  $trans = json_decode(file_get_contents('data/admin/exchange.json'), true)['trans']['trans'];

		end($trans);
		$id = ($trans && count($trans))? intval(substr(key($trans), 2))+1 : 1;
	  $time = date("d.m.Y H:i");
	  $ip = $_SERVER['REMOTE_ADDR'];
	  $trans["id$id"] = [
	  	'time' => $time,
	    'ip' 	 => $ip
	  ];

	  foreach ($post as $key => $val)
	  	if (trim($val))
	  		$trans["id$id"][$key] = trim($val);

	  $transPack = [
	  	'trans' => [
	  		'trans' => $trans
	  	]
	  ];
	  file_put_contents('data/admin/exchange.json', json_encode($transPack, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));

	  foreach ($post as $key => $val)
  		$log .= "$key: $val\n";
  	$log .= "\n\n";
  	file_put_contents('data/admin/exchange.log', $log, FILE_APPEND);


		echo json_encode(true);

		foreach ($post as $key => $val)
			$mess .= "$key: $val<br>";

		$this->mail_confirm('New exchange request', 'bmf.foundation@yandex.com', $mess);

	  exit;

  }


}
$model = new Model;

?>