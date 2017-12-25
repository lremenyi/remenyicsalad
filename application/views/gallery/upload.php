<?php if(isset($name_error) && $name_error != ''): ?>
    <div class="alert alert-danger fade in text-center">
        <button data-dismiss="alert" class="close" type="button">
            <i class="fa fa-times"></i>
        </button>
        <p><?php echo $name_error ?></p>
        <p>A galéria feltöltése nem sikerült! <a href="<?php echo PROTOCOL . $_SERVER['HTTP_HOST'] . '/gallery'; ?>">Próbáld meg újra</a>!</p>
    </div>
<?php endif; ?>


<?php if(!isset($name_error) || $name_error == ''): ?>
    <div class="row">
        <div class="col-md-12">
            <section class="panel">
                <header class="panel-heading">Galéria adatok</header>
                <div class="panel-body def-details">
                    <?php if(isset($gallery_id) && $gallery_id != ''): ?>
                    <div class="row">
                        <div class="col-md-6">
                            <span>Galéria azonosítója</span>
                        </div>
                        <div class="col-md-6">
                            <span id="gallery-id-container"><?php echo $gallery_id; ?></span>
                        </div>
                    </div>
                    <?php endif; ?>
                    <div class="row">
                        <div class="col-md-6">
                            <span>Galéria neve</span>
                        </div>
                        <div class="col-md-6">
                            <span id="gallery-name-container"><?php echo $gallery_name; ?></span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <span>Galéria leírása</span>
                        </div>
                        <div class="col-md-6">
                            <span  id="gallery-desc-container"><?php echo $gallery_desc; ?></span>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <section class="panel">
                <header class="panel-heading clearfix">
                    <span class="title-with-plus">Képek</span>
                </header>
                <div class="panel-body">
                    <div id="dropbox">
                        <div class="row message">
                            <span class="message">Húzd ide a fájlokat a feltöltéshez!</span>
                        </div>
                    </div>
                    <div class="uploads-here">
                        <div class="row"></div>
                    </div>
                </div>
            </section>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 text-right buttons">
            <a id="drop-changes" href="<?php if(isset($gallery_id)) echo PROTOCOL . $_SERVER['HTTP_HOST']. '/gallery/view/' . $gallery_id; else echo PROTOCOL . $_SERVER['HTTP_HOST']. '/gallery'; ?>" class="btn btn-danger">Eldobás</a>
            <a id="save-changes" href="<?php if(isset($gallery_id)) echo PROTOCOL . $_SERVER['HTTP_HOST']. '/gallery/view/' . $gallery_id; else echo PROTOCOL . $_SERVER['HTTP_HOST']. '/gallery'; ?>" class="btn btn-success">Mentés</a>
        </div>
    </div>
<?php endif;



