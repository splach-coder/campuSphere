<?php 
class PostValidator {
    
    private $status;
    private $media;
    private $audience;
    private $errors = array();
    
    public function __construct($status, $media, $audience) {
        $this->status = $status;
        $this->media = $media;
        $this->audience = $audience;
    }
    
    public function validate() {
        // Validate status field
        if (empty($this->media) && empty($this->status)) {
            $this->errors[] = 'Status field is required';
        }

        // Validate status field
        if (empty($this->audience)) {
            $this->errors[] = "Audience field is edited please don't edit the html codes";
        }

        // Validate media files
        if (!empty($this->media) && $this->media != 'undefined') {
            // Check if files array is valid
            if (!is_array($this->media)) {
                $this->errors[] = 'Invalid media files';
            } else {
                $allowedTypes = array('image/png', 'image/jpeg', 'image/jpg', 'image/gif', 'video/mp4');
                $maxImageSize = 2 * 1024 * 1024; // 2MB
                $maxVideoSize = 5 * 1024 * 1024; // 5MB
                
                foreach ($this->media as $file) {
                    // Check file type

                    if (!in_array($file->type, $allowedTypes)) {
                        $this->errors[] = 'Invalid file type: ' . $file->name;
                    }
                    
                    // Check file size
                    if ($file->type == 'video/mp4' && $file->size > $maxVideoSize) {
                        $this->errors[] = 'File size exceeds limit: ' . $file->name;
                    } elseif (in_array($file->type, array_slice($allowedTypes, 0, 3)) && $file->size > $maxImageSize) {
                        $this->errors[] = 'File size exceeds limit: ' . $file->name;
                    }
                
                }
            }
        }
        
        // Return errors or true if validation passed
        return (empty($this->errors)) ? true : $this->errors;
    }
}
