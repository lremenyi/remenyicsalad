
<div class="row">
    <div class="col-md-6">
        <section class="panel">
            <header class="panel-heading">
                Születésnap
                <span class="tools pull-right">
                    <a href="#" id="show-birthday" class="collapse-panel-button fa fa-chevron-down <?php if(!$show_birthday) echo 'rotate-collapse-button'; ?>"></a>
                </span>
            </header>
            <div class="panel-body collapse-panel" <?php if(!$show_birthday) echo 'style="display: none;"'; ?>>
                <?php if(!$no_group): ?>
                <div class="row birthday">
                    <?php foreach($birthdays as $birthday): ?>
                    <div class="col-md-<?php echo round(12/count($birthdays)) ?> text-center">
                        <div class="choosen-profile">
                            <a href="<?php echo PROTOCOL . $_SERVER['HTTP_HOST']; ?>/user/profile/<?php echo $birthday['username'] ?>">
                                <img src="<?php echo PROTOCOL . $_SERVER['HTTP_HOST']; ?>/public/media/profile/<?php echo $birthday['image'] ?>">
                            </a>
                            <div class="choosen-details">
                                <a href="<?php echo PROTOCOL . $_SERVER['HTTP_HOST']; ?>/user/profile/<?php echo $birthday['username'] ?>">
                                    <?php echo $birthday['name'] ?>
                                </a>
                                <span>
                                    <i>
                                        <?php echo Config::monthName($birthday['month']) . ' ' . $birthday['day'] . '.'; ?>
                                    </i>
                                </span>
                                <span>
                                    <i>
                                        <?php 
                                            // if nagymama
                                            if($birthday['id'] == 2) {
                                                echo '(' . (40-(date('Y')-$birthday['year']-40)) . ' éves)';
                                            }
                                            else {
                                                echo '(' . (date('Y')-$birthday['year']) . ' éves)';
                                            }
                                        ?>
                                    </i>
                                </span>
                            </div>
                            <a href="#available-modal" data-toggle="modal" class="btn btn-warning available" id="<?php echo $birthday['id']; ?>">Időpont</a>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
                <?php endif; ?>
                
                <?php if($no_group): ?>
                <div class="text-center">
                    <h3>Te nem húztál!</h3>
                </div>
                <?php endif; ?>
            </div>
        </section>
    </div>
    <div class="col-md-6">
        <section class="panel">
            <header class="panel-heading">
                Karácsony
                <span class="tools pull-right">
                    <a href="#" id="show-christmas" class="collapse-panel-button fa fa-chevron-down <?php if(!$show_christmas) echo 'rotate-collapse-button'; ?>"></a>
                </span>
            </header>
            <div class="panel-body collapse-panel" <?php if(!$show_christmas) echo 'style="display: none;"'; ?>>
                <?php if(!$no_group): ?>
                <h3 class="text-center"><?php echo $christmas_to_group['name'] ?></h3>
                <div class="row christmas text-center">
                    <?php foreach($christmas as $person): ?>
                    <div class="col-md-<?php echo round(12/count($christmas)) ?> text-center">
                        <div class="choosen-profile">
                            <a href="<?php echo PROTOCOL . $_SERVER['HTTP_HOST']; ?>/user/profile/<?php echo $person['username'] ?>">
                                <img src="<?php echo PROTOCOL . $_SERVER['HTTP_HOST']; ?>/public/media/profile/<?php echo $person['image'] ?>">
                            </a>
                            <div class="choosen-details">
                                <a href="<?php echo PROTOCOL . $_SERVER['HTTP_HOST']; ?>/user/profile/<?php echo $person['username'] ?>">
                                    <?php echo $person['name'] ?>
                                </a>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                    <a href="#christmas-available-modal" data-toggle="modal" class="btn btn-warning available-group" id="<?php echo $christmas_to_group['id']; ?>">Időpont</a>
                </div>
                <?php endif; ?>
                
                <?php if($no_group): ?>
                <div class="text-center">
                    <h3>Te nem húztál!</h3>
                </div>
                <?php endif; ?>
            </div>
        </section>
    </div>
</div>

<?php if(!$no_group): ?>
<div class="row">
    <div class="col-md-12">
        <section class="panel">
            <header class="panel-heading">Megkérdezett időpontok</header>
            <div class="panel-body text-center">
                <?php if($asked== NULL): ?> 
                    <h3>Még nincs  megkérdezett időpont</h3>
                <?php endif; ?>
                <?php if($asked != NULL): ?>
                    <?php foreach($asked as $ask): ?>
                    <div class="row">
                        <div class="col-md-6">
                            <?php echo $ask['start_year'] . '. ' . sprintf('%02d',$ask['start_month']) . '. ' . sprintf('%02d',$ask['start_day']) .
                                    '. ' . sprintf('%02d',$ask['start_hour']) . ':' . sprintf('%02d',$ask['start_min']) . ' - ' . sprintf('%02d',$ask['end_hour']). ':' . sprintf('%02d',$ask['end_min']);  ?>
                        </div>
                        <div class="col-md-6">
                            <?php
                                $answer;
                                if(!$ask['answered']) {
                                    $answer = 'question';
                                }
                                else {
                                    if($ask['answer'])
                                        $answer = 'check';
                                    else
                                        $answer = 'close';
                                }
                            ?>
                            <?php echo '<a id="'. $ask['table'] . '-' . $ask['id'] . '" class="change-answer" href="#"><i class="fa fa-' . $answer . '"></i></a>' ?>
                        </div>
                    </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </section>
    </div>
