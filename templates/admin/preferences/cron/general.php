<?php
global $aiosc_settings, $aiosc_capabilities;

?>
<div class="aiosc-subtoolbar">
    <ul class="aiosc-subtabs">
        <li class="active" data-screen="cron"><?php _e('General','aiosc')?></li>
        <li data-screen="cron-autoclose"><?php _e('Cierre Automático','aiosc')?></li>
        <li data-screen="cron-reminder-queue"><?php _e('Recordatorio de Cola','aiosc')?></li>
    </ul>
</div>
<input type="hidden" name="section" value="cron-general" />
<table class="form-table">
    <tbody>
    <tr>
        <td colspan="2">
            <em>
                <?php _e('Antes de habilitar CRON, debe leer la guía detallada sobre cómo configurar Ticket System CRON en la documentación.','aiosc')?>
            </em>
        </td>
    </tr>
    <tr><td colspan="2"><div class="aiosc-separator"></div></td></tr>
    <tr>
        <th><label for="cron_enable"><?php _e('Habilitar Cron','aiosc')?></label>
            <a href="#" class="aiosc-info-tooltip dashicons dashicons-lightbulb"></a>
            <small><?php _e('¿Te gustaría ejecutar tareas programadas de Ticket System?','aiosc')?> </small></th>
        <td>
            <label>
            <input type="checkbox" id="cron_enable" name="cron_enable" <?php checked($aiosc_settings->get('cron_enable')) ?> />
                <?php _e('Sí, habilite Ticket System Cron.','aiosc')?>
            </label>
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
