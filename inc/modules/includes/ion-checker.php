<?php
/**
 *
 * @package Petrona
 * @since 1.0
 */

defined('ABSPATH') || exit ("no access");

$min_loader_version="11.0";
$min_php_version="7.4";
$ioncube_error_checker=[];

if (!extension_loaded('ionCube Loader')){
    $ioncube_error_checker[]=sprintf(esc_html__('We detect you do not have ionCube loader, please call to your host service to install ionCube loader version to upper than %s', 'petrona'),$min_loader_version);
}elseif (!function_exists('ioncube_loader_version') || version_compare(ioncube_loader_version(),$min_loader_version,'<')){
    $ioncube_error_checker[]=sprintf(esc_html__('We detect your ionCube loader is too old, please call to your host service to update ionCube loader version to upper than %s', 'petrona'),$min_loader_version);
}
if(!version_compare(phpversion(),$min_php_version,'>=')) {
    $ioncube_error_checker[] = sprintf(
        esc_html__('We detect your server php version is too old, Petrona theme need php version 7.4 to up.  please call to your host service to update php', 'petrona'),
        $min_php_version
    );
}


