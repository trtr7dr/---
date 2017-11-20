
function CategorySelect(){
	
	var res = document.getElementById("resArtTeg");
	
	var select = document.getElementById("selectCategory"); 
	var text = select.options[select.selectedIndex].text;
	
	
	jQuery.ajax({
		type: 'post',
		url: '/wp-content/themes/typecore-master/js/glo/ajax/artTegAdmin.php',
		data: {
		    'catName': text,
		    'flag': 'select'
		},
		async: false,
        response: 'text',
		success: function (data) {
			
			source = JSON.parse(data);
			
			res.innerHTML = '';
			selectElement(source, res);
		    
		}
    });
}

function selectElement(tags, res){

	var element;
	for(var i = 0; i < tags.length; i++){
		res.innerHTML += '<input type="button" onclick=\'dropTeg("'+tags[i]+'")\' value="'+tags[i]+'" id="'+tags[i]+'drop" class="redButton"/>';
		element = document.getElementById(tags[i]+' ');
		element.classList.add("selectTag");
	}
}

function addTeg(tag){

	var res = document.getElementById("resArtTeg");
	
	var select = document.getElementById("selectCategory"); 
	var text = select.options[select.selectedIndex].text;
	
	jQuery.ajax({
		type: 'post',
		url: '/wp-content/themes/typecore-master/js/glo/ajax/artTegAdmin.php',
		data: {
		    'tagName': tag,
		    'catName': text,
		    'flag': 'add'
		},
		async: false,
        response: 'text',
		success: function (data) {
			res.innerHTML += '<input type="button" onclick=\'dropTeg("'+tag+'")\' value="'+tag+'" id="'+tag+'drop" class="redButton"/>';     
		}
    });
}

function dropTeg(tag){
	var res = document.getElementById(tag+'drop');
	
	jQuery.ajax({
		type: 'post',
		url: '/wp-content/themes/typecore-master/js/glo/ajax/artTegAdmin.php',
		data: {
		    'tagName': tag,
		    'flag': 'drop'
		},
		async: false,
        response: 'text',
		success: function (data) {
			res.parentNode.removeChild(res);     
		}
    });
}




