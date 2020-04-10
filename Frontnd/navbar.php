<style>
#cssmenu ul ul {
    position: absolute;
    left: -9999px;
    margin: 0;
    padding: 0;
}
	#cssmenu ul {padding:0; margin: 0}

	.large-menu li a {width:500px;}
	#cssmenu ul.open {
    transform: rotate(0deg) !important; padding:0;
}
	.navbar-header .navbar-toggle {display: none;}

.logo {height:50px;}
.logo{position:relative;z-index:123;padding:0px;font:18px verdana;color:#6DDB07;float:left;width:15%}
.logo a{color:#6DDB07;}
nav{position:relative;width:100%;margin:0 auto;}
#cssmenu,#cssmenu ul,#cssmenu ul li,#cssmenu ul li a,#cssmenu #head-mobile{border:0;list-style:none;line-height:1;display:block;position:relative;-webkit-box-sizing:border-box;-moz-box-sizing:border-box;box-sizing:border-box}
#cssmenu:after,#cssmenu > ul:after{content:".";display:block;clear:both;visibility:hidden;line-height:0;height:0}
#cssmenu #head-mobile{display:none}
#cssmenu{font-family:sans-serif;background:#4f5366; z-index: 999;}
#cssmenu > ul > li{float:left}
#cssmenu > ul > li > a{padding:17px;font-size:13px;letter-spacing:1px;text-decoration:none;color:#ddd;font-weight:400; text-transform: uppercase;}
#cssmenu > ul > li:hover > a,#cssmenu ul li.active a{color:#fff}
#cssmenu > ul > li:hover,#cssmenu ul li.active:hover,#cssmenu ul li.active,#cssmenu ul li.has-sub.active:hover{border-bottom:2px solid #44a42b;-webkit-transition:background .3s ease;-ms-transition:background .3s ease;transition:background .3s ease;}
#cssmenu > ul > li.has-sub > a{padding-right:30px}
#cssmenu > ul > li.has-sub > a:after{position:absolute;top:22px;right:11px;width:8px;height:2px;display:block;background:#ddd;content:''}
#cssmenu > ul > li.has-sub > a:before{position:absolute;top:19px;right:14px;display:block;width:2px;height:8px;background:#ddd;content:'';-webkit-transition:all .25s ease;-ms-transition:all .25s ease;transition:all .25s ease}
#cssmenu > ul > li.has-sub:hover > a:before{top:23px;height:0}
#cssmenu ul ul{position:absolute;left:-9999px}
#cssmenu ul ul li{height:0;-webkit-transition:all .25s ease;-ms-transition:all .25s ease;background:#4f5265;transition:all .25s ease}
#cssmenu ul ul li:hover{}
#cssmenu li:hover > ul{left:auto}
#cssmenu li:hover > ul > li{height:40px}
#cssmenu ul ul ul{margin-left:100%;top:0}
#cssmenu ul ul li a {
    border-bottom: 1px solid rgba(150,150,150,0.15);
    padding: 11px 15px;
    min-width: 200px;
    font-size: 12px;
    text-decoration: none;
    color: #ddd;
    font-weight: 400;
    line-height: 16px;
}
ul.large-menu li a {
    padding: 11px 10px !important;
    height: 39px;
     display: flex;
     align-items: center;
     justify-content: center;

    vertical-align: middle;
}
#cssmenu ul ul li:last-child > a,#cssmenu ul ul li.last-item > a{border-bottom:0}
#cssmenu ul ul li:hover > a,#cssmenu ul ul li a:hover{color:#fff}
#cssmenu ul ul li.has-sub > a:after{position:absolute;top:16px;right:11px;width:8px;height:2px;display:block;background:#ddd;content:''}
#cssmenu ul ul li.has-sub > a:before{position:absolute;top:13px;right:14px;display:block;width:2px;height:8px;background:#ddd;content:'';-webkit-transition:all .25s ease;-ms-transition:all .25s ease;transition:all .25s ease}
#cssmenu ul ul > li.has-sub:hover > a:before{top:17px;height:0}
#cssmenu ul ul li.has-sub:hover,#cssmenu ul li.has-sub ul li.has-sub ul li:hover{background:#44a42b;}
#cssmenu ul ul ul li.active a{border-left:1px solid #333}
#cssmenu > ul > li.has-sub > ul > li.active > a,#cssmenu > ul ul > li.has-sub > ul > li.active> a{border-top:1px solid #333}
/*Scroll*/
/* width */
::-webkit-scrollbar {
  width: 8px;
}

/* Track */
::-webkit-scrollbar-track {
  background: #f1f1f1; 
}
 
/* Handle */
::-webkit-scrollbar-thumb {
  background: #888; 
}

/* Handle on hover */
::-webkit-scrollbar-thumb:hover {
  background: #555; 
}
@media screen and (min-width:1000px){
	#cssmenu .logo {
    display: none;
	}
	
	
	}
	

