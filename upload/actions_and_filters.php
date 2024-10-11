<?php
    
    // Adiciona os ShortCodes e Menu do Admin
    add_shortcode('woocommerce_custom_registration_form', 'woocommerce_custom_registration_form');
    add_action( 'template_redirect', 'woocommerce_custom_registration_process' );
    
    add_action('admin_menu', 'custom_admin_menu_colaboradores');
    
    add_action('admin_post_download_colaboradores_detalhes_csv', 'download_colaboradores_detalhes_csv');
    add_action('admin_post_download_colaboradores_page_csv', 'download_colaboradores_page_csv');
    
    add_shortcode( 'cadastro_atividade', 'shortcode_cadastro_atividade' );
    
    add_action( 'wp_ajax_registrar_atividade', 'registrar_atividade' );
    add_action( 'wp_ajax_nopriv_registrar_atividade', 'registrar_atividade' );
    
    add_action('wp_ajax_add_activity_colaborador', 'addActivityColaborador');
    add_action('wp_ajax_update_activity_colaborador', 'updateActivityColaborador');
    