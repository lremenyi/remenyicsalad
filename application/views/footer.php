
            </section>
        </section>
        <footer>

        </footer>
    </section>

    <!-- JQUERY 2.1.0 -->
    <script src="<?php echo PROTOCOL ?><?php echo $_SERVER['HTTP_HOST']; ?>/public/assets/js/jquery-<?php echo JQUERY_VERSION ?>.min.js"></script>
    <!-- BOOTSTRAP -->
    <script src="<?php echo PROTOCOL ?><?php echo $_SERVER['HTTP_HOST']; ?>/public/assets/bootstrap-<?php echo BOOTSTRAP_VERSION ?>/js/bootstrap.min.js"></script>
    <!-- FUNCTIONS -->
    <script src="<?php echo PROTOCOL ?><?php echo $_SERVER['HTTP_HOST']; ?>/public/assets/js/functions.js"></script>
    <!-- HEADER -->
    <script src="<?php echo PROTOCOL ?><?php echo $_SERVER['HTTP_HOST']; ?>/public/assets/js/header.js"></script>
    <!-- HASH -->
    <script src="<?php echo PROTOCOL ?><?php echo $_SERVER['HTTP_HOST']; ?>/public/assets/js/hash.js"></script>
    <!-- HASH -->
    <script src="<?php echo PROTOCOL ?><?php echo $_SERVER['HTTP_HOST']; ?>/public/assets/js/nicescroll.js"></script>
    <!-- DATEPICKER -->
    <script src="<?php echo PROTOCOL ?><?php echo $_SERVER['HTTP_HOST']; ?>/public/assets/datepicker/js/bootstrap-datepicker.min.js"></script>
    <!-- DATEPICKER HUN LANGUAGE -->
    <script src="<?php echo PROTOCOL ?><?php echo $_SERVER['HTTP_HOST']; ?>/public/assets/datepicker/js/locale/bootstrap-datepicker.hu.js"></script>
    <!-- CLOCKPICKER -->
    <script src="<?php echo PROTOCOL ?><?php echo $_SERVER['HTTP_HOST']; ?>/public/assets/clockpicker/js/bootstrap-clockpicker.min.js"></script>
    <!-- MOMENT -->
    <script src="<?php echo PROTOCOL ?><?php echo $_SERVER['HTTP_HOST']; ?>/public/assets/calendar/js/moment.min.js"></script>
    <!-- CALENDAR-->
    <script src="<?php echo PROTOCOL ?><?php echo $_SERVER['HTTP_HOST']; ?>/public/assets/calendar/js/fullcalendar.min.js"></script>
    <!-- CALENDAR LANGUAGE-->
    <script src="<?php echo PROTOCOL ?><?php echo $_SERVER['HTTP_HOST']; ?>/public/assets/calendar/js/lang/hu.js"></script>
    <!-- GALLERY -->
    <script src="//blueimp.github.io/Gallery/js/jquery.blueimp-gallery.min.js"></script>
    <script src="<?php echo PROTOCOL ?><?php echo $_SERVER['HTTP_HOST']; ?>/public/assets/bootstrap-gallery/js/bootstrap-image-gallery.min.js"></script>
    <!-- GALLERY -->
    <script src="<?php echo PROTOCOL ?><?php echo $_SERVER['HTTP_HOST']; ?>/public/assets/js/filedrop.js"></script>
    <!-- CUSTOM -->
    <?php 
        if(file_exists("public/assets/js/" . $include_javascript . ".js")){
            echo "<script src=" . PROTOCOL . $_SERVER['HTTP_HOST'] . "/public/assets/js/" . $include_javascript . ".js></script>";
        }
    ?>
</body>
</html>
