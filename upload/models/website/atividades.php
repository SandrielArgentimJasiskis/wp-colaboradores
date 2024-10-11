<?php
    
    // Registra a atividade via AJAX
    function registrar_atividade() {
        global $wpdb;
    
        if (!isset($_POST['user_id']) || !isset($_POST['comment'])) {
            wp_send_json_error('Dados inválidos.');
            return;
        }
    
        $user_id = intval(get_current_user_id());
        $comment = sanitize_text_field($_POST['comment']);
    
        // Verifica se já existe um registro com date_end NULL
        $last_activity = verificar_atividade();
    
        if ($last_activity) {
            atualiza_atividade($last_activity->id);
            wp_send_json_success('Atividade finalizada com sucesso!');
        } else {
            $result = cadastra_atividade($user_id, $comment);
    
            if ($result) {
                // Obtenha a data de início recém-registrada
                $date_start = $wpdb->get_var($wpdb->prepare("
                    SELECT date_start FROM " . $wpdb->prefix . "user_activity_timer WHERE user_id = %d ORDER BY date_start DESC LIMIT 1
                ", $user_id));
    
                wp_send_json_success(array(
                    'message' => 'Atividade registrada com sucesso!',
                    'date_start' => $date_start
                ));
            } else {
                wp_send_json_error('Erro ao registrar a atividade.');
            }
        }
    }

    
    function registrar_atividadeBackup_30_09_2024() {
        global $wpdb;
    
        if (!isset( $_POST['user_id'] ) || !isset( $_POST['comment'] )) {
            wp_send_json_error( 'Dados inválidos.' );
            return;
        }
        
        $user_id = intval(get_current_user_id());
        $comment = sanitize_text_field($_POST['comment']);

        // Verifica se já existe um registro com date_end NULL
        $last_activity = verificar_atividade();

        if ($last_activity) {
            atualiza_atividade($last_activity->id);

            wp_send_json_success('Atividade finalizada com sucesso!');
        } else {
            $result = cadastra_atividade($user_id, $comment);

            if ($result) {
                wp_send_json_success('Atividade registrada com sucesso!');
            } else {
                wp_send_json_error('Erro ao registrar a atividade.');
            }
        }
    }
    
    function cadastra_atividade($id = 0, $comment = '') {
        global $wpdb;
        
        return $wpdb->insert(
            "{$wpdb->prefix}user_activity_timer",
            array(
                'user_id' => (int)$id,
                'comment' => sanitize_text_field($comment),
                'date_start' => current_time('mysql'),
                'date_end' => NULL // date_end é NULL na inserção
            )
        );
    }
    
    function atualiza_atividade($id = 0) {
        global $wpdb;
        
        $wpdb->update(
            "{$wpdb->prefix}user_activity_timer",
            array(
                'date_end' => current_time('mysql') // Atualiza o date_end para a data atual
            ),
            array('id' => (int)$id) // Usa o ID do último registro encontrado
        );
    }
    
     function verificar_atividade() {
        global $wpdb;
         
        $user_id = intval(get_current_user_id());

        $last_activity = $wpdb->get_row(
            $wpdb->prepare(
                "SELECT * FROM {$wpdb->prefix}user_activity_timer WHERE user_id = %d AND date_end IS NULL ORDER BY date_start DESC",
                $user_id
            )
        );
        
        return $last_activity;
    }
    
    