<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=no">
    <meta name="author" content="Gergely Reményi">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Bejelentkezés</title>
    <!-- FAVICON -->
    <link href="<?php echo PROTOCOL ?><?php echo $_SERVER['HTTP_HOST']; ?>/public/assets/img/logos/<?php echo FAVICON; ?>" rel="icon">
    <!-- BOOTSTRAP -->
    <link href="<?php echo PROTOCOL ?><?php echo $_SERVER['HTTP_HOST']; ?>/public/assets/bootstrap-<?php echo BOOTSTRAP_VERSION; ?>/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?php echo PROTOCOL ?><?php echo $_SERVER['HTTP_HOST']; ?>/public/assets/css/bootstrap-reset.css" rel="stylesheet">
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <!-- FONTAWESOME -->
    <link href="<?php echo PROTOCOL ?><?php echo $_SERVER['HTTP_HOST']; ?>/public/assets/font-awesome-<?php echo FONTAWESOME_VERSION; ?>/css/font-awesome.min.css" rel="stylesheet">
    <!-- CUSTOM CSS -->
    <link href="<?php echo PROTOCOL ?><?php echo $_SERVER['HTTP_HOST']; ?>/public/assets/css/login.css" rel="stylesheet">
</head>
<body>
    <section>
        <div class="login-panel col-lg-4 col-lg-offset-4 col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2 col-xs-12">
            <div class="panel">
                <div class="panel-heading white">
                    <img src="<?php echo PROTOCOL ?><?php echo $_SERVER['HTTP_HOST'] ?>/public/assets/img/logos/logo_remenyicsalad.png" class="login-logo">
                </div>
                <div class="panel-body">
                    <?php if(isset($login_error)): ?>
                            <div class="alert alert-danger fade in text-center">
                                <button data-dismiss="alert" class="close" type="button">
                                    <i class="fa fa-times"></i>
                                </button>
                            <?php echo $login_error; ?>
                        </div>
                    <?php endif; ?>
                    <form action="" method="post">
                        <div class="form-group">
                            <div class="form-control-wrapper">
                                <input type="text" name="username" id="username" class="form-control form-icon" autocomplete="off">
                                <div class="floating-label">Felhasználónév</div>
                                <i class="fa fa-user"></i>
                                <span class="material-input-bar"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="form-control-wrapper">
                                <input type="password" name="pass" id="pass" class="form-control form-icon">
                                <input type="hidden" name="password" id="password">
                                <div class="floating-label">Jelszó</div>
                                <i class="fa fa-lock"></i>
                                <span class="material-input-bar"></span>
                            </div>
                        </div>
                        <input type="submit" name="login-submit" id="login-submit" value="Bejelentkezés" class="btn btn-primary pull-right">
                    </form>
                </div>
            </div>
        </div>
    </section>
    
    <!-- JQUERY 2.1.0 -->
    <script src="<?php echo PROTOCOL ?><?php echo $_SERVER['HTTP_HOST']; ?>/public/assets/js/jquery-<?php echo JQUERY_VERSION ?>.min.js"></script>
    <!-- BOOTSTRAP -->
    <script src="<?php echo PROTOCOL ?><?php echo $_SERVER['HTTP_HOST']; ?>/public/assets/bootstrap-<?php echo BOOTSTRAP_VERSION ?>/js/bootstrap.min.js"></script>
    <!-- FUNCTIONS -->
    <script src="<?php echo PROTOCOL ?><?php echo $_SERVER['HTTP_HOST']; ?>/public/assets/js/functions.js"></script>
    <!-- HASH -->
    <script src="<?php echo PROTOCOL ?><?php echo $_SERVER['HTTP_HOST']; ?>/public/assets/js/hash.js"></script>
     <!-- CUSTOM -->
    <script src="<?php echo PROTOCOL ?><?php echo $_SERVER['HTTP_HOST']; ?>/public/assets/js/login.js"></script>
</body>
</html>
