<?php
$cssCode = '';
$background_image = get_theme_mod('osf_page_404_bg_image', false);
$background_color = get_theme_mod('osf_page_404_bg', '#ddd');
$background_position = get_theme_mod('osf_page_404_bg_position', 'top left');
$background_repeat = get_theme_mod('osf_page_404_bg_repeat', 1);
$background_config = get_theme_mod('osf_page_404_page_enable') != 'default';
if ($background_repeat) {
    $repeat = 'no-repeat';
} else {
    $repeat = 'repeat';
}
if ($background_config != 'custom') {
    if ($background_image) {
        return <<<CSS
    .error404 .site-content-contain{
        background-image: url({$background_image});
        background-position: {$background_position};
        background-repeat: {$repeat};
    }
CSS;
    } elseif ($background_color) {
        return <<<CSS
    .error404 .site-content-contain{
        background-color: {$background_color};
    }
CSS;
    } else {
        return ' ';
    }
}

return '';
