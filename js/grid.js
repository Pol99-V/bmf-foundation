$(function(){

  root.gridAdapt = function(nline){
    var units = nline.find('.unit').not(nline.find('.nline .unit')),
        // allUnits = nline.find('.unit').not(nline.find('.nline .unit')),
        // units = allUnits.filter(':visible'),
        // hiddenUnits = allUnits.not(units),
        un = units.length,
        rem = parseInt($('html').css('font-size')),
        uh = 'auto',
        ratio = (nline.attr('ratio'))? nline.attr('ratio').split('/') : false,
        type = nline.attr('type'),
        pad = nline.attr('pad'),
        maxcol = parseInt(nline.attr('maxcol')),
        mincol = parseInt(nline.attr('mincol')),
        min = nline.attr('min'),
        max = nline.attr('max'),
        except = (nline.attr('except'))? nline.attr('except') : '',
        thumbs = (nline.find('img, .img').not(nline.find('.nline img, .nline .img')).length)? true : false,
        i;

    // nline.css('opacity', 0);
    if (un < mincol) {
      for (i=0; i < mincol-un; i++)
        nline.append('<div class="unit"></div>');
      units = nline.find('.unit').not(nline.find('.nline .unit'))
      un = mincol;
    }
    if (!min) min = '10rem';
    min = (root.isrem(min))? parseInt(min)*rem : parseInt(min);
    if (!max) max = '75rem';
    max = (root.isrem(max))? parseInt(max)*rem : parseInt(max);
    var ln = 1,
        nw = nline.width(),
        lw = nw,
        ul = Math.floor(lw/min),
        ulmin = Math.floor(lw/max),
        mar = nline.attr('mar');
    if (ulmin > mincol) ulmin = mincol;
    if (ul == except) ul--;
    if (mar) {mar = mar.split(' '); var xmar=mar[0], ymar=(mar[1])? mar[1]:mar[0]}
    else {var xmar='1rem', ymar='1rem'};
    if (root.isrem(xmar)) {xmar = parseInt(xmar)*rem; /*console.log('xmar', xmar);*/}
    if (root.isrem(ymar)) {ymar = parseInt(ymar)*rem; /*console.log('ymar', ymar);*/}
    xmar = xmar/2;
    if (ul>un) {ul = un; ln = 1}
    if (un<ulmin) {ul = ulmin; ln = 1}
    if (ul>11) ul = 12;
    if (ul>maxcol) ul = maxcol;
    if (ul<1) ul = 1;
    if (ul<un) ln = Math.ceil(un/ul);
    var upen = ul,
        ulast = un - ul * (ln - 1),
        diff = ul - ulast;
    if (type!='simple'){
      // console.log(diff);
      // if (diff==2) {ulast = 2; upen = 2}
      if (diff==3) {ulast = ul-2; upen = ul-1}
      if (diff==4) {ulast = ul-3; upen = ul-1}
      if (diff==5) {ulast = ul-3; upen = ul-2}
      if (diff==6) {ulast = ul-4; upen = ul-2}
      if (diff==7) {ulast = ul-4; upen = ul-3}
      if (diff==8) {ulast = ul-5; upen = ul-3}
      if (diff==9) {ulast = ul-6; upen = ul-3}
      if (diff==10){ulast = ul-2}
      if (diff==11){ulast = ul-1}
    }
    nline.children('.row').remove();
    for (var lid=0; lid<ln; lid++){
      nline.append('<div class="row"></div>');
      var line = nline.children(':last'),
          uthis = ul,
          shell = 0;
      if (lid == ln-2 && type!='simple') uthis = upen;
      if (lid == ln-1 && type!='simple') uthis = ulast;
      for (var uid=0; uid<uthis; uid++){
        var id = (uthis==ulast&&upen!=ul)?
          (lid-1)*ul+upen+uid : lid*ul+uid;
        if (id < un){
          line.append(units.eq(id));
          if (units.eq(id).children('.nline').length)
            units.eq(id).addClass('subgrid');
        }
      };
      if (uthis!=ul){
        if (type=='round'){
          lw = uthis*parseInt(units.eq(0).width())+(uthis-1)*2*xmar;
          if (lw>nw || (ln==2 && lid==0)) lw = nw;
          shell = (nw-lw)/2;
        }
        if (type=='simple') lw = uthis*lw/ul;
      }
      line.css({'width': lw, 'left': shell});
      //var uw = (lw-(uthis-1)*2*xmar)/uthis;
      var uw, float;
      //alert(nline.find('img, .img').not(nline.find('.nline img, .nline .img')).length+' => '+thumbs);
      if (root.ratio > 1 && !thumbs){
        if (ratio) uh = lw*ratio[1]/ratio[0];
        uw = '100%';
        xmar = 0;
        float = 'none';
      } else {
        uw = parseInt((lw-(uthis-1)*2*xmar)/uthis);
        uw = uw+'px';
        float = 'left';
      }
      // line.find('.unit').css({'width': uw, 'padding': pad, 'float': float, 'height': 'auto'});
      line.find('.unit').css({'width': uw, 'padding': pad, 'float': float});
      line.find('.unit').css({'margin-left': xmar+'px', 'margin-right': xmar+'px'});
      line.find('.unit:first-child').css('margin-left', 0);
      line.find('.unit:last-child').css('margin-right', 0);
      // var maxh = 0;
      // line.find('.unit').each(function(){
        // if ($(this).height() > maxh) maxh = $(this).height();
      // });
      // line.find('.unit').height(maxh);
    };
    if (ymar){
      nline.find('.row').css('margin-bottom', ymar);
      nline.find('.row:last-child').css('margin-bottom', 0);
    }
    // nline.css('opacity', 1);
    nline.removeClass('invis');
  }

  root.gridsAdapt = function(page){
    if (!page) page = $('body');
    page.find('.nline').each(function(){root.gridAdapt($(this))});
  }
  // $(document).on('load', '.nline .unit:last-child img', function(){
  //   root.gridAdapt($(this).closest('.grid'));
  // });

  root.unitsOrder = function(){
    var body = $('body'),
        attr = (body.hasClass('mob'))? 'def-order':'order';
    // console.log(body.attr('class'));
    for (i=0; i<2; i++){
      var err = false;
      $('[order]')
        .each(function(){
          // console.log($(this).attr('class'));
          var def = parseInt($(this).attr(attr));
          if (def != $(this).index())
            if (def == 0) $(this).parent().prepend($(this));
            else $(this).siblings().eq(def-1).after($(this));
        }).each(function(){
          if (parseInt($(this).attr(attr)) != $(this).index()) err = true;
        });
      if (err) {
        console.log('block order failure');
        break;
      }
    }
  }

});