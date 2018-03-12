<?php
/**
 *  Basic admin configurations
 * 
 *  Set up the basic admin configurations
 * 
 *  PHP version 5
 * 
 *  @author     Reményi Gergely <gergo@remenyicsalad.hu>
 */
class Config {
    
    /**
     * Secured session start
     */
    public static function sec_session_start(){
        // Set a custom session name
        $session_name = 'sec_session_id';
        //For https -> TRUE
        $secure = FALSE;
        
        // This stops JavaScript being able to access the session id.
        $httponly = true;
        
        // Forces sessions to be secured
        ini_set('session.use_only_cookies', 1);
        
        // Get current cookies params.
        $cookieParams = session_get_cookie_params();
        session_set_cookie_params($cookieParams['lifetime'],
            $cookieParams['path'], 
            $cookieParams['domain'], 
            $secure,
            $httponly);
        
        // Set the session name to the one set above.
        session_name($session_name);
        session_start();            // Start the PHP session 
        session_regenerate_id();    // regenerated the session, delete the old one. 
    }
    
    public static function loadConstants() {
        
        define('PROTOCOL','http://');
        define('FAVICON', 'favicon.ico');
        define('BOOTSTRAP_VERSION','3.3.2');
        define('FONTAWESOME_VERSION','4.3.0');
        define('JQUERY_VERSION', '2.1.3');
        date_default_timezone_set('Europe/Budapest');
        
    }
    
    public static function monthName($month) {
        
        $name = NULL;
        
        switch($month) {
            case 1:
                $name = 'Január';
            break;
            case 2:
                $name = 'Február';
            break;
            case 3:
                $name = 'Március';
            break;
            case 4:
                $name = 'Április';
            break;
            case 5:
                $name = 'Május';
            break;
            case 6:
                $name = 'Június';
            break;
            case 7:
                $name = 'Július';
            break;
            case 8:
                $name = 'Augusztus';
            break;
            case 9:
                $name = 'Szeptember';
            break;
            case 10:
                $name = 'Október';
            break;
            case 11:
                $name = 'November';
            break;
            case 12:
                $name = 'December';
            break;
        }
        
        return $name;
        
    }
    
    
}