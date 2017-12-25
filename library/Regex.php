<?php
/**
 *  Regex class
 * 
 *  Set up the basic admin configurations
 * 
 *  PHP version 5
 * 
 *  @author     Reményi Gergely <gergo@remenyicsalad.hu>
 */
class Regex {
    
    public static function checkUserName($username) {       
       return preg_match('/^[a-z_-]{3,50}$/', $username);        
    }
    
    public static function checkName($name) {
        return (preg_match("/^[a-zA-Z\s, .'\-\pL]+$/u", $name) && (strlen($name) >= 5) && (strlen($name) <= 50));
    }
    
    public static function checkEventName($name) {
        return (preg_match("/^[a-zA-Z0-9\s, .'\-\pL]+$/u", $name) && (strlen($name) >= 5) && (strlen($name) <= 30));
    }
    
    public static function checkGalleryName($name) {
        return (preg_match("/^[a-zA-Z0-9\s, .'\-\pL]+$/u", $name) && (strlen($name) >= 5) && (strlen($name) <= 25));
    }
    
    public static function checkEmail($email) {
        return (preg_match('/^([a-z0-9_\.-]+)@([\da-z\.-]+)\.([a-z\.]{2,6})$/', $email) && (strlen($email) >= 5) && (strlen($email) <= 50));
    }
    
    public static function checkDescription($description) {
        return (strlen($description) <=255);
    }
    
    public static function checkEventDescription($description) {
        return (strlen($description) <= 100);
    }
    
    public static function checkLink($link) {
        return (preg_match('/^(https?:\/\/)?([\da-z\.-]+)\.([a-z\.]{2,6})([\/\w \.-]*)*\/?$/', $link) && (strlen($link) >= 3) && (strlen($link) <= 200));
    }
    
    public static function checkImageName($name) {
        return (strlen($name) <= 50 && strlen($name) >= 3);
    }
    
    public static function checkImageFileName($name) {
        return (strlen($name) <= 50 && strlen($name) >= 5);
    }
    
}