@media screen and (max-width:1000px){
.logo{position:absolute;top:0;left: 0;width:100%;height:46px;text-align:center;padding:10px 0 0 0 ;float:none}
.logo2{display:none}
nav{width:100%;}
#cssmenu{width:100%;z-index: 999;}
#cssmenu ul{width:100%;display:none}
#cssmenu ul li{width:100%;border-top:1px solid #444}
#cssmenu ul li:hover{background:#363636;}
#cssmenu ul ul li,#cssmenu li:hover > ul > li{height:auto}
#cssmenu ul li a,#cssmenu ul ul li a{width:100%;border-bottom:0}
#cssmenu > ul > li{float:none}
#cssmenu ul ul li a{padding-left:25px}
#cssmenu ul ul li{background:#333!important;}
#cssmenu ul ul li:hover{background:#363636!important}
#cssmenu ul ul ul li a{padding-left:35px}
#cssmenu ul ul li a{color:#ddd;background:none}
#cssmenu ul ul li:hover > a,#cssmenu ul ul li.active > a{color:#fff}
#cssmenu ul ul,#cssmenu ul ul ul{position:relative;left:0;width:100%;margin:0;text-align:left}
#cssmenu > ul > li.has-sub > a:after,#cssmenu > ul > li.has-sub > a:before,#cssmenu ul ul > li.has-sub > a:after,#cssmenu ul ul > li.has-sub > a:before{display:none}
#cssmenu #head-mobile{display:block;padding:23px;color:#ddd;font-size:12px;font-weight:700}
.button{width:55px;height:46px;position:absolute;right:0;top:0;cursor:pointer;z-index: 12399994;}
.button:after{position:absolute;top:22px;right:20px;display:block;height:4px;width:20px;border-top:2px solid #dddddd;border-bottom:2px solid #dddddd;content:''}
.button:before{-webkit-transition:all .3s ease;-ms-transition:all .3s ease;transition:all .3s ease;position:absolute;top:16px;right:20px;display:block;height:2px;width:20px;background:#ddd;content:''}
.button.menu-opened:after{-webkit-transition:all .3s ease;-ms-transition:all .3s ease;transition:all .3s ease;top:23px;border:0;height:2px;width:19px;background:#fff;-webkit-transform:rotate(45deg);-moz-transform:rotate(45deg);-ms-transform:rotate(45deg);-o-transform:rotate(45deg);transform:rotate(45deg)}
.button.menu-opened:before{top:23px;background:#fff;width:19px;-webkit-transform:rotate(-45deg);-moz-transform:rotate(-45deg);-ms-transform:rotate(-45deg);-o-transform:rotate(-45deg);transform:rotate(-45deg)}
#cssmenu .submenu-button{position:absolute;z-index:99;right:0;top:0;display:block;border-left:1px solid #444;height:46px;width:46px;cursor:pointer}
#cssmenu .submenu-button.submenu-opened{background:#262626}
#cssmenu ul ul .submenu-button{height:34px;width:34px}
#cssmenu .submenu-button:after{position:absolute;top:22px;right:19px;width:8px;height:2px;display:block;background:#ddd;content:''}
#cssmenu ul ul .submenu-button:after{top:15px;right:13px}
#cssmenu .submenu-button.submenu-opened:after{background:#fff}
#cssmenu .submenu-button:before{position:absolute;top:19px;right:22px;display:block;width:2px;height:8px;background:#ddd;content:''}
#cssmenu ul ul .submenu-button:before{top:12px;right:16px}
#cssmenu .submenu-button.submenu-opened:before{display:none}
#cssmenu ul ul ul li.active a{border-left:none}
#cssmenu > ul > li.has-sub > ul > li.active > a,#cssmenu > ul ul > li.has-sub > ul > li.active > a{border-top:none}
}

</style>
<nav id='cssmenu'>
	<div class="logo"><a href="index.php">Menu </a></div>
	<div id="head-mobile"></div>
	<div class="button"></div>
	<ul class="main_category">
		<li class='active'><a href='index.php'>HOME</a></li>
		<li><a href='#'>Category</a>
			<ul>
			<?php
			$_cat_sub = '';
			$nav_cat = json_decode($_SESSION['US']['permission'], TRUE);
		//	print_r($nav_cat);
			//$nav_main = $nav_cat['m'];
			$nav_category = $nav_cat['c'];
			$nav_sub_category = $nav_cat['s'];
			$nav_pages = $nav_cat['p'];
			
			/*$rej_cat = json_decode($_SESSION['US']['perm_reject'], TRUE);
			$rej_category = $rej_cat['c'];
			$rej_sub_category = $rej_cat['s'];
			$rej_where_cat = $rej_where_subcat = '';
			if($rej_category!='')
				$rej_where_cat = ' AND c_id NOT IN ('.$rej_category.') ';
			if($rej_sub_category!='')
				$rej_where_subcat = ' AND c_id NOT IN ('.$rej_sub_category.') ';*/
			if(isset($nav_main) && $nav_main===1){
				$sqlm = 'SELECT c_id,c_name as name from `'.MAIN_CATEGORY.'` WHERE status=0 '.$rej_where_cat;
				$row_m=$prop->getAll_Disp($sqlm);
				$count_m = count($row_m);
				for($i=0; $i<$count_m; $i++){
				?>
				<li><a href='#'><?php echo $row_m[$i]['name']; ?></a>
					<ul class="sub_category_menu pre-scrollable">
					<?php 
					$sqls = "SELECT c_id as id,c_name as c_id, sc_name as name  from `".SUB_CATEGORY."` WHERE status=0 AND c_name='".$row_m[$i]['c_id']."' $rej_where_subcat";
					$row_s=$prop->getAll_Disp($sqls);
					$count_s = count($row_s);
					for($j=0; $j<$count_s; $j++){
						$_cat_sub .=$row_s[$j]['id'].',';
					?>
						<li><a href='#'><?php echo $row_s[$j]['name']; ?></a>
							<ul class="large-menu pre-scrollable">
							<?php
							$sqlp = 'SELECT p_id,title from `'.PAGES.'` WHERE category='.$row_s[$j]['id'].' AND page_status=0 order by title ASC';
							$row_p=$prop->getAll_Disp($sqlp);
							$count_p = count($row_p);
							for($k=0; $k<$count_p; $k++){
							?>
								<li>
									<a href='category-detail.php?id=<?php echo $row_p[$k]['p_id']; ?>' title="<?php echo $row_p[$k]['title']; ?>">
									<?php 
									echo substr($row_p[$k]['title'],0,75 );
									$stlenth = strlen($row_p[$k]['title']);
									echo ($stlenth > 75?'...':'');
									?></a>
								</li>
							<?php 
							} 
							?>
							</ul>
						</li>
					<?php 
					} 
					?>
					</ul>
				</li>
				<?php 
				}
			}else{
				
				if(isset($nav_category) && $nav_category!=''){
					$sqlm = 'SELECT c_id,c_name as name from `'.MAIN_CATEGORY.'` WHERE status=0 AND c_id IN ('.$nav_category.') ';
					$row_m=$prop->getAll_Disp($sqlm);
					$count_m = count($row_m);
					for($i=0; $i<$count_m; $i++){
					?>
					<li><a href='#'><?php echo $row_m[$i]['name']; ?></a>
						<ul class="sub_category_menu">
						<?php 
						$sqls = "SELECT c_id as id,c_name as c_id, sc_name as name  from `".SUB_CATEGORY."` WHERE status=0 AND c_id IN (".$nav_sub_category.") AND c_name='".$row_m[$i]['c_id']."'";
						$row_s=$prop->getAll_Disp($sqls);
						$count_s = count($row_s);
						for($j=0; $j<$count_s; $j++){
							$_cat_sub .=$row_s[$j]['id'].',';
						?>
							<li><a href='#'><?php echo $row_s[$j]['name']; ?></a>
								<ul class="large-menu pre-scrollable">
								<?php
								$sqlp = 'SELECT p_id,title from `'.PAGES.'` WHERE category='.$row_s[$j]['id'].' and p_id IN ('.$nav_pages.') AND page_status=0 order by title ASC';
								$row_p=$prop->getAll_Disp($sqlp);
								$count_p = count($row_p);
								for($k=0; $k<$count_p; $k++){
								?>
									<li>
										<a href='category-detail.php?id=<?php echo $row_p[$k]['p_id']; ?>' title="<?php echo $row_p[$k]['title'];?>">
										<?php 
										echo substr($row_p[$k]['title'],0,75 );
										$stlenth = strlen($row_p[$k]['title']);
										echo ($stlenth > 75?'...':'');
										?></a>
									</li>
								<?php 
								} 
								?>
								</ul>
							</li>
						<?php 
						} 
						?>
						</ul>
					</li>
					<?php 
					}

				}	
			}
			$_cat_sub = rtrim($_cat_sub,',');
			?>
			</ul>
		</li>
		<!--<li><a href='saved-forms.php'>Saved Forms</a></li>-->
		<li class="text-right pull-right"><a href="#" class="waves-effect">Date : <?php echo date("j M Y"); ?></a></li>
	</ul>
</nav>
<script src='//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>
<script>(function($) {
$.fn.menumaker = function(options) {
 var cssmenu = $(this), settings = $.extend({
   format: "dropdown",
   sticky: false
 }, options);
 return this.each(function() {
   $(this).find(".button").on('click', function(){
     $(this).toggleClass('menu-opened');
     var mainmenu = $(this).next('ul');
     if (mainmenu.hasClass('open')) {
       mainmenu.slideToggle().removeClass('open');
     }
     else {
       mainmenu.slideToggle().addClass('open');
       if (settings.format === "dropdown") {
         mainmenu.find('ul').show();
       }
     }
   });
   cssmenu.find('li ul').parent().addClass('has-sub');
multiTg = function() {
     cssmenu.find(".has-sub").prepend('<span class="submenu-button"></span>');
     cssmenu.find('.submenu-button').on('click', function() {
       $(this).toggleClass('submenu-opened');
       if ($(this).siblings('ul').hasClass('open')) {
         $(this).siblings('ul').removeClass('open').slideToggle();
       }
       else {
         $(this).siblings('ul').addClass('open').slideToggle();
       }
     });
   };
   if (settings.format === 'multitoggle') multiTg();
   else cssmenu.addClass('dropdown');
   if (settings.sticky === true) cssmenu.css('position', 'fixed');
resizeFix = function() {
  var mediasize = 1000;
     if ($( window ).width() > mediasize) {
       cssmenu.find('ul').show();
     }
     if ($(window).width() <= mediasize) {
       cssmenu.find('ul').hide().removeClass('open');
     }
   };
   resizeFix();
   return $(window).on('resize', resizeFix);
 });
  };
})(jQuery);

(function($){
$(document).ready(function(){
$("#cssmenu").menumaker({
   format: "multitoggle"
});
});
})(jQuery);</script>
<script>
$(document).ready(function(){
	$( "ul.sub_category_menu" ).each(function( index ) {
	  var get_screen_height = $( this ).height();
	  if($( document ).height() <= $( this ).height()){
		$( this ).css({'max-height': get_screen_height,'overflow-y':'scroll','scroll-behavior': 'smooth'});
	  }		
	  console.log(get_screen_height);
	});
})

</script>
