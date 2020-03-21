<?php
class aiosc_TicketManager {
    static function is_delay_ok($user) {
        global $aiosc_settings, $wpdb;
        if($aiosc_settings->get('creation_delay') < 1) return true;
        $last = $wpdb->get_var('SELECT date_created FROM `'.aiosc_get_table(aiosc_tables::tickets)."` WHERE author_id=$user->ID ORDER BY date_created DESC LIMIT 0,1");
        $last = strtotime($last);
        if($last < 1) return true;
        $delay = $aiosc_settings->get('creation_delay',0);
        $now = current_time('timestamp');
        if($now > ($last + $delay)) return true;
        else return false;
    }

    /**
     * @update 1.1 - added $author field
     * @param int $id
     * @param int $author
     * @param string $subject
     * @param $content
     * @param int $department
     * @param int $operator
     * @param int $priority
     * @param bool $attachments
     * @param bool $is_public
     * @param bool $return_frontend
     * @return array|mixed|string|void
     */
    static function update_ticket($id = 0, $author = 0, $subject = '', $content, $department = 0, $operator = 0, $priority = 0, $attachments = false, $is_public=false, $return_frontend = false) {
        global $aiosc_settings, $aiosc_user, $wpdb;

        $change_author = $author > 0;
        $author = $author > 0 ? new aiosc_User($author) : $aiosc_user;
        if(!aiosc_is_user($author) || !$author->can('create_ticket'))
            return aiosc_response(0,AIOSC_PERMISSION_ERROR);

        if(is_numeric($id) && $id > 0) $ticket = new aiosc_Ticket($id);
        else $ticket = false;

        if(!aiosc_is_ticket($ticket)) {
            if(!$author->can('create_ticket')) return aiosc_response(0,AIOSC_PERMISSION_ERROR);
        }
        else {
            if(!$aiosc_user->can('edit_ticket',array('ticket_id'=>$ticket->ID))) return aiosc_response(0,AIOSC_PERMISSION_ERROR);
        }
        if($id < 1) {
            //check creation delay
            if(!self::is_delay_ok($author))
                return aiosc_response(0,__("<strong>Error:</strong> Debe esperar un tiempo hasta que pueda crear un nuevo ticket.",'aiosc'));
        }
        $errors = array();

        $aiosc_settings->load_settings();

        $subject = apply_filters('aiosc_ticket_submission_subject', $subject);

        if(strlen($subject) < $aiosc_settings->get('min_subject_len'))
            $errors[] = sprintf(__('<strong>Error:</strong> El asunto es demasiado corto. La longitud mínima es %d caracteres.','aiosc'),$aiosc_settings->get('min_subject_len'));

        $content = apply_filters('aiosc_ticket_submission_content', $content);

        if(strlen($content) < $aiosc_settings->get('min_content_len'))
            $errors[] = sprintf(__('<strong>Error:</strong> La descripción es demasiado corta. Por favor escriba una descripción más constructiva.','aiosc'),$aiosc_settings->get('min_content_len'));

        $department = apply_filters('aiosc_ticket_submission_department', new aiosc_Department($department));

        if(!aiosc_is_department($department))
            $errors[] = sprintf(__('<strong>Error:</strong> Por favor seleccione un departamento.','aiosc'));
        else {
            if(!$department->is_active)
                $errors[] = sprintf(sprintf(__('<strong>Error:</strong> Departamento &quot;%s&quot; no está funcionando en este momento. Por favor, elija otro departamento.','aiosc'),$department->name));
        }

        $priority = apply_filters('aiosc_ticket_submission_priority', new aiosc_Priority($priority));
        if(!aiosc_is_priority($priority))
            $errors[] = sprintf(__('<strong>Error:</strong> Por favor seleccione una prioridad.','aiosc'));
        else {
            if(!$priority->is_active)
                $errors[] = sprintf(sprintf(__('<strong>Error:</strong> Prioridad &quot;%s&quot; no está funcionando en este momento. Por favor, elija otra prioridad.','aiosc'),$priority->name));
        }

        //process attachments
        $files = array();
        $fupload = aiosc_AttachmentManager::upload_attachments($attachments);

        if(aiosc_is_error($fupload)) {
            $fupload = @json_decode($fupload);
            $errors[] = @$fupload->message;
            return aiosc_response(0,implode('<br>',$errors));
        }
        else {
            $fupload = @json_decode($fupload);
            $files = @$fupload->data->files;
        }

        //only on creation
        if($ticket === false) $errors = apply_filters('aiosc_before_ticket_creation',$errors);
        else $errors = apply_filters('aiosc_before_ticket_update',$errors, $id);

        if(!empty($errors)) return aiosc_response(0,implode('<br>',$errors));

        //everything passed? insert/update ticket into database
        $subject = esc_sql($subject);
        $content = esc_sql($content);
        $is_public = aiosc_boolToEnum($is_public);
        $now = current_time('mysql');

        if(aiosc_is_ticket($ticket)) {

            $q = $wpdb->query("UPDATE `".aiosc_get_table(aiosc_tables::tickets)."` SET
            subject='$subject', content='$content', is_public='$is_public', last_update='$now' WHERE ID=$ticket->ID");
            if(aiosc_is_department($department)) {
                $ticket->set_department($department, $operator);
            }
            if(aiosc_is_priority($priority)) {
                $ticket->set_priority($priority, $priority->level);
            }

            if($change_author && aiosc_is_user($author)) {
                $ticket->set_author($author);
            }
            do_action('aiosc_after_ticket_update',$ticket);
            return aiosc_response(1,sprintf(__('Ticket <code>#%s</code> actualizado exitosamente. Es posible que tenga que <a href="%s">actualizar</a> la página para ver algunos cambios.','aiosc')
                ,$ticket->ID,'javascript:window.location.reload()'));
        }
        else {
            if(!empty($files)) $files = esc_sql(serialize($files));
            else $files = '';
            $hash = sha1(time().$author->ID.rand(1,999999));
            $operator = new aiosc_User(aiosc_UserManager::get_free_operator($department)); //$department->operators[rand(0,count($department->operators) - 1)]

            if(!aiosc_is_user($author) || !$author->can('create_ticket')) {
                return aiosc_response(0,sprintf(__('No se pudo crear el ticket para el ID de autor <strong>%s</strong> porque el usuario no tiene permiso para crear tickets.
                <br />Por favor intente con otro usuario o asigne a este un rol correcto.','aiosc'),
                    $_POST['author']));
            }

            $q = $wpdb->query("INSERT INTO `".aiosc_get_table(aiosc_tables::tickets)."`
            (subject, content, department_id, priority_id, priority_level, author_id, op_id, is_public, attachment_ids, hash_code, date_created, last_update, awaiting_reply)
            VALUES('$subject','$content',$department->ID, $priority->ID, $priority->level, $author->ID, $operator->ID, '$is_public', '$files', '$hash', '$now','$now', 'Y')");
            if($q) {
                $ticket = new aiosc_Ticket($wpdb->insert_id);
                do_action('aiosc_after_ticket_creation',$ticket);
                //send email-templates
                //to customer
                if($aiosc_settings->get('email_ar_customer_ticket_creation')) {
                    aiosc_EmailManager::send_customer_creation($ticket);
                }
                //to operator
                if($aiosc_settings->get('email_ar_staff_ticket_creation')) {
                    aiosc_EmailManager::send_staff_creation($ticket);
                }
                return aiosc_response(1,sprintf(__('Ticket creada con éxito. Haga clic en <a href="%s">aquí</a> para ver su ticket.','aiosc'),$ticket->get_url(false, $return_frontend)),
                array('url'=>$ticket->get_url(false, $return_frontend)));
            }
            else return aiosc_response(0,sprintf(__('<strong>Error:</strong> No se pudo crear el ticket <code>#%s</code> por una razón desconocida.:<br />%s','aiosc'),@$ticket->ID, @$wpdb->last_error));
        }
    }
    static function request_closure($ticket) {
        global $aiosc_settings, $aiosc_user, $wpdb;
        if(is_numeric($ticket)) $ticket = new aiosc_Ticket($ticket);

        if(!$aiosc_user->can('request_ticket_closure',array('ticket_id'=>$ticket))) return aiosc_response(0,AIOSC_PERMISSION_ERROR);

        $wpdb->query('UPDATE `'.aiosc_get_table(aiosc_tables::tickets)."` SET closure_requested='Y' WHERE ID=$ticket->ID");


        if($aiosc_settings->get('email_ar_staff_ticket_close')) {
            $ticket = new aiosc_Ticket($ticket->ID); //new instance to re-load data and apply all tags that are changed
            aiosc_EmailManager::send_staff_closure($ticket);
        }
        return aiosc_response(1,__('Su petición ha sido recibida. La página se actualizará pronto...','aiosc'));
    }
    static function close_ticket($ticket, $note='', $send_notification = true) {
        global $aiosc_settings, $aiosc_user, $wpdb;
        if(is_numeric($ticket)) $ticket = new aiosc_Ticket($ticket);
        if(!aiosc_is_ticket($ticket) || !$aiosc_user->can('close_ticket',array('ticket_id'=>$ticket)))
            return aiosc_response(0,AIOSC_PERMISSION_ERROR);

        $note = esc_sql($note);
        $now = current_time('mysql');
        $wpdb->query('UPDATE `'.aiosc_get_table(aiosc_tables::tickets)."` SET status='closed', closure_note='$note', date_closed='$now' WHERE ID=$ticket->ID");


        if($send_notification && $aiosc_settings->get('email_ar_customer_ticket_close')) {
            $ticket = new aiosc_Ticket($ticket->ID); //new instance to re-load data and apply all tags that are changed
            aiosc_EmailManager::send_customer_closure($ticket);
        }
        return aiosc_response(1,sprintf(__('El ticket <code>#%s</code> se ha cerrado. Por favor, <a href="%s">actualice</a> la página.','aiosc'),
            $ticket->ID,'javascript:window.location.reload()'));
    }
    static function reopen_ticket($ticket, $send_notification = true) {
        global $aiosc_settings, $aiosc_user, $wpdb;
        if(is_numeric($ticket)) $ticket = new aiosc_Ticket($ticket);
        if(!aiosc_is_ticket($ticket) || !$aiosc_user->can('reopen_ticket',array('ticket_id'=>$ticket)))
            return aiosc_response(0,AIOSC_PERMISSION_ERROR);

        $ticket->open();

        //Send notification to customer or staff member, depending who re-opened ticket
        if($send_notification) {
            //Send to Customer
            if(!$aiosc_user->can('staff')) {
                if($aiosc_settings->get('email_ar_customer_ticket_reopen')) {
                    $ticket = new aiosc_Ticket($ticket->ID); //new instance to re-load data and apply all tags that are changed
                    aiosc_EmailManager::send_customer_reopen($ticket);
                }
            }
            else {
                //Send to Staff
                if($aiosc_settings->get('email_ar_staff_ticket_reopen')) {
                    $ticket = new aiosc_Ticket($ticket->ID); //new instance to re-load data and apply all tags that are changed
                    aiosc_EmailManager::send_staff_reopen($ticket);
                }
            }
        }

        return aiosc_response(1,sprintf(__('El ticket <code>#%s</code> se volvió a abrir correctamente. Por favor, <a href="%s">actualice</a> la página.','aiosc'),
            $ticket->ID,'javascript:window.location.reload()'));
    }

    static function quick_edit($tickets=array(), $department='', $operator = 0, $priority='', $visibility='') {
        global $aiosc_user, $aiosc_settings;
        if(!$aiosc_user->can('edit_tickets')) return aiosc_response(0,AIOSC_PERMISSION_ERROR);
        $processed = 0;
        $dep = empty($department)?false:new aiosc_Department($department);
        $pri = empty($priority)?false:new aiosc_Priority($priority);
        if($visibility != 'Y' && $visibility != 'N') $visibility = '';
        foreach($tickets as $t_id) {
            $ticket = new aiosc_Ticket($t_id);
            if(aiosc_is_ticket($ticket)) {
                if(!empty($department) && (!aiosc_is_department($dep) || !$dep->is_active)) return aiosc_response(0,__('Los tickets no se pudieron actualizar porque el departamento seleccionado no existe o está inactivo.','aiosc'));
                if(!empty($priority) && (!aiosc_is_priority($pri) || !$pri->is_active)) return aiosc_response(0,__('Los tickets no se pudieron actualizar porque la prioridad seleccionada no existe o está inactiva.','aiosc'));

                if(!empty($department) || $operator > 0) {
                    $dep_set = $ticket->set_department($dep, $operator);
                    if(!$dep_set) return aiosc_response(0,"Could not change department");
                }
                if(!empty($priority) && $pri->ID != $ticket->priority_id) {
                    $ticket->set_priority($pri);
                }
                if(!empty($visibility)) {
                    $ticket->set_visibility(aiosc_enumToBool($visibility));
                }


                $processed++;
            }
        }
        if($processed > 0) {
            if($processed > 1)
                return aiosc_response(1,sprintf(__('Total de %d tickets fueron actualizados exitosamente.','aiosc'), $processed));
            else
                return aiosc_response(1,__('Ticket fue actualizado exitosamente.','aiosc'));
        }
        else return aiosc_response(0,__('No se seleccionaron tickets por lo que no se tomó ninguna acción.','aiosc'));
    }
    static function delete_tickets($tickets, $delete_attachments=true) {
        global $aiosc_user, $aiosc_settings;
        if(!$aiosc_user->can('staff') || aiosc_is_demo()) return aiosc_response(0,AIOSC_PERMISSION_ERROR);
        $processed = 0;
        foreach($tickets as $t_id) {
            $ticket = new aiosc_Ticket($t_id);
            if(aiosc_is_ticket($ticket) && $aiosc_user->can('delete_ticket',array('ticket_id'=>$ticket))) {
                $ticket->remove($delete_attachments);
                $processed++;
            }
        }
        if($processed > 0) {
            if($processed > 1)
                return aiosc_response(1,sprintf(__('El total de %d tickets fue eliminado exitosamente.','aiosc'), $processed));
            else
                return aiosc_response(1,__('Ticket fue eliminado con éxito.','aiosc'));
        }
        else return aiosc_response(0,__('No se seleccionaron tickets por lo que no se tomó ninguna acción.','aiosc'));
    }
    /**
     * Get array of table fields in Tickets table
	 * @update 2.0.2 - added date_closed, date_open, last_update
     * @return array
     */
    static function get_columns() {
        return array('ID','subject','content','author_id','department_id','priority_id','priority_level','op_id','collab_ids','ticket_meta','status','is_public','date_created', 'date_closed', 'date_open','attachment_ids', 'last_update');
    }
    static function get_statuses() {
        return array('queue','open','closed');
    }

    static function get_ticket_query($args=array(),$additional_query="",$search_like="") {
        global $aiosc_user, $wpdb;
        $cols = self::get_columns();
        $q = "SELECT * FROM `".aiosc_get_table(aiosc_tables::tickets)."`";
        //parse
        $where = "";
        $is_and = 0;
        if(!empty($args) && is_array($args)) {
            foreach($args as $arg=>$val) {
                if(in_array($arg,$cols)) {
                    if(empty($where)) $where .= " WHERE ";
                    if($is_and > 0) $where .= " AND ";
                    $where .= $arg." = '".esc_sql($val)."'";
                    $is_and++;
                }
            }
            if(!empty($search_like))
                $where .= " AND $search_like ";
        }
        else {
            if(!empty($search_like))
                $where .= " WHERE $search_like ";
        }
        if(!empty($additional_query))
            $where .= " ".$additional_query;

        return $q.$where;
    }
    static function get_tickets($query = '') {
        global $aiosc_user, $wpdb;
        if(empty($query)) {
            $query = 'SELECT * FROM `'.aiosc_get_table(aiosc_tables::tickets).'`';
            if(!$aiosc_user->can('staff')) $query .= ' WHERE author_id='.$aiosc_user->ID;
        }
        $results = $wpdb->get_results($query);
        aiosc_log($query);
        $tickets = array();
        foreach($results as $result) {
            $tickets[] = new aiosc_Ticket($result->ID,$result);
        }
        return $tickets;
    }
    static function get_count_by($args=array(), $additional_query = '') {
        global $wpdb;
        $q = "SELECT COUNT(*) FROM `".aiosc_get_table(aiosc_tables::tickets)."`";
        if(!empty($args)) {
            foreach($args as $k=>$v) {
                if(in_array($k,self::get_columns())) $where[] = "$k = '".esc_sql($v)."'";
            }
        }
        if(!empty($where)) {
            $q .= " WHERE ".implode(" AND ",$where);
        }
        if(!empty($additional_query))
			$q .= empty($where) ? " WHERE " : " AND ";
            $q .= " ".$additional_query;

        return $wpdb->get_var($q);
    }

    /**
     * Check if current user (staff member) have any tickets in queue
     * Function is used for displaying ticket count in toolbars
     */
    static function count_new_tickets() {
        global $aiosc_user;
        $new_ticket_count = 0;
        if(!$aiosc_user->can('edit_tickets') && $aiosc_user->can('staff')) {
            //is operator
            $additional_query = '';
            $ddd = $aiosc_user->get_departments(false);
            if($ddd !== false) {
                $additional_query .= ' (';
                for($i=0;$i<count($ddd);$i++) {
                    $additional_query .= " department_id = ".$ddd[$i]." ";
                    if($i < count($ddd) - 1) $additional_query .= " OR ";
                }
                $additional_query .= ')';
            }
            $new_ticket_count = aiosc_TicketManager::get_count_by(array(
                'status'=>'queue'
            ),$additional_query);
            return $new_ticket_count;
        }
        elseif($aiosc_user->can('edit_tickets')) {
            //is moderator or supervisor
            $new_ticket_count = aiosc_TicketManager::get_count_by(array(
                'status'=>'queue'
            ));
            return $new_ticket_count;
        }
        else return $new_ticket_count;
        //<span class="awaiting-mod disupport-awaiting-mod" title="'.__('Hay tickets en cola','disupport').'"><span class="update-count">'.$new_ticket_count.'</span></span>
    }
}
