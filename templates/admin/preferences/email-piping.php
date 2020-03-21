<?php
global $aiosc_settings, $aiosc_capabilities;

$departments = aiosc_DepartmentManager::get_departments(true);
$priorities = aiosc_PriorityManager::get_priorities(true);

$domain = aiosc_get_domain();
?>
<div class="aiosc-subtoolbar">
    <ul class="aiosc-subtabs">
        <li data-screen="email"><?php _e('Respondedores automáticos','aiosc')?></li>
        <li class="active" data-screen="email-piping"><?php _e('Canalización de Correo Electrónico','aiosc')?></li>
    </ul>
</div>
<input type="hidden" name="section" value="email-piping" />
<table class="form-table">
    <tbody>
    <tr>
        <th><label for="email_piping_enable"><?php _e('Habilitar Canalización de Correo Electrónico','aiosc')?></label>
            <a href="#" class="aiosc-info-tooltip dashicons dashicons-lightbulb"></a>
            <small><?php _e('Permitir a los usuarios crear / responder a tickets por correo electrónico.','aiosc')?> </small>
        </th>
        <td>
            <label><input type="checkbox" id="email_piping_enable" name="email_piping_enable" value="1" <?php checked($aiosc_settings->get('email_piping_enable'))?>>
                <?php _e('Sí, habilitar la canalización de correo electrónico.','aiosc')?></label>
        </td>
    </tr>
    <tr>
        <th><label for="email_piping_enable_html"><?php _e('Habilitar Tipo de Contenido HTML','aiosc')?></label>
            <a href="#" class="aiosc-info-tooltip dashicons dashicons-lightbulb"></a>
            <small><?php _e('Permitir el contenido HTML en el correo electrónico o sólo texto sin formato.','aiosc')?> </small>
        </th>
        <td>
            <label><input type="checkbox" id="email_piping_enable_html" name="email_piping_enable_html" value="1" <?php checked($aiosc_settings->get('email_piping_enable_html'))?>>
                <?php _e('Sí, permitir al usuario enviar correos electrónicos HTML.','aiosc')?></label>
        </td>
    </tr>
    <tr><td colspan="2" class="aiosc-title"><h3><?php _e('Creación de tickets','aiosc')?></h3><div class="aiosc-separator"></div></td></tr>
    <tr>
        <th><label for="email_piping_domain"><?php _e('Dirección de Correo Electrónico Reenviada','aiosc')?></label>
            <a href="#" class="aiosc-info-tooltip dashicons dashicons-lightbulb"></a>
            <small><?php _e('Los usuarios enviarán sus tickets a esta dirección de correo electrónico.','aiosc')?> </small>
        </th>
        <td>
            <input type="text" id="email_piping_support_addr" name="email_piping_support_addr" placeholder="ex. support@<?php echo $domain?>" size="40" value="<?php echo $aiosc_settings->get('email_piping_support_addr')?>" />
        </td>
    </tr>
    <tr>
        <th><label for="email_piping_creation_department"><?php _e('Departamento Predeterminado','aiosc')?></label>
            <a href="#" class="aiosc-info-tooltip dashicons dashicons-lightbulb"></a>
            <small><?php _e('Departamento activo utilizado para almacenar tickets creados vía correo electrónico.','aiosc')?> </small>
        </th>
        <td>
            <?php
            if($departments != false) : ?>
                <select id="email_piping_creation_department" name="email_piping_creation_department">
                    <option value=""><?php _e('Por favor seleccione...','aiosc')?></option>
                    <?php foreach($departments as $dep) : ?>
                        <option value="<?php echo $dep->ID?>" <?php if($aiosc_settings->get('email_piping_creation_department') == $dep->ID) : ?>selected<?php endif;?>><?php echo $dep->name?></option>
                    <?php endforeach; ?>
                </select>
            <?php else : ?>
                <?php _e('Debe tener al menos un departamento <strong>activo</strong> para que funcione esta función.', 'aiosc')?>
            <?php endif; ?>
        </td>
    </tr>
    <tr>
        <th><label for="email_piping_creation_priority"><?php _e('Prioridad Predeterminada','aiosc')?></label>
            <a href="#" class="aiosc-info-tooltip dashicons dashicons-lightbulb"></a>
            <small><?php _e('Prioridad activa utilizada para tickets creados a través de correo electrónico.','aiosc')?> </small>
        </th>
        <td>
            <?php
            if($priorities != false) : ?>
                <select id="email_piping_creation_priority" name="email_piping_creation_priority">
                    <option value=""><?php _e('Por favor seleccione...','aiosc')?></option>
                    <?php foreach($priorities as $pri) : ?>
                        <option value="<?php echo $pri->ID?>" <?php if($aiosc_settings->get('email_piping_creation_priority') == $pri->ID) : ?>selected<?php endif;?>><?php echo $pri->name?></option>
                    <?php endforeach; ?>
                </select>
            <?php else : ?>
                <?php _e('Debe tener al menos una prioridad <strong>activa</strong> para que funcione esta función.', 'aiosc')?>
            <?php endif; ?>
        </td>
    </tr>
    <tr><td colspan="2" class="aiosc-title"><h3><?php _e('Respuestas de Tickets','aiosc')?></h3><div class="aiosc-separator"></div></td></tr>
    <tr>
        <th><label for="email_piping_domain"><?php _e('Subdominio de Correo Electrónico','aiosc')?></label>
            <a href="#" class="aiosc-info-tooltip dashicons dashicons-lightbulb"></a>
            <small><?php _e('¿Dónde recibir respuestas de los usuarios?','aiosc')?> </small>
        </th>
        <td>
            *@<input type="text" id="email_piping_domain" name="email_piping_domain" size="38" placeholder="aiosc.<?php echo $domain?>" value="<?php echo $aiosc_settings->get('email_piping_domain')?>" />
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
