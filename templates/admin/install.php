<?php
wp_enqueue_media();
?>
<?php aisoc_print_js_debug() ?>
<div class="wrap">
    <div class="aiosc-window">
        <h2 class="page-title"><?php _e('Finalizar la Activación','aiosc') ?>
            <span><?php printf(__('Tiene más de %d usuarios ya registrados o tiene instalada la versión < 2.1.2.','aiosc'), AIOSC_ACTIVATION_MAX_USERS)?></span></h2>
        <div class="aiosc-toolbar">
            <ul class="aiosc-tabs">
                <li><?php _e('Activador','aiosc')?></li>
            </ul>
        </div>
        <div class="aiosc-clear"></div>
        <div id="ajax-response"></div>
        <div class="aiosc-form">
            <div class="aiosc-tab-content-holder">
                <div class="aiosc-tab-content">
                    <p>
                        <?php printf(__('Tiene más de %d usuarios ya registrados o tiene instalada la versión < 2.1.2.','aiosc'), AIOSC_ACTIVATION_MAX_USERS)?>
                        <br />
                        <br />
                        <?php _e("Una vez que se inicia la activación, <strong>no actualices la página</strong> hasta que se complete. No debería tomar mucho tiempo, así que por favor sea paciente.",'aiosc')?>
                    </p>
                    <br />
                    <div id="aiosc-installer-window">
                        <div><span id="aiosc-progress"><?php _e('Presione "Ejecutar Activador" para iniciar el progreso de activación.','aiosc')?></span>
                            <span id="aiosc-elapsed"></span>
                            <span id="aiosc-eta"></span>
                        </div>
                        <div class="diwave-pbar"></div>
                    </div>
                    <div class="aiosc-installer-controls">
                        <button type="button" id="aiosc-installer-start" class="button button-primary"><?php _e('Ejecutar Activador','aiosc')?></button>
                        <button type="button" id="aiosc-installer-pause" disabled class="button"><?php _e('Pausar','aiosc')?></button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>

</script>
