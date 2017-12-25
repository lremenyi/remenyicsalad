<?php
/**
 *  Site's statistics for the administrator
 * 
 *  This collect and shows the satisctics, exception, error logs etc.
 * 
 *  PHP version 5
 * 
 *  @author     Reményi Gergely <gergo@remenyicsalad.hu> 
*/
class StatisticsController extends Controller {
    
    public function index($query) {
        
        if(isset($query) && $query != '') {
            throw new LoggableException(1017);
        }
        
    }
    
}