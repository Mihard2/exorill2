<?php
$cssCode = '';

$margin_bottom  = get_theme_mod( 'osf_layout_sidebar_margin_bottom', 30 );
$padding_bottom = get_theme_mod( 'osf_layout_sidebar_padding_bottom', 30 );

$cssCode .= <<<CSS
#secondary .widget{
    margin-bottom: {$margin_bottom}px;
    padding-bottom: {$padding_bottom}px;
}
CSS;

if ($cssCode){
    return <<<CSS
@media screen and (min-width: 768px){
    {$cssCode}
}
CSS;
}
return '';