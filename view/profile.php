<hr class="h5">
<!-- <pre><?// print_r($_SESSION) ?></pre> -->
<div class="profile">
  <div class="container">
    <div class="flex flex-wrap">

      <div class="left-side">
      	<div class="img rel round overhide ava-wrapper">
      		<? if (file_exists('img/'.$data->user['id'].'.jpg')): ?>
      			<div class="img ava round" style="background: url(img/<?=$data->user['id']?>.jpg) center 25% / cover">
	    				<img src="img/<?=$data->user['id']?>.jpg" class="invis">
	    			</div>
	    		<? else: ?>
	    			<div class="img ava round" style="background: url(img/person.jpg) center 25% / cover">
	    				<img src="img/person.jpg" class="invis">
	    			</div>
	    		<? endif ?>
	    		<div class="overlay upload-img center pointer">
	    			Change Image
	    			<div class="error red">
	    				JPG up&nbsp;to&nbsp;1.5&#8239;mb 2560&times;2560&#8239;px only
	    			</div>
	    		</div>
	    	</div>
	    	<hr>
	    	<?// if ($admin): ?>
		    	<form id="upload-img" action="upload_img" class="hide">
		    		<input type="text" name="action" value="upload_img">
				    <input type="file" name="img[]">
				    <input type="text" name="name" value="<?=$data->user['id']?>">
				  </form>
				<?// endif ?>
				<hr class="h2">
				<div class="rep-box light-gray f1">
					<div class="right"><?=$data->v7?></div>
					<div class="flex">
						<div class="image"><img src="img/rep.png?v=1" class="round"></div>
						<div class="lpad1">
							<div class="rel">
								<div class="bold" var="rep_name" <?=$ce?>><?=($data->user['rep_name'])?$data->user['rep_name']:'Alfredo'?></div>
								<? if ($admin): ?>
			            <form action="save_var" class="right abs">
			            	<input type="hidden" name="lang" value="<?=$router->lang?>">
			              <input type="hidden" name="data" value="admin/users.json">
			              <input type="hidden" name="page" value="users">
			              <input type="hidden" name="var" value="users-><?=$data->user['id']?>->rep_name">
			              <button type="submit" class="save">Save</button>
			            </form>
			          <? endif ?>
							</div>
							<div class="flex">
								<div class="label">WhatsApp:</div>
								<div class="rel">
									<? $rep_skype = ($data->user['rep_skype'])? $data->user['rep_skype'] : '+58-414-2909711' ?>
									<a href="https://api.whatsapp.com/send?phone=<?=str_replace(['+','-'],'',$rep_skype)?>" class="light-gray" target="_blank" var="rep_skype" <?=$ce?> <?=($admin)?'onclick="return false"':''?>>
										<?=$rep_skype?>
									</a>
									<? if ($admin): ?>
				            <form action="save_var" class="right abs">
				            	<input type="hidden" name="lang" value="<?=$router->lang?>">
				              <input type="hidden" name="data" value="admin/users.json">
				              <input type="hidden" name="page" value="users">
				              <input type="hidden" name="var" value="users-><?=$data->user['id']?>->rep_skype">
				              <button type="submit" class="save">Save</button>
				            </form>
				          <? endif ?>
								</div>
							</div>
							<div class="flex">
								<div class="label">Email:</div>
								<div class="rel">
									<? $rep_mail = ($data->user['rep_mail'])? $data->user['rep_mail'] : 'Bmf.foundation@protonmail.com' ?>
									<a href="mailto:<?=$rep_mail?>" class="light-gray" target="_blank" var="rep_mail" <?=$ce?> <?=($admin)?'onclick="return false"':''?>>
										<?=$rep_mail?>
									</a>
									<? if ($admin): ?>
				            <form action="save_var" class="right abs">
				            	<input type="hidden" name="lang" value="<?=$router->lang?>">
				              <input type="hidden" name="data" value="admin/users.json">
				              <input type="hidden" name="page" value="users">
				              <input type="hidden" name="var" value="users-><?=$data->user['id']?>->rep_mail">
				              <button type="submit" class="save">Save</button>
				            </form>
				          <? endif ?>
								</div>
							</div>
							<!-- <div class="flex">
								<div class="label">Book appt:</div>
								<div class="rel">
									<?// $rep_book = ($data->user['rep_book'])? $data->user['rep_book'] : 'https://link...' ?>
									<a href="<?//=$rep_book?>" class="light-gray" target="_blank" var="rep_book" <?//=$ce?> <?//=($admin)?'onclick="return false"':''?>>
										<?//=$rep_book?>
									</a>
									<?// if ($admin): ?>
				            <form action="save_var" class="right abs">
				            	<input type="hidden" name="lang" value="<?//=$router->lang?>">
				              <input type="hidden" name="data" value="admin/users.json">
				              <input type="hidden" name="page" value="users">
				              <input type="hidden" name="var" value="users-><?//=$data->user['id']?>->rep_book">
				              <button type="submit" class="save">Save</button>
				            </form>
				          <?// endif ?>
								</div>
							</div> -->
						</div>
					</div>
				</div>
				<hr class="h4">
      </div>

      <div class="right-side">
      	<div class="flex flex-between">

					<div class="rel">
						<div class="bold f2" var="name" <?=$ce?>><?=$data->user['name']?></div>
						<? if ($admin): ?>
	            <form action="save_var" class="right abs" var="name">
	            	<input type="hidden" name="lang" value="<?=$router->lang?>">
	              <input type="hidden" name="data" value="admin/users.json">
	              <input type="hidden" name="page" value="users">
	              <input type="hidden" name="var" value="users-><?=$data->user['id']?>->name">
	              <button type="submit" class="save">Save</button>
	            </form>
	          <? endif ?>
					</div>

					<div class="right flex-grow-1">
						<div class="rel nowrap">
							<span class="label"><?=$data->v8?></span>
							<? $b = $data->user['balance']; if (!$b) $b = '0'; ?>
							<span class="bold f125">$<div class="ilbk" <?=$ce?> var="balance"><?=$b?></div>
								<? if ($admin): ?>
			            <form action="save_var" class="right abs" var="balance">
			            	<input type="hidden" name="lang" value="<?=$router->lang?>">
			              <input type="hidden" name="data" value="admin/users.json">
			              <input type="hidden" name="page" value="users">
			              <input type="hidden" name="var" value="users-><?=$data->user['id']?>->balance">
			              <button type="submit" class="save">Save</button>
			            </form>
			          <? endif ?>
			        </span>
			      </div>

			      <div class="rel nowrap">
			      	<span class="label"><?=$data->v9?></span>
							<? $b = $data->user['bmf_balance']; if (!$b) $b = '0'; ?>
							<span class="bold f125"><img src="img/icon.btc.png" class="ilbk h125 wa rel top2px"><div class="ilbk" <?=$ce?> var="bmf_balance"><?=$b?></div>
								<? if ($admin): ?>
			            <form action="save_var" class="right abs" var="bmf_balance">
			            	<input type="hidden" name="lang" value="<?=$router->lang?>">
			              <input type="hidden" name="data" value="admin/users.json">
			              <input type="hidden" name="page" value="users">
			              <input type="hidden" name="var" value="users-><?=$data->user['id']?>->bmf_balance">
			              <button type="submit" class="save">Save</button>
			            </form>
			          <? endif ?>
			        </span>
			      </div>
					</div>
				</div><hr>

				<div class="flex">
					<div class="rpad4">
						
						<div class="rel nowrap">
							<div class="label">Email:</div>
							<div <?=$ce?> var="mail"><?=($data->user['mail'])?$data->user['mail']:''?></div>
							<? if ($admin): ?>
		            <form action="save_var" class="right abs" var="mail">
		            	<input type="hidden" name="lang" value="<?=$router->lang?>">
		              <input type="hidden" name="data" value="admin/users.json">
		              <input type="hidden" name="page" value="users">
		              <input type="hidden" name="var" value="users-><?=$data->user['id']?>->mail">
		              <button type="submit" class="save">Save</button>
		            </form>
		          <? endif ?>
						</div><hr class="h025">
						
						<div class="rel nowrap">
							<div class="label">WhatsApp:</div>
							<div <?=$ce?> var="whatsapp"><?=($data->user['whatsapp'])?$data->user['whatsapp']:''?></div>
							<? if ($admin): ?>
		            <form action="save_var" class="right abs" var="whatsapp">
		            	<input type="hidden" name="lang" value="<?=$router->lang?>">
		              <input type="hidden" name="data" value="admin/users.json">
		              <input type="hidden" name="page" value="users">
		              <input type="hidden" name="var" value="users-><?=$data->user['id']?>->whatsapp">
		              <button type="submit" class="save">Save</button>
		            </form>
		          <? endif ?>
						</div><hr class="h025">

						<div class="rel nowrap">
							<div class="label"><?=$data->v10?></div>
							<div <?=$ce?> var="country"><?=($data->user['country'])?$data->user['country']:''?></div>
							<? if ($admin): ?>
		            <form action="save_var" class="right abs" var="country">
		            	<input type="hidden" name="lang" value="<?=$router->lang?>">
		              <input type="hidden" name="data" value="admin/users.json">
		              <input type="hidden" name="page" value="users">
		              <input type="hidden" name="var" value="users-><?=$data->user['id']?>->country">
		              <button type="submit" class="save">Save</button>
		            </form>
		          <? endif ?>
						</div><hr class="h025">
						
						<div class="rel nowrap">
							<div class="label">National ID:</div>
							<div <?=$ce?> var="national"><?=($data->user['national-id'])?$data->user['national-id']:''?></div>
							<? if ($admin): ?>
		            <form action="save_var" class="right abs" var="national">
		            	<input type="hidden" name="lang" value="<?=$router->lang?>">
		              <input type="hidden" name="data" value="admin/users.json">
		              <input type="hidden" name="page" value="users">
		              <input type="hidden" name="var" value="users-><?=$data->user['id']?>->national">
		              <button type="submit" class="save">Save</button>
		            </form>
		          <? endif ?>
						</div><hr class="h025">
					</div>
					<div>
						
						<div class="rel">
							<div class="label top"><?=$data->v16?></div><hr class="h05">
							<div <?=$ce?> var="bank"><?=($data->user['bank'])?$data->user['bank']:''?></div>
							<? if ($admin): ?>
		            <form action="save_var" class="right abs" var="bank">
		            	<input type="hidden" name="lang" value="<?=$router->lang?>">
		              <input type="hidden" name="data" value="admin/users.json">
		              <input type="hidden" name="page" value="users">
		              <input type="hidden" name="var" value="users-><?=$data->user['id']?>->bank">
		              <button type="submit" class="save">Save</button>
		            </form>
		          <? endif ?>
						</div><hr class="h025">

						<!-- <div class="rel nowrap">
							<div class="label"><?//=$data->v17?></div>
							<div <?//=$ce?> var="number"><?//=($data->user['number'])?$data->user['number']:''?></div>
							<?// if ($admin): ?>
		            <form action="save_var" class="right abs" var="number">
		            	<input type="hidden" name="lang" value="<?//=$router->lang?>">
		              <input type="hidden" name="data" value="admin/users.json">
		              <input type="hidden" name="page" value="users">
		              <input type="hidden" name="var" value="users-><?//=$data->user['id']?>->number">
		              <button type="submit" class="save">Save</button>
		            </form>
		          <?// endif ?>
						</div><hr class="h025"> -->

						<!-- <div class="rel nowrap">
							<div class="label"><?//=$data->v18?></div>
							<div <?//=$ce?> var="type"><?//=($data->user['type'])?$data->user['type']:''?></div>
							<?// if ($admin): ?>
		            <form action="save_var" class="right abs" var="type">
		            	<input type="hidden" name="lang" value="<?//=$router->lang?>">
		              <input type="hidden" name="data" value="admin/users.json">
		              <input type="hidden" name="page" value="users">
		              <input type="hidden" name="var" value="users-><?//=$data->user['id']?>->type">
		              <button type="submit" class="save">Save</button>
		            </form>
		          <?// endif ?>
						</div><hr class="h025"> -->

						<!-- <div class="rel nowrap">
							<div class="label">Phone:</div>
							<div <?//=$ce?> var="phone"><?//=($data->user['phone'])?$data->user['phone']:''?></div>
							<?// if ($admin): ?>
		            <form action="save_var" class="right abs" var="phone">
		            	<input type="hidden" name="lang" value="<?//=$router->lang?>">
		              <input type="hidden" name="data" value="admin/users.json">
		              <input type="hidden" name="page" value="users">
		              <input type="hidden" name="var" value="users-><?//=$data->user['id']?>->phone">
		              <button type="submit" class="save">Save</button>
		            </form>
		          <?// endif ?>
						</div><hr class="h025">
						
						<div class="rel nowrap">
							<div class="label">Address:</div>
							<div <?//=$ce?> var="address"><?//=($data->user['address'])?$data->user['address']:''?></div>
							<?// if ($admin): ?>
		            <form action="save_var" class="right abs" var="address">
		            	<input type="hidden" name="lang" value="<?//=$router->lang?>">
		              <input type="hidden" name="data" value="admin/users.json">
		              <input type="hidden" name="page" value="users">
		              <input type="hidden" name="var" value="users-><?//=$data->user['id']?>->address">
		              <button type="submit" class="save">Save</button>
		            </form>
		          <?// endif ?>
						</div><hr class="h025"> -->
						
						
					</div>
				</div>

				<hr class="h3">
				<div class="wallet pad1 f1375 fill-gray white box rel">
    			<div <?=$ce?> var="wallet">
            <?=$data->wallet?>
          </div>
          <? if ($admin): ?>
            <form action="save_var" class="right abs">
            	<input type="hidden" name="lang" value="<?=$router->lang?>">
              <input type="hidden" name="data" value="<?=$router->data?>">
              <input type="hidden" name="page" value="<?=$router->page?>">
              <input type="hidden" name="var" value="wallet"><hr>
              <button type="submit" class="save">Save</button>
            </form>
          <? endif ?>
				</div>
				<hr class="h3">

				<?// if (!$admin): ?>
					<div class="btc rel hide">

						<div class="w100">
							<script type="text/javascript">
								baseUrl = "https://widgets.cryptocompare.com/";
								var scripts = document.getElementsByTagName("script");
								var embedder = scripts[ scripts.length - 1 ];
								var cccTheme = {"General":{"background":"#333","borderColor":"#121212"},"PoweredBy":{"textColor":"#EEE","linkColor":"#ffcc66"},"Data":{"priceColor":"#FFF","infoValueColor":"#FFF","borderColor":"#333"},"NewsItem":{"color":"#FFF","borderColor":"#444"},"Conversion":{"background":"#000","color":"#CCC"}};
								(function (){
								var appName = encodeURIComponent(window.location.hostname);
								if(appName==""){appName="local";}
								var s = document.createElement("script");
								s.type = "text/javascript";
								s.async = true;
								var theUrl = baseUrl+'serve/v1/coin/feed?fsym=BTC&tsym=USD&feedType=CoinTelegraph';
								s.src = theUrl + ( theUrl.indexOf("?") >= 0 ? "&" : "?") + "app=" + appName;
								embedder.parentNode.appendChild(s);
								})();
							</script>
						</div>
					</div>

					<!-- <div class="btc rel" style="left: -10px">
					  <script>
					    (function(b,i,t,C,O,I,N) {
					      window.addEventListener('load',function() {
					        if(b.getElementById(C))return;
					        I=b.createElement(i),N=b.getElementsByTagName(i)[0];
					        I.src=t;I.id=C;N.parentNode.insertBefore(I, N);
					      },false)
					    })(document,'script','https://widgets.bitcoin.com/widget.js','btcwdgt');
					  </script>

	          <div class="btcwdgt-chart" bw-cash="true" bw-theme="dark"></div>
	          <style>.btcwdgt {box-shadow: none !important; }</style>
					</div> -->
				<?// endif ?>

				<hr class="h3">
				<div class="wallet pad1 f1375 fill-gray white box rel hide">
    			<div <?=$ce?> var="wallet2">
            <?=$data->wallet2?>
          </div>
          <? if ($admin): ?>
            <form action="save_var" class="right abs">
            	<input type="hidden" name="lang" value="<?=$router->lang?>">
              <input type="hidden" name="data" value="<?=$router->data?>">
              <input type="hidden" name="page" value="<?=$router->page?>">
              <input type="hidden" name="var" value="wallet2"><hr>
              <button type="submit" class="save">Save</button>
            </form>
          <? endif ?>
				</div>
				<hr class="h3">

				<!-- <h3>Transaction history:</h3><hr> -->
				<table class="rel pay-table">
					<thead>
						<tr class="bold">
							<td class="bottom w10 box">+/-</td>
							<td class="bottom w10 box"><?=$data->v11?></td>
							<td class="bottom w10 box"><?=$data->v12?></td>
							<td class="bottom w10 box"><?=$data->v13?></td>
							<td class="bottom w10 box"><?=$data->v14?></td>
						</tr>
					</thead>
					<tbody <?=$ce?> var="table">
						<?=$data->user['table']?>
					</tbody>
					<tfoot>
						<tr>
							<td colspan="5">
								<? if ($admin): ?>
			            <form action="save_var" class="right abs" var="table">
			            	<input type="hidden" name="lang" value="<?=$router->lang?>">
			              <input type="hidden" name="data" value="admin/users.json">
			              <input type="hidden" name="page" value="users">
			              <input type="hidden" name="var" value="users-><?=$data->user['id']?>->table">
			              <button type="submit" class="save">Save</button>
			            </form>
			          <? endif ?>
			        </td>
						</tr>
					</tfoot>
				</table>
				<hr class="h3">

				<div class="referal">
					<h3><?=$data->v15?></h3><hr>

					<div class="f15 center pad05 fill-gray" style="color: #2196F3">
						https://bmf.foundation/pl_<?=$data->user['id']?>
					</div><hr>
					
					<div class="rel">
	    			<div <?=$ce?> var="ref_link">
	            <?=$data->ref_link?>
	          </div>
	          <? if ($admin): ?>
	            <form action="save_var" class="right abs">
	            	<input type="hidden" name="lang" value="<?=$router->lang?>">
	              <input type="hidden" name="data" value="<?=$router->data?>">
	              <input type="hidden" name="page" value="<?=$router->page?>">
	              <input type="hidden" name="var" value="ref_link"><hr>
	              <button type="submit" class="save">Save</button>
	            </form>
	          <? endif ?>
					</div><hr>

					<!-- For instance:<hr class="h025">
					https://bmf.foundation/pl_<?//=$data->user['id']?>/about<br>
					https://bmf.foundation/pl_<?//=$data->user['id']?>/register -->
				</div>
				<hr class="h3">

      </div>
    </div>
  </div>
</div>
<!-- <hr class="h10"> -->