</div>
<?php endif; ?>

<?php if(DEVELOPMENT_ENVIRONMENT): ?>
<div class="row">
    <div class="col-md-12 text-center">
        <form action="" method="post">
            <button type="submit" name="generate" id="generate" class="btn btn-primary">Teszt generálás</button>
        </form>
    </div>
</div>
<?php endif;?>

<?php if(!$no_group): ?>
<div class="modal fade" id="available-modal" tabindex="-1" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h4 class="modal-title">Szabad időpontok</h4>
            </div>
            <div class="modal-body">
                <div class="new-date-content text-center row">
                    <h2>Új kérdés</h2>
                    <form method="post" action="" class="send-date-form">
                        <div class="col-md-3">
                            <div class="form-group">
                                <div class="form-control-wrapper">
                                    <input type="text" name="add-date" id="add-date" class="form-control form-icon" autocomplete="off">
                                    <div class="floating-label">Dátum</div>
                                    <i class="fa fa-calendar"></i>
                                    <span class="material-input-bar"></span>
                                    <span class="highlight"></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group clockpicker">
                                <div class="form-control-wrapper">
                                    <input type="text" name="add-date-time-from" id="add-date-time-from" class="form-control form-icon" autocomplete="off">
                                    <div class="floating-label">Kezdet</div>
                                    <i class="fa fa-clock-o"></i>
                                    <span class="material-input-bar"></span>
                                    <span class="highlight"></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group clockpicker">
                                <div class="form-control-wrapper">
                                    <input type="text" name="add-date-time-to" id="add-date-time-to" class="form-control form-icon" autocomplete="off">
                                    <div class="floating-label">Vége</div>
                                    <i class="fa fa-clock-o"></i>
                                    <span class="material-input-bar"></span>
                                    <span class="highlight"></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <input type="submit" name="send-date" id="send-date" class="btn btn-flat btn-primary" value="Küldés">
                        </div>
                    </form>
                </div>
                <div class="show-dates text-center">
                    <h2>Válaszok</h2>
                </div>
            </div>
            <div class="modal-footer">
                <button data-dismiss="modal" class="btn btn-flat btn-success" type="button">
                    <i class="fa fa-check"></i>
                    OK
                </button>
            </div>
        </div>
    </div>
</div>
<?php endif;?>

<?php if(!$no_group): ?>
<div class="modal fade" id="christmas-available-modal" tabindex="-1" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h4 class="modal-title">Szabad időpontok</h4>
            </div>
            <div class="modal-body">
                <div class="new-christmas-date-content text-center row">
                    <h2>Új kérdés</h2>
                    <form method="post" action="" class="send-christmas-date-form" id="<?php echo $christmas_to_group['id'] ?>">
                        <div class="col-md-3">
                            <div class="form-group">
                                <div class="form-control-wrapper">
                                    <input type="text" name="add-christmas-date" id="add-christmas-date" class="form-control form-icon" autocomplete="off">
                                    <div class="floating-label">Dátum</div>
                                    <i class="fa fa-calendar"></i>
                                    <span class="material-input-bar"></span>
                                    <span class="highlight"></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group clockpicker">
                                <div class="form-control-wrapper">
                                    <input type="text" name="add-christmas-date-time-from" id="add-christmas-date-time-from" class="form-control form-icon" autocomplete="off">
                                    <div class="floating-label">Kezdet</div>
                                    <i class="fa fa-clock-o"></i>
                                    <span class="material-input-bar"></span>
                                    <span class="highlight"></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group clockpicker">
                                <div class="form-control-wrapper">
                                    <input type="text" name="add-christmas-date-time-to" id="add-christmas-date-time-to" class="form-control form-icon" autocomplete="off">
                                    <div class="floating-label">Vége</div>
                                    <i class="fa fa-clock-o"></i>
                                    <span class="material-input-bar"></span>
                                    <span class="highlight"></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <input type="submit" name="send-christmas-date" id="send-christmas-date" class="btn btn-flat btn-primary" value="Küldés">
                        </div>
                    </form>
                </div>
                <div class="show-dates text-center">
                    <h2>Válaszok</h2>
                </div>
            </div>
            <div class="modal-footer">
                <button data-dismiss="modal" class="btn btn-flat btn-success" type="button">
                    <i class="fa fa-check"></i>
                    OK
                </button>
            </div>
        </div>
    </div>
</div>
<?php endif;

