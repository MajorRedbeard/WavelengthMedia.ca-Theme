<?php
/*
Plugin Name: List Category Posts - Template "Default"
Plugin URI: http://picandocodigo.net/programacion/wordpress/list-category-posts-wordpress-plugin-english/
Description: Template file for List Category Post Plugin for Wordpress which is used by plugin by argument template=value.php
Version: 0.9
Author: Radek Uldrych & Fernando Briano
Author URI: http://picandocodigo.net http://radoviny.net
*/

/*
Copyright 2009 Radek Uldrych (email : verex@centrum.cz)
Copyright 2009-2015 Fernando Briano (http://picandocodigo.net)

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 3 of the License, or any
later version.

This program is distributed in the hope that it will be useful, but
WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU
General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA 02110-1301
USA
*/

/**
* The format for templates changed since version 0.17.  Since this
* code is included inside CatListDisplayer, $this refers to the
* instance of CatListDisplayer that called this file.
*/

/* This is the string which will gather all the information.*/
$lcp_display_output = '';
$featured_sites = '';
$logo_list = '<ul class="lcp_catlist logo-list portfolio">';
$logo_sites = 0;

// Show category link:
$lcp_display_output .= $this->get_category_link('strong');

// Show the conditional title:
$lcp_display_output .= $this->get_conditional_title();

//Add 'starting' tag. Here, I'm using an unordered list (ul) as an example:
$start .= '<ul class="lcp_catlist logo-list portfolio">';

/* Posts Loop
 *
 * The code here will be executed for every post in the category.  As
 * you can see, the different options are being called from functions
 * on the $this variable which is a CatListDisplayer.
 *
 * CatListDisplayer has a function for each field we want to show.  So
 * you'll see get_excerpt, get_thumbnail, etc.  You can now pass an
 * html tag as a parameter. This tag will sorround the info you want
 * to display. You can also assign a specific CSS class to each field.
*/
global $post;
while ( have_posts() ):
  the_post();

//_wm_website_featured
  $featured = get_post_meta(get_the_ID(),'_wm_website_featured',true);
  $url = get_post_meta(get_the_ID(),'_wm_website_url',true);
  $description = get_post_meta(get_the_ID(),'_wm_website_description',true);
  $old = get_post_meta(get_the_ID(),'_wm_website_old',true);
  $logo = get_post_meta(get_the_ID(),'_wm_website_logo',true);
  $logo_featured = get_post_meta(get_the_ID(),'_wm_website_featured_logo',true);
  
//  echo 'Featured: '.$featured.'<br />URL: '.$url.'<br />Desc: '.$description.'<br />';
  

		if ($logo && $logo_featured) { $logos[$logo_sites] = '<li class="logo '.++$logo_sites.'"><a href="'.$url.'" target="_blank"><img src="'.$logo.'" /></a></li>'; 
		
		//$logo_list .= '<li class="logo '.++$logo_sites.'"><img src="'.$logo.'" /></li>'; 
		}
  //Start a List Item for each post:
  $lcp_display_output .= "<li class='logo'>";

  //Show the title and link to the post:
  //$lcp_display_output .= $this->get_post_title($post, 'h3', 'lcp_post');
$lcp_display_output .= '<a href="'.$url.'" target="_blank"><strong>'.get_the_title().'</strong></a> ['.$description.']';
  
  //Show comments:
  $lcp_display_output .= $this->get_comments($post);

  //Show date:
  $lcp_display_output .= ' ' . $this->get_date($post);

  //Show date modified:
  $lcp_display_output .= ' ' . $this->get_modified_date($post);

  //Show author
  $lcp_display_output .= $this->get_author($post);

  //Custom fields:
  $lcp_display_output .= $this->get_custom_fields($post);


  

  /**
   * Post content - Example of how to use tag and class parameters:
   * This will produce:<p class="lcp_content">The content</p>
   */
  $lcp_display_output .= $this->get_content($post, 'p', 'lcp_content');

  /**
   * Post content - Example of how to use tag and class parameters:
   * This will produce:<div class="lcp_excerpt">The content</div>
   */
  $lcp_display_output .= $this->get_excerpt($post, 'div', 'lcp_excerpt');

  // Get Posts "More" link:
  $lcp_display_output .= $this->get_posts_morelink($post);

  //Close li tag
  $lcp_display_output .= '</li>'; /* }*/
endwhile;

	//print_r($logos);
	shuffle($logos);
	//print_r($logos);
	$logo_sites = 0;
	foreach ($logos as $item) {
		if ($logo_sites++ > 9) { break; }
		//echo $item;
		$logo_list .= $item;
	}

// Close the wrapper I opened at the beginning:
$end .= '</ul>';

$oldheading = '<h2>Select past clients</h2>';
$regularheading = "<h2>Wavelength Media's Websites</h2>";
$featuredheading = "<h2>Featured Websites</h2>";

// If there's a "more link", show it:
$end .= $this->get_morelink();

//Pagination
$end .= $this->get_pagination();

$this->lcp_output = $logo_list.'</ul>';