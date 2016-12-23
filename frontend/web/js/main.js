jQuery(document).ready(function ($) {

//sub-menu
$('.main-menu .have-sub-menu').hover(function() {
    $('> ul', this).stop().delay(100).fadeIn(100);
}, function() {
    $('> ul', this).stop().fadeOut(100);
});

$('.main-menu .have-sub-sub-menu').hover(function() {
    $('> ul', this).stop().delay(100).fadeIn(100);
}, function() {
    $('>ul', this).stop().fadeOut(100);
});

$('.main-menu li').click(function() {
    $('>ul', this).fadeIn(50);
});

$('.have-sub-menu > a').on('click', function(){
	return false;
})
$('.have-sub-sub-menu > a').on('click', function(){
	return false;
})

//разварачиваем новости
	$('.see-more-link').click(function() {
		$(this).closest('.see-more').siblings('.news_hide').slideToggle("slow");
		$(this).remove();
		return false;
	});

//main-slider-top инициализация
$("#big-slider").owlCarousel({
	items : 1,
	navigation : true,
	baseClass : "owl-big-slider",
	theme : "big-slider-theme",
	slideSpeed : 600,
	autoPlay : true,
	navigationText : ["",""],
	itemsCustom : [[0, 1], [400, 1], [700, 1], [1000, 1], [1200, 1]],
});

//new-tv-slider инициализация
$("#new-tv-slider").owlCarousel({
	items : 1,
	navigation : true,
	pagination: false,
	baseClass : "owl-new-tv-slider",
	theme : "new-tv-theme",
	slideSpeed : 900,
	autoPlay : true,
	stopOnHover : true,
	navigationText : ["",""],
	itemsCustom : [[0, 1], [400, 1], [700, 3], [1000, 3], [1200, 3], [1600, 4]],
});


// Гамбургер
$( ".cross" ).hide();
$( ".menu" ).hide();
$( ".hamburger" ).click(function() {
	$( ".menu" ).slideToggle( "slow", function() {
		$( ".hamburger" ).hide();
		$( ".cross" ).show();
	});
	$( ".menu a" ).click(function(){
		$(".menu").slideUp("slow");
		$( ".cross" ).hide();
		$( ".hamburger" ).show();
	})
});

$( ".cross" ).click(function() {
	$( ".menu" ).slideToggle( "slow", function() {
		$( ".cross" ).hide();
		$( ".hamburger" ).show();
	});
});

//Гамбургер саб-меню
$('.have-sub-menu > a').after('<span class="plus">+</span>');
$('.have-sub-sub-menu > a').after('<span class="plus">+</span>');


//hamburger sub-menu
$('.plus').click(function(){
  $(this).siblings('.sub-menu').slideToggle(500);
});

$('.plus').click(function(){
  $(this).siblings('.sub-sub-menu').slideToggle(500);
});

//vertical sliders
$('#news-slider-v').jsCarousel({ 
	onthumbnailclick: function(src) { }, 
	autoscroll: false, 
	scrollspeed: 500,
	masked: false, 
	itemstodisplay: 7, 
	circular: true,
	orientation: 'v'
});

$('#announce-slider-v').jsCarousel({ 
	onthumbnailclick: function(src) { }, 
	autoscroll: false, 
	scrollspeed: 500,
	masked: false, 
	itemstodisplay: 7, 
	circular: true,
	orientation: 'v' 
});

$('#current-program-h').jsCarousel({ 
	onthumbnailclick: function(src) { }, 
	autoscroll: false, 
	scrollspeed: 700,
	masked: false, 
	itemstodisplay: 3, 
	circular: true,
	orientation: 'h'
});


//news-post-slider
$('.pgwSlideshow').pgwSlideshow();


// подключаем плеер
plyr.setup({
	controls: ['play-large', 'play', 'progress', 'current-time', 'mute', 'volume', 'fullscreen'],
});


//modal-video
var elems = document.querySelectorAll('.play-in-modal');
for(var i=0; i<elems.length; i++){
	elems[i].addEventListener('click', playModal, true);
}
function playModal(event) {
	event.stopPropagation();
	var id = $(this).attr('data-id');
	//отправляем запрос для заполнения модального окна
	$.ajax({
		type: 'POST',
		url: '/news/news/play',
		async: true,
		data: {
			id: id
		},
		success: function (data) {
			$('#modal-content').append(data);
			$('.modal-video').fadeIn(400);
			$('html, body').scrollTop(0);
			plyr.setup({
				controls: ['play-large', 'play', 'progress', 'current-time', 'mute', 'volume', 'fullscreen'],
			});
		}
	});
}

$('#modal-content').on('click', '.close', function(){
	$('.modal-video').fadeOut(500);
	$('.modal-video').empty();
})


//calendar
$('#archive').on('click', function(){
	var calendar = $('.calendar-wrap');
	if(calendar.hasClass('hidden')){
		calendar.removeClass('hidden');
	}
	else{
		calendar.addClass('hidden');

	}

	return false;
});


	//получаес выбранную дату из php

	var date = $('#calendar').attr('data-day');

	if(date !=undefined){
		pickmeup('#calendar', {
			flat : true,
			date: date,
			first_day : 1,
			locale : 'ru',
			prev : '<',
			next: '>',
			select_year : false,
		});
	}


	//отправляем выбранную дату и id программы
	$('#calendar').on('pickmeup-change', function(e) {
		var date = e.detail.date;
		var program_id = $('#calendar').attr('data-program');
		$.ajax({
			type: 'POST',
			url: '/type',
			async: true,
			data: {
				id: program_id,
				date: date
			},
		});
	});

	//страница программа - календарь
	function yearSort(a, b) {
		var x = a.split(',');
		var y = b.split(',');
		var date1 = new Date(x[2]+'-'+x[1]+'-'+x[0]);
		var date2 = new Date(y[2]+'-'+y[1]+'-'+y[0]);
		if (date1 > date2) return 1;
		if (date1 < date2) return -1;
	}

	var date = $('#program_calendar').attr('data-day');
	var now = $('#program_calendar').attr('data-now');

	if(date !=undefined){
		var arr = date.split('| ');
		arr.pop();
		//для того чтобы не выделялся диапазон дат при одной дате, при переходе через год
		 var year=[];
		 var temp=[];
		 for (var j = 0; j < arr.length; j++) {
		 	if(arr[j] != ''){
				var x =arr[j].slice(-4);
				var res = year.indexOf(x);
				if(res==-1){
					year.push(x);
					temp.push(arr[j]);
				}
		 	}
		 }

		 var newArr = arr.concat(temp);
		 newArr.sort(yearSort);
		 newArr.push('');//пустой элемент в массиве, чтоб отображалась текущая дата

		pickmeup('#program_calendar', {
			flat : true,
			date: newArr,
			mode : 'range',
			first_day : 1,
			locale : 'ru',
			prev : '<',
			next: '>',
			select_year : false,
			hide_on_select: false
		});
	};

	$('#program_calendar').on('pickmeup-change', function(e){
		var date = e.detail.date;
		date= date[0];
		var program_id =$('#program_calendar').attr('data-program');
		$.ajax({
			type: 'POST',
			url: '/type',
			data: {
				id: program_id,
				date: date
			}
		});
		return false;
	});

	//архивная лента новостей
	var date = $('#arhiv_calendar').attr('data-day');

	if(date !=undefined){
		pickmeup('#arhiv_calendar', {
			flat : true,
			date: date,
			mode : 'single',
			first_day : 1,
			locale : 'ru',
			prev : '<',
			next: '>',
			select_year : false
		});
	};

	$('#arhiv_calendar').on('pickmeup-change', function(e){
		var date = e.detail.date;
		$.ajax({
			type: 'POST',
			url: 'arhiv',
			data: {
				date: date
			}
		});
		return false;
	});

	//лента анонсов
	var date = $('#anons_calendar').attr('data-day');

	if(date !=undefined){
		pickmeup('#anons_calendar', {
			flat : true,
			date: date,
			mode : 'single',
			first_day : 1,
			locale : 'ru',
			prev : '<',
			next: '>',
			select_year : false
		});
	};

	$('#anons_calendar').on('pickmeup-change', function(e){
		var date = e.detail.date;
		$.ajax({
			type: 'POST',
			url: 'anons',
			data: {
				date: date
			}
		});
		return false;
	});


	//social-comments

	$('#vk-btn').addClass('selected-social');
	$('.fb-comments').hide();


	$('#vk-btn').click(function(){
		$(this).addClass('selected-social');
		$('#fb-btn').removeClass('selected-social');
		$('.vk-comments').show();
		$('.fb-comments').hide();
	});

	$('#fb-btn').click(function(){
		$(this).addClass('selected-social');
		$('#vk-btn').removeClass('selected-social');
		$('.vk-comments').hide();
		$('.fb-comments').show();
	});

	//программа телепередач страница программа
	$('.tv').on('click', function(){
		var tvprograms = $('.tv-program');
		var day =$('.tv');
		day.removeClass('selected-day');
		var id = $(this).attr('data-day');
		$(this).addClass('selected-day');
		tvprograms.addClass('hidden');
		$('#'+id).removeClass('hidden');
		return false;
	});

	//большая программа телепередач
	$('.day').on('click', function(){
		var att = $(this).attr('data-day');
		$('.day').removeClass('selected-day');
		$(this).addClass('selected-day');
		var item = $('#'+att);
		$('.schedule').addClass('hidden');
		item.removeClass('hidden');
	});

	//показать еще новости по теме
	$('a.topical').on('click', function(){
		$('.topical-block .preview').removeClass('hidden');
	});

});



