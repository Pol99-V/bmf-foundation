<?

// rights check
session_start();
if (!$_SESSION['admin']) {
	$img['error'] = 'Permission error';
	echo json_encode($data);
	session_write_close();
	exit;
}
session_write_close();

// id calc
// $page = $_POST['page'];
$name = $_POST['name'];
// $id = 0;
// foreach (glob("img/$page/img*") as $file) {
//   $curId = intval(substr(explode('.', basename($file))[0], 3));
//   if ($id < $curId) $id = $curId;
// }
// $maxId = $id;

foreach ($_FILES['img']['error'] as $key => $err) {

	// load check
	if ($err != UPLOAD_ERR_OK) continue;
	$id++;
	$ext = strtolower(pathinfo($_FILES['img']['name'][$key])['extension']);
	$path = "img/$name.tmp.$ext";
	// if (!is_dir("img/$page")) mkdir("img/$page");
	if (move_uploaded_file($_FILES['img']['tmp_name'][$key], $path) == false) {
		$img['error'][] = 'File '.$_FILES['img']['name'][$key].' upload is not possible';
		continue;
	}

  // optimization
  $maxw = 2560;
  $maxh = 2048;
  $prop = getimagesize($path);
  $w = $prop[0];
  $h = $prop[1];
  $r = $w / $h;
  if ($w > $maxw || $h > $maxh) {
  	$optPath = "img/$name.opt.tmp.$ext";
	  $nw = ($r > 1.25)? $maxw : $maxh*$r;
	  $nh = ($r > 1.25)? $maxw/$r : $maxh;
	  $src = false;
		if ($ext == 'jpg' || $ext == 'jpeg') $src = imagecreatefromjpeg($path);
		elseif ($ext == 'png') $src = imagecreatefrompng($path);
		elseif ($ext == 'gif') $src = imagecreatefromgif($path);
		if ($src === false)
			$img['error'][] = 'File format '.$_FILES['img']['name'][$key].' not supported';
		else {
			header('Content-Type: image/jpeg');
			$optImg = imagecreatetruecolor($nw, $nh);
			imagecopyresampled($optImg, $src, 0, 0, 0, 0, $nw, $nh, $w, $h);
			imagejpeg($optImg, $path, 90);
			imagedestroy($optImg);
		}
	}

	// thumb create
	$minw = 450;
  $minh = 300;
  $prop = getimagesize($path);
  $w = $prop[0];
  $h = $prop[1];
  $r = $w / $h;
  $thumbPath = false;
  if ($w > $minw && $h > $minh) {
	  $thumbPath = "img/$name.thumb.tmp.$ext";
	  $nw = ($r > 1.5)? $minh*$r : $minw;
	  $nh = ($r > 1.5)? $minh : $minw/$r;
		if ($ext == 'jpg' || $ext == 'jpeg') $src = imagecreatefromjpeg($path);
		elseif ($ext == 'png') $src = imagecreatefrompng($path);
		elseif ($ext == 'gif') $src = imagecreatefromgif($path);
		header('Content-Type: image/jpeg');
		$thumb = imagecreatetruecolor($nw, $nh);
		imagecopyresampled($thumb, $src, 0, 0, 0, 0, $nw, $nh, $w, $h);
		imagejpeg($thumb, $thumbPath, 70);
		imagedestroy($thumb);
	}

	$img['id'][] = $id;
	$img['path'][] = $path;
	$img['thumb'][] = ($thumbPath)? $thumbPath : $path;
	$img['ratio'][] = round($r, 2);
	$img['size'][] = $w.'x'.$h;
}

// // img code
// if (count($img['id']) == 1) {
// 	$img['var'] = 'img'.$img['id'][0];
// 	$img['code'] = '</div>
// 		<div class="s-field" contenteditable="false" new>';

// 	// just img
// 	if ($img['thumb'][0] == $img['path'][0]) $img['code'] .= '
// 			<img src="'.$img['thumb'][0].'" id="'.$img['var'].'" tmp>';

// 	// thumb
// 	else $img['code'] .= '
// 			<div img="'.$img['path'][0].'" id="'.$img['var'].'" thumb="'.$img['thumb'][0].'"
// 			size="'.$img['size'][0].'" ratio="'.$img['ratio'][0].'" folder="'.$page.'" tmp>
// 				<img src="'.$img['thumb'][0].'">
// 				<div class="overlay"><i class="fa fa-search"></i></div>
// 			</div>';

// 	$img['code'] .= '
//       <div class="size" contenteditable="false">
//         <i class="fa fa-plus plus"></i>
//         <i class="fa fa-minus minus"></i>
//         <i class="fa fa-times del"></i>
//       </div>
//     </div><div class="text">';
// }

// album code
// elseif (count($img['id']) > 1) {

// 	// album id calc
// 	if (explode('/', $page)[0] == 'blog') {
// 		$data = json_decode(file_get_contents('data/blog.json'), true);
// 		$page = explode('/', $page)[1];
// 	} else
// 		$data = json_decode(file_get_contents('data/pages.json'), true);
// 	$albumId = 0;
// 	if (isset($data[$page]))
// 		foreach ($data[$page] as $key => $val)
// 			if (substr($key, 0, 5) == 'album') {
// 			  $curId = intval(substr($key, 5));
// 			  if ($albumId < $curId) $albumId = $curId;
// 			}
// 	$albumId++;

// 	$img['var'] = "album$albumId";
// 	$img['code'] = '</div>
//     <div class="c-field" contenteditable="false" new>
//     	<div class="nline album invis" min-width="6.5rem" type="round" id="'.$img['var'].'" ratio="3:2">';
//   foreach ($img['id'] as $key => $id) {
//     $img['code'] .= '
// 	      <div class="unit" img="'.$img['path'][$key].'" id="img'.$id.'" thumb="'.$img['thumb'][$key].'"
// 	        size="'.$img['size'][$key].'" ratio="'.$img['ratio'][$key].'" folder="'.$img['var'].'"
// 	        style="background: url('.$img['path'][$key].') center 25% / cover" tmp>
// 	          <div class="overlay"><i class="fa fa-search"></i></div>
// 	      </div>';
//   }
//   $img['code'] .= '
// 	  	</div>
// 			<div class="size" contenteditable="false">
// 	      <i class="fa fa-plus plus"></i>
// 	      <i class="fa fa-minus minus"></i>
// 	      <i class="fa fa-times del"></i>
// 	    </div>
// 		</div><div class="text">';
// }

echo json_encode(true);

?>