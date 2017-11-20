
<?php

    require_once($_SERVER['DOCUMENT_ROOT'] . '/wp-load.php');


    if ($_POST['tagList'] != '' && $_POST['flag'] == 'res') {
	    
	    $res['num'] = $_POST['num'];
	    
	    $res['mla'] = '<div>';

		$res['mla'] .= do_shortcode('[mla_gallery attachment_tag="' . $_POST['tagList'] . '" tax_operator=AND mla_target="_blank" link=file columns=4 thumbnail="medium" limit=12 offset='.$res['num'].'] ');

	    $res['mla'] .= '</div>';
		
		$res['num']+=12;
		print(json_encode($res));
		exit();
    }

    if ($_POST['tagList'] != '' && $_POST['flag'] == 'noUse') {
	    
	    $list = do_shortcode('[mla_term_list separator="|" link=none taxonomy=attachment_tag mla_output="array"]');
		$list_array = explode('|', $list);
		$list_res = array();
		$data = array();
		$j = 0;
		for($i = 0; $i < count($list_array); $i++){
			$res = do_shortcode('[mla_gallery attachment_tag="' . $_POST['tagList'].$list_array[$i].'" tax_operator=AND  posts_per_page=1 link=none] ');
			
			if(count(explode(' ',$res)) > 2){
				$data[$j] = ($list_array[$i]);
				$j++;
			}
		}
		print(json_encode($data));
		exit();
    }
        
    
    if ($_POST['flag'] == 'all') {
	    
	    $list = do_shortcode('[mla_term_list separator="|" link=none taxonomy=attachment_tag mla_output="array"]');
		$list = explode('|', $list);
		
		
		$color = array();
		$i = 0;
		foreach($list as $key => $t){
			
			if(stripos($t,'#') !== false){
				$color[$i] = $t;
				$i++;
				
				unset($list[$key]);
			}
		}
		
		$list_array['color'] = $color;
		$list_array['data'] = $list;
		
		//print_r($list_array);
		print(json_encode($list_array));
		exit();
    }
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    