$(function(){

	var $win = $(window),
      $doc = $(document),
      $html = $('html'),
      $body = $('body'),
      $cont = $('.content'),
      $speed = 400,
      swipe = false,
      angelPrice = 1000,
      visitorPrice = 200,
      discount = .75;


  $win.on('load', function() {
    var hash = window.location.hash;
    // console.log(hash, 'a[filter][href="'+hash+'"]', $('a[filter][href="'+hash+'"]').length);
    $('a[filter][href="'+hash+'"]').click();
    $('.carousel.invis').removeClass('invis');
    // $(hash).click();
    // if (hash && $(hash).length) {
    //   $(hash).click();
    //   // console.log(hash);
    //   setTimeout(function(){if ($('#'+$(hash).attr('href')).is(':visible')) $(hash).click()}, 500);
    //   setTimeout(function(){if ($('#'+$(hash).attr('href')).is(':visible')) $(hash).click()}, 1000);
    //   setTimeout(function(){if ($('#'+$(hash).attr('href')).is(':visible')) $(hash).click()}, 2000);
    // }

    // var hash = window.location.hash;
    // console.log(123, window.location.hash);
    // if (hash && $(hash).length) {
    //   // $(hash).click();
    //   // console.log(hash);
    //   link = $('#'+$(hash).attr('href').toLowerCase())
    //   if (link.length) {
    //     if link.is(':visible')
    //       link.click();
    //   } else scrollTo(hash);
    // }

    setTimeout(function(){
      $('.mob-menu').removeClass('invis');
    }, 1000);

  $hash = window.location.hash;
  if ($hash)
    if ($($hash).is('.modal')){
      $body.append('<a href="'+$hash+'" class="modal-link"></a>');
      setTimeout(function(){
        $body.find('a[href="'+$hash+'"]').click();
      }, 1000)
    } else if ($($hash).is('a') || $($hash).is('button'))
      $($hash).click();

  });

  // type list
  $doc.on('click', '.type-list .more', function(e){
    e.preventDefault();
    var text = ($body.hasClass('ru'))?
      'Свернуть&nbsp;&nbsp;&uarr;' : 'Hide&nbsp;&nbsp;&uarr;'
    $(this).prev('.desc').removeClass('short');
    $(this).removeClass('more').addClass('curtail').html(text);
  });

  $doc.on('click', '.type-list .curtail', function(e){
    e.preventDefault();
    var text = ($body.hasClass('ru'))?
      'Читать дальше' : 'More';
    $(this).prev('.desc').addClass('short');
    $(this).removeClass('curtail').addClass('more').html(text);
  });


  // slider
  $doc.on('click swiperight swipeleft', '.prev-hover, .next-hover', function(e) {
    e.preventDefault();
    var next = $(this).hasClass('next-hover'),
        prev = $(this).hasClass('prev-hover'),
        click = (e.type == 'click'),
        swipeleft = (e.type == 'swipeleft'),
        swiperight = (e.type == 'swiperight'),
        slider = $(this).closest('.slider');

    // console.log(swipeleft, swiperight);

    if (slider.find('.to-center').length) return false;
    if (click && swipe) {swipe = false; return false}
    else if (swipeleft || swiperight) swipe = true;

    if ((prev && (click || swiperight) || (next && swiperight)))
      root.goToSlide(slider, 'prev');
    if ((next && (click || swipeleft) || (prev && swipeleft)))
      root.goToSlide(slider, 'next');
  });

  $doc.on('click', '.speakers-list .item', function(){
    var speakers = $('.speakers-list .item'),
        id = $.inArray($(this)[0], speakers);
    root.goToSlide($('.slider'), id);
    // console.log($win.scrollTop() + $win.height() < $('.slider').offset().top);
    if ($win.scrollTop() + $win.height() < $('.slider').offset().top)
      root.scrollTo('.slider-target', 1000);
  });

  root.goToSlide = function(slider, target) {
    var slides = slider.children('.slide'),
        dots = slider.find('.dot'),
        oldId = slides.index(slides.filter('.active'));
        newId = (typeof target == 'number')?
                  (slides.eq(target).length)?
                    target :
                  oldId :
                (target == 'next')?
                  (slides.eq(oldId+1).length)?
                    oldId+1 : 
                  0 :
                (target == 'prev')?
                  (slides.eq(oldId-1).length)?
                    oldId-1 :
                  slides.length-1 :
                (target.startsWith('.') || target.startsWith('#'))?
                  (slides.filter(target).length)?
                    slides.filter(target).index() :
                  oldId :
                oldId;
                
    if (newId == oldId) return false;
    var to = (target == 'next')?
               'to-left' :
             (target == 'prev')?
               'to-right' :
             (newId > oldId)?
               'to-left' :
             'to-right',
        from = (target == 'prev')?
                 'from-left' :
               (target == 'next')?
                 'from-right' :
               (newId > oldId)?
                 'from-right' :
               'from-left';
    // console.log('target: '+target+' to: '+to+' from: '+from);
    slides.eq(oldId).addClass(to);
    slides.eq(newId).addClass(from);
    slider.css({'height': slides.eq(oldId).height()});
    setTimeout(function() {
      slides.eq(newId).addClass('to-center');
      setTimeout(function() {
        slider.css({'height': slides.eq(newId).height()});
        setTimeout(function() {
          slides.eq(oldId)
            .removeClass('active '+to);
          slides.eq(newId)
            .removeClass('to-center '+from)
            .addClass('active');
          slider.find('.prev.active, .next.active').removeClass('active');
          slider.find('.prev.invis, .next.invis').removeClass('invis');
        }, $speed);
      }, $speed);
    }, 10);

    dots.filter('.active').removeClass('active');
    dots.eq(newId).addClass('active');
  }


  // faq
  $doc.on('click', '.faq .q', function(){
    $(this).next().next('.a').slideToggle();
  });

  // modal
  $doc.on('click tap', '.modal-link', function(e){
    e.preventDefault();
    // console.log('modal');
    if ($('.modal:visible').length)
      $('.modal:visible').removeClass('act');
    var path = window.location.pathname.replace(/\/+$/, ''),
        hash = window.location.hash;
    window.history.pushState({path, hash}, null, path+hash);
    var href = $(this).attr('href');
        // scroll = $win.scrollTop();
    // $cont.css({
    //   'position': 'absolute',
    //   'top': -scroll,
    //   'width': $cont.width()
    // }).attr('scroll', scroll);
    // var shift = ($cont.height()*0.02) * ($win.scrollTop()+$win.height()/2) / ($cont.height()/2);
    var pc = $body.height() / 2, // page center
        sc = $win.scrollTop() + $win.height() / 2, // scroll coordinate
        scale = .95,
        max = $cont.height() * ((1 - scale) / 2),
        shift = (sc > pc)? ((sc - pc) / pc) * max :
                          -((pc - sc) / pc) * max;

    // var shift = $cont*.01 * ($body.height()/$win.scrollTop()+$win.height()/2)
    // console.log(sc, pc, max, shift);
    $body.width($body.width());
    $('.header').width($('.header').width());
    $('.footer').width($('.footer').width());
    $cont
      // .width($cont.width())
      .css('transform', 'scale('+scale+') translateY('+shift+'px)');
    // root.disableScroll();
    $body.attr('modal', href).addClass('modal-show');
    $(href).show();
    setTimeout(function() {
      $(href).addClass('act');
      $(href).find('input, select, textarea').first().focus();
    }, 100);

    // $(href).show();
    // $body.animate({scrollTop: 0}, 0);
    // $('.modals').show();
    // $(href).show($speed, function(){
    //   $(href).find('input').first().focus();
    // });
    // $body.css({
    //   'height': $(href).height(),
    //   'overflow': 'hidden'
    // });
  });

  $doc.on('click', '.modal .exit', function(e){
    e.preventDefault();
    modalClose();
    

  //   $body.css({
  //     'height': 'initial',
  //     'overflow': 'auto'
  //   });
  //   $(this).closest('.modal').hide();
  //   $('.modals').hide();
  //   $cont.css({
  //     'position': 'static',
  //     'top': 0,
  //     'width': 'initial'
  //   });
  //   $('html, body').animate({scrollTop: $cont.attr('scroll')}, 0);
  // });

  //  window.addEventListener('popstate', function(e){
  //   e.preventDefault();
  //   var path = (e.state)? e.state.path : '',
  //       hash = (e.state)? e.state.hash : '';
  //   window.location.replace(path + hash);
  });

  function modalClose() {
    $cont.css('transform', 'scale(1) translateY(0)');
    $('.modal').removeClass('act');
    setTimeout(function() {
      $('.modal').hide();
      $body.attr('modal', '').removeClass('modal-show');
      // $cont.width('auto');
      $body.width('auto');
      $('.header').width('100%');
      $('.footer').width('100%');
      $cont.attr('style', '');
    }, $speed);
  }

	// order send
  // $doc.on('click', '.submit', function(e) {
  //   e.preventDefault();
  //   if ($(this).closest('.promo').length) return false;
  //   console.log(123);
  //   orderSend($(this).closest('form'));
  // });
  $doc.on('submit', 'form', function(e) {
    // console.log('custom recoll submit');
    if ($(this).attr('action') == 'https://www.coinpayments.net/index.php')
      return true;
    else {
      e.preventDefault();
      formSend($(this));
    }
  });
  // $doc.on('click', 'form .submit', function(e){
  //   e.preventDefault();
  //   console.log('submit link');
  //   if ($(this).closest('form').is('[action="/regs/"]'))
  //     $(this).closest('form').submit();
  //   else
  //     orderSend($(this).closest('form'));
  // });
  $doc.on('keypress change', 'input, textarea, select', function() {
    var form = $(this).closest('form');
    $(this).removeClass('wrong');
    if (!form.find('.req.wrong').length) {
      form.closest('.modal').find('.error').slideUp($speed);
      form.closest('.modal').find('.success').slideUp($speed);
      form.closest('.modal').find('.mess').slideUp($speed);
      // form.prev('.mess').find('.error').slideUp($speed);
      // form.prev('.mess').find('.success').slideUp($speed);
      // form.prev('.mess').slideUp($speed);
    }
  });
  $doc.on('focus', 'input, textarea', function() {
    var $this = $(this);
    $this.select();
    if ($this.hasClass('copy')) {
      var successful = document.execCommand('copy');  
      // console.log(successful); 
      $this.prev('.console').addClass('start');
      setTimeout(function(){
        $this.prev('.console').addClass('fin');
        setTimeout(function(){
          $this.prev('.console').removeClass('start fin');
        }, 500);
      }, 500);
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
    }, 100);
  });
  $doc.on('click', '.one-more a', function(){
    var modal = $(this).closest('.modal'),
        form = modal.find('form');
    form.slideDown($speed);
    modal.find('.mess').slideUp($speed);
    modal.find('.mess .error').slideUp($speed);
    modal.find('.mess .success').slideUp($speed);
    modal.find('.one-more').slideUp($speed);
    form.find('input').not('[name="company"], [type="hidden"]').val('');
    form.find('input[type="checkbox"]').prop('checked', false);
    form.find('input').first().focus();
  });

  function formSend(form) {
    var action = form.attr('action');
    if (action == 'register') {
      var currentUrl = window.location.href;
      form.find('input[name="success_url"]').val(currentUrl+'#success');
      form.find('input[name="cancel_url"]').val(currentUrl);
      form.find('input[name="url"]').val(currentUrl);
      if (!verification(form))
        return false;
    }
    var data = 'action='+action+'&'+form.serialize();

    // console.log('form send', data);
    $.post('/', data, function(res) {
      // console.log(res);
      if (action == 'login' || action == 'logout' || action == 'appearance')
        location.reload();
      else if (action == 'register')
        if (res.status === 1){
          // console.log(res.paymentForm);
          registerSuccess(form, res.paymentForm);
          // $.post('/coinpayments.php', data, function(){
          //   console.log('post', data);
          // });
        } else
          registerError(form);
    }, 'json');
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
      var modal = form.closest('.modal');
      modal.find('.mess').slideDown($speed);
      modal.find('.mess .success').slideUp($speed);
      modal.find('.mess .error').slideDown($speed);
      var firstWrong = form.find('.wrong').first();
      if (firstWrong.position().top < form.closest('.modals').scrollTop())
        form.closest('.modals').animate({scrollTop: firstWrong.position().top}, $speed);
      firstWrong.focus();
      return false;
    } else return true;
  }

  $doc.on('click', '.fillform', function(e) {
    e.preventDefault();
    var form = $(this).closest('form');
    form.find('input[type="text"], textarea').val('Test');
    form.find('input[type="checkbox"]').prop('checked', true);
    form.find('select').each(function(){$(this).val($(this).find('option:eq(1)').val())});
    form.find('.label, .chb-list').addClass('act');
  });

  function registerSuccess(form, paymentForm) {
    // console.log('register success');
    // var paymentForm = (form.attr('pay_after_registration') && $('#'+form.attr('pay_after_registration')).length)?
                        // $('#'+form.attr('pay_after_registration')) : false;
    if (paymentForm) {
      $doc.find('#coinpayments').remove();
      form.after(paymentForm);
      form.next('#coinpayments').submit();

    } else {
      form.slideUp();
      var modal = form.closest('.modal');
      modal.find('.mess').slideDown($speed);
      modal.find('.mess .error').slideUp($speed);
      modal.find('.mess .success').slideDown($speed);
      modal.find('.one-more').slideDown($speed);

    }
  }

  function registerError(form) {
    // console.log('register error');
    var modal = form.closest('.modal');
    modal.find('.mess').slideDown($speed);
    modal.find('.mess .error').slideDown($speed);
    modal.find('.mess .success').slideUp($speed);
  }


  // // copy text
  // // $doc.on('click', '.copy', function(){
  //   var copyBtn = document.querySelector('.copy');  
  //   copyBtn.addEventListener('click', function(event) {
    
  //     var target = document.querySelector('.code');  
  //     var range = document.createRange();  
  //     range.selectNode(target);  
  //     window.getSelection().addRange(range);  
      
  //     try {  
  //       var successful = document.execCommand('copy');  
  //       var msg = successful ? 'successful' : 'unsuccessful';  
  //       console.log('Copy email command was ' + msg);  
  //     } catch(err) {  
  //      console.log('Oops, unable to copy');  
  //   } 
  // // });


  // function orderSend(form) {
  //   console.log('custom orderSend');
  //   var err = false;
  //   form.find('.req').each(function() {
  //     // var name = $.trim($(this).attr('placeholder').replace(/\*/, '')),
  //     // console.log($(this).attr('name'), $(this).val());
  //     var val = $(this).val();
  //     if (!val || val == '0' || ($(this).attr('type') == 'checkbox' && !$(this).is(":checked"))) {
  //       err = true;
  //       $(this).addClass('wrong');
  //       // form.find('.mess').text('Поле «'+name+'» необходимо заполнить').removeClass('green').addClass('red');
  //     }
  //   });

  //   if (err) {
  //     // console.log(123);
  //     form.closest('.modal').find('.mess').slideDown($speed);
  //     form.closest('.modal').find('.mess .success').slideUp($speed);
  //     form.closest('.modal').find('.mess .error').slideDown($speed);
  //     var firstWrong = form.find('.wrong').first();
  //     if (firstWrong.position().top < form.closest('.modals').scrollTop())
  //       form.closest('.modals').animate({scrollTop: firstWrong.position().top}, $speed);
  //     firstWrong.focus();
  //     return false;
  //   }
    
  //   var data = 'model=register&'+form.serialize(),
  //       scheme = form.find('[name="scheme"]').val();

  //   console.log(data);
  //   $.post('', data, function(res) {
  //     console.log(res);
  //     if (res == true) {
  //       form.slideUp();
  //       form.closest('.modal').find('.mess').slideDown($speed);
  //       form.closest('.modal').find('.mess .error').slideUp($speed);
  //       form.closest('.modal').find('.mess .success').slideDown($speed);
  //       form.closest('.modal').find('.one-more').slideDown($speed);
  //       // if (scheme == 'sponsor') dataLayer.push({'event': 'Sponsor'});
  //       // if (scheme == 'team') dataLayer.push({'event': 'Team'});
  //     } else {
  //       // form.closest('.modal').find('.mess .error').text(res.err);
  //       form.closest('.modal').find('.mess').slideDown($speed);
  //       form.closest('.modal').find('.mess .error').slideDown($speed);
  //       form.closest('.modal').find('.mess .success').slideUp($speed);
  //     }
  //   }, 'json');
  // }

  // // promo
  // function promoOrderSend(form) {
  //   var err = false;

  //   form.find('.req').each(function() {
  //     // var name = $.trim($(this).attr('placeholder').replace(/\*/, '')),
  //     // console.log($(this).attr('name'), $(this).val());
  //     var val = $(this).val();
  //     if (!val || val == '0' || ($(this).attr('type') == 'checkbox' && !$(this).is(":checked"))) {
  //       err = true;
  //       $(this).addClass('wrong');
  //       // form.find('.mess').text('Поле «'+name+'» необходимо заполнить').removeClass('green').addClass('red');
  //     }
  //   });
  //   data = form.serialize();
  //   // console.log(data);

  //   $.post('promo.order.php', data, function(res) {
  //     // console.log(res);
  //    if (res == true) {
  //       form.slideUp();
  //       form.prev('.mess').slideDown($speed);
  //       form.prev('.mess').find('.error').slideUp($speed);
  //       form.prev('.mess').find('.success').slideDown($speed);
  //       form.find('input').val('');
  //     } else {
  //       // form.prev('.mess').find('.mess .error').text(res.err);
  //       form.prev('.mess').slideDown($speed);
  //       form.prev('.mess').find('.error').slideDown($speed);
  //       form.prev('.mess').find('.success').slideUp($speed);
  //     }
  //   }, 'json');
  // }


  // setTimeout(function() {
  //   var cssId = 'myCss';
  //   if (!document.getElementById(cssId))
  //   {
  //     var head  = document.getElementsByTagName('head')[0];
  //     var link  = document.createElement('link');
  //     link.id   = cssId;
  //     link.rel  = 'stylesheet';
  //     link.type = 'text/css';
  //     link.href = 'css/rudolf.css';
  //     link.media = 'all';
  //     head.appendChild(link);
  //   }
  // }, 3000);


});
