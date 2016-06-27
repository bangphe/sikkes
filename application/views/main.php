<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><head>
	<title>Sistem Informasi Kementrian Kesehatan</title>
	
<!-- ICON -->
		<link rel="icon" type="image/x-icon" href="<?php echo  base_url() ?>images/icons/depkes.png" />
		
		<!-- Link CSS -->
		<link rel="stylesheet" type="text/css" href="<?php echo  base_url() ?>css/flexigrid.css" media="screen, tv, projection" title="Default" />
		<link rel="stylesheet" type="text/css" href="<?php echo  base_url() ?>css/shortcut.css" media="screen, tv, projection" title="Default" />
		<link rel="stylesheet" type="text/css" href="<?php echo  base_url() ?>css/main.css" media="screen, tv, projection" title="Default" />
		<link rel="stylesheet" type="text/css" href="<?php echo  base_url() ?>css/default/jquery.css" media="screen, tv, projection" title="Default" />
		<link rel="stylesheet" type="text/css" href="<?php echo  base_url() ?>css/button.css" media="screen, tv, projection" title="Default" />
		<link rel="stylesheet" type="text/css" href="<?php echo  base_url() ?>css/accordion.css" media="screen, tv, projection" title="Default" />
		<link rel="stylesheet" type="text/css" href="<?php echo  base_url() ?>css/form/form.css" media="screen, tv, projection" title="Default" />	
		<link rel="stylesheet" type="text/css" href="<?php echo  base_url() ?>css/tab_view/tab-view.css" media="screen, tv, projection" title="Default" />	
		<?php /*<link rel="stylesheet" type="text/css" href="<?php echo  base_url() ?>css/jquery-ui-1.9.1.custom.css" media="screen, tv, projection" title="Default" />*/ ?>
		<style type="text/css">@import url("<?php echo  base_url().'css/jquery-ui-1.9.1.custom.css'; ?>");</style> 
		<?php /*<link rel="stylesheet" type="text/css" href="<?php echo  base_url() ?>css/datepicker.css" media="screen, tv, projection" title="Default" /> */ ?>
		<link rel="stylesheet" type="text/css" href="<?php echo  base_url() ?>css/ext-all.css" />
		<?php /*<link rel="stylesheet" type="text/css" href="<?php echo  base_url() ?>css/jquery-ui-1.8.18.custom.css" media="screen, tv, projection" title="Default" /> */ ?>
		<link rel="stylesheet" type="text/css" href="<?php echo  base_url() ?>css/jquery.tree.css" media="screen, tv, projection" title="Default" />
        <link rel="stylesheet" type="text/css" href="<?php echo  base_url() ?>css/treegrid/themes/default/easyui.css"/>
		<link rel="stylesheet" type="text/css" href="<?php echo  base_url() ?>css/treegrid/themes/icon.css"/>
		<link rel="stylesheet" type="text/css" href="<?php echo  base_url() ?>css/chosen.css"/>
		<link rel="stylesheet" type="text/css" href="<?php echo  base_url() ?>css/chosen_embed.css"/>
		<link rel="stylesheet" type="text/css" href="<?php echo  base_url() ?>css/chosen_non_add.css"/>
        
        
		<!-- JAVASCRIPT -->
        <!-- TREEGRID-->
        <script type="text/javascript" src="<?php echo  base_url() ?>js/jquery-1.8.0.min.js"></script>
		<script type="text/javascript" src="<?php echo  base_url() ?>js/jquery.easyui.min.js"></script>
        
		<script type="text/javascript" src="<?php echo  base_url() ?>js/jquery.js"></script>
		<script type="text/javascript" src="<?php echo  base_url() ?>form_attribute/view.js"></script>
		<!--
		<script type="text/javascript" src="<?php echo  base_url() ?>js/datepicker.js"></script>
		-->
		<script type="text/javascript" src="<?php echo  base_url() ?>js/wufoo.js"></script>	
		<script type="text/javascript" src="<?php echo  base_url() ?>js/ajax.js"></script>
		<script type="text/javascript" src="<?php echo  base_url() ?>js/jquery.ui.all.js"></script>
		
		<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script> 
		<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.16/jquery-ui.min.js"></script>  
		<script type="text/javascript" src="<?php echo  base_url() ?>js/jquery-1.7.1.min.js"></script> 
		<script type="text/javascript" src="<?php echo  base_url() ?>js/jquery-ui-1.9.1.custom.min.js"></script>
		<script type="text/javascript" src="<?php echo  base_url() ?>js/jquery.layout.js"></script>
		
		
		<script type="text/javascript" src="<?php echo  base_url() ?>js/jquery.ui.autocomplete.js"></script>
		<script type="text/javascript" src="<?php echo  base_url() ?>js/jquery.tree.js"></script>
		<script type="text/javascript" src="<?php echo  base_url() ?>js/jquery.treeajax.js"></script>
		<script type="text/javascript" src="<?php echo  base_url() ?>js/jquery.treecheckbox.js"></script>
		<script type="text/javascript" src="<?php echo  base_url() ?>js/jquery.treecollapse.js"></script>
		<script type="text/javascript" src="<?php echo  base_url() ?>js/jquery.treecontextmenu.js"></script>
		<script type="text/javascript" src="<?php echo  base_url() ?>js/jquery.treednd.js"></script>
		<script type="text/javascript" src="<?php echo  base_url() ?>js/jquery.treeselect.js"></script>
		<script type="text/javascript" src="<?php echo  base_url() ?>js/flexigrid.pack.js"></script>
		
		<script type="text/javascript" src="<?php echo  base_url() ?>js/FusionCharts.js"></script>
		<script type="text/javascript" src="<?php echo  base_url() ?>js/tiny_mce/tiny_mce.js"></script>
		
		<script type="text/javascript" src="<?php echo  base_url() ?>js/chosen.jquery.js"></script>
		<script type="text/javascript" src="<?php echo  base_url() ?>js/chosen.jquery_non_add.js"></script>
		<script type="text/javascript" src="<?php echo  base_url() ?>js/chosen.proto.js"></script>
		<script type="text/javascript" src="<?php echo  base_url() ?>js/chosen.proto.min.js"></script>
		
		<script type="text/javascript">
			<!-- <MENU_KANAN>
			//  Developed by Roshan Bhattarai 
			//  Visit http://roshanbh.com.np for this script and more.
			//  This notice MUST stay intact for legal use
			-->
			$(document).ready(function()
			{
				//slides the element with class "menu_body" when paragraph with class "menu_head" is clicked 
				$("#firstpane p.menu_head").click(function()
				{
					$(this).next("div.menu_body").slideToggle(300).siblings("div.menu_body").slideUp("slow");
				});
				//slides the element with class "menu_body" when mouse is over the paragraph
				$("#secondpane p.menu_head").mouseover(function()
				{
					 $(this).css({backgroundImage:"url(<?php echo  base_url() ?>images/main/down.png)"}).next("div.menu_body").slideDown(500).siblings("div.menu_body").slideUp("slow");
					 $(this).siblings().css({backgroundImage:"url(<?php echo  base_url() ?>images/main/left.png)"});
				});
			});
		</script>
		<script type="text/javascript">
			<!-- <BORDER_LAYOUT> -->
			var outerLayout; 
			$(document).ready(function () { 
				outerLayout = $('body').layout({ 
					center__paneSelector:	".outer-center" 
				,	west__paneSelector:		".outer-west" 
				,	west__size:				185 
				,	spacing_open:			10 
				,	spacing_closed:			10
				,	north__spacing_open:	0
				,	south__spacing_open:	0
				,	resizable:				false
				,	togglerTip_open:		"Tutup"
				,	togglerTip_closed:		"Buka"
				,	sliderTip:				"Buka Slide"
				}); 
			}); 
		</script> 
		<?php if(isset($added_js)) echo $added_js; ?>
		<?php if(isset($added_js2)) echo $added_js2; ?>
		<?php if(isset($added_js3)) echo $added_js3; ?>
