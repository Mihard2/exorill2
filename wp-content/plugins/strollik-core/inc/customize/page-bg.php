<?php
$bg_page = false;


if($bg_page){
    return <<<CSS
#page .site-content-contain{
    background-color: {$bg_page};
}
CSS;
}
return '';

/**
 * @see get_theme_mod()
 */