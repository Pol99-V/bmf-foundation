<?

// echo '<pre>';
// echo "SERVER_NAME: $_SERVER[SERVER_NAME]<br>";
// echo "HTTP_HOST: $_SERVER[HTTP_HOST]<br>";
// echo "PATH_INFO: $_SERVER[PATH_INFO]<br>";
// echo "REQUEST_URI: $_SERVER[REQUEST_URI]<br>";
// echo "REMOTE_ADDR: $_SERVER[REMOTE_ADDR]<br>";
// print_r($_SERVER);
// echo '</pre>';


// error reports on
// error_reporting(E_ALL);
// ini_set('display_errors', true);
// ini_set('html_errors', true);

// error reports off
error_reporting();
ini_set('display_errors', false);
ini_set('html_errors', false);

// sessions
session_start();
// $admin = (isset($_SESSION['admin']) && $_SESSION['admin'] === true);
if (isset($_SESSION['user']['group'])){
	$group = $_SESSION['user']['group'];
	$admin = ($group === 'admin');
	$editor = ($group === 'editor' || $admin);
	$ce = ($editor)? 'contenteditable="true"' : '';
}

// function getId($itemKey, $arr) {
// 	$i = 0;
// 	foreach($arr as $key => $val) {
// 		$i++;
// 		if ($itemKey == $key)
// 			return $i;
// 	}
// 	return false;
// }

// router
class Router {
  public $map;
  public $path = '/';
  public $dataDir = 'data';
  public $data = 'pages.json';
  public $control;
  public $page = 'main';
  // public $type = '';
  // public $title;
  // public $desc;
  public $branch;
  public $children = [];
  public $list;
  public $numList;
  public $num;
  public $id;
  public $itemId;
  public $lang = 'en';
  public $syskeys = [
		'title' 	=> 0,
		'desc' 		=> 0,
		'menu' 		=> 0,
		'type' 		=> 0,
		'control' => 0,
		'data' 		=> 0
	];
  public $err = false;
  public $mess = [];

  public function getId($itemKey, $arr) {
		$i = 0;
		if (is_array($arr) && array_key_exists($itemKey, $arr))
			foreach($arr as $key => $val) {
				if ($itemKey == $key)
					return $i;
				$i++;
			}
		return false;
	}
	public function getKey($id, $arr) {
		$i = 0;
		if (is_array($arr))
			foreach($arr as $key => $val) {
				if ($i == $id)
					return $key;
				$i++;
			}
		return false;
	}
	public function getPages($path, $limit = 0) {
		$path = explode('/', $path);
		$path[0] = 'main';
		$branch = $this->map;
		foreach ($path as $uri)
			$branch = $branch[$uri];
		// $pages = array_diff_key($branch, $this->syskeys);
		$pages = [];
		foreach ($branch as $key => $item)
			if (isset($item['type']) && $item['type'] == 'page' && $item['hidden'] !== true)
				$pages[$key] = $item;
		if ($limit) return array_slice($pages, 0, $limit, true);
		else return $pages;
	}

