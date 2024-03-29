<?php
/**
 * Template for displaying Bulk actions in "All Tickets"
 */
global $aiosc_settings, $aiosc_capabilities, $aiosc_user;

$action = @$_POST['bulkaction']; //edit | delete
$tickets = @$_POST['tickets']; //ID of tickets

?>
<input type="hidden" name="section" value="tickets-confirmation" />
<input type="hidden" name="confirmation" value="<?php echo $action ?>" />
<div class="aiosc-subtoolbar">
    <ul class="aiosc-subtabs">
        <li class="active">
            <?php
            if($action == 'delete') {
                if(count($tickets) == 1)
                    printf(__('Confirmar la eliminación de %d ticket','aiosc'),count($tickets));
                else
                    printf(__('Confirmar la eliminación de %d tickets','aiosc'),count($tickets));
            }
            elseif($action == 'edit') {
                _e('Edición rapida','aiosc');
            }
            ?>
        </li>
    </ul>
</div>
<table class="form-table">
    <tbody>
    <tr>
        <th colspan="2"><?php
            if($action == 'delete')
                _e('Tickets a eliminar:','aiosc');
            else
                _e('Tickets a editar:','aiosc');
            ?></th>
    </tr>
    <tr class="deps-for-deletion">
        <td colspan="2">
            <div class="aiosc-ops-list aiosc-deps-list">
                <ul>
                    <?php
                        if(is_array($tickets) && !empty($tickets)) :
                            foreach($tickets as $ticket_id) :
                                $ticket = new aiosc_Ticket($ticket_id);
                                if(aiosc_is_ticket($ticket)) :
                                    $op = new aiosc_User($ticket->op_id);
                                    $author = new aiosc_User($ticket->author_id);
                                ?>
                                <li><label><input type="checkbox" name="tickets[]" value="<?php echo $ticket->ID ?>" checked />
                                        <strong><?php echo $ticket->subject; ?></strong>
                                            <small><em>(<?php printf(__('Autor: %s','aiosc'),'<a target="_blank" href="'.aiosc_get_page_user_profile($author).'">'.$author->wpUser->display_name.'</a>')?>)</em>,
                                                <em>(<?php printf(__('Asignado a: %s','aiosc'),'<a target="_blank" href="'.aiosc_get_page_user_profile($op).'">'.$op->wpUser->display_name.'</a>')?>)</em></small>
                                    </label></li>
                        <?php
                                endif;
                            endforeach;
                        else : ?>
                        <li>
                            <?php printf(__('Por favor <a href="%">refrescarh</a> la página.','aiosc'),'javascript:click_first_subtab()'); ?>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </td>
    </tr>
    <tr><td colspan="2"><div class="aiosc-separator"></div></td></tr>
    <?php
    if($action == 'edit') :
        $deps = aiosc_DepartmentManager::get_departments(true);
        $pris = aiosc_PriorityManager::get_priorities(true);
        $authors = aiosc_UserManager::get_users_with_capability('create_ticket',true);
        ?>
        <tr>
            <th colspan="2"><?php _e('Departamento:','aiosc'); ?></th>
        </tr>
        <tr class="deps-for-deletion">
            <td colspan="2">
                <div class="aiosc-ops-list aiosc-deps-list">
                    <select name="new_department" id="new_department">
                        <option value="0"><?php _e('- No cambiar -','aiosc')?></option>
                        <?php foreach($deps as $dep) : ?>
                            <option value="<?php echo $dep->ID?>"><?php printf(__('Asignar a: %s','aiosc'),$dep->name); ?></option>
                        <?php endforeach; ?>
                    </select>
                    <select name="new_operator" id="new_operator">
                        <option value="0"><?php _e('- Elegir operador -','aiosc')?></option>
                    </select>
                </div>
            </td>
        </tr>
        <tr>
            <th colspan="2"><?php _e('Prioridad:','aiosc'); ?></th>
        </tr>
        <tr class="deps-for-deletion">
            <td colspan="2">
                <div class="aiosc-ops-list aiosc-deps-list">
                    <select name="new_priority">
                        <option value="0"><?php _e('- No cambiar -','aiosc')?></option>
                        <?php foreach($pris as $pri) : ?>
                            <option value="<?php echo $pri->ID?>"><?php printf(__('Ajustado a: %s','aiosc'),$pri->name); ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </td>
        </tr>
       <?php /*
  <tr>
            <th colspan="2"><?php _e('Author:','aiosc'); ?></th>
        </tr>
        <tr class="deps-for-deletion">
            <td colspan="2">
                <div class="aiosc-ops-list aiosc-deps-list">
                    <select name="new_author">
                        <option value="0"><?php _e('- Do not change -','aiosc')?></option>
                        <?php foreach($authors as $auth) : ?>
                            <option value="<?php echo $auth->ID?>"><?php printf(__('Set to: %s','aiosc'),$auth->wpUser->display_name); ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </td>
        </tr>
 */ ?>
        <tr>
            <th colspan="2"><?php _e('Visibilidad:','aiosc'); ?></th>
        </tr>
        <tr class="deps-for-deletion">
            <td colspan="2">
                <div class="aiosc-ops-list aiosc-deps-list">
                    <select name="new_visibility">
                        <option value="0"><?php _e('- No cambiar -','aiosc')?></option>
                        <option value="Y"><?php _e('Publico','aiosc')?></option>
                        <option value="N"><?php _e('Privado','aiosc')?></option>
                    </select>
                </div>
            </td>
        </tr>
    <?php elseif($action == 'delete') : ?>
        <tr>
            <th colspan="2"><?php _e('Eliminar adjuntos:','aiosc'); ?></th>
        </tr>
        <tr class="deps-for-deletion">
            <td colspan="2">
                <label><input type="checkbox" name="delete_attachments" value="1" /> <?php _e('Sí, eliminar todos los archivos adjuntos asociados con este ticket','aiosc')?> </label>
            </td>
        </tr>
    <?php endif; ?>
    <tr><td colspan="2"><div class="aiosc-separator"></div></td></tr>
    <tr>
        <th>&nbsp;</th>
        <td>
            <input type="submit" name="ticket-confirmation-submit" class="button button-primary" id="aiosc-form-submit" value="<?php if($action == 'delete') _e('Confirmar Eliminación','aiosc'); else _e('Guardar Edición','aiosc'); ?>" />
            <button type="button" class="button" onClick="javascript:click_first_tab()"><?php _e('Descartar','aiosc')?></button>
        </td>
    </tr>
    </tbody>
</table>
<script>
    jQuery(document).ready(function($) {
        $(document).on('change','#new_department',function(e) {
            var dep_id = $(this).val();
            $("#aiosc-form-submit").attr('disabled','disabled');
            $("#new_operator").attr('disabled','disabled');
            $.post(AIOSC_AJAX_URL, { action: 'aiosc_load_operator_list', department_id: dep_id }, function(data) {
                $("#aiosc-form-submit").removeAttr('disabled');
                $("#new_operator").removeAttr('disabled');
                console.log(data);
                var res = $.parseJSON(data);
                $("#new_operator").html(res.data.html);
            })
        });
    })
</script>
