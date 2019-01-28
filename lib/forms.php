<?php
    namespace SV\Utils\Forms;

    function HandleFileUpload($uploadedFile, $saveLocation)
    {
        try {
    
            // Undefined | Multiple Files | $_FILES Corruption Attack
            // If this request falls under any of them, treat it invalid.
            if (
                !isset($uploadedFile['error']) ||
                is_array($uploadedFile['error'])
            ) {
                throw new RuntimeException('Invalid parameters.');
            }
        
            // Check uploadedFile['error'] value.
            switch ($uploadedFile['error']) {
                case UPLOAD_ERR_OK:
                    break;
                case UPLOAD_ERR_NO_FILE:
                    throw new RuntimeException('No file sent.');
                case UPLOAD_ERR_INI_SIZE:
                case UPLOAD_ERR_FORM_SIZE:
                    throw new RuntimeException('Exceeded filesize limit.');
                default:
                    throw new RuntimeException('Unknown errors.');
            }
        
            // You should also check filesize here. 
            if ($uploadedFile['size'] > 5*1024*1024) {
                throw new RuntimeException('Exceeded filesize limit.');
            }
        
            // DO NOT TRUST $_FILES['upfile']['mime'] VALUE !!
            // Check MIME Type by yourself.
            $finfo = new \finfo(FILEINFO_MIME_TYPE);
            $finfo->file($uploadedFile['tmp_name']);
                
        
            $filename = sprintf('%s/%s_%s', $saveLocation, uniqid(), $uploadedFile['name']);
            
            // You should name it uniquely.
            // DO NOT USE $_FILES['upfile']['name'] WITHOUT ANY VALIDATION !!
            // On this example, obtain safe unique name from its binary data.
            if (!move_uploaded_file(
                $uploadedFile['tmp_name'],
                $filename
            )) {
                throw new RuntimeException('Failed to move uploaded file.');
            }
        
            return $filename;
        
        } catch (RuntimeException $e) {
        
            return $e->getMessage();
        
        }
    }
?>