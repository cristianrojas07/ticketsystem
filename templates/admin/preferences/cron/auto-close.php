<?php
global $aiosc_settings, $aiosc_capabilities;

$deps = aiosc_DepartmentManager::get_departments(true);
$saved_deps = $aiosc_settings->get('cron_autoclose_ignore_departments');
if(!is_array($saved_deps)) $saved_deps = array();
?>
<div class="aiosc-subtoolbar">
    <ul class="aiosc-subtabs">
        <li data-screen="cron"><?php _e('General','aiosc')?></li>
        <li class="active" data-screen="cron-autoclose"><?php _e('Cierre Automático','aiosc')?></li>
        <li data-screen="cron-reminder-queue"><?php _e('Recordatorio de Cola','aiosc')?></li>
    </ul>
</div>
<input type="hidden" name="section" value="cron-autoclose" />
<table class="form-table">
    <tbody>
    <tr>
        <td colspan="2">
            <em>
                <?php _e('Esta tarea cerrará automáticamente los tickets inactivos. También puede enviar notificaciones a los clientes antes del cierre para informarles que sus tickets se cerrarán si no responden de manera oportuna. <br /> Puede encontrar más detalles en la <strong>documentación</strong>.','aiosc')?>
            </em>
        </td>
    </tr>
    <tr><td colspan="2"><div class="aiosc-separator"></div></td></tr>
    <tr>
        <th><label for="cron_autoclose_enable"><?php _e('Habilitar el Cierre Automático','aiosc')?></label>
            <a href="#" class="aiosc-info-tooltip dashicons dashicons-lightbulb"></a>
            <small><?php _e('¿Cerrar automáticamente los tickets inactivos?','aiosc')?> </small></th>
        <td>
            <label>
                <input type="checkbox" id="cron_autoclose_enable" name="cron_autoclose_enable" <?php checked($aiosc_settings->get('cron_autoclose_enable')) ?> />
                <?php _e('Sí, habilitar el cierre automático.','aiosc')?>
            </label>
        </td>
    </tr>
    <tr><td colspan="2" class="aiosc-title"><h3><?php _e('Notificaciones', 'aiosc')?></h3></td></tr>
    <tr>
        <th><label for="cron_autoclose_notify_customer"><?php _e('Notificar al Cliente','aiosc')?></label>
            <a href="#" class="aiosc-info-tooltip dashicons dashicons-lightbulb"></a>
            <small><?php _e('¿Enviar la notificación al cliente cuando el ticket está cerrado?','aiosc')?> </small></th>
        <td>
            <label>
                <input type="checkbox" id="cron_autoclose_notify_customer" name="cron_autoclose_notify_customer" <?php checked($aiosc_settings->get('cron_autoclose_notify_customer')) ?> />
                <?php _e('Sí, enviar una notificación por correo electrónico al cliente.','aiosc')?>
            </label>
        </td>
    </tr>
    <tr>
        <th>
            <label for="aiosc-content"><?php _e('Nota de Cierre por Inactividad','aiosc')?></label>
            <a href="#" class="aiosc-info-tooltip dashicons dashicons-lightbulb"></a>
            <small><?php _e('Nota de cierre predeterminada para tickets cerrados por cron debido a inactividad.','aiosc')?> </small></th>
        </th>
        <td>
            <?php
            wp_editor(
                $aiosc_settings->get('cron_autoclose_closure_note'),
                'aiosc-content',
                array(
                    "media_buttons"=>false,
                    "quicktags"=>false,
                    'textarea_rows'=>4,
                    "textarea_name"=>"content",
                    "tinymce"=>array(
                        "forced_root_block"=>false,
                        "force_br_newlines"=>true,
                        "force_p_newlines"=>false
                    )
                )
            );
            ?>
        </td>
    </tr>
    <tr>
        <th>
            <label for="aiosc-content"><?php _e('Nota de Cierre Solicitada','aiosc')?></label>
            <a href="#" class="aiosc-info-tooltip dashicons dashicons-lightbulb"></a>
            <small><?php _e('Nota de cierre predeterminada para tickets cerrados por cron porque el cliente solicitó el cierre.','aiosc')?> </small></th>
        </th>
        <td>
            <?php
            wp_editor(
                $aiosc_settings->get('cron_autoclose_requested_closure_note'),
                'aiosc-content-2',
                array(
                    "media_buttons"=>false,
                    "quicktags"=>false,
                    'textarea_rows'=>4,
                    "textarea_name"=>"content-2",
                    "tinymce"=>array(
                        "forced_root_block"=>false,
                        "force_br_newlines"=>true,
                        "force_p_newlines"=>false
                    )
                )
            );
            ?>
        </td>
    </tr>
    <tr><td colspan="2" class="aiosc-title"><h3><?php _e('Reglas', 'aiosc')?></h3></td></tr>
    <tr>
        <th><label for="cron_autoclose_interval"><?php _e('Intervalo de Inactividad','aiosc')?></label>
            <a href="#" class="aiosc-info-tooltip dashicons dashicons-lightbulb"></a>
            <small><?php _e('¿Qué se considera ticket inactivo?','aiosc')?> </small></th>
        <td>
            <label for="cron_autoclose_interval"><?php _e('El ticket debe ser mayor que:', 'aiosc') ?></label>
            <select name="cron_autoclose_interval" id="cron_autoclose_interval">
                <?php for($i=1;$i<=30;$i++) : ?>
                    <option value="<?php echo $i?>" <?php if($i == $aiosc_settings->get('cron_autoclose_interval')) : ?>selected<?php endif;?>><?php echo $i?></option>
                <?php endfor; ?>
            </select>
            <label for="cron_autoclose_interval"><?php _e('día(s) &nbsp; &nbsp; <strong>O</strong> ', 'aiosc')?></label>
            &nbsp; &nbsp;
            <label style="text-decoration: underline; display: inline-block;" title="<?php _e('Si se marca esta opción, los tickets con Solicitud de cierre se cerrarán independientemente de su tiempo.','aiosc')?>">
                <input type="checkbox" id="cron_autoclose_requested_closure" name="cron_autoclose_requested_closure" <?php checked($aiosc_settings->get('cron_autoclose_requested_closure')) ?> />
                <?php _e('tiene pendiente solicitud de cierre.','aiosc')?>
            </label>
        </td>
    </tr>
    <tr>
        <th><label for="cron_autoclose_ignore_departments"><?php _e('Ignorar Departamentos','aiosc')?></label>
            <a href="#" class="aiosc-info-tooltip dashicons dashicons-lightbulb"></a>
            <small><?php _e('Ignorar los tickets de los departamentos seleccionados. <br /> <br /> Mantenga presionada la tecla CTRL para seleccionar múltiples departamentos.','aiosc')?> </small></th>
        <td>
            <div class="aiosc-listbox">
                <select class="aiosc-listbox" name="cron_autoclose_ignore_departments[]" id="cron_autoclose_ignore_departments" size="8" multiple>
                    <?php foreach($deps as $dep) : ?>
                        <option value="<?php echo $dep->ID?>" <?php if(in_array($dep->ID, $saved_deps)) : ?>selected<?php endif; ?>><?php echo $dep->name?></option>
                    <?php endforeach; ?>
                </select>
                <button class="button button-list-clear" data-list="cron_autoclose_ignore_departments"><?php _e('Ninguna', 'aiosc')?></button>
            </div>
        </td>
    </tr>

    <tr><td colspan="2" class="aiosc-title"><h3><?php _e('Recordatorio', 'aiosc')?></h3></td></tr>
    <tr>
        <th><label for="cron_reminder_inactivity_enable"><?php _e('Habilitar Recordatorio de Inactividad','aiosc')?></label>
            <a href="#" class="aiosc-info-tooltip dashicons dashicons-lightbulb"></a>
            <small><?php _e('¿Notificar a los clientes cuando su ticket se considere inactivo?','aiosc')?> </small></th>
        <td>
            <label>
                <input type="checkbox" id="cron_reminder_inactivity_enable" name="cron_reminder_inactivity_enable" <?php checked($aiosc_settings->get('cron_reminder_inactivity_enable')) ?> />
                <?php _e('Sí, habilitar recordatorio de inactividad.','aiosc')?>
            </label>
        </td>
    </tr>
    <tr>
        <th><label for="cron_reminder_inactivity_interval"><?php _e('Intervalo de Recordatorio','aiosc')?></label>
            <a href="#" class="aiosc-info-tooltip dashicons dashicons-lightbulb"></a>
            <small><?php _e('¿Cuándo enviar recordatorio?','aiosc')?> </small></th>
        <td>
            <select name="cron_reminder_inactivity_interval" id="cron_reminder_inactivity_interval">
                <?php for($i=1;$i<=30;$i++) : ?>
                    <option value="<?php echo $i?>" <?php if($i == $aiosc_settings->get('cron_reminder_inactivity_interval')) : ?>selected<?php endif;?>><?php echo $i?></option>
                <?php endfor; ?>
            </select>
            <label for="cron_reminder_inactivity_interval"><?php printf(__('día(s) <a href="%s" title="%s">antes del cierre</a>.', 'aiosc'),
                    '#cron_autoclose_interval', sprintf(__('día(s) antes del campo (%s)', 'aiosc'),__('Intervalo de Inactividad','aiosc')))?> </label>
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
<script type="text/javascript">
    if(aiosc_tinymce_enabled()) {
        var str = aiosc_tinyMCEPreInit;
        str = str.replace(/aiosc-demo-wp_editor/gi, 'aiosc-content');
        tinymce.init( JSON.parse(str).mceInit['aiosc-content'] );
        str = aiosc_tinyMCEPreInit;
        str = str.replace(/aiosc-demo-wp_editor/gi, 'aiosc-content-2');
        tinymce.init( JSON.parse(str).mceInit['aiosc-content-2'] );

        jQuery("input[type='submit']").on("mousedown",function() {
            tinymce.triggerSave(); //must save before submitting in order to pass data to request
        });
    }
</script>
