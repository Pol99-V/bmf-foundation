<? $lang = ($router->lang != 'en')? "/$router->lang" : '' ?>
<div class="header z3 act">
  <div class="container">
    <div class="flex flex-between flex-middle">

      <div class="logo-wrapper">
        <? if ($router->lang == 'en'): ?>
          <a class="logo white box rel ilbk" href="<?=$lang?>/"><img src="img/logo.png"></a>
          <div class="lang">
            <span class="f875">EN</span>&nbsp;<span class="light-gray">|</span>
            <a href="/sp<?=$router->path?>" class="f875">ES</a>
          </div>
        <? else: ?>
          <a class="logo white box rel ilbk" href="<?=$lang?>/"><img src="img/logo.sp.png"></a>
          <div class="lang">
            <a href="<?=str_replace(['/ru', '/sp'],'',$router->path)?>" class="f875">EN</a>&nbsp;<span class="light-gray">|</span>
            <span class="f875">ES</span>
          </div>
        <? endif ?>
      </div>
      



      <div class="menu">
        <? if ($editor && !$lang): ?>
          <a class="item" href="/admin">Admin&nbsp;panel</a>
        <? endif ?>
        <a class="item modal-link" href="<?=$lang?>/about"><?=($lang)?'Sobre&nbsp;nosotros':'About'?></a>
        <a class="item modal-link" href="<?=$lang?>/services"><?=($lang)?'Servicios':'Services'?></a>
        <a class="item modal-link" href="https://directbmf.net/portal/public/"><?=($lang)?'Ganar':'Earn'?></a>
      </div>

      <div class="profile-menu menu right">
        <? if ($admin || (isset($data->user) && $data->user)): ?>
          <a class="item rel ilbk bold lpad2" href="<?=$lang?>/profile">
            <img src="img/icon.person.svg" class="h1375 wa abs top2px left">
            <?=($data->user['name'])?$data->user['name']:'Profile'?>
          </a>
          <hr class="h0 mob">
          <span class="desk">&nbsp;&nbsp;</span>
          <form action="logout" method="post" class="ilbk item">
            <button type="submit" class="button logout submit"><?=($lang)?'Salida':'Exit'?></a>
          </form>
        <? else: ?>
          <a class="button item modal-link" href="<?=$lang?>/signin"><?=($lang)?'Ingresar':'Sign In'?></a>
          <hr class="h0 mob">
          <span class="desk">&nbsp;&nbsp;</span>
          <a class="button item modal-link" href="<?=$lang?>/register"><?=($lang)?'Registrarse':'Register'?></a>
        <? endif ?>
      </div>

    </div>
    <?// if ($admin) echo 'Admin'; ?>
  </div>
</div> <!-- header -->