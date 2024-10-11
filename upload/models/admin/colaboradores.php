<?php
    
    function getColaborador($id = 0) {
        global $wpdb;
        
        $user_id = intval($id);
        
        return get_userdata( $user_id );
    }
    
    function getColaboradores() {
        global $wpdb;
        
        $filter_sql = '';
        if (!empty($_GET['name'])) {
            $filter_sql .= " AND u.display_name LIKE '%" . esc_sql($_GET['name']) . "%'";
        }
        if (!empty($_GET['email'])) {
            $filter_sql .= " AND u.user_email LIKE '%" . esc_sql($_GET['email']) . "%'";
        }
        
        // Adicionar filtro para atividades usando HAVING
        $having_sql = '';
        if (isset($_GET['activity'])) {
            if ($_GET['activity'] != '') {
                $having_sql .= " HAVING total_activities = '" . intval($_GET['activity']) . "'";
            }
        }
        
        // Mover o filtro da data para a cláusula HAVING
        if (!empty($_GET['date'])) {
            if (!empty($having_sql)) {
                $having_sql .= " AND ";
            } else {
                $having_sql .= " HAVING ";
            }
            $having_sql .= " last_activity_date = '" . esc_sql($_GET['date']) . "'";
        }
        
        $results = $wpdb->get_results("
            SELECT u.ID, u.display_name, u.user_email, u.user_registered, COUNT(t.id) as total_activities, MAX(DATE(t.date_start)) as last_activity_date
            FROM {$wpdb->users} u
            LEFT JOIN {$wpdb->prefix}user_activity_timer t ON u.ID = t.user_id
            INNER JOIN {$wpdb->usermeta} um ON u.ID = um.user_id
            WHERE um.meta_key = '{$wpdb->prefix}capabilities' 
            AND um.meta_value LIKE '%customer%'
            " . $filter_sql . "
            GROUP BY u.ID
            " . $having_sql . "
            ORDER BY u.user_registered DESC
        ");
		
		return $results;
    }
    