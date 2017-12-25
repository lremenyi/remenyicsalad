<?php
/**
 *  Loggable exception class
 * 
 *  This exception is for the better performance optimalization.
 *  This exception can log the code of the exception in the database
 *  for the developers, and can redirect the users to different error
 *  pages
 * 
 *  PHP version 5
 * 
 *  @author     Reményi Gergely <gergo@remenyicsalad.hu>
 */
class LoggableException extends Exception {
    
    /**
     * Loggable Exception construcor
     * 
     * Call the parent's constructor
     * 
     * @param type $code The exception message
     * @param type $message The exception code
     * @param Exception $previous Previous exception default null
     */
    public function __construct($code,$message = NULL) {
        
        // Load the default exception's constructor with the correct values
        parent::__construct($message,$code,NULL);
    }
    
    public function logError() {
          
        // Do some database INSERT
        echo $this->code;
        
    }
    
    public function showErrorToUser() {
        
        // Do some database SELECT
        
        // Redirect
        //header('Location: ' . $_SERVER['HTTP_HOST'] );
        
        // If redirect failed exit rendering
        exit();
        
    }
    
}
