<?php aisoc_print_js_debug() ?>
<?php
global $aiosc_settings, $aiosc_user;
$departments = aiosc_DepartmentManager::get_departments(true);
$priorities = aiosc_PriorityManager::get_priorities(true);
?>
<div class="wrap">
    <div class="aiosc-window">
        <h2 class="page-title"><?php echo apply_filters('aiosc_ticket_creation_title',__('Crear Nuevo Ticket','aiosc')) ?>
            <span><?php echo apply_filters('aiosc_ticket_creation_subtitle',__('Enviar un nuevo ticket a la cola.','aiosc')) ?></span></h2>
        <div class="aiosc-separator"></div>
        <div id="ajax-response" class="aiosc-form-response"></div>
        <div class="aiosc-form">
            <form method="post" id="aiosc-form" action="<?php echo get_admin_url()?>admin-ajax.php" enctype="multipart/form-data">
                <input type="hidden" name="action" value="aiosc_new_ticket" />
                <table class="form-table aiosc-new-ticket-table">
                    <tbody>
                    <tr>
                        <th><label for="aiosc-subject"><?php _e('Asunto','aiosc')?></label></th>
                        <td><input type="text" maxlength="255" id="aiosc-subject" name="subject" /></td>
                    </tr>
                    <tr>
                        <th><label for="aiosc-content"><?php _e('Descripción','aiosc')?></label></th>
                        <td><?php wp_editor('','aiosc-content',array(
                                "media_buttons"=>false,
                                "quicktags"=>false,
                                'textarea_rows'=>8,
                                "textarea_name"=>"content",
                                'mce' => array(
                                    'mce_buttons' => 'code,italic,underline'
                                ),
                                "tinymce"=>array(
                                    "forced_root_block"=>false,
                                    "force_br_newlines"=>true,
                                    "force_p_newlines"=>false
                                )
                            ))?></td>
                    </tr>
                    <?php
                    if($departments != false) :
                        if(count($departments) > 1) : ?>
                            <tr>
                                <th><label for="aiosc-department"><?php _e('Departamento','aiosc')?></label>
                                    <small><?php _e('¿A qué departamento pertenece tu ticket?','aiosc')?></small></th>
                                <td><select id="aiosc-department" name="department">
                                        <option value=""><?php _e('Por favor seleccione...','aiosc')?></option>
                                        <?php foreach($departments as $dep) : ?>
                                        <option value="<?php echo $dep->ID?>"><?php echo $dep->name?></option>
                                        <?php endforeach; ?>
                                    </select></td>
                            </tr>
                        <?php else : ?>
                            <input type="hidden" name="department" value="<?php echo $departments[0]->ID?>" />
                        <?php endif; ?>
                    <?php else : ?>
                    <input type="hidden" name="department" value="0" />
                    <?php endif; ?>
                    <?php
                    if($priorities != false) :
                        if(count($priorities) > 1) : ?>
                            <tr>
                                <th><label for="aiosc-priority"><?php _e('Prioridad','aiosc')?></label>
                                    <small><?php _e('¿Qué tan urgente es tu petición?','aiosc')?></small></th>
                                <td><select id="aiosc-priority" name="priority">
                                        <option value=""><?php _e('Por favor seleccione...','aiosc')?></option>
                                        <?php foreach($priorities as $pri) : ?>
                                            <option value="<?php echo $pri->ID?>"><?php echo $pri->name?></option>
                                        <?php endforeach; ?>
                                    </select></td>
                            </tr>
                        <?php else : ?>
                            <input type="hidden" name="priority" value="<?php echo $priorities[0]->ID?>" />
                        <?php endif; ?>
                    <?php else : ?>
                        <input type="hidden" name="priority" value="0" />
                    <?php endif; ?>

                    <?php
                    if($aiosc_user->can('create_tickets')) : ?>
                        <tr>
                            <th><label for="aiosc-author"><?php _e('Establecer autor','aiosc')?></label>
                                <small><?php _e('¿Quieres crear este ticket para un usuario específico?','aiosc')?></small></th>
                            <td>
                                <div style="max-width: 300px">
                                    <select id="aiosc-author" name="author" data-placeholder="<?php _e('- Elegir autor -','aiosc')?>">
                                        <option value=""><?php _e('- Elegir autor -','aiosc')?></option>
                                    </select>
                                </div>
                            </td>
                        </tr>
                    <?php endif; ?>

                    <?php echo do_action('aiosc_custom_form_fields') ?>
                    <?php if($aiosc_settings->get('enable_public_tickets') || $aiosc_user->can('answer_tickets')) : ?>
                    <tr>
                        <th>
                            <label for="aiosc-public"><?php _e('¿Ticket público?','aiosc')?></label>
                            <small><?php _e('¿Quieres que tu ticket sea visible públicamente?','aiosc')?></small></th>
                        <td>
                            <label><input type="checkbox" id="aiosc-public" name="is_public" /> <?php _e('Sí, permitir que otros vean este ticket.','aiosc')?></label>
                        </td>
                    </tr>
                    <?php endif; ?>
                    <?php if($aiosc_settings->get('allow_upload') || $aiosc_user->can('answer_tickets')) : ?>
                        <tr>
                            <th><label for="aiosc-attach"><?php _e('Adjuntar archivos','aiosc')?></label>
                                <small><?php printf(__('Puede adjuntar hasta %s archivos por ticket.','aiosc'),$aiosc_settings->get('max_files_per_ticket'))?></small></th>
                            <td>
                                <div class="aiosc-uploader">
                                    <ul class="aiosc-uploader-files">
                                        <li class="aiosc-uploader-browse">
                                            <i class="dashicons mainicon dashicons-welcome-add-page"></i>
                                       <span class="aiosc-uploader-file-name">
                                            <a href="#"><?php echo _x('+ Nuevo Archivo', 'File Upload', 'aiosc')?></a>
                                       </span>
                                        </li>
                                    </ul>
                                </div>
                                <small class="input-info">
                                    <?php printf(__('Número máximo de archivos adjuntos: <strong>%d</strong> | Tamaño máximo por archivo: <strong>%s</strong> Kb','aiosc'),
                                        $aiosc_settings->get('max_files_per_ticket'), number_format($aiosc_settings->get('max_upload_size_per_file'),0))?>
                                </small>
                            </td>
                        </tr>
                    <?php endif; ?>
                    <tr>
                        <td colspan=2><div style="margin: 0;" class="aiosc-separator"></div></td>
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
            </form>
        </div>
    </div>
