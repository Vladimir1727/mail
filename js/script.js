(function($){$(function(){

$.fn.try_add=function(arr){//функция проверки на пустые поля при нажатии кнопки
var butt=this;
	butt.click(function(){
		var f=true;
		for (var i = arr.length - 1; i >= 0; i--){
			test=$("#"+arr[i]);
			if (test.val().length>0) test.val(test.val().trim());
			if (test.val().trim().length<1 || test.val().trim()=="0"){
				test.css({"border":"1px red solid"})
				f=false;
			}
			else test.css({"border":"1px #ccc solid"});
		}
	if (f==true) return true;
	return false;
	});
}

$.fn.try_press=function(arr){//функция проверки отправки формы
var butt=this;
	butt.click(function(){
		var f=true;
		for (var i = arr.length - 1; i >= 0; i--){
			test=$("#"+arr[i]);
			if (test.val().length>0) test.val(test.val().trim());
			if (test.val().trim().length<1 || test.val().trim()=="0"){
				test.css({"border":"1px red solid"})
				f=false;
			}
			else test.css({"border":"1px #ccc solid"});
		}
	if (f==true) return true;
	return false;
	});
}

//вход
$('#enter').try_press(['elogin','epass']);

//вкладка категорий
//$('#add_cat').try_add(['input_cat']);
//$('#add_sub').try_add(['input_sub','sel_cat1']);
//вкладка товара
//$('#add_item').try_add(['itemname','pricein','pricesale','info','sel_cat2','subid','itempic']);
//вкладка картинки
//$('#addpics').try_add(['sel_cat3','subid2','itemlist','files']);
//регистрация
//$('#adduser').try_add(['pass1','pass2','login','file_pic']);
//$('#enter').try_add(['login0','pass0']);

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