  function __construct() {

  	$path = false;
    $this->map = json_decode(file_get_contents("data/map.json"), true);
    $branch = $this->map['main'];

   //  if ($_SERVER['REQUEST_URI'] == '/profile' && (!isset($_SESSION['admin']) || $_SESSION['admin'] !== true))
			// $_SERVER['REQUEST_URI'] = '/';

    $uri = (isset($_SERVER['REQUEST_URI']))? $_SERVER['REQUEST_URI'] : '';

    if (($uri != '/' && !in_array($uri, ['/ru/', '/sp/'])) || $path) {
    	if ($path)
    		$this->path = $path;
    	else
      	$this->path = $uri;
      foreach (array_slice(explode('/', $this->path), 1) as $val) {
      	
      	if (in_array($val, ['ru', 'sp'])) {
      		$this->lang = $val;
      		$this->dataDir = "data/$val";
			    $this->map = json_decode(file_get_contents("$this->dataDir/map.json"), true);
			    $branch = $this->map['main'];
      		continue;
      	}
      	
      	if (substr($val, 0, 2) == 'id') {
      		$this->itemId = $val;
      		break;
      	}

      	if (substr($val, 0, 3) == 'pl_') {
      		$_SESSION['ref'] = substr($val, 3);
      		continue;
      	}

        if (is_array($branch) && array_key_exists($val, $branch)) {
        	$this->list = array_diff_key($branch, $this->syskeys);
          $branch = $branch[$val];
          $this->page = $val;
          if (is_array($branch)) {
          	if (array_key_exists('control', $branch))
          		$this->control = $branch['control'];
          	if (array_key_exists('data', $branch))
	            $this->data = $branch['data'];
	        }
        } else $this->err = true;
      }
      if ($this->err || explode('/', $this->path)[1] == 'data') {
        header("HTTP/1.x 404 Not Found");
        $this->path = '/404';
        $this->page = '404';
        $this->mess[] = "Error 404: Page $this->path doesn't exist";
      }
    }

    if (in_array($uri, ['/ru/', '/sp/'])) {
    	$this->path = $uri;
   				if (strpos($uri, 'ru') !== false) $this->lang = 'ru';
   		elseif (strpos($uri, 'sp') !== false) $this->lang = 'sp';
  		$this->dataDir = "data/$this->lang";
	    $this->map = json_decode(file_get_contents("$this->dataDir/map.json"), true);
	    $branch = $this->map['main'];
    }

    $this->branch = $branch;
    if (is_array($branch)) {
    	if (array_key_exists('control', $branch))
    		$this->control = $branch['control'];
    	if (array_key_exists('data', $branch))
        $this->data = $branch['data'];
      foreach ($branch as $key => $val)
      	if (is_array($val) && isset($val['type']) && $val['type'] == 'page')
	      	$this->children[$key] = $val;
    }
    if ($this->list)
    	$this->numList = array_values($this->list);
		$this->id = $this->getId($this->page, $this->list);
		if (is_array($this->list))
			$this->num = count($this->list);
  }
}
$router = new Router;
// echo '<pre>';
// print_r($router);
// echo '</pre>';



include_once 'model/models.php';



class Data {
	public $syskeys = [
		'type' 		=> 0,
		'control' => 0,
		'data' 		=> 0
	];
	public $pages = [];
	function __construct($router, $post) {
		
		$data = json_decode(file_get_contents("data/global.json"), true);
		foreach ($data as $key => $val)
			$this->$key = $val;
		
		foreach ($router->branch as $key => $val)
			if (!array_key_exists($key, $this->syskeys))
				$this->$key = $val;
			// elseif (is_array($val) && isset($val['type']) && $val['type'] == 'page')
				// $this->pages[$key] = $val;
		
		$data = json_decode(file_get_contents("$router->dataDir/$router->data"), true)[$router->page];
		if ($data && count($data))
			foreach ($data as $key => $val)
				$this->$key = $val;
		
		$this->post = $post;
		if (isset($_SESSION['user']))
			$this->user = $_SESSION['user'];
	}
}
$data = new Data($router, $_POST);


class New_Data {
	public $syskeys = [
		'type' 		=> 0,
		'control' => 0,
		'data' 		=> 0
	];
	public $pages = [];
	function __construct($file, $page) {

		$data = json_decode(file_get_contents("data/global.json"), true);
		foreach ($data as $key => $val)
			$this->$key = $val;
	
		$data = json_decode(file_get_contents($file), true)[$page];
		if ($data && count($data))
			foreach ($data as $key => $val)
				$this->$key = $val;
	}
}


// controls
$views = [];
if ($router->control && file_exists("control/$router->control"))
	include "control/$router->control";
else
	include "control/default.php";

if (isset($data->desc) && $data->desc) {
	$data->desc = strip_tags($data->desc);
	$data->desc = substr($data->desc,0,strrpos(substr($data->desc,0,297),' '));
	if (strlen($data->desc) > 0)
		$data->desc .= '…';
} else
	$data->desc = '';


if (isset($_POST['action'])) {
	$action = $_POST['action'];
	unset($_POST['action']);
	$model->$action($_POST, $router);
}

session_write_close();

?>