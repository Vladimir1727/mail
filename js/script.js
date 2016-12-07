(function($){$(function(){

$.fn.try_press=function(arr){//функция проверки отправки формы
var butt=this;
	butt.click(function(){
		var f=true;
		var pass_err=false;
		var pass='';
		for (var i = arr.length - 1; i >= 0; i--){
			test=$("#"+arr[i][0]);
			if (test.val().length>0) test.val(test.val().trim());
			var reg=0;
			if (arr[i][1]=='login') reg=test.val().search(/\w{2,}/);
			if (arr[i][1]=='text') reg=test.val().search(/\w{1,}/);
			if (arr[i][1]=='email') reg=test.val().search(/\w+@+\w+\.\w{2,5}/i);
			if (arr[i][1]=='pass'){
				reg=test.val().search(/\w{3,}/);
				if (pass=='') pass=test.val();
					else{
						if (pass!=test.val()){
							pass_err=true;
						}
					}
				}
			if (arr[i][1]=='email') reg=test.val().search(/\w{3,}/);
			if (test.val().length<1 || test.val()=="0" || reg==-1 || pass_err==true){
				test.css({"border":"1px red solid"})
				f=false;
			}
			else test.css({"border":"1px #ccc solid"});
		}
	if (f==true) return true;
	return false;
	});
}

//вход проверка
$('#enter').try_press([['elogin',"login"],['epass',"pass"]]);

//регистрация проверка
$('#adduser').try_press([['login1','login'],['pass1','pass'],['pass2','pass'],['email','email']]);

//отправка письма проверка
$('#msend').try_press([['mto','email'],['mtxt','text'],['mtheme','text']]);

sort('mtxt','f',(document.getElementById('user_name').innerHTML));//сортировка таблицы


$('#open_new').click(function(){//открыть форму создание письма
	$('#view_mess').slideUp();
	$('#open_new').hide();
	$('#del').hide();
	$('#newmess').slideDown();
	return false;
});

$('#chancel').click(function(){//отменить новое письмо
	$('#open_new').show();
	$('#del').show();
	$('#newmess').hide();
	return false;
});

$('#d_all').change(function(){//функция быбора всех сообщений
	var d_all=document.getElementById('d_all');
	if (d_all.checked){
		$('input:checkbox').each(function(){
			this.checked=true;
		});
	}
	else{
		$('input:checkbox').each(function(){
			this.checked=false;
		});
	}
});

$('tbody').on("click","tr", function() {//показать текст письма
  	$('#open_new').show();
	$('#del').show();
	$('#newmess').slideUp();
	$('#view_mess').slideDown();
	show_mes($( this ).find('input').val());
});

$('.isort').each(function(){//сортировка таблицы
	$(this).on("click",function(){
		var f='glyphicon glyphicon-sort-by-attributes';
		var r='glyphicon glyphicon-sort-by-attributes-alt';
		if ($(this).find('span').hasClass(f)){
			$('.isort').find('span').removeClass(f);
			$('.isort').find('span').removeClass(r);
			$(this).find('span').addClass(r);
			var sort_by=$(this).find('p').text();
			sort(sort_by,'r',(document.getElementById('user_name').innerHTML));
		}
		else{
			$('.isort').find('span').removeClass(f);
			$('.isort').find('span').removeClass(r);
			$(this).find('span').addClass(f);
			var sort_by=$(this).find('p').text();
			sort(sort_by,'f',(document.getElementById('user_name').innerHTML));
		} 
	});
});



})})(jQuery)