<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Exception;

class Ckeditor extends Model
{
    use HasFactory;
    public static function listStudents($post)
    {
        try {
            //dd($post);
            $query = Ckeditor::select('id', 'name', 'email', 'image', 'date', 'description')
                             ->where('status', 'Y') 
                             ->get();
           
            return $query;
           
        } catch (Exception $e) {
            throw $e;
        }
    }
    
    
    public static function saveData($post)
    {
        try {
            // prepares data array
            $dataArray = [
                'name' =>$post['name'],
                'email' =>$post['email'],
                'date' =>$post['date'],
                'description' =>$post['description'],
            ];

         
          


            // if (isset($post['image'])) {
            //     // $file = $post['image'];
            //     // $filename = time() . '_' . $file->getClientOriginalName();
            //     // $filepath = $file->storeAs('images', $filename, 'public');
            //     $filename =  Common::uploadFile('post', $post['image']);
            //     if (!$filename) {
            //         return false;
            //     }
            //     $dataArray['image'] = $filename;
            // }

            if (!empty($post['image'])) {
                $fileName = Common::uploadFile('images', $post['image']);
                if (!$fileName) {
                    return false;
                }
                $dataArray['image'] = $fileName;
            }
    

    
            if (!empty($post['id'])) {
                $dataArray['updated_at'] = Carbon::now();
                if (!Ckeditor::where('id', $post['id'])->update($dataArray)) {
                    throw new Exception("Couldn't update Records", 1);
                }
            } else {
                $dataArray['created_at'] = Carbon::now();
                if (!Ckeditor::insert($dataArray)) {
                    throw new Exception("Couldn't Save Records", 1);
                }
            }
            // dd($dataArray);
            return true;
        } catch (Exception $e) {
            throw $e;
        }
    }
    public static function getData($post) {
       
        $data = Ckeditor::where('id', $post)->first();
        return $data;
    }
    


    

    public static function deleteData($post)
    {
        try {
            $info = Ckeditor::find($post['id']);
            
            if ($info) {
                $info->status = 'N'; 
                if ($info->save()) { 
                    return true;
                }
            }
    
            throw new Exception("Couldn't update the status for record with ID: {$post['id']}");
            
        } catch (Exception $e) {
            throw $e;
        }
    }
    
}