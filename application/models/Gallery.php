<?php
/**
 *  Site's gallery model
 * 
 *  TThe model for the gallery
 * 
 *  PHP version 5
 * 
 *  @author     Reményi Gergely <gergo@remenyicsalad.hu>
*/
class Gallery extends Model {
    
    
    public function getGalleryPreview() {
        $sql = 'SELECT id,name FROM galleries ORDER BY id DESC';
        $stmt = $this->sc->PDOprepare($sql);
        $res = $stmt->execute();
        
        $galleries = NULL;
        
        if($stmt->numRows() == 0) {
            return NULL;
        }
        
        $i=0;
        while($row = $stmt->fetchAssoc($res)) {
            $galleries[$i] = $row;
            $i++;
        }
        
        foreach($galleries as $key => $gallery) {
            $sql = 'SELECT i.file FROM images as i INNER JOIN gallery_image_connector as c ON i.id = c.image_id '
                    . 'WHERE c.gallery_id=? ORDER BY RAND() LIMIT 1';
            $stmt = $this->sc->PDOprepare($sql);
            if(!$res = $stmt->executeBind(array($gallery['id']))) {
                    throw new LoggableException(1024);
            }
                
            $galleries[$key]['image'] = $stmt->fetchOneData();
        }
        
        return $galleries;
        
    }
    
    public function checkGalleryExists($id) {
        $sql = 'SELECT * FROM galleries WHERE id = ? LIMIT 1;';
        $stmt = $this->sc->PDOprepare($sql);
        if(!$res = $stmt->executeBind(array($id))) {
                throw new LoggableException(1069);
        }
        
        return ($stmt->numRows() == 1);
    }
    
    public function checkImageForGallery($gallery_id, $id) {
        $sql = 'SELECT * FROM gallery_image_connector WHERE image_id = ? AND gallery_id = ? LIMIT 1;';
        $stmt = $this->sc->PDOprepare($sql);
        if(!$res = $stmt->executeBind(array($id,$gallery_id))) {
                throw new LoggableException(1069);
        }
        
        return ($stmt->numRows() == 1);
    }
    
    public function getImagesForGallery($id) {
        $sql = 'SELECT c.gallery_id, i.id, i.file, i.name, i.uploader_id FROM images as i INNER JOIN gallery_image_connector as c ON i.id = c.image_id '
                    . 'WHERE c.gallery_id=? ORDER BY i.id';
        $stmt = $this->sc->PDOprepare($sql);
        if(!$res = $stmt->executeBind(array($id))) {
                throw new LoggableException(1071);
        }
                
        $i = 0;
        $image = NULL;
        while($row = $stmt->fetchAssoc($res)) {
            $image[$i] = $row;
            $i++;
        }
        
        return $image;
    }
    
    public function getGalleryDetails($id) {
        $sql = 'SELECT * FROM galleries WHERE id = ? LIMIT 1;';
        $stmt = $this->sc->PDOprepare($sql);
        if(!$res = $stmt->executeBind(array($id))) {
            throw new LoggableException(1072);
        }
        
        return ($stmt->fetchAssoc($res));
    }
    
    public function addImagesToGallery($gallery_id, $images) {
        
        foreach($images as $key => $image) {
            
            // Name conflict
            $i = 0;
            while(file_exists(ROOT . DS . 'public/media/galleries/' . $gallery_id . DS . $images[$key]['file'])) {
                $ext_array = explode('.', $image['file']);
                $ext = array_pop($ext_array);
                $name = implode('.',$ext_array);
                $images[$key]['file'] = $name . $i . '.' .  $ext;
                $i++;
            }
            
            // Upload
            $sql = 'INSERT INTO images (name, file, uploader_id) VALUES (?,?,?);' .
                   'INSERT INTO gallery_image_connector (gallery_id, image_id) VALUES (?,(SELECT LAST_INSERT_ID()));';
            $stmt = $this->sc->PDOprepare($sql);
            if(!$stmt->executeBind(array($image['name'],$image['file'],$_SESSION['id'],$gallery_id))) {
                throw new LogabbleException(1075);
            }
            rename('tmp/' . $image['file'], ROOT . DS . 'public/media/galleries/' . $gallery_id . DS . $image['file']);
        }
        
        
        $sql = 'SELECT uploader FROM galleries WHERE id = ? LIMIT 1';
        $stmt = $this->sc->PDOprepare($sql);
        if(!$stmt->executeBind(array($gallery_id))) {
            throw new LoggableException(1089);
        }
        
        $uploader_id = $stmt->fetchOneData();
        if($uploader_id != $_SESSION['id'])
            $this->newImagesInGalleryEmail($uploader_id,count($images),$gallery_id);
        
    }
    
