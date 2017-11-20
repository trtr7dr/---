<?php
	require_once($_SERVER['DOCUMENT_ROOT'] . '/wp-load.php');
	global $wpdb;
	
	if ($_POST['flag'] == 'select') {

		$cat = $wpdb->get_results('SELECT `id` FROM `term_category` WHERE `name` = "'.$_POST['catName'].'"');
		$i = 0;
		foreach($cat as $obj){
			$terms[$i] = $wpdb->get_results('SELECT `term` FROM `term_category_rel` WHERE `category` = "'.$obj->id.'"');
			$i++;
		}
		
		$res = array();
		$i = 0;
		foreach($terms as $obj){
			foreach($obj as $tag){
				$res[$i] = $tag->term;
				$i++;
			}
		}
		
		print json_encode($res);
		
	}
	
	if ($_POST['flag'] == 'add') {
		$cat = $wpdb->get_results('SELECT `id` FROM `term_category` WHERE `name` = "'.$_POST['catName'].'"');
		
		$t = $_POST['tagName'];
		if($t[strlen($t)-1] == ' '){
			$t = substr($t,0,-1);
		}
		
		$res = $wpdb->get_results('INSERT INTO `term_category_rel` (`term`, `category`) VALUES ("'.$t.'", "'.$cat[0]->id.'");');
		
		print ('ok');
	}
	
	if ($_POST['flag'] == 'drop') {
		
		$del = $wpdb->get_results('DELETE FROM `term_category_rel` WHERE `term` = "'.$_POST['tagName'].'"');
		
		print ('ok');
	}
	
	
?>