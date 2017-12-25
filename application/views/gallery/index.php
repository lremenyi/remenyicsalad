<?php if($galleries == NULL): ?>
<div class="row">
    <div class="col-md-12 text-center">
        <h2>Nincsen még galéria</h2>
    </div>
</div>
<?php endif; ?>
<?php if($galleries != NULL): ?>
    <?php for ($j=0;$j<=floor(count($galleries)/4);$j++): ?>
        <div class="row">
        <?php for($i=0;$i<4 && isset($galleries[($j*4)+$i]);$i++): ?>
            <a class="col-md-3 gallery-container" href="<?php echo PROTOCOL . $_SERVER['HTTP_HOST'] ?>/gallery/view/<?php echo $galleries[($j*4)+$i]['id'] ?>">
                <?php if(isset($galleries[($j*4)+$i]['image']) && $galleries[($j*4)+$i]['image'] != NULL): ?>
                    <img class="gallery-cover" src="<?php echo PROTOCOL . $_SERVER['HTTP_HOST'] ?>/public/media/galleries/<?php echo $galleries[($j*4)+$i]['id'] . DS . $galleries[($j*4)+$i]['image'];  ?>">
                <?php endif; ?>
                <?php if(!isset($galleries[($j*4)+$i]['image']) || $galleries[($j*4)+$i]['image'] == NULL): ?>
                    <img class="gallery-cover" src="<?php echo PROTOCOL . $_SERVER['HTTP_HOST'] ?>/public/media/galleries/default/default_cover.jpg">
                <?php endif; ?>
                <div class='gallery-title'><?php echo $galleries[($j*4)+$i]['name'] ?></div>
            </a>
        <?php endfor; ?>
        </div>
    <?php endfor; ?>
<?php endif;?>

<button class="btn btn-fab btn-fab-info" id="add-gallery">
    <i class="fa fa-plus"></i>
</button>

<div class="modal fade" id="new-gallery" tabindex="-1" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title">Új galéria hozzáadása</h4>
            </div>
            <form action="<?php echo PROTOCOL . $_SERVER['HTTP_HOST'] . '/gallery/upload' ?>" method="POST">
                <div class="modal-body">
                    <div class="form-group">
                        <div class="form-control-wrapper">
                            <input type="text" name="new-gallery-name" id="new-gallery-name" class="form-control" autocomplete="off">
                            <div class="floating-label">Galéria neve</div>
                            <span class="material-input-bar"></span>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="form-control-wrapper">
                            <input type="text" name="new-gallery-desc" id="new-gallery-desc" class="form-control" autocomplete="off">
                            <div class="floating-label">Galéria leírása</div>
                            <span class="material-input-bar"></span>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <input id="add-new-gallery" name="add-new-gallery" class="btn btn-primary" type="submit" value="Létrehozás">
                </div>
            </form>
        </div>
    </div>
</div>
