<?php
    /*
      Template Name: ArtTeg1.9
     */

    get_header();
    require_once($_SERVER['DOCUMENT_ROOT'] . '/wp-load.php');
?>

<section class="content">

    <?php
	wp_enqueue_script('jquery3.1.1', get_template_directory_uri() . '/js/glo/jquery-3.1.1.min.js');
	wp_enqueue_script('scriptjava', get_template_directory_uri() . '/js/glo/scriptjava.js');

	$r = rand(1000, 9999);
	wp_enqueue_script('sigScript', get_template_directory_uri() . '/js/glo/arteg.js?rand=' . $r);
	wp_enqueue_script('facedetection', get_template_directory_uri() . '/js/glo/jquery_lazyload/jquery.lazyload.js');
	wp_enqueue_script('facedetection', get_template_directory_uri() . '/js/glo/jquery_lazyload/jquery.lazyload.use.js');
	
	wp_enqueue_style('art-teg', get_template_directory_uri() . '/skeleton/art-teg.css');	
    ?>

    <div class="pad group">

	<?php while (have_posts()): the_post(); ?>

		<article <?php post_class('group'); ?>>

		    <?php get_template_part('inc/page-image'); ?>

		    <div class="entry themeform">

			<div class="tegCloud">

			    <?php
				    
			    global $wpdb;


			    //все теги
			    $list = do_shortcode('[mla_term_list separator="|" link=none taxonomy=attachment_tag show_count=true mla_output="array"]');
			    $list_array = explode('|', $list);
			    $list_res = array();

			    $temp = array();
			    for ($i = 0; $i < count($list_array); $i++) {
					$temp = explode('(', $list_array[$i]);
					$list_res[$temp[0]] = substr($temp[1], 0, -1);
			    }
			    arsort($list_res);
			    //все теги
			    
			    //категории
			    $terms = $wpdb->get_results("SELECT `term`,`category` FROM `term_category_rel` ORDER BY `category` ASC");
			    $cat = $wpdb->get_results("SELECT `id` FROM `term_category`");


				//название категорий
			    $category = array();
			    foreach ($cat as $obj) { 
					$tmp = $wpdb->get_results('SELECT `name` FROM `term_category` WHERE `id` = "' . $obj->id . '"');
					$category[$obj->id] = $tmp[0];
			    }
			    arsort($category);
			    //название категорий
			    
			    
			    $allCat = array();
			    $flag = 0;
			    $tmp2 = 0;
			    $i = 0;

			    foreach ($terms as $obj) {
					$tmp1 = $obj->category;
					if ($tmp1 != $tmp2) {
					    $i = 0;
					}
					$allCat[$category[$obj->category]->name][$i] = $obj->term;
					$i++;
	
					$tmp2 = $obj->category;
			    }
				//arsort($terms);
				//вывод тегов
				
			    foreach ($allCat as $index => $catName) {
					echo('<h2>' . $index . '</h2><div class="block_art_teg ">');
					foreach ($list_res as $key => $value) {
					    if ($key[strlen($key) - 1] == ' ') {
							$key = substr($key, 0, -1);
					    }
					    if (in_array($key, $catName)) {
	
						if ($index == 'Цвет') {
						    echo('<input type="button" onclick=\'addTeg("' . $key . '")\' style="background:' . $key . '" (' . $value . ')" id="' . $key . '" class="tegButtonColor"/>');
						} else {
						    echo('<input type="button" onclick=\'addTeg("' . $key . '")\' value="' . $key . ' (' . $value . ')" id="' . $key . '" class="tegButton"/>');
						}
						unset($list_res[$key . ' ']);
					    }
					}
					echo('</div>');
			    }
			    //вывод тегов
			    
				//оставшиеся теги
			    echo('<h2>Другое</h2><div class="block_art_teg">');
			    foreach ($list_res as $key => $value) {

				echo('<input type="button" onclick=\'addTeg("' . $key . '")\' value="' . $key . ' (' . $value . ')" id="' . $key . '" class="tegButton"/>');
			    }
			    echo('</div>');
			    //оставшиеся теги
			    

			    //категории
			    ?>



			</div>
			<div class="tegRes">
			    <div class="tegClick" id='tegClick'></div>
			    <div class="tegOut" id='tegOut'><span style="text-align: center;padding: 10px;font-size: 20px;">Выберите теги из списка слева.</span></div>
			</div>

		    </div><!--/.entry-->


		</article>


	    <?php endwhile; ?>

    </div><!--/.pad-->

</section><!--/.content-->

<?php get_sidebar(); ?>

<?php get_footer(); ?> 