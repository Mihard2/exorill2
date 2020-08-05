<?php
$gutter_width = get_theme_mod( 'osf_layout_general_gutter_width', 30 ) /2;
return apply_filters('osf_customize_grid', '', $gutter_width);