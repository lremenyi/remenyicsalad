<div class="row">
    <div class="col-md-12">
        <section class="panel">
            <header class="panel-heading"><?php echo $gallery_details['name'] ?></header>
            <div class="panel-body">
                <p><?php echo $gallery_details['description'] ?></p>
            </div>
            <?php if($images == NULL): ?>
                <?php if($gallery_details['uploader'] == $_SESSION['id']): ?>
                <div class="panel-footer text-right edit-gallery">
                    <?php if($gallery_details['uploader'] == $_SESSION['id']): ?>
                    <form action="" method="POST">
                        <input type="hidden" name="delete-gallery-id" id="delete-gallery-id" value="<?php echo $gallery_details['id'] ?>">
                        <input type="submit" name="delete-gallery" id="delete-gallery" class="btn btn-danger" value="Galéria törlése">
                    </form>
                        <a id="open-modal" href="#details-modal" data-toggle="modal" class="btn btn-primary">Adatok szerkesztése</a>
                        <div class="text-left modal fade" id="details-modal" tabindex="-1" role="dialog">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                        <h4 class="modal-title">Galéria adatok módosítása</h4>
                                    </div>
                                    <form action="" method="POST">
                                        <div class="modal-body">
                                            <input type="hidden" value="<?php echo $gallery_details['id']; ?>" name="edit-gallery-id" id="edit-gallery-id">
                                            <div class="form-group">
                                                <div class="form-control-wrapper">
                                                    <input type="text" name="edit-gallery-name" id="edit-gallery-name" value="<?php echo $gallery_details['name'] ?>" class="form-control" autocomplete="off" maxlength="25">
                                                    <div class="floating-label">Galéria neve</div>
                                                    <span class="material-input-bar"></span>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="form-control-wrapper">
                                                    <input type="text" value="<?php echo $gallery_details['description'] ?>" name="edit-gallery-desc" id="edit-gallery-desc" class="form-control" autocomplete="off">
                                                    <div class="floating-label">Galéria leírása</div>
                                                    <span class="material-input-bar"></span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <input id="save-details" name="save-details" class="btn btn-primary" type="submit" value="Mentés">
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
                <?php endif; ?>
            <?php endif; ?>
            <?php if($images != NULL): ?>
                <?php if(count(array_filter($images, function($el) {return ($el['uploader_id'] == $_SESSION['id']);})) || $gallery_details['uploader'] == $_SESSION['id']): ?>
                <div class="panel-footer text-right edit-gallery">
                    <?php if(count(array_filter($images, function($el) {return ($el['uploader_id'] == $_SESSION['id']);}))): ?>
                        <button class="btn btn-warning delete-image">Kép törlése</button>
                    <?php endif; ?>
                    <?php if($gallery_details['uploader'] == $_SESSION['id']): ?>
                    <form action="" method="POST">
                        <input type="hidden" name="delete-gallery-id" id="delete-gallery-id" value="<?php echo $gallery_details['id'] ?>">
                        <input type="submit" name="delete-gallery" id="delete-gallery" class="btn btn-danger" value="Galéria törlése">
                    </form>
                        <a id="open-modal" href="#details-modal" data-toggle="modal" class="btn btn-primary">Adatok szerkesztése</a>
                        <div class="text-left modal fade" id="details-modal" tabindex="-1" role="dialog">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                        <h4 class="modal-title">Galéria adatok módosítása</h4>
                                    </div>
                                    <form action="" method="POST">
                                        <div class="modal-body">
                                            <input type="hidden" value="<?php echo $gallery_details['id']; ?>" name="edit-gallery-id" id="edit-gallery-id">
                                            <div class="form-group">
                                                <div class="form-control-wrapper">
                                                    <input type="text" name="edit-gallery-name" id="edit-gallery-name" value="<?php echo $gallery_details['name'] ?>" class="form-control" autocomplete="off" maxlength="25">
                                                    <div class="floating-label">Galéria neve</div>
                                                    <span class="material-input-bar"></span>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="form-control-wrapper">
                                                    <input type="text" value="<?php echo $gallery_details['description'] ?>" name="edit-gallery-desc" id="edit-gallery-desc" class="form-control" autocomplete="off">
                                                    <div class="floating-label">Galéria leírása</div>
                                                    <span class="material-input-bar"></span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <input id="save-details" name="save-details" class="btn btn-primary" type="submit" value="Mentés">
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
                <?php endif; ?>
            <?php endif; ?>
        </section>
    </div>
