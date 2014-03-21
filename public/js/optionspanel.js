jQuery(document).ready(function($) {
	
	$('.options_toggle').bind('click', function() {
		if($('#t_options').css('left') == '0px'){
			$('#t_options').stop(false, true).animate({left:'-230px'}, 400, 'easeOutExpo');
		}else {
			$('#t_options').stop(false, true).animate({left:'0px'}, 400, 'easeOutExpo');
		}	
	});

	$(".wideboxed a.wrapboxed").click(function() { 
		$.cookie($('#wrapper').addClass("boxed"));
		return false;
	});
	$(".wideboxed a.wrapwide").click(function() { 
		$.cookie($('#wrapper').removeClass("boxed"));
		return false;
	});
	
	
	$("#stylechanger .color a").click(function() { 
		$("#t-colors").attr("href",'color/'+$(this).attr('data-rel'));
		$.cookie("css",'color/'+$(this).attr('data-rel'), {expires: 365, path: '/'});
		return false;
	});
	
	$(".bgr .color a").click(function() { 
		$("#bodybg").attr("href",'boxedbg/'+$(this).attr('data-rel'));
		$.cookie("css",'boxedbg/'+$(this).attr('data-rel'), {expires: 365, path: '/'});
		return false;
	});
	
	$('#accent_color').ColorPicker({
		onSubmit: function(hsb, hex, rgb, el) {
			$(el).val(hex);
			$(el).ColorPickerHide();
		},
		onBeforeShow: function () {
			$(this).ColorPickerSetColor(this.value);
		},
		onChange: function (hsb, hex, rgb) {
			$('#accent_color').val(hex);
			$('#accent_color').css('backgroundColor', '#' + hex);
			accentColorUpdate(hex);
		}
	})
	.bind('keyup', function(){
		$(this).ColorPickerSetColor(this.value);
	});
	
	$('#bodybg_color').ColorPicker({
		onSubmit: function(hsb, hex, rgb, el) {
			$(el).val(hex);
			$(el).ColorPickerHide();
		},
		onBeforeShow: function () {
			$(this).ColorPickerSetColor(this.value);
		},
		onChange: function (hsb, hex, rgb) {
			$('#bodybg_color').val(hex);
			$('#bodybg_color').css('backgroundColor', '#' + hex);
			bodybgColorUpdate(hex);
		}
	})
	.bind('keyup', function(){
		$(this).ColorPickerSetColor(this.value);
	});
	
function accentColorUpdate(hex){

	hex = '#'+hex;

	$('#custom_styles').html('<style>'+
		' .sidebar .widget h4,	a:hover,#inner-headline ul.breadcrumb li a,h1 span.colored, h2 span.colored,h3 span.colored,h4 span.colored,h5 span.colored,h6 span.colored,ul.topmenu li a:hover,form#contactform .validation,div.tabs  ul.nav-tabs li.active a,div.tabbable.tabs-left  ul.nav-tabs li.active a,div.tabbable.tabs-right  ul.nav-tabs li.active a,.accordion-heading a.active,.accordion-heading a.active i,[class^="icon-"].active,ul.styledlist li:before,.logo h1 [class^="icon-"],.footer_logo h3 [class^="icon-"],.cta-text h2 span,.box:hover .text h4,#inner-headline ul.breadcrumb li a:hover,article .post-heading h3 a,.post-entry a.readmore:hover,ul.cat li a:hover, ul.folio-detail li a:hover,.meta-post a,.meta-post ul li i,.meta-bottom li a:hover,ul.popular li a,.pagination ul > li > a:hover,ul.portfolio-categ.filter li.active a,ul.team-categ.filter li.active a,footer a:hover,footer ul.link-list li a:hover { color:'+ hex +'; }' +
		
		'.navbar .nav > li > a.active,.btn-danger,.da-slide h2 span,.top,.button a, button a:visited,footer,.posts .tags a.active,.da-arrows span.da-arrows-prev:before,.da-arrows span.da-arrows-next:before,.da-slide .da-link:hover,.da-dots span,a i.icon-bglight:hover,a i.icon-bgdark:hover,i.icon-bglight.active,i.icon-bgdark.active,.btn-theme,#pagination a:hover,.pagination ul > .active > a,.pagination ul > .active > span,.pagination ul > .active > a:hover,.pagination ul > .active > span:hover,.pricing-box-wrap.special .pricing-heading,.grid figcaption  { background:'+ hex +';}'+
		'	#sendmessage,.btn-theme,.pagination ul > .active > a,.pagination ul > .active > span,.pagination ul > .active > a:hover,.pagination ul > .active > span:hover  { border: 1px solid '+ hex +';}'+
	
	    '   .da-slide .da-link:hover { border:4px solid '+ hex +'; }'+
		'   textarea:focus,input[type="text"]:focus,input[type="password"]:focus,input[type="datetime"]:focus,input[type="datetime-local"]:focus,input[type="date"]:focus,input[type="month"]:focus,input[type="time"]:focus,input[type="week"]:focus,input[type="number"]:focus,input[type="email"]:focus,input[type="url"]:focus,input[type="search"]:focus,input[type="tel"]:focus,input[type="color"]:focus,.uneditable-input:focus,a.thumbnail:hover,a.thumbnail:focus { border-color: '+ hex +';}'+

	    '   div.tabs  ul.nav-tabs li.active a { border-top: 2px solid '+ hex +';}'+
		'   div.tabbable.tabs-left  ul.nav-tabs li.active a { border-left: 2px solid '+ hex +';}'+
		'   div.tabbable.tabs-right  ul.nav-tabs li.active a { border-right: 2px solid '+ hex +';}'+
		
		'   .pullquote-left { border-left: 5px solid '+ hex +';}'+
		'   .pullquote-right { border-right: 5px solid '+ hex +';}'+
		'</style>');
}

function bodybgColorUpdate(hex){
	$('body').css('background', '#'+hex);
}
	
});