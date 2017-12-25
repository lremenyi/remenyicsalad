<?php
/**
 *  Site's header class
 * 
 *  This class included and instanced in every page.
 * 
 *  PHP version 5
 * 
 *  @author     Reményi Gergely <gergo@remenyicsalad.hu>
*/
class HeaderController extends Controller {
    
    private $css;
    
    public function setCss($model) {
        $this->css = $model;
    }
    
    public function index() {
        
        // Pass name and picture
        $this->set('name', $this->Header->getUsersName());
        $this->set('avatar_img', $this->Header->getAvatarImg());
        
        // Pass of the menu is small or big
        $this->set('menu_small', $this->Header->isSidebarSmall());
        
        // Pass the menu
        $this->set('menu',$this->Header->getMenu());
        
        // Set up the css file
        $this->set('controller_css', strtolower($this->css));
        
    }
    
    public function xhrMenuChanged() {
        $this->Header->changeMenuSizeSettings();
    }
    
}
