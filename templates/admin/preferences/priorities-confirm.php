<?php
global $aiosc_settings, $aiosc_capabilities, $aiosc_user;

$action = @$_POST['action2']; //DELETE | ACTIVATE | DEACTIVATE
$priorities = @$_POST['priorities']; //ID of departments

?>
<input type="hidden" name="section" value="priorities-update" />
<input type="hidden" name="confirmation" value="<?php echo $action ?>" />
<div class="aiosc-subtoolbar">
    <ul class="aiosc-subtabs">
        <li data-screen="priorities"><?php _e('Lista','aiosc')?></li>
        <li data-screen="priorities-new"><?php _e('Añadir Nuevo','aiosc')?></li>
        <li class="active">
            <?php
            if($action == 'delete') {
                if(count($priorities) == 1)
                    printf(__('Confirmar la eliminación de %d prioridad','aiosc'),count($priorities));
                else
                    printf(__('Confirmar la eliminación de %d prioridades','aiosc'),count($priorities));
            }
            elseif($action == 'activate') {
                if(count($priorities) == 1)
                    printf(__('Confirmar activación de %d prioridad','aiosc'),count($priorities));
                else
                    printf(__('Confirmar activación de %d prioridades','aiosc'),count($priorities));
            }
            elseif($action == 'deactivate') {
                if(count($priorities) == 1)
                    printf(__('Confirmar desactivación de %d prioridad','aiosc'),count($priorities));
                else
                    printf(__('Confirmar desactivación de %d prioridades.','aiosc'),count($priorities));
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
                _e('Prioridades a eliminar:','aiosc');
            elseif($action == 'activate')
                _e('Prioridades a activar:','aiosc');
            else
                _e('Prioridades a desactivar:','aiosc');
            ?></th>
    </tr>
    <tr class="deps-for-deletion">
        <td colspan="2">
            <div class="aiosc-ops-list aiosc-deps-list">
                <ul>
                    <?php

                        foreach($priorities as $pri_id) :
                            $pri = new aiosc_Priority($pri_id);
                            if(aiosc_is_priority($pri)) :
                            ?>
                            <li><label><input type="checkbox" name="priorities[]" value="<?php echo $pri->ID ?>" checked />
                                    <strong><?php echo $pri->name; ?></strong>
                                        <small><em>(<?php printf(__('Tickets: %d','aiosc'),$pri->ticket_count())?>)</em>,
                                            <em>(<?php printf(__('Nivel: %d','aiosc'),$pri->level)?>)</em></small>
                                </label></li>
                    <?php
                    endif;
                    endforeach;
                    ?>
                </ul>
            </div>
        </td>
    </tr>
    <tr><td colspan="2"><div class="aiosc-separator"></div></td></tr>
    <?php
    if($action == 'delete') :
        ?>
        <tr>
            <th colspan="2"><?php _e('¿Qué te gustaría hacer con los tickets que usan esta prioridad?','aiosc'); ?></th>
        </tr>
        <tr class="deps-for-deletion">
            <td colspan="2">
                <div class="aiosc-ops-list aiosc-deps-list">

                    <?php
                    $free_pris = aiosc_PriorityManager::get_priorities(false,true);
                    ?>
                    <select name="new_priority">
                        <option value="0"><?php _e('- Eliminar todos los tickets -','aiosc')?></option>
                        <?php foreach($free_pris as $new_pri) :
                            if(!in_array($new_pri->ID, $priorities)) : ?>
                                <option value="<?php echo $new_pri->ID?>"><?php printf(__('Mover a: %s','aiosc'),$new_pri->name); ?></option>
                            <?php endif; endforeach; ?>
                    </select>
                </div>
            </td>
        </tr>
        <tr><td colspan="2"><div class="aiosc-separator"></div></td></tr>
    <?php endif; ?>
    <tr>
        <th>&nbsp;</th>
        <td>
            <input type="submit" class="button button-primary" id="aiosc-form-submit" value="<?php if($action == 'delete') _e('Confirmar Eliminación','aiosc'); elseif($action == 'deactivate') _e('Confirmar Desactivación','aiosc'); else _e('Confirmar Activación','aiosc'); ?>" />
            <button type="button" class="button" onClick="javascript:click_first_subtab()"><?php _e('Descartar','aiosc')?></button>
        </td>
    </tr>
    </tbody>
</table>
