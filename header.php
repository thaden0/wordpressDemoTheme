<!DOCTYPE html>
<html>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<title><?php wp_title( '|', true, 'right' ); ?></title>

<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_nav_menu([
    'theme_location' => 'primary',
    'container' => 'nav',
    'container_class' => 'primary-menu',
    'menu_class' => 'menu-list',
    'menu_id' => 'primary-menu',
    'menu_item_id' => 'primary-menu-item',
    'menu_item_class' => 'primary-menu-item',
   
]); ?>