</div>
<script>
    jQuery(document).ready(function($) {
        aioscupload = new aioscUploader({
            ul: 'ul.aiosc-uploader-files',
            inputName: 'attachments[]',
            maxFiles: <?php echo $aiosc_settings->get('max_files_per_ticket') ?>
        });
        var author = $('#aiosc-author');
        var select2_options = {
            language: {
                noResults: function() {
                    return "<?php _e('No se encontraron usuarios', 'aiosc')?>"
                },
                inputTooShort: function(args) {
                    var remainingChars = args.minimum - args.input.length;
                    return "<?php _e('Introduce %d caracteres más.', 'aiosc')?>".replace('%d', remainingChars);
                }
            },
            escapeMarkup: function (markup) { return markup; }, // let our custom formatter work
            minimumInputLength: 3,
            templateResult: function (repo) {
                if(repo.loading) return '<?php _e('Buscando...', 'aiosc')?>';
                return '<div class="clearfix">' + repo.name + ' (<em>'+repo.login+'</em>)</div>';
            },
            templateSelection: function (repo) {
                if(typeof repo.name == "undefined")
                    return repo.text;

                return repo.name + " (" + repo.login + ")";
            }
        };
        author.select2($.extend({
            placeholder: author.attr('data-placeholder'),
            ajax: {
                url: '<?php echo admin_url('admin-ajax.php')?>',
                dataType: 'json',
                delay: 250,
                data: function (params) {
                    return {
                        q: params.term, // search term
                        action: 'aiosc_get_user_list',
                        authors: true
                    };
                },
                processResults: function (data) {
                    return {
                        results: data
                    };
                },
                cache: true
            }
        }, select2_options));
    });
</script>
