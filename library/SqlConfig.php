<?php
/** 
 *  Configuration for mysql connect
 * 
 *  PHP version 5
 * 
 *  @author     Reményi Gergely <gergo@lotech.hu>
 *  @copyright  LoTecH 2014 all rights reserved
 *  @since      File available since 2015
 * 
 *  @var    string[]    $params Contains the account information for mysql connect
 */
class sqlConfig{
	
    private $params = array(
	'host' => 'localhost',
	'dbName' => 'remenyi_remenyinet',
	'loginName' => 'remenyi_user',
	'loginPass' => 'eempHdKwxq586vZ4'
    );
		
    /**
     * Magic set function
     * 
     * @param string $name  Array index
     * @param string $value Indexed element value
    */
    function __set($name,$value){
        
        $this->params[$name]=$value;
        
    }
		
    /**
     * Magic get function
     * 
     * @param string $name  Array index
    */
    function __get($name){
        
        if (array_key_exists($name, $this->params)) {
            return $this->params[$name];
	}
	else {
            return NULL;
        }
        
    }
		
}