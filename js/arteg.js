var allTag;

jQuery(document).ready(function() {
	var tagList;
	
jQuery("#tegClick").find("input").each(function() {
			tagList += (jQuery(this).attr('id').substr(1)) + ', ';
		});

jQuery.ajax({
		type: 'post',
		url: '/wp-content/themes/typecore-master/js/glo/ajax/arteg.php',
		global: false,
		data: {'tagList': tagList, 'flag':'all'},
		async: true,
		response: 'text',
		success: function (data) {
			var src = JSON.parse(data);	
			allTag = src['data'];
		}
	});
	
});
	
	
	
function mlaUpdate(){
	var tagList = '';
	var check = 0;
		jQuery("#tegClick").find("input").each(function() {
			tagList += (jQuery(this).attr('id').substr(1)) + ', ';
			check++;
		});
		
		var tegClick = document.getElementById('tegClick');
		var html = tegClick.innerHTML;
			jQuery.ajax({
				type: 'post',
				url: '/wp-content/themes/typecore-master/js/glo/ajax/arteg.php',
				global: false,
				data: {'tagList': tagList, 'flag':'noUse'},
				async: true,
				response: 'text',
				success: function (data) {
					var src = JSON.parse(data);
					noTeg(src);
					
				}
		    });
		
	
		var res = document.getElementById('tegOut');
	    jQuery.ajax({
			type: 'post',
			url: '/wp-content/themes/typecore-master/js/glo/ajax/arteg.php',
			global: false,
			data: {'tagList': tagList, 'flag':'res','num':0},
			async: true,
			response: 'text',
			success: function (data) {
				var src = JSON.parse(data);
			    res.innerHTML = src['mla'];
			    
			    res.innerHTML += '<div id="'+tagList+'num" class="12 loadMore" onclick="get_gallery_more(\''+tagList+'\')">Загрузить еще</div>';
			}
	    });
	    return 0;
}


function get_gallery_more(tagList){
	
	var num = document.getElementById(tagList+'num').classList[0];
	var numDiv = document.getElementById(tagList+'num');

	var res = document.getElementById('tegOut');
	$.ajax({

	type: 'post',
	url: '/wp-content/themes/typecore-master/js/glo/ajax/arteg.php',
	global: false,
	processData: true,
	data: {'tagList': tagList, 'flag':'res','num':num},
	async: true,
	response: 'text',
	success: function (data) {
		
		numDiv.parentNode.removeChild(numDiv);
		
		var src = JSON.parse(data);
	    res.innerHTML += src['mla'];
	    res.innerHTML += '<div id="'+tagList+'num" class="'+src['num']+' loadMore" onclick="get_gallery_more(\''+tagList+'\')">Загрузить еще</div>';
	    
	}
    });
    return 0;
}

function noTeg(source){
	var tmp;
	for(var i = 20; i < 300; i++){
		tmp = document.getElementById(allTag[i]);
		if(!tmp){
			tmp = document.getElementById(allTag[i]+' ');
		}
		if(source.indexOf(allTag[i]) != -1){
			tmp.classList.remove("noTag");
		}else{
			tmp.classList.add("noTag");
		}
	}
	
}

function addTeg(tagName) {
	
	var res = document.getElementById('tegOut');
		res.innerHTML = '<img class="tagPreloader" src="https://artrue.ru/wp-content/themes/typecore-master/img/cube.svg">';
	
	var tegClick = document.getElementById('tegClick');
	
	if(document.getElementById('-'+tagName)){
		dropTeg(tagName);
	}else{
		tegClick.innerHTML += '<input type="button" class="tegButton selectTag" onclick=\'dropTeg("'+tagName+'")\' value="-'+tagName+'" id="-'+tagName+'"/>';
		document.getElementById(tagName).classList.add("selectTag"); //remove
	
		mlaUpdate();
		
    }
}

function dropTeg(tagName){
	var res = document.getElementById('tegOut');
		res.innerHTML = '<img class="tagPreloader" src="https://artrue.ru/wp-content/themes/typecore-master/img/cube.svg">';
		
	var del = document.getElementById('-'+tagName);
	del.parentNode.removeChild(del);
	var click = document.getElementById('tegClick');
	var res = document.getElementById('tegOut');
	if(click.innerHTML == ''){
		var timer = setTimeout(function() {
			for(var i = 50; i < 300; i++){
				document.getElementById(allTag[i]+' ').classList.remove("noTag");	
			}
			res.innerHTML = '<span style="text-align: center;padding: 10px;font-size: 20px;">Выберите теги из списка слева.</span>';
		},3200);
		document.getElementById(tagName).classList.remove("selectTag"); //remove
		
		
	}else{
		document.getElementById(tagName).classList.remove("selectTag"); //remove
		mlaUpdate();
	}
	
	
}

