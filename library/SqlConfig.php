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
        'host' => '',
        'dbName' => '',
        'loginName' => '',
        'loginPass' => ''
    );

    public function __construct() {
        $environment = parse_ini_file(ROOT . DS . 'environments' . DS . 'prod.env.ini');

        if($environment) {
            $this->params['host'] = $environment['db_host'];
            $this->params['dbName'] = $environment['db_name'];
            $this->params['loginName'] = $environment['db_user'];
            $this->params['loginPass'] = $environment['db_pass'];
        }
    }

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
     * @return string   Config param
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