    public function createNewGallery($gallery_name, $gallery_desc, $images) {
        
        // Create new gallery
        $sql = 'INSERT INTO galleries (name, description, uploader) VALUES (?,?,?);';
        $stmt = $this->sc->PDOprepare($sql);
        if(!$stmt->executeBind(array($gallery_name,$gallery_desc,$_SESSION['id']))) {
            throw new LogabbleException(1076);
        }
        
        $sql1 = 'SELECT id FROM galleries WHERE uploader = ? ORDER BY id DESC LIMIT 1;';
        $stmt1 = $this->sc->PDOprepare($sql1);
        if(!$stmt1->executeBind(array($_SESSION['id']))) {
            throw new LogabbleException(1078);
        }
        
        $gallery_id = $stmt1->fetchOneData();
        
        if(!file_exists(ROOT . DS . 'public/media/galleries/' . $gallery_id))
                mkdir(ROOT . DS . 'public/media/galleries/' . $gallery_id, 0777, true);
        
        // Upload images
        foreach($images as $image) {
            $sql = 'INSERT INTO images (name, file, uploader_id) VALUES (?,?,?);' .
                   'INSERT INTO gallery_image_connector (gallery_id, image_id) VALUES (?,(SELECT LAST_INSERT_ID()));';
            $stmt = $this->sc->PDOprepare($sql);
            if(!$stmt->executeBind(array($image['name'],$image['file'],$_SESSION['id'],$gallery_id))) {
                throw new LogabbleException(1077);
            }
            
            rename('tmp/' . $image['file'], ROOT . DS . 'public/media/galleries/' . $gallery_id . DS . $image['file']);
        }
        
        $this->newGalleryEmail($gallery_name,$gallery_id);
                   
    }
    
    public function deleteGallery($id) {
        
        $sql1 = 'SELECT image_id FROM gallery_image_connector WHERE gallery_id = ?;';
        $stmt1 = $this->sc->PDOprepare($sql1);
        if(!$res1 = $stmt1->executeBind(array($id))) {
            throw new LengthException(1089);
        }
        
        $i = 0;
        $ids = NULL;
        while($row1 = $stmt1->fetchAssoc($res1)) {
            $ids[$i] = $row1['image_id'];
            $i++;
        }
        
        $this->deleteTheseImages($ids);
        
        $sql = 'DELETE FROM galleries WHERE id = ? AND uploader = ?;';
        $stmt = $this->sc->PDOprepare($sql);
        if(!$stmt->executeBind(array($id,$_SESSION['id']))) {
            throw new LoggableException(1079);
        }
           
        rmdir(ROOT . DS . 'public/media/galleries/' . $id);
        
    }
    
    public function deleteTheseImages($ids) {
        
        foreach($ids as $id) {
            // Delete from folder
            $sql1 = 'SELECT c.gallery_id,i.file FROM gallery_image_connector AS c LEFT JOIN images AS i ON c.image_id = i.id WHERE i.id = ? LIMIT 1;';
            $stmt1 = $this->sc->PDOprepare($sql1);
            if(!$res1 = $stmt1->executeBind(array($id))) {
                throw new LoggableException(1080);
            }          
            $row = $stmt1->fetchAssoc($res1);
            if(file_exists(ROOT . DS . 'public/media/galleries' . DS . $row['gallery_id'] . DS . $row['file']))
                unlink(ROOT . DS . 'public/media/galleries' . DS . $row['gallery_id'] . DS . $row['file']);
            
            // Delete from database
            $sql = 'DELETE FROM gallery_image_connector WHERE image_id = ?;' .
                   'DELETE FROM images WHERE id = ?;';
            $stmt = $this->sc->PDOprepare($sql);
            if(!$stmt->executeBind(array($id,$id))) {
                throw new LoggableException(1081);
            } 
        }
        
        
    }
    
    public function saveGalleryDetails($id,$name,$desc) {
        $sql = 'UPDATE galleries SET name = ?, description = ? WHERE id = ? AND uploader = ?;';
        $stmt = $this->sc->PDOprepare($sql);
        if(!$stmt->executeBind(array($name, $desc, $id, $_SESSION['id']))) {
            throw new LoggableException(1082);
        }
    } 
    
}