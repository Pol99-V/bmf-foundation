$(function(){
  // $('.content').addClass('invis');
	var $win = $(window),
      $doc = $(document),
      $html = $('html'),
      $body = $('body'),
      $cont = $('.content'),
      $speed = 300,
      $scroll = $(this).scrollTop(),
      $rem,
      $path = window.location.pathname,
      $hash = window.location.hash,
      $fullscreen = false,
      $lang = $html.attr('lang'),
      $country;

  var $header = $('.header'),
      $menu = $('.header .menu'),
      $menuDeskMin = 61.25*$rem,
      $minScroll = 4.125*$rem,
      $controls = $('.controls');



  $.get("https://ipinfo.io", function(response) {
    $country = response.country;
    // console.log($country);
    // console.log(response);
    if ($country == 'ES' && $lang != 'sp')
      window.location.replace('/sp'+ path);
  }, "jsonp");






  // m test
  root.mtest = function() {

    $html.css('font-size', '16px');
    // console.log(' ');
    // pageAdapt();
    // $('.content').addClass('invis');

    if (!$('.mtest').length)
      $body.prepend('\
        <div class="mtest">\
          <div class="m">mmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmm</div>\
          <div class="px"></div>\
          <div class="inch"></div>\
        </div>');

    var bw = $body.width(),
        mw = $('.mtest .m').width(),
        iw = $('.mtest .inch').width(),
        pw = $('.mtest .px').width();

    $('.mtest').remove();

    ipr = iw / pw;
    mbr = mw / bw;
    $rem = (mbr > 1)? Math.round(16 / mbr) :
           (mbr < .12)? Math.round(8 / mbr) : 16;

    $html.css('font-size', $rem+'px');
    if (ipr > 1.5 || ipr < .75 || mbr > .5 || mbr < .12 || bw < 750)
      $body.removeClass('desk').addClass('mob');
    else
      $body.removeClass('mob').addClass('desk');

    if ($win.width() < $win.height())
      $body.addClass('por');
    else
      $body.removeClass('por');

    $minScroll = 4.125*$rem;
    $menuDeskMin = 61.25*$rem;
    // console.log('mtest', bw, $rem);
    adapt();

  }
  root.mtest();

  var path = $path,
      hash = $hash;
  window.history.replaceState({path, hash}, null, path+hash);

  $win.on('load', function(){
    if ($hash)
      scrollTo($hash);
    $('.btc').removeClass('hide');
  });


  // tech
  root.rem = function() {return parseInt($html.css('font-size'))}
  root.isrem = function(x) {return (x.indexOf('rem') > 0)? true : false}
  root.ispx = function(x) {return (x.indexOf('px') > 0)? true : false}
  root.getrem = function(x) {
    return (typeof x == 'number')?
        x/root.rem() :
      (x.indexOf('rem') > 0)?
        parseInt(x) :
      parseInt(x)/root.rem();
  }
  root.getpx = function(x) {
    return (typeof x == 'number')?
        x*root.rem() :
      (x.indexOf('px') > 0)?
        parseInt(x) :
      parseInt(x)*root.rem();
  }
  root.path = function() {return ($path)? $path : '/'}

  // classes
  var remainingAddСlasses;
  function addClasses(classes, el) {
    classes = classes.split(' ');
    var current = classes[0];
    remainingAddСlasses = classes.splice(1);
    setTimeout(function() {
      el.addClass(current);
    });
  }
  var remainingRemСlasses;
  function remClasses(classes, el) {
    classes = classes.split(' ');
    var current = classes[0];
    remainingRemСlasses = classes.splice(1);
    setTimeout(function() {
      el.removeClass(current);
    });
  }

  // adapt
  function adapt() {
    // console.log('adapt');
    headerAdapt();
    controlsAdapt();
    gridAdapt();
  }

  // function pageAdapt() {
    // console.log('page adapt');
  //   $body.add($header).add($controls).css('width', '');
  // }

  function headerAdapt() {
    $header.addClass('notrans');
    if ($header.is('.mob-menu'))
      $header.addClass('invis').removeClass('mob-menu');
    if ($menu.width() < $menuDeskMin)
      $header.addClass('mob-menu');
    setTimeout(function(){
      $header.removeClass('notrans invis').addClass('act');
      if ($('.win:visible').length) {
        $header.css('width', $('.win').width());
        headerScroll(0, 1);
      }
    });
  }
  
  // hide menu
  $doc.on('click', '.content', function() {
    $header.removeClass('drop-menu');
  });

  function controlsAdapt() {
    // console.log('controls adapt', $body.innerWidth() > 83*$rem);
    if ($body.innerWidth() > 83*$rem && $('.modal').length)
      $controls.show();
    else
      $controls.hide();
  }


  // .*col*-grids adapt
  function gridAdapt() {
    $('[size]').each(function() {
      
      var width = $(this).innerWidth(),
          size = parseInt($(this).attr('size'))*$rem,
          except = ($(this).attr('except'))?
            ($(this).attr('except').split(' ')) : false,
          newNum = Math.floor(width/size);

          // width = $(this).children().eq(0).outerWidth(true)
      // console.log('except: '+except, $.inArray(''+newNum, except)+1);
      if (except)
        while ($.inArray(''+newNum, except)+1)
          newNum--;
      if (newNum < 1) newNum = 1;
      // console.log('new num: '+width+' / '+size+' = '+newNum);

      if ($(this).is('.flex')) {
        // console.log($(this).attr('class'), size/16);
        var classes = $(this).attr('class').split(' '),
            oldClass = classes.find(function(el) {
                    return el.indexOf('flex-1')+1 > 0 ||
                           el.indexOf('flex-2')+1 > 0 ||
                           el.indexOf('flex-3')+1 > 0 ||
                           el.indexOf('flex-4')+1 > 0 ||
                           el.indexOf('flex-5')+1 > 0 ||
                           el.indexOf('flex-6')+1 > 0;
                  });
        // console.log('old class: '+oldClass);
        var oldNum = oldClass.charAt(5);
        // console.log('old num: '+oldNum);

        newClass = oldClass.replace('flex-'+oldNum, 'flex-'+newNum);
        $(this).removeClass(oldClass).addClass(newClass).attr('cols', newNum);
      }
      // console.log(' ');

      if ($(this).is('.slider')) {
        if ($(this).is('.slick-slider'))
          $(this).slick('unslick');
        $(this).slick({
          dots: $(this).is('.dots'),
          infinite: $(this).is('.infinite'),
          slidesToShow: newNum,
          slidesToScroll: newNum,
          arrows: $(this).is('.arrows'),
          prevArrow: '<button class="slick-prev" aria-label="Previous" type="button"><img src="img/icon.arrow.left.svg"></button>',
          nextArrow: '<button class="slick-next" aria-label="Next" type="button"><img src="img/icon.arrow.right.svg"></button>'
        }).attr('cols', newNum);
      }

    });
  }


  root.goToPage = function(path, hash, e, popstate) {
    // console.log('go to page', path);
    if (path == '/') {
      if ($('.modal').length)
        closeModal('/', hash, popstate);
      // else
        // location.reload();
    } else {
      e.preventDefault();
      if ($('.modal').length) {
        var modalLinks = $('.modal-link'),
            curLink = $.inArray($('.modal-link[href="'+$body.attr('modal')+'"]')[0], modalLinks),
            newLink = $.inArray($('.modal-link[href="'+path+'"]')[0], modalLinks),
            next = (curLink > newLink)? true : false;
        otherModal(path, hash, popstate, next);
      } else
        openModal(path, hash, popstate);
    }
  }

  // browser events
  window.addEventListener('popstate', function(e){
    // console.log('popstate', e.state);
    if (e.state) {
      e.preventDefault();
      root.goToPage(e.state.path, e.state.hash, e, true);
    }
  });

  // local links
  $doc.on('click', 'a[href^="#"], a[href^="."], a[href^="/"][href*="#"]', function(e){
    var link = $(this),
        href = $(this).attr('href'),
        local = link.is('[href^="/"]')? true : false;

    var hash = href.indexOf('#'),
        path = (hash+1)? href.slice(0, hash) : href.replace(/\/+$/, ''),
        hash = (hash+1)? href.slice(hash) : '';

    if (local)
      root.goToPage(path, hash, e);
    else
      e.preventDefault();
    
    if (link.is('.modal-link, .exit, .next, .prev'))
      return false;
    else if (link.hasClass('drop'))
      drop(href, link);
    else if (link.hasClass('accordion'))
      accordion(href, link);
    else
      scrollTo(hash);
  });


  function scrollTo(x, speed) {
    speed = (speed)? speed : ($speed)? $speed : 0;
    if (x && $(x).length) {
      var y = $(x).offset().top - 3*$rem;
      if (y < $win.scrollTop())
        y = y - 4.125*$rem; 
      $('html, body').animate({scrollTop: y}, speed);
    }
  }
  root.scrollTo = function(x, speed) {scrollTo(x, speed)}


  function drop(target, link) {
    if (target && $(target).length) {
      if ($(target).is(':visible')) {
        $(target).slideUp($speed/2);
        link.removeClass('act');
        // link.html(link.html().replace({'Short', 'Hide', 'fa-angle-up'}, {'Full', 'Show', 'fa-angle-down'}));
        link.html(link.html().replace('Short', 'Full'));
        link.html(link.html().replace('Hide', 'Show'));
        link.html(link.html().replace('fa-angle-up', 'fa-angle-down'));
      } else {
        $(target).slideDown($speed/2);
        link.addClass('act');
        link.html(link.html().replace('Full', 'Short'));
        link.html(link.html().replace('Show', 'Hide'));
        link.html(link.html().replace('fa-angle-down', 'fa-angle-up'));
      }
    } else console.log('not exist');
  }


  function accordion(target, link) {

    var targetLinks = $('a[href="'+target+'"]');
    targetLinks.each(function(){
      var links = $(this).closest('.accordion-links').find('.accordion'),
          id = $.inArray($(this)[0], links);

      links.removeClass('act').each(function(i){
        if (i != id)
          $($(this).attr('href')).hide();
        else {
          $($(this).attr('href')).show();
          $(this).addClass('act');
        }
      });
    });

  }


  // scroll 
  $win.on('scroll', function() {
    var scroll = Math.round($(this).scrollTop());
    headerScroll(scroll, $scroll);
    $scroll = $(this).scrollTop();
  });
  $win.scroll();

  function headerScroll(s, os) {
    if ($header.is('.drop-menu'))
      $header.removeClass('drop-menu');

    if (s < $minScroll) {
      if ($header.is('.fix'))
        $header.removeClass('fix');
    } else
      if (!$header.is('.fix'))
        $header.addClass('fix');

    if (s <= os) {
      if (!$header.is('.act'))
        $header.addClass('act');
    } else
      if ($header.is('.act'))
        $header.removeClass('act');
  }


  // burger
  $doc.on('click', '.burger', function() {
    $header.toggleClass('drop-menu');
  });  

  var resizeTimer;
  $win.on('resize', function(){
    clearTimeout(resizeTimer);
    resizeTimer = setTimeout(function() {
      $body.add($header).add($controls).css('width', '');
      root.mtest();
    }, 200);
  });

  //fullscreen detect
  $('iframe').bind('webkitfullscreenchange mozfullscreenchange fullscreenchange', function(e) {
    var state = document.fullScreen || document.mozFullScreen || document.webkitIsFullScreen;
    // var event = state ? 'FullscreenOn' : 'FullscreenOff';
    $fullscreen = state ? true : false;
    $body.addClass('fullscreen-event');
  });

  // disable & enable scroll
  var keys = {37: 1, 38: 1, 39: 1, 40: 1};
  function preventDefault(e) {
    e = e || window.event;
    if (e.preventDefault)
        e.preventDefault();
    e.returnValue = false;  
  }
  function preventDefaultForScrollKeys(e) {
    if (keys[e.keyCode]) {
      preventDefault(e);
      return false;
    }
  }
  root.disableScroll = function() {
    if (window.addEventListener) // older FF
        window.addEventListener('DOMMouseScroll', preventDefault, false);
    window.onwheel = preventDefault; // modern standard
    window.onmousewheel = document.onmousewheel = preventDefault; // older browsers, IE
    window.ontouchmove  = preventDefault; // mobile
    document.onkeydown  = preventDefaultForScrollKeys;
  }
  root.enableScroll = function() {
    if (window.removeEventListener)
        window.removeEventListener('DOMMouseScroll', preventDefault, false);
    window.onmousewheel = document.onmousewheel = null; 
    window.onwheel = null; 
    window.ontouchmove = null;  
    document.onkeydown = null;  
  }
  
  // var $ww = $win.outerWidth(true);
  // $doc.on('mousemove', function(e) {
  //   // event.pageX;
  //   var deviation = (event.x / $ww) - .5;
  //   $('.text').css('transform', 'translateX('+deviation+'rem)');
  // });


  // form
  $doc.on('submit', 'form', function(e) {
    // console.log('submit');
    e.preventDefault();
    formSend($(this));
  });

  $doc.on('click', '[subject]', function() {
    $('#contact [name="subject"]').val($('option[value="'+$(this).attr('subject')+'"]').val());
    $('#contact [name="title"]').focus();
  });

  $doc.on('keypress change', 'input, textarea, select', function() {
    var form = $(this).closest('form');
    $(this).removeClass('wrong');
    if (!form.find('.req.wrong').length) {
      form.find('.error').slideUp($speed);
      form.find('.success').slideUp($speed);
    }
  });

  $doc.on('focus', 'input, textarea', function() {
    var $this = $(this);
    $this.select();
    if ($this.hasClass('copy')) {
      var successful = document.execCommand('copy');  

      $this.prev('.console').addClass('start');
      setTimeout(function(){
        $this.prev('.console').addClass('fin');
        setTimeout(function(){
          $this.prev('.console').removeClass('start fin');
        }, $speed);
      }, $speed);
    }
  });

  $doc.on('focus blur', '.chb-list input[type="checkbox"]', function() {
    var chbList = $(this).closest('.chb-list'),
        checkboxes = chbList.find('input[type="checkbox"]');
    setTimeout(function(){
      if (checkboxes.filter(':focus, :checked').length)
        chbList.addClass('act');
      else
        chbList.removeClass('act');
    });
  });

  $doc.on('click', '.one-more a', function(){
    var form = $(this).closest('form');
    form.slideDown($speed);
    form.find('.mess .error').slideUp($speed);
    form.find('.mess .success').slideUp($speed);
    form.find('.one-more').slideUp($speed);
    form.find('input').not('[name="company"], [type="hidden"]').val('');
    form.find('input[type="checkbox"]').prop('checked', false);
    form.find('input').first().focus();
  });

  function objectifyForm(formArray) {//serialize data function

    var returnArray = {};
    for (var i = 0; i < formArray.length; i++){
      returnArray[formArray[i]['name']] = formArray[i]['value'];
    }
    return returnArray;
  }

  function formSend(form) {
    var action = form.attr('action');
    if (!verification(form))
        return false;

    if (form.is('#upload-img'))
      return false;

    console.log('form send');

    // 
    // var data = 'action='+action+'&'+form.serialize();
    var data = {action: action};
    data = Object.assign(data, objectifyForm(form.serializeArray()));

    if (action == 'save_var')
      if ($('[var='+form.attr('var')+']').length)
        data = Object.assign(data, { val: $('[var='+form.attr('var')+']').html() });
      else
        data = Object.assign(data, { val: form.prev('[contenteditable]').html() });
    
    // data = Object.assign(data, { val: JSON.stringify(form.prev('[contenteditable]').html()) });
    

    // if (action == 'save_var')
      // data += '&val='+form.prev('[contenteditable]').html();

    console.log(data);
    $.post('/', data, function(res) {
    // // $.ajax('/', {
    // //   data : JSON.stringify(data),
    // //   contentType : 'application/json',
    // //   type : 'POST',
    // //   success: function(res){
      
      console.log(res);

      if (action == 'login')
        if (res.status === true)
          if (window.location.pathname != '/admin')
            ($lang == 'ru')? window.location.replace('/ru/profile') :
            ($lang == 'sp')? window.location.replace('/sp/profile') :
                             window.location.replace('/profile');
          else
            window.location.replace('/admin');
        else
          formError(form, res.err);

      else if (action == 'logout' && res === true)
        ($lang == 'ru')? window.location.replace('/ru/') :
        ($lang == 'sp')? window.location.replace('/sp/') :
                         window.location.replace('/');
        // location.reload();

      else if (action == 'register')
        if (res.status === true)
          formSuccess(form);
        else
          formError(form, res.err);

      else if (action == 'add_user')
        if (res.status === true)
          window.location.replace('/admin/users');
        else
          formError(form, res.err);

      else if (action == 'remove_user')
        if (res.status === true)
          window.location.replace('/admin/users');
        else
          formError(form, res.err);

      else if (action == 'save_var')
        if (res.status === true) {
          // form.prev('[contenteditable]').addClass('saved');
          // setTimeout(function(){form.prev('[contenteditable]').removeClass('saved')});
          form.find('button.save').addClass('saved');
          setTimeout(function(){form.find('button.save').removeClass('saved')});
          setTimeout(function(){form.removeClass('act')}, $speed*2);
        } else
          formError(form, res.err);

      else if (action == 'exchange')
        openModal('/success', '', false);

    //   // }
    // // }

    }, 'json');
  }

  $doc.on('keypress change', '[var]', function() {
    var v = $(this).attr('var'),
        form = ($('input[name="var"][value*="->'+v+'"]').length)?
          $('input[name="var"][value*="->'+v+'"]').closest('form') :
          $('input[name="var"][value="'+v+'"]').closest('form');
    console.log(v, $('input[name="var"][value*="->'+v+'"]').length, $('input[name="var"][value="'+v+'"]').length);
    form.addClass('act');
  });

  function varsInit() {
    $('[var][contenteditable]').each(function(){
      if (!$(this).text()) $(this).html('&mdash;')
    });
  }
  varsInit();

  function registerSuccess(form) {
    form.find('.mess .error').slideUp($speed);
    form.find('.mess .success').slideDown($speed);
    form.find('input, select, textarea').val('').slideUp($speed);
    form.find('select').each(function(){$(this).val($(this).find('option:eq(1)').val())});
    form.find('button').slideUp($speed);
  }

  function registerError(form, err) {
    console.log(err);
    form.find('.mess .error').text(getError(err)).slideDown($speed);
    form.find('.mess .success').slideUp($speed);
  }

  function getError(num) {
    var error = (num == 0)? '' :
                (num == 1)? 'Marked fields must be filled out correctly' :
                (num == 2)? 'A person with this mail is not registered or the password is not correct' :
                (num == 4)? 'You are logged in. Log out before registering.' :
                (num == 5)? 'User is already registered' :
                            'Something is wrong. Try again in a few minutes.';
    return error;
  }

  function formSuccess(form) {
    form.find('.mess .error').slideUp($speed);
    form.find('.mess .success').slideDown($speed);
    form.find('input, select, textarea').val('').slideUp($speed);
    form.find('select').each(function(){$(this).val($(this).find('option:eq(1)').val())});
    form.find('button, label, .mess ~ hr').slideUp($speed);
  }

  function formError(form, err) {
    console.log(err);
    form.find('.mess .success').slideUp($speed);
    form.find('.mess .error').text(getError(err)).slideDown($speed);
    var firstWrong = form.find('.wrong').first();
    if (firstWrong.length) {
      $body.animate({scrollTop: firstWrong.position().top-5*$rem}, $speed);
      firstWrong.focus();
    }
  }

  function verification(form) {
    var err = false;
    form.find('input.req').each(function() {
      var val = $(this).val();
      if (!val || val == '0' || ($(this).attr('type') == 'checkbox' && !$(this).is(":checked"))) {
        err = true;
        $(this).addClass('wrong');
      }
    });

    if (err) {
      formError(form, 1);
      return false;
    } else return true;
  }



  // modal
  $doc.on('click tap', '.modal-link', function(e){
    e.preventDefault();
    openModal($(this).attr('href'), '', false);
  });

  function openModal(path, hash, popstate) {
    // console.log('open modal');
    // cur remove
    var curModal = false;
    if ($('.modal:visible').length) {
      curModal = $('.modal:visible');
      curModal.removeClass('act');
      setTimeout(function(){
        curModal.remove();
      }, $speed);
    }
    
    // animate calc
    var bw = $body.innerWidth(),
        pc = $body.height() / 2, // page center
        sc = $win.scrollTop() + $win.height() / 2, // scroll coordinate
        scale = .95,
        max = $cont.height() * ((1 - scale) / 2),
        shift = (sc > pc)? ((sc - pc) / pc) * max :
                          -((pc - sc) / pc) * max;
    
    // history state
    if (!popstate && path)
      window.history.pushState({path, hash}, null, path+hash);
    else if (path)
      window.history.replaceState({path, hash}, null, path+hash);

    // create modal
    $body.add($header).add($controls).width(bw);
    $cont.css('transform', 'scale('+scale+') translateY('+shift+'px)');
    var lang = ($lang != 'en')? '/'+$lang : '';
    var backToSite = ($lang == 'ru')? 'Вернуться на сайт' :
                     ($lang == 'sp')? 'Volver a la página principal' :
                                      'Back to the site';
    var join = ($lang == 'sp')? 'Únete a BMF' : 'Join BMF Today';
    var modalHtml = (jQuery.inArray(path, ['/about', '/sp/about', '/services', '/sp/services']) !== -1)? '<div class="modal z1"><div class="win"></div><div class="container"><hr class="h2"><span class="f125 link">&larr;</span>&nbsp;<a href="'+lang+'/" class="exit">'+backToSite+'</a><hr class="h3"></div><div class="fill-blue join-bmf center"><hr class="h3"><a class="button big fill-dark-gray modal-link" href="'+lang+'/register">'+join+'</a><hr class="h3"></div></div>' : '<div class="modal z1"><div class="win"></div><div class="container"><hr class="h2"><span class="f125 link">&larr;</span>&nbsp;<a href="'+lang+'/" class="exit">'+backToSite+'</a><hr class="h3"></div></div>';
    // var modalHtml = '<div class="modal z1"><div class="win"></div><div class="container"><hr class="h2"><span class="f125 link">&larr;</span>&nbsp;<a href="'+lang+'/" class="exit">'+backToSite+'</a><hr class="h3"></div></div>';
    $body
      .attr('modal', path)
      .addClass('modal-show overhide')
      .append(modalHtml);
      
    var newModal = $('.modal').last();
    newModal.show();
    $minScroll = 1;
    newModal.on('scroll', function() {
      var scroll = $(this).scrollTop();
      headerScroll(scroll, $scroll);
      $scroll = scroll;
    });
    
    // get content and show
    $.post(path, {action: 'getBlock'}, function(res) {
      // console.log(path, res);
      newModal.find('.win').html(res); //.prepend('<a href="#" class="exit">X</a>');
      newModal
        .addClass('act')
        .find('input, select, textarea').first()
          .focus();
      $header.removeClass('fix').addClass('act');
      
    }, 'json');
  }

  $doc.on('click', '.modal .exit', function(e){
    e.preventDefault();
    closeModal($(this).attr('href'), '', false);
  });

  function closeModal(path, hash, popstate) {
    // console.log('close modal');
    // history state
    if (!popstate)
      window.history.pushState({path, hash}, null, path+hash);
    else 
      window.history.replaceState({path, hash}, null, path+hash);

    $('.modal').removeClass('act');
    $cont.attr('style', '');
    $controls.addClass('invis');
    $header.addClass('fix');
    $body.attr('modal', '').removeClass('modal-show');
    setTimeout(function() {
      $('.modal').remove();
      $body.add($header).add($controls).css('width', '');
      $controls.hide();
      $body.removeClass('overhide');
      $win.scroll();
    }, $speed);
    $minScroll = 4.125*16;
  }

  $doc.on('click', '.controls .next, .controls .prev', function(e){
    e.preventDefault();
    otherModal($(this).attr('href'), '', false, $(this).is('.next'));
  });
  // $doc.on('swipeleft', '.case', function() {
  //   otherModal($('.controls .next').attr('href'), '', false, true);
  // });
  // $doc.on('swiperight', '.case', function() {
  //   otherModal($('.controls .pref').attr('href'), '', false, false);
  // });

  function otherModal(path, hash, popstate, next) {

    if ($('.modal .win').length > 1) return false;
    
    if (!popstate && path)
      window.history.pushState({path, hash}, null, path+hash);
    else if (path)
      window.history.replaceState({path, hash}, null, path+hash);

    var oldWin = $('.modal .win'),
        from = (next)? 'from-right' : 'from-left',
        to = (next)? 'to-left' : 'to-right';
    
    $('.modal').append('<div class="win '+from+'"></div>');
    var newWin = $('.modal .win').last();

    oldWin.addClass(to);
    newWin.show();
    $.post(path, {action: 'getBlock'}, function(res) {
      newWin.html(res).addClass('to-center');
      $controls.find('.prev').attr('href', newWin.find('.prev').attr('href'));
      $controls.find('.next').attr('href', newWin.find('.next').attr('href'));
      setTimeout(function() {
        oldWin.remove();
        newWin.removeClass('from-left from-right to-center');
      }, $speed+100);
    }, 'json');
  }


  $doc.on('click', '.upload-img', function(e) {
    e.preventDefault();
    // console.log('upload img');
    $('#upload-img [name^="img"]').val('').click();
  });

  $doc.on('change', '#upload-img [name^="img"]', function() {
    console.log($(this).val());
    // return false;
    var name = $(this).val(),
        ext = name.substr(name.lastIndexOf('.') + 1).toLowerCase(),
        exts = ['jpg']; //svg , 'jpeg', 'png', 'gif'
    if (exts.indexOf(ext) + 1) {
      // $('#upload-img [name="ext"]').val(ext);
      $('#upload-img').submit();
    } else {
      // $('.admin-panel .mess')
      //     .html('JPG only')
      //     .addClass('red')
      //     .removeClass('green invis');
      // setTimeout(function() {
      //   $('.admin-panel .mess').addClass('invis');
      // }, 10000);
    }
  });

  $doc.on('submit', '#upload-img', function(e) {
    if (window.FormData !== undefined) {
      console.log('upload img');
      // var page = $('.page').attr('name');
      // if (page == 'blog-item') page = 'blog/'+$('.post').attr('id');
      // $('#upload-img [name="name"]').val(page);
      var formData = new FormData(this);
      console.log(formData);
      $.ajax({
        url: '/',
        type: 'POST',
        data: formData,
        mimeType: 'multipart/form-data',
        contentType: false,
        cache: false,
        processData: false,
        success: function(res) {
          res = $.parseJSON(res);
          console.log(res);
          if (!res.error)
            $('img.ava').attr('src', res.path);
          else {
            $('.img.ava-wrapper').addClass('err');
            setTimeout(function(){
              $('.img.ava-wrapper').removeClass('err');
            }, 5000);
          }
        },
        error: function(jqXHR, textStatus, errorThrown) {
          textStatus+errorThrown;
        }
      });
      e.preventDefault();
    } else console.log('Browser does not support image upload');
  });

  $doc.on('click', '.curr-link', function(e) {
    e.preventDefault();
    var direct = ($(this).closest('.from-drop').length)? 'from':'to',
        name = $(this).attr('name'),
        val = $(this).attr('val');

    $('#exchange-form').find('select[name="'+name+'"]').val(val);
    // console.log(direct+'-name');
    $('.'+direct+'-name').text($(this).text());
    $('.'+direct+'-code').text(val.toUpperCase());
    $('.'+direct+'-drop').slideUp($speed);

    // console.log(console.log(123));
  });


});
