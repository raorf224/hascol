<?php
include("../config.php");
session_start();

// Allow large file uploads
ini_set('upload_max_filesize', '128M');
ini_set('post_max_size', '128M');
ini_set('max_execution_time', '300');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Check if file was uploaded
    if (isset($_FILES['file']) && $_FILES['file']['error'] == UPLOAD_ERR_OK) {
        // Get the original file name from uploaded file
        $file_name = basename($_FILES['file']['name']);
        
        // Sanitize file name
        $file_name = preg_replace('/[^a-zA-Z0-9._-]/', '', $file_name);
        
        // Get file extension
        $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
        
        // Allowed file types - Images and Videos
        $allowed_ext = array(
            // Images
            'jpg', 'jpeg', 'png', 'gif', 'bmp', 'webp', 'svg', 'ico',
            // Videos
            'mp4', 'avi', 'mov', 'wmv', 'flv', 'mkv', 'webm', 'm4v', '3gp', 'mpeg'
        );
        
        // Check file type
        if (in_array($file_ext, $allowed_ext)) {
            $file_size = $_FILES['file']['size'];
            $max_size = 134217728; // 128 MB
            
            if ($file_size <= $max_size) {
                $file_tmp = $_FILES['file']['tmp_name'];
                $upload_dir = "../../vitalBridge_files/uploads/suspect/";
                
                // Ensure upload directory exists
                if (!file_exists($upload_dir)) {
                    mkdir($upload_dir, 0777, true);
                }
                
                $file_path = $upload_dir . $file_name;
                $file_index = 1;
                $original_name = $file_name;
                
                // If file exists, append number to avoid overwriting
                while (file_exists($file_path)) {
                    $file_info = pathinfo($original_name);
                    $file_name = $file_info['filename'] . '_' . $file_index . '.' . $file_info['extension'];
                    $file_path = $upload_dir . $file_name;
                    $file_index++;
                }
                
                // Move uploaded file
                if (move_uploaded_file($file_tmp, $file_path)) {
                    // Determine file type (image or video)
                    $file_type = 'other';
                    $image_ext = array('jpg', 'jpeg', 'png', 'gif', 'bmp', 'webp', 'svg', 'ico');
                    $video_ext = array('mp4', 'avi', 'mov', 'wmv', 'flv', 'mkv', 'webm', 'm4v', '3gp', 'mpeg');
                    
                    if (in_array($file_ext, $image_ext)) {
                        $file_type = 'image';
                    } elseif (in_array($file_ext, $video_ext)) {
                        $file_type = 'video';
                    }
                    
                    echo json_encode([
                        'status' => 'success',
                        'message' => 'File uploaded successfully',
                        'file_name' => $file_name,
                        'file_path' => $file_path,
                        'file_type' => $file_type,
                        'file_extension' => $file_ext,
                        'file_size' => $file_size
                    ]);
                } else {
                    echo json_encode([
                        'status' => 'error',
                        'message' => 'Failed to move uploaded file'
                    ]);
                }
            } else {
                echo json_encode([
                    'status' => 'error',
                    'message' => 'File size exceeds 128 MB limit'
                ]);
            }
        } else {
            echo json_encode([
                'status' => 'error',
                'message' => 'Invalid file type. Allowed: ' . implode(', ', $allowed_ext)
            ]);
        }
    } else {
        $error_msg = isset($_FILES['file']['error']) ? $_FILES['file']['error'] : 'No file uploaded';
        echo json_encode([
            'status' => 'error',
            'message' => 'File upload error: ' . $error_msg
        ]);
    }
} else {
    echo json_encode([
        'status' => 'error',
        'message' => 'Invalid request method. Use POST.'
    ]);
}
?>