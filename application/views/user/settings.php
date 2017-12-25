<div class="row">
    <div class="col-md-12">
        <section class="panel">
            <header class="panel-heading">Felhasználói adatok</header>
            <div class="panel-body">
                <?php if(isset($error_details) && $error_details != ''): ?>
                <div class="alert alert-danger fade in text-center">
                    <button data-dismiss="alert" class="close" type="button">
                        <i class="fa fa-times"></i>
                    </button>
                    <?php echo $error_details; ?>
                </div>
                <?php endif; ?>
                <?php if(isset($success_details) && $success_details != ''): ?>
                <div class="alert alert-success fade in text-center">
                    <button data-dismiss="alert" class="close" type="button">
                        <i class="fa fa-times"></i>
                    </button>
                    <?php echo $success_details; ?>
                </div>
                <?php endif; ?>
                <div class="row">
                    <div class="col-md-3">
                        <span>Felhasználónév</span>
                    </div>
                    <div class="col-md-9">
                        <div class="form-group">
                            <div class="form-control-wrapper">
                                <input type="text" disabled="true" name="username" id="username" class="form-control" value="@<?php echo $details['username'] ?>">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3">
                        <span>Utolsó bejelentkezés</span>
                    </div>
                    <div class="col-md-9">
                        <div class="form-group">
                            <div class="form-control-wrapper">
                                <input type="text" disabled="true" name="last_login" id="last_login" class="form-control" value="<?php echo $details['year'] . '. ' . sprintf('%02d',$details['month']) . '. ' . sprintf('%02d',$details['day']) . '. ' . sprintf('%02d',$details['hour']) . ':' . sprintf('%02d',$details['minute']) ?>">
                            </div>
                        </div>
                    </div>
                </div>
                <form action="" method="post">
                    <div class="row">
                        <div class="col-md-3">
                            <span>Teljes név</span>
                        </div>
                        <div class="col-md-9">
                            <div class="form-group">
                                <div class="form-control-wrapper">
                                    <input type="text" maxlength="50" name="name" id="name" class="form-control" value="<?php echo $details['name'] ?>" autocomplete="off">
                                    <span class="material-input-bar"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3">
                            <span>E-mail cím</span>
                        </div>
                        <div class="col-md-9">
                            <div class="form-group">
                                <div class="form-control-wrapper">
                                    <input type="email" maxlength="50" name="email" id="email" class="form-control" value="<?php echo $details['email'] ?>" autocomplete="off">
                                    <span class="material-input-bar"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3">
                            <span>Rövid leírás</span>
                        </div>
                        <div class="col-md-9">
                            <div class="form-group">
                                <div class="form-control-wrapper">
                                    <input type="text" maxlength="255" name="description" id="description" class="form-control" value="<?php echo $details['description'] ?>" autocomplete="off">
                                    <span class="material-input-bar"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3">
                            <span>Facebook link</span>
                        </div>
                        <div class="col-md-9">
                            <div class="form-group">
                                <div class="form-control-wrapper">
                                    <input type="url" maxlength="200" name="facebook" id="facebook" class="form-control" value="<?php echo $details['facebook'] ?>" autocomplete="off">
                                    <span class="material-input-bar"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <input type="submit" class="btn btn-primary pull-right" name="save_details" id="save_details" value="Mentés">
                </form>
            </div>
        </section>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <section class="panel">
            <header class="panel-heading">Jelszó</header>
            <div class="panel-body">
                <?php if(isset($error_password) && $error_password != ''): ?>
                <div class="alert alert-danger fade in text-center">
                    <button data-dismiss="alert" class="close" type="button">
                        <i class="fa fa-times"></i>
                    </button>
                    <?php echo $error_password; ?>
                </div>
                <?php endif; ?>
                <?php if(isset($success_password) && $success_password != ''): ?>
                <div class="alert alert-success fade in text-center">
                    <button data-dismiss="alert" class="close" type="button">
                        <i class="fa fa-times"></i>
                    </button>
                    <?php echo $success_password; ?>
                </div>
                <?php endif; ?>
                <form action="" method="post" id="pass-change-form">
                    <div class="row">
                        <div class="col-md-3">
                            <span>Régi jelszó</span>
                        </div>
                        <div class="col-md-9">
                            <div class="form-group">
                                <div class="form-control-wrapper">
                                    <input type="password" name="old_pass" id="old_pass" class="form-control">
                                    <input type="hidden" name="old_pass_hash" id="old_pass_hash" class="form-control">
                                    <span class="material-input-bar"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3">
                            <span>Új jelszó</span>
                        </div>
                        <div class="col-md-9">
                            <div class="form-group">
                                <div class="form-control-wrapper">
                                    <input type="password" name="new_pass" id="new_pass" class="form-control">
                                    <input type="hidden" name="new_pass_hash" id="new_pass_hash" class="form-control">
                                    <span class="material-input-bar"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3">
                            <span>Új jelszó mégegyszer</span>
                        </div>
                        <div class="col-md-9">
                            <div class="form-group">
                                <div class="form-control-wrapper">
                                    <input type="password" name="new_pass_re" id="new_pass_re" class="form-control">
                                    <input type="hidden" name="new_pass_re_hash" id="new_pass_re_hash" class="form-control">
                                    <span class="material-input-bar"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <input type="submit" class="btn btn-primary pull-right" name="save_pass" id="save_pass" value="Mentés">
                </form>
            </div>
        </section>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <section class="panel">
            <header class="panel-heading">E-mail értesítések</header>
            <div class="panel-body notifications">
                <?php if(isset($success_notif) && $success_notif != ''): ?>
                <div class="alert alert-success fade in text-center">
                    <button data-dismiss="alert" class="close" type="button">
                        <i class="fa fa-times"></i>
                    </button>
                    <?php echo $success_notif; ?>
                </div>
                <?php endif; ?>
                <form action="" method="post">
                    <div class="row">
                        <div class="col-md-6 input-label">
                            Értesítés az év eleji sorsolás esetén
                        </div>
                        <div class="col-md-6 text-center">
                            <input type="checkbox" name="new_lot" id="new_lot" <?php if($fill_notification['lot']) echo 'checked'; ?>>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 input-label">
                            Értesítés új időpont megkérdezése esetén
                        </div>
                        <div class="col-md-6 text-center">
                            <input type="checkbox" name="new_asked_date" id="new_asked_date" <?php if($fill_notification['date']) echo 'checked'; ?>>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 input-label">
                            Értesítés új esemény esetén
                        </div>
                        <div class="col-md-6 text-center">
                            <input type="checkbox" name="new_event" id="new_event" <?php if($fill_notification['event']) echo 'checked'; ?>>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 input-label">
                            Értesítés új galéria feltöltése esetén
                        </div>
                        <div class="col-md-6 text-center">
                            <input type="checkbox" name="new_gallery" id="new_gallery" <?php if($fill_notification['gallery']) echo 'checked'; ?>>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 input-label">
                            Értesítés ha valaki új képet töltött fel a galériámba
                        </div>
                        <div class="col-md-6 text-center">
                            <input type="checkbox" name="new_image" id="new_image" <?php if($fill_notification['image']) echo 'checked'; ?>>
                        </div>
                    </div>
                    <input type="submit" name="save_notif" id="save_notif" class="btn btn-primary pull-right" value="Mentés">
                </form>
            </div>
        </section>
    </div>
</div>