<!--script type="text/javascript" src="<?php echo  base_url() ?>js/jquery-1.2.2.pack.js"></script-->

<!--Start of Zopim Live Chat Script-->
<script type="text/javascript">
	window.$zopim||(function(d,s){var z=$zopim=function(c){z._.push(c)},$=z.s=
	d.createElement(s),e=d.getElementsByTagName(s)[0];z.set=function(o){z.set.
	_.push(o)};z._=[];z.set._=[];$.async=!0;$.setAttribute("charset","utf-8");
	$.src="//v2.zopim.com/?2vKzzVCJ3kWq8mimapd9rDzdWNzLSHbf";z.t=+new Date;$.
	type="text/javascript";e.parentNode.insertBefore($,e)})(document,"script");
</script>
<!--End of Zopim Live Chat Script-->

<!-- Google Analytic -->
<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-52356451-1', 'auto');
  ga('send', 'pageview');

</script>
<!-- INTERCOM -->
<!--<script>
  // window.intercomSettings = {
  //   // TODO: The current logged in user's full name
  //   name: "<?php //echo $this->session->userdata('nama_user'); ?>",
  //   // TODO: The current logged in user's email address.
  //   email: "<?php //echo $this->session->userdata('email'); ?>",
  //   // TODO: The current logged in user's sign-up date as a Unix timestamp.
  //   app_id: "o3rxloli"
  // };
