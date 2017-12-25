<?php
/**
 *  Site's header class
 * 
 *  This is the home view the website's start page
 * 
 *  PHP version 5
 * 
 *  @author     Reményi Gergely <gergo@remenyicsalad.hu>
*/
class HomeController extends  Controller {
    
    public function index($query) {
    
        if(isset($query[0]) && $query[0] != '') {
            throw new LoggableException(1051);
        }
        
        $this->set('ask_numb', $this->Home->getNewAskedDates());
        
        $this->set('galleries_numb', $this->Home->getGalleries());
        
        $this->set('images_numb', $this->Home->getImages());
        
        $this->set('events_numb', $this->Home->getEvents());
        
        $this->set('next_events', $this->Home->getAllNextEvents());
        
        $this->set('galleries', $this->Home->getAllGalleries());
        
        $this->set('images', $this->Home->getAllImages());
        
    }
    
}
