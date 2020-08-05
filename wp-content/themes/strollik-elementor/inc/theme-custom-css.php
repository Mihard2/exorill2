<?php
/**
 * @return string
 */
function strollik_custom_css() {

    $css = <<<CSS
CSS;
    /**
     * Filters Home Finder custom colors CSS.
     *
     * @since Home Finder 1.0
     *
     * @param string $css Base theme colors CSS.
     */
    $css = preg_replace('!/\*[^*]*\*+([^/][^*]*\*+)*/!', '', $css);
    $css = str_replace(': ', ':', $css);
    $css = str_replace(array("\r\n", "\r", "\n", "\t", '  ', '    ', '    '), '', $css);
    return apply_filters( 'ezboozt_theme_customizer_css', $css );
}