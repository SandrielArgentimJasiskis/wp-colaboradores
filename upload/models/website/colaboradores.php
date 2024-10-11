<?php
    
    // Processa o registro de usuário no WooCommerce
    function woocommerce_custom_registration_process() {
        if ( isset( $_POST['submit_registration'] ) ) {
            $full_name = sanitize_text_field( $_POST['full_name'] );
            $email = sanitize_email( $_POST['email'] );
            $password = $_POST['password'];
            
            // Verificação básica
            if ( empty( $full_name ) || empty( $email ) || empty( $password ) ) {
                wc_add_notice( 'Todos os campos são obrigatórios.', 'error' );
            } elseif ( ! is_email( $email ) ) {
                wc_add_notice( 'O email fornecido é inválido.', 'error' );
            } elseif ( email_exists( $email ) ) {
                wc_add_notice( 'Este email já está registrado.', 'error' );
            } elseif (strlen($password) < 6) {
                wc_add_notice( 'A senha deve ter pelo menos 6 caracteres.', 'error' );
            } else {
                // Cria o usuário no WooCommerce
                $user_id = wc_create_new_customer( $email, $full_name, $password );
                
                if ( is_wp_error( $user_id ) ) {
                    wc_add_notice( $user_id->get_error_message(), 'error' );
                } else {
                    // Login automático após registro
                    wc_set_customer_auth_cookie( $user_id );
    
                    // Redireciona após o registro bem-sucedido
                    wp_safe_redirect(home_url('/counter'));
                    exit;
                }
            }
        }
    }
