$(function(){

	//===== Easy tabs =====//
	
	// $('.sidebar-tabs').easytabs({
	// 	animationSpeed: 150,
	// 	collapsible: false,
	// 	tabActiveClass: "active"
	// });

	// $('.actions').easytabs({
	// 	animationSpeed: 300,
	// 	collapsible: false,
	// 	tabActiveClass: "current"
	// });

	//===== Collapsible plugin for main nav =====//
	
	$('.expand').collapsible({
		defaultOpen: 'current,third',
		cookieName: 'navAct',
		cssOpen: 'subOpened',
		cssClose: 'subClosed',
		speed: 300
	});

	//===== Hide/show sidebar =====//

	$('.fullview').click(function(){
	    $("body").toggleClass("clean");
	    $('#sidebar').toggleClass("hide-sidebar mobile-sidebar");
	    $('#content').toggleClass("full-content");
	});

	//  =====  loginout hide/show ======//
	$(".dropdown").click(function(){
		$("ul .dropdown-menu").slideToggle(200);
	});
	
})