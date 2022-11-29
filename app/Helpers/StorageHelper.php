<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Storage;

class StorageHelper
{
    private $fieldName;
    private $file;
    private $model;
    private $filename;

    public function __construct($fieldName, $file)
    {
        $this->fieldName = $fieldName;
        $this->file = $file;        
    }

    public function model(object $model)
    {
        $this->model = $model;
        return $this;
    }

    public function image()
    {
        $fieldName = $this->fieldName; 
        if ($this->file)
        {
            $this->filename = md5(uniqid()).'.'.$this->file->getClientOriginalExtension();
        }
        elseif ($this->model->$fieldName)
        {
            $this->filename = $this->model->$fieldName;
        }
        else
        {
            $this->filename = null;
        }
        return $this;
    }

    public function saveImage($path)
    {
        if ($this->file)
        {
            Storage::putFileAs($path, $this->file, $this->filename);
        }
        $this->destroyImage($path);
        return $this->filename;
    }

    public function destroyImage($path)
    {
        $fieldName = $this->fieldName;
        if ($this->model->$fieldName && Storage::exists($path.'/'.$this->model->$fieldName))
        {
            Storage::delete($path.'/'.$this->model->$fieldName);
        }
    }

}