<?php
    
    function addActivityColaborador() {
        global $wpdb;
    
        $user_id = $_POST['user_id'] ?? $_GET['user_id '] ?? 0;
        $user_id = intval($user_id);
        
        $comment = $_POST['comment'] ?? '';
        $date_start = $_POST['date_start'] ?? '';
    
        $user_id = intval($user_id);
        $comment = sanitize_textarea_field($_POST['comment']);
        $date_start = sanitize_text_field($_POST['date_start']);
        $date_end = !empty($_POST['date_end']) ? sanitize_text_field($_POST['date_end']) : null;
    
        if ($user_id && $date_start) {
            $wpdb->insert(
                $wpdb->prefix . 'user_activity_timer',
                [
                    'user_id'    => $user_id,
                    'comment'    => $comment,
                    'date_start' => $date_start,
                    'date_end'   => $date_end
                ],
                [
                    '%d', '%s', '%s', '%s'
                ]
            );
    
            if ($wpdb->insert_id) {
                wp_send_json_success('Atividade registrada com sucesso!');
            } else {
                wp_send_json_error('Erro ao registrar atividade.');
            }
        } else {
            wp_send_json_error('Preencha todos os campos obrigatórios.');
        }
    }
    
    function updateActivityColaborador() {
        global $wpdb;
        
        $activity_id = $_POST['activity_id'] ?? $_GET['activity_id'] ?? null;
        $activity_id = intval($activity_id);
        
        $comment = $_POST['comment'] ?? '';
        
        $user_id = $_POST['user_id'] ?? $_GET['user_id '] ?? 0;
        $user_id = intval($user_id);
        
        $comment = sanitize_textarea_field($comment);
        $date_start = sanitize_text_field($_POST['date_start']);
        $date_end = !empty($_POST['date_end']) ? sanitize_text_field($_POST['date_end']) : null;
    
        if ($user_id && $date_start) {
            // Atualizar atividade existente
            $updated = $wpdb->update(
                $wpdb->prefix . 'user_activity_timer',
                [
                    'user_id'    => $user_id,
                    'comment'    => $comment,
                    'date_start' => $date_start,
                    'date_end'   => $date_end
                ],
                ['id' => $activity_id],
                ['%d', '%s', '%s', '%s'],
                ['%d']
            );

            if ($updated !== false) {
                wp_send_json_success('Atividade atualizada com sucesso!');
            } else {
                wp_send_json_error('Erro ao atualizar atividade.');
            }
        } else {
            wp_send_json_error('Preencha todos os campos obrigatórios.');
        }
    }
    
    function getAtividadesColaborador($id = 0) {
        global $wpdb;
        
        $id = (int)$id;
        $user = get_userdata($id);

        // Verifica se o usuário existe
        if ( $user ) {
            return $wpdb->get_results( "
                SELECT * 
                FROM {$wpdb->prefix}user_activity_timer
                WHERE user_id = $id
                ORDER BY date_start DESC
            " );
        }
        
        return false;
    }
    
    function getUltimaAtividadeColaborador($id = 0) {
        global $wpdb;
        
        $id = (int)$id;
        $user = get_userdata($id);

        // Verifica se o usuário existe
        if ( $user ) {
            return $wpdb->get_row( "
    			SELECT * 
    			FROM {$wpdb->prefix}user_activity_timer 
    			WHERE user_id = $id
    			ORDER BY date_start DESC 
    			LIMIT 1
    		" );
        }
        
        return false;
    }
    