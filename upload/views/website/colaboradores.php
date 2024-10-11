<?php
    
    // Shortcode para exibir o formulário de cadastro personalizado
    function woocommerce_custom_registration_form() {
        if (get_current_user_id() && !is_admin()) {
            return '<script>window.location.href = \'' . esc_url(home_url('/counter')) . '\';</script>';
        }
        
        ob_start();
        
        loadAllDependenciesFrontEndWebSiteColaboradores();
        ?>
        <div class="d-flex justify-content-center">
            <div class="card" style="max-width: 100%;width: 750px">
                <div class="card-header">
                    Registrar novo colaborador
                </div>
                <div class="card-body">
                    <form method="post" action="<?php echo esc_url( home_url('/home') ); ?>">
                        
                        <?php
                            if ( wc_notice_count( 'error' ) > 0 ) {
                                wc_print_notices();
                            }
                        ?>
                        
                        <div class="mb-2">
                            <label for="full_name">Nome Completo <strong class="text-danger">*</strong></label>
                            <input class="form-control" placeholder="Nome Completo" type="text" name="full_name" id="full_name" value="<?php if ( ! empty( $_POST['full_name'] ) ) echo esc_attr( $_POST['full_name'] ); ?>" required>
                        </div>
                        <div class="mb-2">
                            <label for="email">Email <strong class="text-danger">*</strong></label>
                            <input class="form-control" placeholder="Email" type="email" name="email" id="email" value="<?php if ( ! empty( $_POST['email'] ) ) echo esc_attr( $_POST['email'] ); ?>" required>
                        </div>
                        <div class="mb-2">
                            <label for="password">Senha <strong class="text-danger">*</strong></label>
                            <input class="form-control" placeholder="Senha" type="password" name="password" id="password" required>
                        </div>
                        <div class="mb-2 d-flex justify-content-end">
                            <input class="btn btn-primary" type="submit" name="submit_registration" value="Registrar-se">
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <?php
            return ob_get_clean();
    }
    