</div>
<?php if($images != NULL): ?>
    <div id="blueimp-gallery" class="blueimp-gallery blueimp-gallery-controls" data-use-bootstrap-modal="false">
        <div class="slides"></div>
        <h3 class="title"></h3>
        <a class="prev">‹</a>
        <a class="next">›</a>
        <a class="close">×</a>
        <a class="play-pause"></a>
        <ol class="indicator"></ol>
        <div class="modal fade">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" aria-hidden="true">&times;</button>
                        <h4 class="modal-title"></h4>
                    </div>
                    <div class="modal-body next"></div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default pull-left prev">
                            <i class="glyphicon glyphicon-chevron-left"></i>
                            Previous
                        </button>
                        <button type="button" class="btn btn-primary next">
                            Next
                            <i class="glyphicon glyphicon-chevron-right"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="links">
        <form action="" method="POST">
        <?php for ($j=0;$j<=floor(count($images)/4);$j++): ?>
            <div class="row">
            <?php for($i=0;$i<4 && isset($images[($j*4)+$i]);$i++): ?>
                <div class="col-md-3">
                <a class="image-container" href="<?php echo PROTOCOL . $_SERVER['HTTP_HOST'] ?>/public/media/galleries/<?php echo $images[($j*4)+$i]['gallery_id'] . DS . $images[($j*4)+$i]['file'];  ?>" title="<?php echo $images[($j*4)+$i]['name']  ?>" id="<?php echo $images[($j*4)+$i]['id']  ?>" data-gallery>
                    <img class="image" src="<?php echo PROTOCOL . $_SERVER['HTTP_HOST'] ?>/public/media/galleries/<?php echo $images[($j*4)+$i]['gallery_id'] . DS . $images[($j*4)+$i]['file'];  ?>">
                </a>
                <?php if($images[($j*4)+$i]['uploader_id'] == $_SESSION['id']): ?>
                    <input type="checkbox" class="delete-checkbox" name="deletethis[]" id="deletethis[]" value="<?php echo $images[($j*4)+$i]['id'] ?>">
                <?php endif; ?>
                </div>
            <?php endfor; ?>
            </div>
        <?php endfor; ?>
        <?php if(count(array_filter($images, function($el) {return ($el['uploader_id'] == $_SESSION['id']);}))): ?>
            <button type="submit" name="delete-these" id="delete-these" class="btn btn-fab btn-fab-danger"><i class="fa fa-trash"></i></button>
        <?php endif; ?>
        </form>
    </div>
    <?php if(isset($active_image)): ?>
        <div id="active-image"><?php echo $active_image ?></div>
    <?php endif; ?>
<?php endif;?>
<?php if($images == NULL): ?>
    <h2 class="text-center">Nincsen még kép a galériában</h2>
<?php endif;?>

<form action="<?php echo PROTOCOL . $_SERVER['HTTP_HOST'] . '/gallery/upload' ?>" method="POST">
    <input type="hidden" name="gallery-id" id="gallery-id" value="<?php echo $gallery_details['id'] ?>">
    <input type="hidden" name="new-gallery-name" id="new-gallery-name" value="<?php echo $gallery_details['name'] ?>">
    <input type="hidden" name="new-gallery-desc" id="new-gallery-desc" value="<?php echo $gallery_details['description'] ?>">
    <button type="submit" class="btn btn-fab btn-fab-info" id="add-image">
        <i class="fa fa-plus"></i>
    </button>
</form>

