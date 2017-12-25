<?php
/** 
 *  Custom PDO class
 * 
 *  PHP version 5
 * 
 *  @author     Reményi Gergely <gergo@lotech.hu>
 *  @copyright  LoTecH 2014 all rights reserved
 *  @since      File available since 2015
 *   
 *  @var    string[]    $params Contains the account information for mysql connect
 */
class SqlConn {
    private $PDOconn;
	
    /**
     * Constructor
     * 
     * Open database connection
     */
    function __construct() {
        
        // Include config file and create object
        require_once('SqlConfig.php');
	$conf = new SqlConfig();			
			
	// Create PDO connection
	try {
            $driverOptions = array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'");
            $this->PDOconn = new PDO('mysql:dbname=' . $conf->dbName . ';host=' . $conf->host, $conf->loginName, $conf->loginPass, $driverOptions);
            $this->PDOconn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	} catch (PDOException $ex) {
            throw new LoggableException(1006,$ex->getMessage());
	}
    }
	
    /**
     * PDOprepare function
     * 
     * Prepare statement
     * 
     * @param string $sql The sql query in a string
     */
    function PDOprepare($sql) {
	$stmt = $this->PDOconn->prepare($sql);
			
	$handler = new SqlHandler();
	$handler->setResultHandling(new SqlStmt($stmt));
	$handler = $handler->getResultHandling();
        
        return $handler;
	}
	
	// Commit
        function commit() {
            $this->PDOconn->commit();
	}
	
	// Rollback
	function rollback() {
            $this->PDOconn->rollBack();
	}
	
	// Autocommit off, start transaction
	function transactionStart() {
            $this->PDOconn->beginTransaction();
	}
		
	// Commit and set autocommit on
	function transactionEnd() {
            self::commit();
	}
		
        // Rollback and set autocommit on
	function transactionError() {
            self::rollback();
	}
		
        // Check query error in transaction
	function checkTransactionError($query) {
            if ($query == false) {
                    self::transactionError();
		exit();			
		}
	}
		
	// Get the last inserted is
	function lastInsertId($name = NULL) {
            return $this->PDOconn->lastInsertId($name);
	}

}

/**
 * SQL handler class
 */
class SqlHandler {
    
    private $resultHandling;
    
    function setResultHandling($res) {
	$this->resultHandling = $res;
    }

    function getResultHandling() {
	return $this->resultHandling;
    }
    
}

/**
 * Result handling interface
 */
interface ResultHandling {
    function fetchAll();
    function fetchAssoc();
    function fetchRow();
    function fetchOneData();
    function numRows();
    function fieldCount();
    function close();
}
	
/**
 * PDO statement handling
 */
class SqlStmt implements ResultHandling {
    private $stmt;
	
    // Set $stmt
    function __construct($stmt = NULL) {
	$this->stmt = $stmt;
    }
		
    // Set $stmt
    function setStmt($stmt) {
	$this->stmt = $stmt;
    }
		
    // Get $stmt
    function getStmt() {
        return $this->stmt;
    }	
	
    // Return all results
    function fetchAll($type = PDO::FETCH_BOTH) {
	return $this->stmt->fetchAll($type);
    }
			
    // Return next row (with associative array)
    function fetchAssoc() {
        return $this->stmt->fetch(PDO::FETCH_ASSOC);
    }
		
    // Return next row (with numeric indexed array)
    function fetchRow() {
	return $this->stmt->fetch(PDO::FETCH_NUM);
    }
	
    // Return first row
    function fetchOneData() {
	$result = self::fetchRow();
        return $result[0];
    }
	
    // Get number of rows
    function numRows() {
	return $this->stmt->rowCount();
    }
	
    // Get number of fields
    function fieldCount() {
        return $this->stmt->columnCount();
    }
	
    // Free resources
    function close() {
        return $this->stmt->closeCursor();
    }
	
    // Return next row
    function fetch($param) {
	return $this->stmt->fetch($param);
    }
		
    // Bind parameters
    function bindParam($num, $name, $type = PDO::PARAM_STR) {
	return $this->stmt->bindParam($num, $name, $type);
    }
		
    // Execute statement
    function execute() {
	return $this->stmt->execute();
    }
		
    // Execute statement with bind params
    function executeBind($array) {
	return $this->stmt->execute($array);
    }
   
}