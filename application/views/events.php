<div class="row">
    <div class="col-md-12">
        <section class="panel">
            <header class="panel-heading">Naptár</header>
            <div class="panel-body">
                <?php if(isset($error_desc)): ?>
                    <div class="alert alert-danger fade in text-center">
                        <button data-dismiss="alert" class="close" type="button">
                            <i class="fa fa-times"></i>
                        </button>
                        <?php echo $error_desc; ?>
                    </div>
                <?php endif; ?>
                <?php if(isset($success_desc)): ?>
                    <div class="alert alert-success fade in text-center">
                        <button data-dismiss="alert" class="close" type="button">
                            <i class="fa fa-times"></i>
                        </button>
                        <?php echo $success_desc; ?>
                    </div>
                <?php endif; ?>
                <div id="calendar"></div>
            </div>
        </section>
    </div>
</div>

<?php if(isset($called_event)): ?>
<div id="called-event"><?php echo $called_event; ?></div>
<?php endif; ?>

<div class="modal fade" id="event-modal" tabindex="-1" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title" id="event-title"></h4>
            </div>
            <form action="" method="POST" id="event-form">
                <input type="hidden" name="event-id" id="event-id">
                <div class="modal-body">
                    <div class="form-group">
                        <div class="form-control-wrapper">
                            <input type="text" name="event-name" id="event-name" class="form-control" autocomplete="off">
                            <div class="floating-label">Esemény neve</div>
                            <span class="material-input-bar"></span>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="form-control-wrapper">
                            <input type="text" name="event-date" id="event-date" class="form-control" autocomplete="off">
                            <div class="floating-label">Esemény dátuma</div>
                            <span class="material-input-bar"></span>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="form-control-wrapper">
                            <input type="text" name="event-time" id="event-time" class="form-control" autocomplete="off">
                            <div class="floating-label">Esemény kezdési időpontja</div>
                            <span class="material-input-bar"></span>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="form-control-wrapper">
                            <input type="text" name="event-desc" id="event-desc" class="form-control" autocomplete="off">
                            <div class="floating-label">Esemény leírás</div>
                            <span class="material-input-bar"></span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <span>Házigazda</span>
                        </div>
                        <div class="col-md-6 text-right">
                            <select id="event-host" name="event-host">
                                <?php foreach($hosts as $host): ?>
                                    <option value="<?php echo $host['id'] ?>"><?php echo $host['name'] ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <input id="delete-event" name="delete-event" class="btn btn-danger" type="submit" value="Törlés">
                    <input id="save-event" name="save-event" class="btn btn-primary" type="submit" value="Mentés">
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="new-event-modal" tabindex="-1" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title">Új esemény hozzáadása</h4>
            </div>
            <form action="" method="POST">
                <div class="modal-body">
                    <div class="form-group">
                        <div class="form-control-wrapper">
                            <input type="text" name="new-event-name" id="new-event-name" class="form-control" autocomplete="off">
                            <div class="floating-label">Esemény neve</div>
                            <span class="material-input-bar"></span>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="form-control-wrapper">
                            <input type="text" name="new-event-date" id="new-event-date" class="form-control" autocomplete="off">
                            <div class="floating-label">Esemény dátuma</div>
                            <span class="material-input-bar"></span>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="form-control-wrapper">
                            <input type="text" name="new-event-time" id="new-event-time" class="form-control" autocomplete="off">
                            <div class="floating-label">Esemény kezdési időpontja</div>
                            <span class="material-input-bar"></span>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="form-control-wrapper">
                            <input type="text" name="new-event-desc" id="new-event-desc" class="form-control" autocomplete="off">
                            <div class="floating-label">Esemény leírás</div>
                            <span class="material-input-bar"></span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <span>Házigazda</span>
                        </div>
                        <div class="col-md-6 text-right">
                            <select id="event-host" name="new-event-host">
                                <?php foreach($hosts as $host): ?>
                                    <option value="<?php echo $host['id'] ?>"><?php echo $host['name'] ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <input id="save-new-event" name="save-new-event" class="btn btn-primary" type="submit" value="Mentés">
                </div>
            </form>
        </div>
    </div>
</div>

