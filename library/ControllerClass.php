<?php
/**
 *  The controllers template class
 * 
 *  This class is the parent of all the controllers.
 *  Contains the basic attributes and methodes for the
 *  controllers. It loads the header the footer and the 
 *  other standalone page parts. After all the things are
 *  put together renders the view.
 * 
 *  PHP version 5
 * 
 *  @author     Reményi Gergely <gergo@remenyicsalad.hu>
 *  
 *  @var    string  $_model             Name of the current model
 *  @var    string  $_controller        Name of the current controller
 *  @var    string  $_action            Name of the current controller function
 *  @var    object  $_template          Contains the template object
 *  @var    object  $_header            The header object
 *  @var    object  $_headerTemplate    The header's template object
 *  @var    object  $_footer            The footer object
 *  @var    object  $_footerTemplate    The footer's template object
 */
class Controller {
     
    protected $_model;
    protected $_controller;
    protected $_action;
    protected $_template;
    protected $_header;
    protected $_footer;

    /**
     * Controller class constructor
     * 
     * Set up current controller, controller function and model
     * and create new view object for the controller.
     * 
     * @param string $model       Incoming name of the current model
     * @param string $controller  Incoming name of the current controller
     * @param string $action      Incoming nam of the current controller function
     */
    public function __construct($model, $controller, $action) {
        
        // Set up the current controller, model and function names
        $this->_controller = $controller;
        $this->_action = $action;
        $this->_model = $model;
        
        // Create new model object for the controller
        $this->$model = new $model;
        
        try {
            $this->_template = new Template($this->_controller,$this->_action);
        } catch (LoggableException $lex) {
            throw $lex; 
        }
        
    }
    
    
    /**
     * 
     * Controller class set function
     * 
     * Call the current template object's set function to fill the template
     * 
     * @param string $name    Name of the variable  
     * @param string $value   Value of the variable
     * 
     */
    public function set($name,$value) {
        
        $this->_template->set($name,$value);
        
    }
    
    public function setHeader($header) {
        $this->_header = $header;
        $this->_header->setCss(strtolower($this->_model));
    }
    
    public function setFooter($footer) {
        $this->_footer = $footer;
        $this->_footer->setJavascript(strtolower($this->_model));
    }
    
    public function renderController() {
        $this->_template->render();
    }
         
}

