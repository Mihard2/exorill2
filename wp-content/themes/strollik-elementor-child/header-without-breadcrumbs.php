<!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js">
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="profile" href="http://gmpg.org/xfn/11">
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<div id="wptime-plugin-preloader"></div>
<div class="opal-wrapper">
    <div id="page" class="site">
        <header id="masthead" class="site-header">
            <?php get_template_part('template-parts/header'); ?>
        </header>
        <div id="page-title-bar" class="page-title-bar">
            <?php //get_template_part('template-parts/common/page-title'); ?>
        </div>
        <div class="site-content-contain">
            <div id="content" class="site-content">
