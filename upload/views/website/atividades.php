<?php
    
    // Shortcode para exibir o botão de cadastro de atividade
    
    function shortcode_cadastro_atividade( $atts ) {
        if (!get_current_user_id()) {
            return '<script>window.location.href = \'' . esc_url(home_url('/home')) . '\';</script>';
        }
        
        // Parâmetro opcional para o ID do usuário (pode ser passado no shortcode)
        $atts = shortcode_atts( array(
            'user_id' => get_current_user_id(),
        ), $atts );
    
        // HTML do botão
        ob_start();
        
        loadAllDependenciesFrontEndWebSiteColaboradores();
        ?>
        
        <div class="d-flex justify-content-center">
        <div class="card" style="max-width: 100%;width: 750px">
            <div class="card-header">
                Controle de Atividades
            </div>
            <div class="card-body">
                <div class="mb-4">
                    <label for="comment">Observação:</label>
                    <textarea class="form-control" name="comment" id="comment"></textarea>
                </div>
                
                
                
                <div class="d-flex justify-content-between">
                    <?= (wp_get_current_user())->display_name ?>
                    <button id="registrar-atividade" class="btn btn-primary d-flex align-items-center gap-2">
                        <span class="dashicons dashicons-plus-alt"></span> 
                        <span id="register-button-action"><?= verificar_atividade() ? 'Registrar Término de Nova Atividade' : 'Registrar Início de Nova Atividade' ?></span>
                    </button>
                </div>
                <div id="timer"></div> <!-- Div para exibir o cronômetro -->

            </div>
        </div>
        </div>
    
        <script>
            jQuery(document).ready(function($) {
                $('#registrar-atividade').on('click', function() {
                    var user_id = '<?php echo esc_js( $atts['user_id'] ); ?>';
                    var comment = $('#comment').val();
            
                    $.ajax({
                        url: '<?php echo admin_url( 'admin-ajax.php' ); ?>',
                        method: 'POST',
                        data: {
                            action: 'registrar_atividade',
                            user_id: user_id,
                            comment: comment
                        },
                        success: function(response) {
                            if (response.success) {
                                alert(response.data.message);
                                if (response.data.message == 'Atividade registrada com sucesso!') {
                                    $('#register-button-action').html('Registrar Término de Nova Atividade');
                                    
                                    // Iniciar o cronômetro
                                    if (response.data.date_start) {
                                        startTimer(response.data.date_start);
                                    }
                                } else {
                                    $('#register-button-action').html('Registrar Início de Nova Atividade');
                                    stopTimer();
                                }
                            } else {
                                alert('Erro: ' + response.data);
                            }
                        }
                    });
                });
            
                // Função para iniciar o cronômetro
                function startTimer(date_start) {
                    var startTime = new Date(date_start).getTime();
            
                    setInterval(function() {
                        var now = new Date().getTime();
                        var elapsedTime = now - startTime;
            
                        var hours = Math.floor((elapsedTime % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                        var minutes = Math.floor((elapsedTime % (1000 * 60 * 60)) / (1000 * 60));
                        var seconds = Math.floor((elapsedTime % (1000 * 60)) / 1000);
            
                        $('#timer').html(hours + "h " + minutes + "m " + seconds + "s");
                    }, 1000);
                }
            
                // Função para parar o cronômetro (pode ser usada quando a atividade for finalizada)
                function stopTimer() {
                    clearInterval();
                    $('#timer').html('');
                }
            });

        </script>
        
        <?php
        return ob_get_clean();
    }
    
    function shortcode_cadastro_atividadeBackup30_09_2024( $atts ) {
        if (!get_current_user_id()) {
            return '<script>window.location.href = \'' . esc_url(home_url('/home')) . '\';</script>';
        }
        
        // Parâmetro opcional para o ID do usuário (pode ser passado no shortcode)
        $atts = shortcode_atts( array(
            'user_id' => get_current_user_id(),
        ), $atts );
    
        // HTML do botão
        ob_start();
        
        loadAllDependenciesFrontEndWebSiteColaboradores();
        ?>
        
        <div class="d-flex justify-content-center">
        <div class="card" style="max-width: 100%;width: 750px">
            <div class="card-header">
                Controle de Atividades
            </div>
            <div class="card-body">
                <div class="mb-4">
                    <label for="comment">Observação:</label>
                    <textarea class="form-control" name="comment" id="comment"></textarea>
                </div>
                
                <div class="d-flex justify-content-between">
                    <?= (wp_get_current_user())->display_name ?>
                    <button id="registrar-atividade" class="btn btn-primary d-flex align-items-center gap-2">
                        <span class="dashicons dashicons-plus-alt"></span> <span id="register-button-action"><?= verificar_atividade() ? 'Registrar Término de Nova Atividade' : 'Registrar Início de Nova Atividade' ?></span>
                    </button>
                </div>
            </div>
        </div>
        </div>
    
        <script type="text/javascript">
            jQuery(document).ready(function($) {
                $('#registrar-atividade').on('click', function() {
                    var user_id = '<?php echo esc_js( $atts['user_id'] ); ?>';
                    var comment = $('#comment').val();
        
                    $.ajax({
                        url: '<?php echo admin_url( 'admin-ajax.php' ); ?>',
                        method: 'POST',
                        data: {
                            action: 'registrar_atividade',
                            user_id: user_id,
                            comment: comment
                        },
                        success: function(response) {
                            console.log(response);
                            if (response.success) {
                                alert(response.data);
                                if (response.data == 'Atividade registrada com sucesso!') {
                                    $('#register-button-action').html('Registrar Término de Nova Atividade');
                                } else {
                                    $('#register-button-action').html('Registrar Início de Nova Atividade');
                                }
                            } else {
                                alert('Erro: ' + response.data);
                            }
                        }
                    });
                });
            });
        </script>
        
        <?php
        return ob_get_clean();
    }
    