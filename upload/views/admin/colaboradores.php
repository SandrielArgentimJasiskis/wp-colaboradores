<?php
    
    // Exibe a página para cadastro de novo colaborador
    function add_colaborador_form() {
        loadAllDependenciesFrontEndColaboradores();
        
        ?>
        <div class="wrap">
            <h2>Registrar Nova Atividade</h2>
            <form id="activity-form">
                <?php
                    $user_id = $_GET['user_id'] ?? $_POST['user_id'] ?? 0;
                    $user_id = intval($user_id);
                ?>
                
                <table class="form-table">
                    <tr>
                        <th><label for="user_id">Colaborador</label></th>
                        <td>
                            <select id="user_id" name="user_id" required>
                                <?php
                                // Pegando os clientes do WooCommerce
                                $customers = get_users(array('role' => 'customer'));
                                foreach ($customers as $customer) {
                                    $option_html = '<option value="' . intval($customer->ID) . '"';
                                    if ($user_id == intval($customer->ID)) {
                                        $option_html .= 'selected="selected"';
                                    }
                                    $option_html .= '>' . esc_html($customer->display_name) . '</option>';
                                    echo $option_html;
                                }
                                ?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <th><label for="comment">Comentário</label></th>
                        <td><textarea id="comment" name="comment"></textarea></td>
                    </tr>
                    <tr>
                        <th><label for="date_start">Data de Início</label></th>
                        <td><input type="datetime-local" id="date_start" name="date_start" required></td>
                    </tr>
                    <tr>
                        <th><label for="date_end">Data de Fim</label></th>
                        <td><input type="datetime-local" id="date_end" name="date_end"></td>
                    </tr>
                </table>
                <p><button type="submit" class="button button-primary">Registrar Atividade</button></p>
                
                <!-- Botão de Voltar -->
                <p>
                    <a href="javascript:history.back()" class="button">
                        <span class="dashicons dashicons-arrow-left-alt"></span> Voltar
                    </a>
                </p>
            </form>
            <div id="response"></div>
        </div>
        
        <script>
            jQuery(document).ready(function($) {
                $('#activity-form').on('submit', function(e) {
                    e.preventDefault();
    
                    var formData = {
                        action: 'add_activity_colaborador',
                        user_id: $('#user_id').val(),
                        comment: $('#comment').val(),
                        date_start: $('#date_start').val(),
                        date_end: $('#date_end').val() || null
                    };
    
    
                    $.post(ajaxurl, formData, function(response) {
                        $('#response').html('<div class="updated"><p>' + response.data + '</p></div>');
                        $('#activity-form')[0].reset();
                    }).fail(function() {
                        $('#response').html('<div class="error"><p>Erro ao registrar atividade. Tente novamente.</p></div>');
                    });
                });
            });
        </script>
        <?php
    }
    
    function update_colaborador_form() {
        global $wpdb;
        
        $activity_id = $_GET['activity_id'] ?? $_POST['activity_id'] ?? 0;
        $activity_id = intval($activity_id);
        
        if ($activity_id) {
            // Busca a atividade pelo ID
            $activity = $wpdb->get_row($wpdb->prepare("SELECT * FROM " . $wpdb->prefix . "user_activity_timer WHERE id = %d", $activity_id));
            if (!$activity) {
                echo '<div class="wrap"><h1>ID de Atividade de Colaborador inválido.</h1></div>';
                return;
            }
        }
    
        ?>
        <div class="wrap">
            <h2>Editar Atividade</h2>
            <form id="activity-form">
                <input type="hidden" id="activity_id" name="activity_id" value="<?php echo $activity ? $activity->id : ''; ?>">
                <table class="form-table">
                    <tr>
                        <th><label for="user_id">Colaborador</label></th>
                        <td>
                            <select id="user_id" name="user_id" required>
                                <?php
                                $customers = get_users(array('role' => 'customer'));
                                foreach ($customers as $customer) {
                                    $selected = $activity && $activity->user_id == $customer->ID ? 'selected' : '';
                                    echo '<option value="' . $customer->ID . '" ' . $selected . '>' . $customer->display_name . '</option>';
                                }
                                ?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <th><label for="comment">Comentário</label></th>
                        <td><textarea id="comment" name="comment"><?php echo $activity ? esc_textarea($activity->comment) : ''; ?></textarea></td>
                    </tr>
                    <tr>
                        <th><label for="date_start">Data de Início</label></th>
                        <td><input type="datetime-local" id="date_start" name="date_start" value="<?php echo $activity ? esc_attr($activity->date_start) : ''; ?>" required></td>
                    </tr>
                    <tr>
                        <th><label for="date_end">Data de Fim</label></th>
                        <td><input type="datetime-local" id="date_end" name="date_end" value="<?php echo $activity ? esc_attr($activity->date_end) : ''; ?>"></td>
                    </tr>
                </table>
                <p><button type="submit" class="button button-primary">Atualizar Atividade</button></p>
                
                <p>
                    <a href="javascript:history.back()" class="button">
                        <span class="dashicons dashicons-arrow-left-alt"></span> Voltar
                    </a>
                </p>
            </form>
            <div id="response"></div>
        </div>
        
        <script>
            jQuery(document).ready(function($) {
                $('#activity-form').on('submit', function(e) {
                    e.preventDefault();
    
                    var formData = {
                        action: 'update_activity_colaborador',
                        activity_id: $('#activity_id').val(),
                        user_id: $('#user_id').val(),
                        comment: $('#comment').val(),
                        date_start: $('#date_start').val(),
                        date_end: $('#date_end').val() || null
                    };
    
                    $.post(ajaxurl, formData, function(response) {
                        $('#response').html('<div class="updated"><p>' + response.data + '</p></div>');
                        if (!formData.activity_id) {
                            $('#activity-form')[0].reset();
                        }
                    }).fail(function() {
                        $('#response').html('<div class="error"><p>Erro ao salvar atividade. Tente novamente.</p></div>');
                    });
                });
            });
        </script>
        
        <?php
    }
    
    // Exibe a página de detalhes do cliente
    function colaborador_detalhes_display() {
        global $wpdb;
        
        loadAllDependenciesFrontEndColaboradores();
    
        // Verifica se o 'user_id' foi passado na URL
        if ( isset( $_GET['user_id'] ) ) {
            $user = getColaborador($_GET['user_id']);
            if ($user) {
                ?>
                <div class="wrap">
                    <h1>Detalhes do Colaborador: <?php echo esc_html( $user->display_name ); ?> </h1>
                    <p><strong>Email:</strong> <?php echo esc_html( $user->user_email ); ?></p>
                    <p><strong>Data de Registro:</strong> <?php echo esc_html( $user->user_registered ); ?></p>
    
                    <h2>Atividades
                        <span style="float: inline-end;"><a href="<?php echo admin_url('admin-post.php?action=download_colaboradores_detalhes_csv&user_id=' . intval($_GET['user_id'])); ?>" title="Baixar CSV">
                            <i class="fas fa-download"></i>
                        </a>
                        <a href="<?php echo admin_url('admin.php?page=cadastrar_atividade_colaborador&user_id=' . intval($_GET['user_id'])); ?>" title="Cadastrar Nova Atividade">
                            <i class="fas fa-plus"></i>
                        </a></span>
                    </h2>
                    <table class="widefat fixed" cellspacing="0">
                        <thead>
                            <tr>
                                <th scope="col">ID</th>
    							<th scope="col">Observação</th>
                                <th scope="col">Início</th>
                                <th scope="col">Término</th>
                                <th scope="col">Ação</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $activities = getAtividadesColaborador($_GET['user_id']);
                            if ($activities) {
                                foreach ( $activities as $activity ) {
                                    echo '<tr>';
                                    echo '<td>' . esc_html( $activity->id ) . '</td>';
    								echo '<td>' . esc_html( $activity->comment ) . '</td>';
                                    echo '<td>' . esc_html( $activity->date_start ) . '</td>';
                                    echo '<td>' . esc_html( $activity->date_end ) . '</td>';
                                    echo '<td><a href="' . admin_url('admin.php?page=atualizar_atividade_colaborador&activity_id=' . esc_html( $activity->id )) . '"><i class="fas fa-edit"></i></a></td>';
                                    echo '</tr>';
                                }
                            } else {
                                echo '<tr><td colspan="3">Nenhuma atividade encontrada.</td></tr>';
                            }
                            ?>
                        </tbody>
                    </table>
    				
    				<!-- Botão de Voltar -->
                    <p>
                        <a href="javascript:history.back()" class="button">
                            <span class="dashicons dashicons-arrow-left-alt"></span> Voltar
                        </a>
                    </p>
                </div>
                <?php
            } else {
                echo '<div class="wrap"><h1>Usuário não encontrado.</h1></div>';
            }
        } else {
            echo '<div class="wrap"><h1>ID de usuário inválido.</h1></div>';
        }
    }
    
    // Exibe a lista de colaboradores
    function colaboradores_page_display() {
    	global $wpdb;
    	
        loadAllDependenciesFrontEndColaboradores();
        
        ?>
        <div class="wrap">
            <h1>Colaboradores 
                <a href="<?php echo admin_url('admin-post.php?action=download_colaboradores_page_csv'); ?>" title="Baixar CSV">
                    <i class="fas fa-download"></i>
                </a></h1>
                
                <?php
                    $use_activity_field = 0;
                    if (isset($_GET['activity'])) {
                        if ($_GET['activity'] != '') {
                            $use_activity_field = 1;
                        }
                    }
                ?>
                
                <form action="<?php echo admin_url('admin.php'); ?>" method="GET" style="margin:6px;">
                    <input name="page" type="hidden" value="colaboradores_page" />
                    <label for="input-name">Colaborador</label><input name="name" id="input-name" type="text" value="<?php if ( ! empty( $_GET['name'] ) ) echo esc_attr( $_GET['name'] ); ?>"></input>
                    <label for="input-email">E-mail</label><input name="email" id="input-email" type="text" value="<?php if ( ! empty( $_GET['email'] ) ) echo esc_attr( $_GET['email'] ); ?>"></input>
                    <label for="input-date">Data da Última Atividade</label><input name="date" id="input-date" type="date" value="<?php if ( ! empty( $_GET['date'] ) ) echo esc_attr( $_GET['date'] ); ?>"></input>
                    <label for="input-activity">Quant. Atividades</label><input name="activity" id="input-activity" type="text" value="<?php if ($use_activity_field) echo esc_attr( $_GET['activity'] ); ?>"></input>
                    <input type="submit" value="Filtrar"></input>
                </form>
                
            <table class="widefat fixed" cellspacing="0">
                <thead>
                    <tr>
                        <th scope="col">Nome</th>
                        <th scope="col">Email</th>
    					<th scope="col">Última Atividade</th>
    					<th scope="col">Atividades</th>
                        <th scope="col">Data de Registro</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
    				
    				$results = getColaboradores();
                    if ($results) {
                        foreach ( $results as $customer ) {
    						$id = (int)$customer->ID;
    						
    						// Query para obter a última atividade do usuário
    						$last_activity = getUltimaAtividadeColaborador($id);
    						
                            echo '<tr onclick="window.location.href=\'admin.php?page=colaborador_detalhes&user_id=' . esc_attr( $id ) . '\'">';
                            echo '<td>' . esc_html( $customer->display_name ) . '</td>';
                            echo '<td>' . esc_html( $customer->user_email ) . '</td>';
    						?>
    						
    						<?php if ( $last_activity ) : ?>
    							<td>Início: <?php echo esc_html( $last_activity->date_start ); ?>,<br /><?php if ($last_activity->date_end) { echo 'Término: ' . esc_html( $last_activity->date_end); } else { echo 'Em Execução!'; } ?></td>
    						<?php else : ?>
    							<td><strong>Nenhuma atividade encontrada.</strong></td>
    						<?php endif; ?>
    						
    				<?php
    				
    						echo '<td>' . (int)$customer->total_activities . '</td>';
                            echo '<td>' . esc_html( $customer->user_registered ) . '</td>';
                            echo '</tr>';
                        }
                    } else {
                        echo '<tr><td colspan="4">Nenhum colaborador encontrado.</td></tr>';
                    }
                    ?>
                </tbody>
            </table>
        </div>
        <?php
    }
    
    function download_colaboradores_detalhes_csv() {
        // Verificar permissões, caso necessário
        if (!current_user_can('manage_options')) {
            return;
        }
        
        if (!isset( $_GET['user_id'] ) ) {
            return;
        }
        
        $id = intval($_GET['user_id']);
        
        $user = getColaborador($id);
        
        if (!$user) {
            return;
        }
        
        $activities = getAtividadesColaborador($id);
        
        if (!$activities) {
            return;
        }
        
        // Definir os cabeçalhos para download do CSV
        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename=colaboradores.csv');
        
        // Criar o output para escrever o arquivo CSV
        $output = fopen('php://output', 'w');
        
        // Cabeçalhos do CSV
        fputcsv($output, array('ID da Atividade', 'Colaborador', 'Email', 'Observação', 'Início',  'Término'));
        
        foreach ( $activities as $activity ) {
            fputcsv($output, array(
                $activity->id, 
                $user->display_name, 
                $user->user_email,
                $activity->comment,
                $activity->date_start,
                $activity->date_end
            ));
        }
        
        // Fechar o output
        fclose($output);
        
        // Terminar o script para não retornar nada além do CSV
        exit();
    }
    
    function download_colaboradores_page_csv() {
        // Verificar permissões, caso necessário
        if (!current_user_can('manage_options')) {
            return;
        }
    
        // Definir os cabeçalhos para download do CSV
        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename=colaboradores.csv');
        
        // Criar o output para escrever o arquivo CSV
        $output = fopen('php://output', 'w');
        
        
        
        // Cabeçalhos do CSV
        fputcsv($output, array('ID', 'Nome', 'Email', 'Última Atividade', 'Total de Atividades', 'Data de Registro'));
        
        // Buscar os dados dos colaboradores
        $colaboradores = getColaboradores();
        
        // Escrever os dados no CSV
        foreach ($colaboradores as $colaborador) {
            $last_activity_query = getUltimaAtividadeColaborador(intval($colaborador->ID));
            
            $last_activity = '';
            
            if ( $last_activity_query ) {
    			$last_activity .= 'Início: ' . esc_html($last_activity_query->date_start) . ', ';
    			$last_activity .= ($last_activity_query->date_end) ? 'Término: ' . esc_html( $last_activity_query->date_end) : 'Em Execução!';
            } else {
    			$last_activity .= 'Nenhuma atividade encontrada.';
    		}
            
            fputcsv($output, array(
                $colaborador->ID, 
                $colaborador->display_name, 
                $colaborador->user_email,
                $last_activity,
                $colaborador->total_activities,
                $colaborador->user_registered
            ));
        }
        
        // Fechar o output
        fclose($output);
        
        // Terminar o script para não retornar nada além do CSV
        exit();
    }
    
