<?php
/**
 *  Site's footer class
 * 
 *  This class included and instanced in every page.
 * 
 *  PHP version 5
 * 
 *  @author     Reményi Gergely <gergo@remenyicsalad.hu> 
*/
class FooterController extends Controller {
    
    public $javascript;
    
    public function setJavascript($model) {
        $this->javascript = $model;
    }
    
    public function index() {
        
        // Set up javascript file
        $this->set('include_javascript', strtolower($this->javascript));
        
    }
    
}