<?php

namespace App\Models;

use Illuminate\Support\Arr;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Storage;
use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Audience extends Model
{
    use CrudTrait;
    use HasFactory;

    protected $casts = [
        'files' => 'array'
    ];

    protected $fillable = [
        'date',
        'heur',
        'typecourt',
        'resultat',
        'dossier_justice_id',
        'court_id',
        'files'
    ];

    protected $enums = [
        'typecourt' => [
            'Inspection De Travail',
            'Le Tribunal',
            'La Cour',
            'La Cour Supreme'
        ],
        'resultat' => [
            'succès',
            'perdu',
            'reporter'
        ]
    ];

    public function uploadMultipleFilesToDisk($value, $attribute_name, $disk, $destination_path)
    {
        $request = Request::instance();
        $attribute_value = (array) $this->{$attribute_name};
        $files_to_clear = $request->get('clear_'.$attribute_name);
        // if a file has been marked for removal,
        // delete it from the disk and from the db
        if ($files_to_clear) {
            $attribute_value = (array) $this->{$attribute_name};
            foreach ($files_to_clear as $key => $filename) {
                Storage::disk($disk)->delete($filename);
                $attribute_value = Arr::where($attribute_value, function ($value, $key) use ($filename) {
                    return $value != $filename;
                });
            }
        }
        // if a new file is uploaded, store it on disk and its filename in the database
        if ($request->hasFile($attribute_name)) {
            foreach ($request->file($attribute_name) as $file) {
                if ($file->isValid()) {
                    // 1. Generate a new file name
                    $new_file_name = $file->getClientOriginalName();
                    // 2. Move the new file to the correct path
                    $file_path = $file->storeAs($destination_path, $new_file_name, $disk);
                    // 3. Add the public path to the database
                    $attribute_value[] = $file_path;
                }
            }
        }
        $this->attributes[$attribute_name] = json_encode($attribute_value);
    }
    
    public function setFilesAttribute($value)
    {
        $attribute_name = "files";
        $disk = "uploads";
        $destination_path = "uploads/folder_1/";
        

        $this->uploadMultipleFilesToDisk($value, $attribute_name, $disk, $destination_path);
    }

    public function getFilesAttribute($value)
{
    return json_decode($value, true);
}

    public function dossierJustice()
    {
        return $this->belongsTo(DossierJustice::class);
    }

    public function court()
    {
        return $this->belongsTo(Court::class);
    }

}
