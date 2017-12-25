<?php
/**
 *  Site routing class
 * 
 *  This class handles all the incoming requests.
 * 
 *  PHP version 5
 * 
 *  @author     Reményi Gergely <gergo@remenyicsalad.hu>
 * 
 *  @var   string  $_controller    The name of the calleble controller
 *  @var   string  $_modelName     The name of the calleble model
 *  @var   string  $_action        The name of the callable function inside the controller
 *  @var   mixed[] $_query         The parameters of the callable controller function (may NULL)
 */
class Router {
    
    protected $_controller;
    protected $_model;
    protected $_action;
    protected $_query;
	
    /**
     * Router's constructor
     * 
     * Get the url from the .htacces file, and explodes it into the $url. Finally sets up
     * the correct controller, controller function and function parameters.
     */
    public function __construct(){
		
        // Set the default controller for HomeController
        if(!User::userLoginCheck()) {
            $redirect_url = $_GET['url'];
            $this->setController('User','login',$redirect_url);
        }
        else {
            $this->setController('Home','index',NULL);
            // If home page called and no more url load the home page
            if(isset($_GET['url']) && $_GET['url'] != ''){

                // Explode the rewrite into the $url array by slash character('/')
                $url = explode('/',rtrim($_GET['url'],'/'));

                // Set the model name
                $model = ucfirst($url[0]);
                // Check the model name: if it is xhrSomething allow anyway (JSON data flow on ajax calls), 
                // if it is header or footer or lefside disable anyway (these ara only parts of the page)
                if(($model == 'Header' &&  substr($url[1],0,3) != 'xhr') || $model == 'Footer'){
                    throw new LoggableException(1001);
                }
                // Shift out model name
                array_shift($url);

                // Set the action name if url empty, default action is: index
                if(isset($url[0]) && $url[0] != ''){
                    $action = $url[0];
                }
                else {
                    $action = 'index';
                }
                // Shift out action name
                array_shift($url);

                // Set the query name if url empty, default query id NULL
                if(isset($url[0]) && $url[0] != ''){
                    $query = $url;
                }
                else{
                    $query = NULL;
                }

                // Set the controller
                $this->setController($model,$action,$query);

            }
        }
        
    }	
    
    /**
     * Router set local variables
     * 
     * Set up the class variables. Got it from the $url
     * 
     * @param string $model The model from the url
     * @param string $action The action from the url
     * @param mixed[] $query The query from the url
     */
    public function setController($model,$action,$query){
	
        // Set the correct model name: first letter uppercase.
	$this->_model = $model;
        
        // Set the correct controller name: first letter uppercase + "Controller"
	$this->_controller = $model . "Controller";
        
        // Set the controller function
	$this->_action = $action;
        
        // Set the function params
	$this->_query = $query;
    }
	
    /**
     * Load the correct controller.
     * 
     * Load the correct controller with header and footer and left sidebar.
     * Exept if it is an xhr request from some ajax call
     */
    public function loadController(){
        
        // Prepare called page
        if(User::userLoginCheck()) {
            $loadHeader = new HeaderController('Header','HeaderController','index');
        }      
        $load = new $this->_controller($this->_model,$this->_controller,$this->_action);
        if(User::userLoginCheck()) {
            $loadFooter = new FooterController('Footer','FooterController','index');
        }
        
        
        // Check if method exsist on the called page.
	if (method_exists($load, $this->_action)){
            
            // Pass the header and footer object to the main page
            if(User::userLoginCheck()) {
                $load->setHeader($loadHeader);
                $load->setFooter($loadFooter);
            }
            
            
            // Execute the called functions (now you can reach the header and the footer object from the main object)
            if(User::userLoginCheck() && substr($this->_action,0,3) != 'xhr') {
                $loadHeader->{'index'}(NULL);
            }
            $load->{$this->_action}($this->_query);
            if(User::userLoginCheck() && substr($this->_action,0,3) != 'xhr') {
                $loadFooter->{'index'}(NULL);
            }
            
            // Render the page
            if(User::userLoginCheck() && substr($this->_action,0,3) != 'xhr') {
                $loadHeader->renderController();
            }
            if(substr($this->_action,0,3) != 'xhr') {
                $load->renderController();
            }
            if(User::userLoginCheck() && substr($this->_action,0,3) != 'xhr') {
                $loadFooter->renderController();
            }
            
        }
	else {
            throw new LoggableException(1002);
	}
				
    }
    
    /**
     * Error reporting function 
     * 
     * If you are in developer mode. All your php errors can
     * see on the screen. On the live page errors go to the
     * log file.
     */
    public function setReporting() {
        
        // If we are in developer mode then display all erorrs on the screen
        if (DEVELOPMENT_ENVIRONMENT) {
            error_reporting(E_ALL);
            ini_set('display_errors','On');
            ini_set('log_errors', 'Off');
	} 
        //If we're not in developer mode then log it into the errors.log file
        else {
            error_reporting(E_ALL);
            ini_set('display_errors','Off');
            ini_set('log_errors', 'On');
            ini_set('error_log', ROOT . DS . 'tmp' . DS . 'logs' . DS . 'errors.log');
	}
        
    }
    
}

