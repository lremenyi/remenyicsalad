<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=no">
    <meta name="author" content="Gergely Reményi">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>ReményiNET</title>
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
    <!-- ANIMATE CSS -->
    <link href="<?php echo PROTOCOL ?><?php echo $_SERVER['HTTP_HOST']; ?>/public/assets/css/animate.css" rel="stylesheet">
    <!-- HEADER CSS -->
    <link href="<?php echo PROTOCOL ?><?php echo $_SERVER['HTTP_HOST']; ?>/public/assets/css/header.css" rel="stylesheet">
    <!-- DATEPICKER CSS -->
    <link href="<?php echo PROTOCOL ?><?php echo $_SERVER['HTTP_HOST']; ?>/public/assets/datepicker/css/datepicker.css" rel="stylesheet">
    <!-- CLOCKPICKER CSS -->
    <link href="<?php echo PROTOCOL ?><?php echo $_SERVER['HTTP_HOST']; ?>/public/assets/clockpicker/css/bootstrap-clockpicker.css" rel="stylesheet">
    <!-- Gallery -->
    <link href="//blueimp.github.io/Gallery/css/blueimp-gallery.min.css" rel="stylesheet">
    <!-- CUSTOM CSS -->
    <?php
        if(file_exists("public/assets/css/" . $controller_css . ".css")) {
            echo '<link href="' . PROTOCOL . $_SERVER['HTTP_HOST'] . '/public/assets/css/' . $controller_css . '.css" rel="stylesheet">';
    }
    ?>
</head>
<body>
    <section id="container">
        <header>
            <nav class="navbar navbar-default navbar-fixed-top">
                <div class="brand pull-left <?php if($menu_small) echo ' only-logo'; ?>">
                    <img src="<?php echo PROTOCOL . $_SERVER['HTTP_HOST'] ?>/public/assets/img/logos/logo_remenyicsalad_small.png" class="brand-logo">
                    <h4 class="brand-title">ReményiNET</h4>
                </div>
                <ul class="pull-left list-unstyled list-inline sidebar-toggle sidebar-collapse">
                    <li class="sidebar-collapse-li">
                        <i class="fa fa-outdent <?php if($menu_small) echo 'small'; ?>"></i>
                    </li>
                </ul>
                <ul class="pull-left list-unstyled list-inline sidebar-toggle sidebar-collapse-small-res">
                    <li class="sidebar-collapse-li-small-res">
                        <i class="fa fa-bars"></i>
                    </li>
                </ul>
                <ul class="pull-right list-inline right-navigation">
                    <li class="nav-profile dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <img src="<?php echo PROTOCOL . $_SERVER['HTTP_HOST'] . DS . 'public' . DS . 'media' . DS . 'profile' . DS . $avatar_img; ?>" alt="" class="img-circle size-40x40">
                            <span>
                                <?php echo $name; ?>
                                <i class="fa fa-angle-down"></i>
                            </span>
                        </a>
                        <ul class="dropdown-menu animated short fadeInDownSmall">
                            <li class="dropdown-header">
                                <span>@<?php echo $_SESSION['username'] ?></span>
                            </li>
                            <li>
                                <a href="<?php echo PROTOCOL . $_SERVER['HTTP_HOST'] ?>/user">
                                    <i class="fa fa-user"></i>
                                    Profilom
                                </a>
                            </li>
                            <li>
                                <a href="<?php echo PROTOCOL . $_SERVER['HTTP_HOST'] ?>/user/settings">
                                    <i class="fa fa-cog"></i>
                                    Beállítások
                                </a>
                            </li>
                            <li class="logout">
                                <a href="<?php echo PROTOCOL . $_SERVER['HTTP_HOST'] ?>/user/logout">
                                    <i class="fa fa-sign-out"></i>
                                    Kijelentkezés
                                </a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </nav>
        </header>
        <aside>
            <div id="sidebar" <?php if($menu_small) echo 'class="sidebar-small"'; ?>>
                <div class="leftside-navigation">
                    <ul class="menu-list list-unstyled">
                        <?php foreach ($menu as $element): ?>
                            <li>
                                <a href="<?php echo PROTOCOL . $_SERVER['HTTP_HOST'] . DS . $element['url'] ?>">
                                    <i class="fa fa-<?php echo $element['icon'] ?>"></i>
                                    <span><?php echo $element['name'] ?></span>
                                </a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>
        </aside>
        <section id="main-content" <?php if($menu_small) echo 'class="main-expanded"'; ?>>
            <section class="wrapper">