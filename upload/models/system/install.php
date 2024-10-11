<?php
    
    function isColaboradoresInstalled() {
        return file_exists(DIR_COLABORADORES . 'installed.txt');
    }
    
    function installColaboradores() {
        global $wpdb;
    
        // Nome da tabela, utilizando o prefixo do WordPress
        $table_name = $wpdb->prefix . 'user_activity_timer';
    
        // Definir o charset e collation do banco de dados
        $charset_collate = $wpdb->get_charset_collate();
    
        // Query para criar a tabela
        $sql = "CREATE TABLE IF NOT EXISTS $table_name (
            id int(11) NOT NULL AUTO_INCREMENT,
            user_id int(11) NOT NULL,
            comment text NOT NULL,
            date_start datetime NOT NULL,
            date_end datetime DEFAULT NULL,
            PRIMARY KEY (id)
        ) $charset_collate;";
    
        // Carregar a função dbDelta
        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        dbDelta($sql);
        
        $wpdb->query("TRUNCATE TABLE $table_name");
        
        $installation = fopen(DIR_COLABORADORES  . 'installed.txt', 'w');
        fwrite($installation, 'System installed successfully!');
        fclose($installation);
    }