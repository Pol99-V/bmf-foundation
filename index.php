<? include 'core/core.php' ?>
<?// $ver = '?v='.date('zHis') ?>
<? $ver = '?v=29' ?>
<? if (!$model->blockConstruct): ?>
<!doctype html>
<html lang="<?=$router->lang?>">
<head>
  <base href="/">
	<meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
  <meta name="description" content="">
  <meta name="robots" content="noindex, nofollow">
  
  <meta property="og:title" content="">
  <meta property="og:description" content="">
  <meta property="og:image" content="">
  <meta property="og:type" content="website">
  <meta property="og:url" content= "">
  <meta property="og:locale" content="en_US">
 
  <title><?=$data->title?></title>
  <link rel="stylesheet" href="css/core.css<?=$ver?>">
  <link rel="stylesheet" href="css/custom.css<?=$ver?>">
  <link rel="stylesheet" href="slick/slick.css<?=$ver?>">
  <link rel="stylesheet" href="slick/slick-theme.css<?=$ver?>">
  <link rel="icon" type="image/png" href="img/favicon.png<?=$ver?>">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

</head>
<body page="<?=$router->page?>">

  <div class="overlay hide"></div>

  <? include 'view/header.php' ?>

  <div class="content" id="top">
    <!-- <pre><?// print_r($data) ?></pre> -->
<?
endif; // block construct

      foreach ($views as $view)
        if (file_exists($view))
          include $view;

if (!$model->blockConstruct):
?>
  </div> <!-- content -->

  <? include 'view/footer.php' ?>

  <script>var root = {}</script>
  <script src="js/jquery-3.3.1.min.js<?=$ver?>"></script>
  <script src="js/core.js<?=$ver?>"></script>
  <script src="slick/slick.min.js<?=$ver?>"></script>

  <!--Start of Tawk.to Script-->
  <script type="text/javascript">
  var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();
  (function(){
  var
  s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0];
  s1.async=true;
  s1.src='https://embed.tawk.to/5c02b19040105007f37a8ac6/default';
  s1.charset='UTF-8';
  s1.setAttribute('crossorigin','*');
  s0.parentNode.insertBefore(s1,s0);
  })();
  </script>
  <!--End of Tawk.to Script-->

  <!-- Global site tag (gtag.js) - Google Analytics -->
  <script async src="https://www.googletagmanager.com/gtag/js?id=UA-131535849-1"></script>
  <script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());

    gtag('config', 'UA-131535849-1');
  </script>

</body>
</html>
<? else: echo json_encode(str_replace(array("\t","\n"), "", ob_get_clean())); endif; exit; ?>