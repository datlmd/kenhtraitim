<?php 

//pagination
define('PAGINATION_UL_CLASS',               'paging');

$config = array(

            'full_tag_open' => '<ul class="paging">',
            'full_tag_close' => '</ul>',

            'cur_tag_open' => '<li><a href="javascript:void(0);" class="active">',
            'cur_tag_close' => '</a></li>',

            'num_tag_open' => '<li class="vng_custom">',
            'num_tag_close' => '</li>',

            'prev_link' => '<<',
            'prev_tag_open' => '<li class="first">',
            'prev_tag_close' => '</li>',

            'next_link' => '>>',
            'next_tag_open' => '<li class="last">',
            'next_tag_close' => '</li>',

            'last_link' => FALSE,
            'last_tag_open' => '<li class="vng_custom">',
            'last_tag_close' => '</li>',

            'first_link' => FALSE,
            'first_tag_open' => '<li>',
            'first_tag_close' => '</li>' ,
    
            'num_links' => 2,
);