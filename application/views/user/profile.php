<div class="row">
    <div class="col-md-12">
        <section class="panel">
            <div class="panel-body profile-information">
                <div class="col-md-3">
                    <div class="profile-pic text-center">
                        <img src="<?php echo PROTOCOL . $_SERVER['HTTP_HOST'] . DS . 'public/media/profile/' . $info['image'] ?>">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="profile-desk">
                        <h1><?php echo $info['name']; ?></h1>
                        <span class="text-muted"><?php echo $info['email']; ?></span>
                        <p><?php echo $info['description']; ?></p>
                    </div>
                </div>
                <div class="col-md-3 profile-more text-center">
                    <a href="<?php echo $info['facebook'] ?>" class="fa fa-facebook"></a>
                </div>
            </div>
        </section>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <section class="panel">
            <div class="panel-body images">
                <?php if($owned_images == NULL): ?>
                    <h1 class="text-center">Nincs még általa feltöltött kép!</h1>
                <?php endif; ?>
                <?php if($owned_images != NULL): ?>
                    <?php for($i = 0; $i <= floor(count($owned_images)/4); $i++): ?>
                        <div class="row">
                            <?php for($j = 0; $j < 4 && isset($owned_images[($i*4)+$j]); $j++): ?>
                                <div class="col-md-3">
                                    <a href="<?php echo PROTOCOL . $_SERVER['HTTP_HOST'] . DS . 'gallery/view/' . $owned_images[($i*4)+$j]['gallery_id'] . DS . $owned_images[($i*4)+$j]['id']?>">
                                        <img src="<?php echo PROTOCOL . $_SERVER['HTTP_HOST'] . DS . 'public/media/galleries/' . $owned_images[($i*4)+$j]['gallery_id'] . DS . $owned_images[($i*4)+$j]['file'] ?>">
                                    </a>
                                </div>
                            <?php endfor; ?>
                        </div>
                    <?php endfor; ?>
                <?php endif; ?>
            </div>
            <div class="panel-footer">
                <a class="text-right" href="<?php echo PROTOCOL . $_SERVER['HTTP_HOST'] . DS . 'gallery' ?>">
                    Összes kép
                    <i class="fa fa-chevron-right"></i>
                </a>
            </div>
        </section>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <section class="panel">
            <div class="panel-body events">
                <?php if($owned_events == NULL): ?>
                    <h1 class="text-center">Nem volt és jelenleg sincs olyan esemény, ahol házigazda!</h1>
                <?php endif; ?>
                <?php if($owned_events != NULL): ?>
                    <?php foreach($owned_events as $event): ?>
                        <div class="row">
                            <div class="col-md-4">
                                <?php echo $event['name']; ?>
                            </div>
                            <div class="col-md-4">
                                <?php echo $event['where_desc']; ?>
                            </div>
                            <div class="col-md-4 text-right">
                                <?php echo $event['year'] . '. ' . sprintf('%02d',$event['month']) . '. ' . sprintf('%02d',$event['day']) . '. ' . sprintf('%02d',$event['hour']) . ':' . sprintf('%02d',$event['minute']); ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
            <div class="panel-footer">
                <a class="text-right" href="<?php echo PROTOCOL . $_SERVER['HTTP_HOST'] . DS . 'events' ?>">
                    Összes esemény
                    <i class="fa fa-chevron-right"></i>
                </a>
            </div>
        </section>
    </div>
</div>


