<?php

/*
 Plugin Name: bbPress Popular Topics
 Plugin URI: http://www.eduardoleoni.com.br
 Description: Shortcode to show the topics with more replies
 Version: 0.2.1
 Author: Eduardo Leoni
 Author URI: http://www.eduardoleoni.com.br
 Text Domain: bbpress-popular-topics
 */


function bbpt_get($limit){
   
    global $wpdb;
    $query = "SELECT 
                post_parent, COUNT(*) as count 
              FROM 
                " . $wpdb->prefix . "posts 
              WHERE 
                post_type ='reply' 
              GROUP BY 
                post_parent 
              ORDER BY 
                count DESC
              LIMIT $limit;";
    $result = $wpdb->get_results($query);
    
    foreach ($result as $each):
        $post = $each->post_parent;
        $replies = $each->count;
        
        $post = get_post($post);
        ?>
        <div class ="each">
            <span class ="post"><a href ="<?php echo get_permalink($post->ID); ?>"><?php echo $post->post_title; ?></a></span>
            <span class ="by"> <span class ="image"><?php echo get_avatar($post->post_author) ?></span></span>
            <span class ="author"><a href = "<?php echo bbp_get_topic_author_url($post->ID); ?>">By <?php echo bbp_get_topic_author_display_name($post->ID); ?></a></span>
            <span class ="replies"><?php echo $replies; ?> replies</span>

        </div>
        <?php
        
    endforeach;
    
    
    ?>
      
    <?php
    
}



function bbpt_shortcodeCaller( $atts ){
    
    bbpt_get($atts["qty"]);
}


add_shortcode( 'bbpresspopulartopics', 'bbpt_shortcodeCaller' );



