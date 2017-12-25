<?php
/**
 *  Site's gallery
 * 
 *  The gallery modul for the site
 * 
 *  PHP version 5
 * 
 *  @author     Reményi Gergely <gergo@remenyicsalad.hu> 
*/
class GalleryController extends Controller {
    
    public function index($query) {
        
        if(isset($query) && $query != '') {
            throw new LoggableException(1017);
        }
        
        $this->set('galleries', $this->Gallery->getGalleryPreview());
        
    }
    
    public function view($query) {
        
        if(!isset($query) || $query == '' || count($query) > 2) {
            throw new LoggableException(1070);
        }
        
        if(isset($query) && $query != '' && !$this->Gallery->checkGalleryExists($query[0])) {
            throw new LoggableException(1068);
        }
        
        if(isset($_POST['delete-gallery'])) {
            $id = $_POST['delete-gallery-id'];
            $this->Gallery->deleteGallery($id);
            header('Location: ' . PROTOCOL . $_SERVER['HTTP_HOST'] . DS . 'gallery');
        }
        
        if(isset($_POST['delete-these'])) {
            $delete_id = $_POST['deletethis'];
            $this->Gallery->deleteTheseImages($delete_id);
        }
        
        if(isset($_POST['save-details'])) {
            $id = $_POST['edit-gallery-id'];
            $name = $_POST['edit-gallery-name'];
            $desc = $_POST['edit-gallery-desc'];
            
            $this->Gallery->saveGalleryDetails($id,$name,$desc);
        }
        
        if(count($query) == 2 && !$this->Gallery->checkImageForGallery($query[0],$query[1])) {
            throw new LoggableException(1071);
        }
        
        $this->set('images', $this->Gallery->getImagesForGallery($query[0]));
        $this->set('gallery_details', $this->Gallery->getGalleryDetails($query[0]));
        if(isset($query[1]) && $query != '') {
            $this->set('active_image',$query[1]);
        }
        
    }
    
    public function upload($query) {
        
        if(isset($query) && $query != '') {
            throw new LoggableException(1066);
        }
        
        if(!isset($_POST['new-gallery-name']) || !isset($_POST['new-gallery-desc'])) {
            throw new LoggableException(1065);
        }
        
        if(!Regex::checkGalleryName($_POST['new-gallery-name'])) {
            $this->set('name_error', 'Hibásan adtad meg a galéria nevét (Minimum 5, maximum 25 karakternek kell lennie)!');
        }
        
        $this->set('gallery_name',$_POST['new-gallery-name']);
        $this->set('gallery_desc',$_POST['new-gallery-desc']);
        
        if(isset($_POST['gallery-id']) && $_POST['gallery-id'] != '') {
            $this->set('gallery_id', $_POST['gallery-id']);
        }
        
    }
    
    public function xhrGalleryUpload() {
        $upload_dir = 'tmp/';
        $allowed_ext = array('jpg','jpeg','png','gif');

        if(strtolower($_SERVER['REQUEST_METHOD']) != 'post'){
            echo json_encode(array('status' => 'Hiba! Rossz HTTP metódus!'));
            exit;
        }

        else if(array_key_exists('pictures',$_FILES) && $_FILES['pictures']['error'] == 0 ){

            $pic = $_FILES['pictures'];
            
            $pic['name'] = str_replace('%20','',str_replace(' ', '', $pic['name']));
            
            $ext_array = explode('.', $pic['name']);
            $ext = array_pop($ext_array);

            if(!in_array(strtolower($ext),$allowed_ext)){
                echo json_encode(array('status' =>'Csak képfájlok engedélyezettek!'));
            }	
            
            $i = 1;
            while(file_exists($upload_dir.$pic['name'])) {
                $ext_array = explode('.', $pic['name']);
                $ext = array_pop($ext_array);
                $name = str_replace(' ','',implode('.',$ext_array));
                $pic['name'] = $name . $i . '.' .  $ext;
                $i++;
            }
            if(move_uploaded_file($pic['tmp_name'], $upload_dir.$pic['name'])){
                // Resize image to 1024 * x
                $img_size = getimagesize($upload_dir.$pic['name']);
                if($img_size[0] > 1024) {
                    require_once (ROOT . DS . 'library/SimpleImage.php');
                    $img = new SimpleImage($upload_dir.$pic['name']);
                    $img->fit_to_width(1024);
                    $img->save();
                }
                
                $image['name'] = $pic['name'];
                $image['file'] = $pic['name'];
                $image['uploader_id'] = $_SESSION['id'];
                echo json_encode($image);
            }

        }
        
        else {
            echo json_encode(array('status' => 'Valami hiba történt a feltöltés közben!'));
        }
        
    }
    
    public function xhrDropChanges() {
        
        $delete = json_decode($_POST['must_delete'], true);
        
        foreach($delete as $delete_this) {
            unlink('tmp/' . $delete_this['file']);
        }
        
    }
    
    public function xhrSaveChanges() {
        
        $images = json_decode($_POST['images'], true);
        if(isset($_POST['gallery_id'])) {
            $gallery_id = $_POST['gallery_id'];
        }
        $gallery_name = strip_tags($_POST['gallery_name']);
        $gallery_desc = strip_tags($_POST['gallery_desc']);
        
        $error = false;
        $error_desc = array();
        $i = 0;
        foreach($images as $image) {
            if(!Regex::checkImageName($image['name'])) {
                $error_desc[$i]['error'] = sprintf('Hiba a "%s" névvel. A névnek 3 és 30 karakter között kell lennie',$image['name']);
                $i++;
                $error = true;
            }
            else if(!Regex::checkImageFileName($image['file'])) {
                $error_desc[$i]['error'] = sprintf('Hiba a "%s" fájlnévvel. A névnek 5 és 50 karakter között kell lennie',$image['file']);      
                $i++;
                $error = true;
            }     
        }
         
        if(!$error) {
            if(isset($gallery_id)) {
                $this->Gallery->addImagesToGallery($gallery_id, $images);
            }

            else {
                $this->Gallery->createNewGallery($gallery_name, $gallery_desc, $images);
            }
            echo json_encode(array('status' => 'Done'));
        }
        else {
            echo json_encode($error_desc);
        }
        
    }
    
}