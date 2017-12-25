<?php
/**
 *  Basic view class
 * 
 *  This class creates the view for the called controller.
 *  Loads the fillable variables and includes the needed files
 *  finally renders the page when controller's destructor called
 * 
 *  PHP version 5
 * 
 *  @author     Reményi Gergely <gergo@remenyicsalad.hu>
 *  
 *  @var    mixed[] $variable       Stores the variables to fill the view
 *  @var    string  $_controller    Name of the controller
 *  @var    string  $_action        Name of the controller function 
 */
class Template {
     
    protected $variables = array();
    protected $_controller;
    protected $_action;
    
    /**
     * Template constructor
     * 
     * Set up the class params
     * 
     * @param string $controller  Incoming name of the controller
     * @param string $action      Incoming name of the controller function
     */
    function __construct($controller,$action) {
        
        $this->_controller = $controller;
        $this->_action = $action;

    }
 
    /**
     * Set up variables to fill the view
     * 
     * @param string $name    Name of the variable
     * @param string $value   Value of the variable
     */
    function set($name,$value) {
        
        $this->variables[$name] = $value;
        
    }
 
    /**
     * Display template
     */
    function render() {
        
       // Fill it with variables array
       extract($this->variables);
        
        //Search for the file and display
       $path = ROOT . DS . 'application' . DS . 'views';
       // Search for AJAX JSON request
        if(substr($this->_action,0,3) != 'xhr') {
            if (is_dir($path . DS . strtolower(substr($this->_controller,0,-10)))){
                if(file_exists($path. DS . strtolower(substr($this->_controller,0,-10)) . DS . $this->_action . '.php')){
                    include ($path. DS . strtolower(substr($this->_controller,0,-10)) . DS . $this->_action . '.php');
                }
                else {
                    throw new LoggableException(1004);
                }
            } else if (file_exists($path . DS . strtolower(substr($this->_controller,0,-10)) . '.php')) {
                include ($path . DS . strtolower(substr($this->_controller,0,-10)) . '.php');
            } else {
                throw new LoggableException(1005);
            }
        }
    }
 
}