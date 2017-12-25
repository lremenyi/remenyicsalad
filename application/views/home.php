<div class="row">
    <div class="col-lg-3 col-md-6 col-sm-6">
        <a href="<?php echo PROTOCOL . $_SERVER['HTTP_HOST'] ?>/gifting" class="mini-stat clearfix">
            <span class="mini-stat-icon orange">
                <i class="fa fa-gift"></i>
            </span>
            <div class="mini-stat-info">
                <span><?php echo $ask_numb ?></span>
                új megkérdezett időpont
            </div>
        </a>
    </div>
    <div class="col-lg-3 col-md-6 col-sm-6">
        <a href="<?php echo PROTOCOL . $_SERVER['HTTP_HOST'] ?>/gallery" class="mini-stat clearfix">
            <span class="mini-stat-icon tar">
                <i class="fa fa-image"></i>
            </span>
            <div class="mini-stat-info">
                <span><?php echo $galleries_numb ?></span>
                galéria
            </div>
        </a>
    </div>
    <div class="col-lg-3 col-md-6 col-sm-6">
        <a href="<?php echo PROTOCOL . $_SERVER['HTTP_HOST'] ?>/gallery" class="mini-stat clearfix">
            <span class="mini-stat-icon purple">
                <i class="fa fa-file-image-o"></i>
            </span>
            <div class="mini-stat-info">
                <span><?php echo $images_numb ?></span>
                kép
            </div>
        </a>
    </div>
    <div class="col-lg-3 col-md-6 col-sm-6">
        <a href="<?php echo PROTOCOL . $_SERVER['HTTP_HOST'] ?>/events" class="mini-stat clearfix">
            <span class="mini-stat-icon green">
                <i class="fa fa-calendar"></i>
            </span>
            <div class="mini-stat-info">
                <span><?php echo $events_numb ?></span>
                közelgő esemény
            </div>
        </a>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <section class="panel">
            <header class="panel-heading">Következő események</header>
            <div class="panel-body event-list">
                <?php if($next_events == NULL): ?>
                    <div class="row">
                        <div class="col-md-12 text-center">
                            <h1>Nincsen semmilyen esemény</h1>
                        </div>
                    </div>
                <?php endif; ?>
                <?php if($next_events != NULL): ?>
                    <?php for($i=0; $i<=(floor(count($next_events)/4)); $i++): ?>
                        <div class="row">
                            <?php for($j=0; $j<4 && isset($next_events[($i*4)+$j]);$j++): ?>
                                <div class="col-md-3">
                                    <a href="<?php echo PROTOCOL . $_SERVER['HTTP_HOST'] . "/events/index/" . $next_events[($i*4)+$j]['id']; ?>">
                                        <i class="fa fa-calendar" style="background-color: <?php echo $next_events[($i*4)+$j]['event_color']; ?>;"></i>
                                        <span class="event-title"><?php echo $next_events[($i*4)+$j]['event_name']; ?></span>
                                        <span class="host-name"><?php echo $next_events[($i*4)+$j]['host_name']; ?></span>
                                        <span class="when-date"><?php echo $next_events[($i*4)+$j]['year'] . '. ' . sprintf('%02d',$next_events[($i*4)+$j]['month']) . '. ' . sprintf('%02d',$next_events[($i*4)+$j]['day']) . '. ' . sprintf('%02d',$next_events[($i*4)+$j]['hour']) . ':' . sprintf('%02d',$next_events[($i*4)+$j]['minute']); ?></span>
                                    </a>
                                </div>
                            <?php endfor; ?>
                        </div>
                    <?php endfor; ?>
                <?php endif; ?>
            </div>
        </section>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <section class="panel">
            <header class="panel-heading">Legfrisseb galériák</header>
            <div class="panel-body gallery-list">
                <?php if($galleries == NULL): ?>
                    <div class="row">
                        <div class="col-md-12 text-center">
                            <h1>Nincsen még egyetlen galéria sem</h1>
                        </div>
                    </div>
                <?php endif; ?>
                <?php if($galleries != NULL): ?>
                    <?php for($i=0; $i<=(floor(count($galleries)/4)); $i++): ?>
                        <div class="row">
                            <?php for($j=0; $j<4 && isset($galleries[($i*4)+$j]);$j++): ?>
                                <a href="<?php echo PROTOCOL . $_SERVER['HTTP_HOST'] . DS . "gallery/view" . DS . $galleries[($i*4)+$j]['id'] ?>" class="col-md-3">
                                    <img src="<?php echo PROTOCOL . $_SERVER['HTTP_HOST'] . DS . "public/media/galleries" . DS . $galleries[($i*4)+$j]['id'] . DS . $galleries[($i*4)+$j]['image']['file'] ?>">
                                    <div class="gallery-title"><?php echo $galleries[($i*4)+$j]['name']; ?></div>
                                </a>
                            <?php endfor; ?>
                        </div>
                    <?php endfor; ?>
                <?php endif; ?>
            </div>
        </section>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <section class="panel">
            <header class="panel-heading">Legfrisseb képek</header>
            <div class="panel-body image-list">
                <?php if($images == NULL): ?>
                    <div class="row">
                        <div class="col-md-12 text-center">
                            <h1>Nincsen még egyetlen kép sem</h1>
                        </div>
                    </div>
                <?php endif; ?>
                <?php if($images != NULL): ?>
                    <?php for($i=0; $i<=(floor(count($images)/4)); $i++): ?>
                        <div class="row">
                            <?php for($j=0; $j<4 && isset($images[($i*4)+$j]);$j++): ?>
                                <a href="<?php echo PROTOCOL . $_SERVER['HTTP_HOST'] . DS . "gallery/view" . DS . $images[($i*4)+$j]['gallery_id'] . DS . $images[($i*4)+$j]['id']?>" class="col-md-3">
                                    <img src="<?php echo PROTOCOL . $_SERVER['HTTP_HOST'] . DS . 'public/media/galleries' . DS . $images[($i*4)+$j]['gallery_id'] . DS . $images[($i*4)+$j]['file']; ?>">
                                </a>
                            <?php endfor; ?>
                        </div>
                    <?php endfor; ?>
                <?php endif; ?>
            </div>
        </section>
    </div>
</div>

