<?php
global $aiosc_settings, $aiosc_capabilities;

$deps = aiosc_DepartmentManager::get_departments(true);
$saved_deps = $aiosc_settings->get('cron_reminder_queue_ignore_departments');
if(!is_array($saved_deps)) $saved_deps = array();
?>
<div class="aiosc-subtoolbar">
    <ul class="aiosc-subtabs">
        <li data-screen="cron"><?php _e('General','aiosc')?></li>
        <li data-screen="cron-autoclose"><?php _e('Cierre Automático','aiosc')?></li>
        <li class="active" data-screen="cron-reminder-queue"><?php _e('Recordatorio de Cola','aiosc')?></li>
    </ul>
</div>
<input type="hidden" name="section" value="cron-reminder-queue" />
<table class="form-table">
    <tbody>
    <tr>
        <td colspan="2">
            <em>
                <?php _e('Esta tarea enviará notificaciones por correo electrónico a todos los clientes cuyos tickets estén en cola más tiempo del esperado.<br />Puede encontrar más detalles en la <strong>documentación</strong>.','aiosc')?>
            </em>
        </td>
    </tr>
    <tr><td colspan="2"><div class="aiosc-separator"></div></td></tr>
    <tr>
        <th><label for="cron_reminder_queue_enable"><?php _e('Habilitar Recordatorio de Cola','aiosc')?></label>
            <a href="#" class="aiosc-info-tooltip dashicons dashicons-lightbulb"></a>
            <small><?php _e('¿Notificar a los clientes cuando su ticket está en cola más tiempo del esperado?','aiosc')?> </small></th>
        <td>
            <label>
                <input type="checkbox" id="cron_reminder_queue_enable" name="cron_reminder_queue_enable" <?php checked($aiosc_settings->get('cron_reminder_queue_enable')) ?> />
                <?php _e('Sí, habilitar el recordatorio de cola.','aiosc')?>
            </label>
        </td>
    </tr>
    <tr>
        <th><label for="cron_reminder_queue_interval"><?php _e('Intervalo de Retardo','aiosc')?></label>
            <a href="#" class="aiosc-info-tooltip dashicons dashicons-lightbulb"></a>
            <small><?php _e('¿Qué se considera como ticket retrasado?','aiosc')?> </small></th>
        <td>
            <label for="cron_reminder_queue_interval"><?php _e('El ticket está en <strong>cola</strong> al menos:', 'aiosc') ?></label>
            <select name="cron_reminder_queue_interval" id="cron_reminder_queue_interval">
                <?php for($i=1;$i<=30;$i++) : ?>
                    <option value="<?php echo $i?>" <?php if($i == $aiosc_settings->get('cron_reminder_queue_interval')) : ?>selected<?php endif;?>><?php echo $i?></option>
                <?php endfor; ?>
            </select>
            <label for="cron_reminder_queue_interval"><?php _e('día(s)', 'aiosc')?></label>
            &nbsp; &nbsp; &nbsp; &nbsp;
            <label style="text-decoration: underline; display: inline-block;" title="<?php _e('Si se marca esta opción, se incluirán todos los tickets que esperan la respuesta del personal, tanto ABIERTO como EN COLA.','aiosc')?>">
                <input type="checkbox" id="cron_reminder_queue_include_open" name="cron_reminder_queue_include_open" <?php checked($aiosc_settings->get('cron_reminder_queue_include_open')) ?> />
                <?php _e('Incluye también los tickets <strong>abiertos</strong> que esperan la respuesta del personal.','aiosc')?>
            </label>
        </td>
    </tr>
    <tr>
        <th><label for="cron_reminder_queue_ignore_departments"><?php _e('Ignorar Departamentos','aiosc')?></label>
            <a href="#" class="aiosc-info-tooltip dashicons dashicons-lightbulb"></a>
            <small><?php _e('Ignorar los tickets de los departamentos seleccionados.<br /><br />Mantenga presionada la tecla CTRL para seleccionar múltiples departamentos.','aiosc')?> </small></th>
        <td>
            <div class="aiosc-listbox">
                <select class="aiosc-listbox" name="cron_reminder_queue_ignore_departments[]" id="cron_reminder_queue_ignore_departments" size="8" multiple>
                    <?php foreach($deps as $dep) : ?>
                        <option value="<?php echo $dep->ID?>" <?php if(in_array($dep->ID, $saved_deps)) : ?>selected<?php endif; ?>><?php echo $dep->name?></option>
                    <?php endforeach; ?>
                </select>
                <button class="button button-list-clear" data-list="cron_reminder_queue_ignore_departments"><?php _e('Ninguna', 'aiosc')?></button>
            </div>
        </td>
    </tr>
    <tr>
        <th>&nbsp;</th>
        <td>
            <input type="submit" class="button button-primary" id="aiosc-form-submit" value="<?php _e('Enviar','aiosc')?>" />
            <button type="button" class="button" id="aiosc-form-discard"><?php _e('Descartar','aiosc')?></button>
        </td>
    </tr>
    </tbody>
</table>