</script>-->
<!--<script>(function(){var w=window;var ic=w.Intercom;if(typeof ic==="function"){ic('reattach_activator');ic('update',intercomSettings);}else{var d=document;var i=function(){i.c(arguments)};i.q=[];i.c=function(args){i.q.push(args)};w.Intercom=i;function l(){var s=d.createElement('script');s.type='text/javascript';s.async=true;s.src='https://widget.intercom.io/widget/o3rxloli';var x=d.getElementsByTagName('script')[0];x.parentNode.insertBefore(s,x);}if(w.attachEvent){w.attachEvent('onload',l);}else{w.addEventListener('load',l,false);}}})()</script>-->
<!-- END INTERCOM -->

</head>
<meta content="text/html; charset=utf-8" http-equiv="Content-Type">
<meta content="utf-8" http-equiv="encoding">
	<body link="#FFFFFF" vlink="#FFFFFF" alink="#FFFFFF">
		<div class="ui-layout-north">
			<table class="header" width="100%" height ="65" border="0">
			  <tr>
				<td width="65"><img src="<?php echo base_url();?>images/icons/erenggar_old.png" height="65px" /></td>
			    <td align="right" style="font-size: 18px; font-family: 'Courier New', Courier, monospace; vertical-align:middle; color: #FFF; ">
                  <p>Selamat Datang <a href="<?php echo  site_url().'/master_data/master_user/detail_user'; ?>"><b><u><?php echo  $this->session->userdata('username'); ?></u></b></a></p>
                <p>Tahun <span style="text-align: right"></span>Anggaran Login: <b><?php echo  $this->session->userdata('thn_anggaran'); ?></b> | <a href="<?php echo  site_url().'/login/logout'; ?>"><b><u>Logout</u></b></a></p></td>
			    <td width="65" align="center"><img src="<?php echo base_url();?>images/icons/depkes.png" height="65px" /></td>
		      </tr>
			  </table>
		</div>
		
		<div class="outer-center">
			<div class="content_panel"><?php echo  $content;?></div>
		</div> 

		<div class="outer-west">
			<div class="leftmenu_panel"><?php $this->load->view('menu_kiri');?></div>
		</div>
		
		<div class="ui-layout-south">
			<div class="footer_panel"><div style="padding:10px 0 0 600px;">© 2015 Biro Perencanaan & Anggaran.</div></div>
		</div> 
	</div> 
	</body>
</html>

