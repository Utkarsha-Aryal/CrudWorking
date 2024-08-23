<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Common extends Model
{
    use HasFactory;
    public static function uploadFile($directory,$file)
    {
        try {
            // Ensure $file is an instance of UploadedFile
            if (!$file instanceof \Illuminate\Http\UploadedFile) {
                throw new \Exception("Invalid file upload.");
            }
    
            // Generate a unique filename with timestamp and original name
            $filename = time() . '_' . $file->getClientOriginalName();
    
            // Store the file in the specified directory within the 'public' disk
            $filepath = $file->storeAs($directory, $filename, 'public');
    
            // Check if the file was successfully stored
            if ($filepath) {
                return $filename; // Return the filename if successful
            } else {
                throw new \Exception("File storage failed.");
            }
        } catch (\Exception $e) {
            \Log::error("File upload error: " . $e->getMessage()); // Log the error
            return false; // Return false if an error occurs
        }
    }

    public static function deleteSingleData($post, $model,  $status)
    {
        try {
            // Ensure 'id' and 'status' are present in the post data
            if (empty($post['id']) || empty($status)) {
                throw new Exception("Record ID or status is missing.");
            }

            // Find the record by ID
            
            $record = $model::find($post['id']);
            if (!$record) {
                throw new Exception("Record not found.");
            }

            // Update the status
            $record->status = $status;
            if ($record->save()) {
                return true;
            }

            throw new Exception("Couldn't update the status for record with ID: {$post['id']}");
            
        } catch (Exception $e) {
            \Log::error("Update status error: " . $e->getMessage()); // Log the error
            return false; // Return false if an error occurs
        }
    }
    


}
