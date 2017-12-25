<?php
/** 
 *  Website index page
 * 
 *  This page handles all the incoming requests, 
 *  and loads the correct application files.
 * 
 *  PHP version 5
 * 
 *  @author     Reményi Gergely <gergo@remenyicsalad.hu>
 */
ob_start();

//Define basic home and directory separator consts
define('DS', DIRECTORY_SEPARATOR);
define('ROOT', dirname(__FILE__));

//Define development environment. Set FALSE on live page!
define('DEVELOPMENT_ENVIRONMENT', false);

//Basic site config class
require_once (ROOT . DS . 'library' . DS . 'Config.php');
// Rooter file
require_once (ROOT . DS . 'library' . DS . 'Router.php');
// Custom exception classes
require_once (ROOT . DS . 'library' . DS . 'LoggableException.php');
// Regex class
require_once (ROOT . DS . 'library' . DS . 'Regex.php');

// Start secured session
Config::sec_session_start();
// Load contants
Config::loadConstants();

try {
    //Start the application, create new router object
    $application = new Router();
    //Set up error reporting
    $application->setReporting();
    //Load the page
    $application->loadController();
} catch (LoggableException $lex) {
    $lex->logError();
    $lex->showErrorToUser();
}


/**
 * Autoload function
 * 
 * This function loads all the required php class files.
 * This subtitutes the 'required' and 'include' methods in
 * every page.
 * 
 * @param   string  $className  Name of the includable class file
 */
function __autoload($className) {
    if (file_exists(ROOT . DS . 'library' . DS . $className . 'Class.php')) {
        require_once(ROOT . DS . 'library' . DS . $className . 'Class.php');
    } else if (file_exists(ROOT . DS . 'application' . DS . 'controllers' . DS . $className . '.php')) {
        require_once(ROOT . DS . 'application' . DS . 'controllers' . DS . $className . '.php');
    } else if (file_exists(ROOT . DS . 'application' . DS . 'models' . DS . $className . '.php')) {
	require_once(ROOT . DS . 'application' . DS . 'models' . DS . $className . '.php');
    } else {
        $lex = new LoggableException(1003);
        $lex->logError();
        $lex->showErrorToUser();
    }
}
ob_end_flush();