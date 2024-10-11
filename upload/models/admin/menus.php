<?php
    
    function custom_admin_menu_colaboradores() {
        add_menu_page(
            'Colaboradores',
            'Colaboradores',
            'manage_options',
            'colaboradores_page',
            'colaboradores_page_display',
            'dashicons-groups', // Ícone para Colaboradores
            10 // Posição no menu
        );
        
        add_submenu_page(
            null, // Página oculta
            'Detalhes do Colaborador', // Título da página
            'Detalhes do Colaborador', // Nome do menu
            'manage_options', // Capacidade necessária
            'colaborador_detalhes', // Slug da página
            'colaborador_detalhes_display' // Função de callback
        );
        
        add_submenu_page(
            null, // Página oculta
            'Cadastrar Atividade para Colaborador', // Título da página
            'Cadastrar Atividade para Colaborador', // Nome do menu
            'manage_options', // Capacidade necessária
            'cadastrar_atividade_colaborador', // Slug da página
            'add_colaborador_form' // Função de callback
        );
        
        add_submenu_page(
            null, // Página oculta
            'Atualizar Atividade para Colaborador', // Título da página
            'Atualizar Atividade para Colaborador', // Nome do menu
            'manage_options', // Capacidade necessária
            'atualizar_atividade_colaborador', // Slug da página
            'update_colaborador_form' // Função de callback
        );
    }