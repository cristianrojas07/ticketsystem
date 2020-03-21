<?php
$addons = aiosc_AddonManager::get_addons_from_server();
if($addons !== false) :
?>
<h4><?php _e('Lista de complementos disponibles para la compra:','aiosc')?></h4>
<ul class="aiosc-addon-list">
    <?php foreach($addons as $addon) : ?>
    <li>
        <?php if(@$addon->thumbnail != '') : ?>
            <img class="aiosc-addon-icon" src="<?php echo $addon->thumbnail ?>" alt="" />
        <?php endif; ?>
        <div class="aiosc-addon-info">
            <?php if(@$addon->package_name != '' && file_exists(WP_PLUGIN_DIR."/".@$addon->package_name)) : ?>
                <small class="aiosc-addon-already-installed"><?php _e('Ya instalado','aiosc')?></small>
            <?php endif; ?>
            <?php if(version_compare(aiosc_get_version(), @$addon->aiosc_version, '<')) : ?>
                <small class="aiosc-addon-update-required" title="<?php _e('Para utilizar este complemento, primero debe actualizar su Ticket System.','aiosc')?>"><?php _e('Se requiere la actualización de Ticket System','aiosc'); ?></small>
            <?php endif; ?>
            <h4><?php echo @$addon->name?>
                <small><?php printf(__('Versión %s','aiosc'),@$addon->version)?>
                    |
                    <?php printf(__('Ticket System %s','aiosc'),@$addon->aiosc_version)?>
                </small>
            </h4>
            <p>
                <?php echo @$addon->description ?>
            </p>
            <p>
                <a href="<?php echo @$addon->info_url?>" target="_blank"><?php _e('Más Información','aiosc')?></a> |
                <a href="<?php echo @$addon->purchase_url?>" target="_blank"><?php
                    if(@$addon->regular_price > 0)
                        printf(__('Compra ahora para $%s','aiosc'),@$addon->regular_price);
                    else _e('Descárgalo gratis','aiosc');
                    ?></a>
            </p>
        </div>
    </li>
    <?php endforeach; ?>
</ul>
<?php else : ?>
<h4><?php _e('No hay complementos disponibles en este momento o el servidor puede estar inactivo. Por favor, vuelva más tarde.','aiosc')?></h4>
<?php endif; ?>
