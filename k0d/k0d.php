<?php
/*
 * Plugin Name: k0d
 * Description: вывод записей
 * Author: Kiryl Ausiankin
 */




add_action('init', 'my_post_type');
function my_post_type(){
	register_post_type('k0d', array(
		'labels'             => array(
			'name'               => 'Запись k0d',
			'singular_name'      => 'Запись k0d',
			'add_new'            => 'Добавить запись k0d',
			'add_new_item'       => 'Добавить новую запись k0d',
			'edit_item'          => 'Редактировать запись k0d',
			'new_item'           => 'Новая запись k0d',
			'view_item'          => 'Посмотреть запись k0d',
			'search_items'       => 'Найти запись k0d',
			'not_found'          =>  'Запись k0d не найдена',
			'not_found_in_trash' => 'В корзине запись k0d не найдена',
			'parent_item_colon'  => '',
			'menu_name'          => 'Записи k0d'

		  ),
		'public'             => true,
		'publicly_queryable' => true,
    'show_ui'            => true,
		'show_in_menu'       => true,
		'capability_type'    => 'post',
		'has_archive'        => true,
		'hierarchical'       => true,
    'exclude_from_search'=> true,
		'menu_position'      => 4,
    'query_var'          => true,
		'rewrite'            => true,
		'supports'           => array('title','editor','excerpt','page-attributes')
	) );
}


add_shortcode( 'k0d', 'k0d_shortcode' );

function k0d_shortcode( $atts ){
  global $post;
  $atts = (object) shortcode_atts( array(
		'post'   => null,
		'pagen' => null,
    'showfirst'  => 'new',
    'title'  => 'Хардкоооод!',
	), $atts );

  if($atts->post!=null and $atts->showfirst!=null){

    $order = 'ASC';
    if($atts->showfirst=='old'){
      $order = 'DESC';
    }


    $posts = get_posts( array(
      'numberposts' => -1,
      'orderby'     => 'date',
      'order'       => $order,
      'post_type'   => $atts->post,
      'suppress_filters' => true,
    ));

    $out = '<h1>'.$atts->title.'</h1>';
    $out  .= '<div id="postsList" pagen="'.$atts->pagen.'">';
    foreach( $posts as $post ){
      setup_postdata($post);
      $out  .= '
      <div class="media">
        <div class="media-body">
          <div><small>'.get_the_date().'</small></div>
          <a class="mt-0 mb-1" href="'.get_permalink().'">'.get_the_title().'</a>
          <div>'.get_the_excerpt().'</div>
        </div>
      </div>
      ';
    }
    $out  .= '</div>';




    wp_reset_postdata();
    return  $out;
  }
}
?>