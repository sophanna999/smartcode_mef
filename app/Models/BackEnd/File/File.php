<?php

namespace App\Models\BackEnd\File;

use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    protected $fillable = [];
    protected $hidden = [
        'is_temp_delete','status','module','module_id'
    ];
    protected $primaryKey = 'id';
    protected $table = 'mef_files';

    public function scopeFilterByModule($q, $module)
    {
        if (! $module) {
            return $q;
        }

        return $q->where('module', '=', $module);
    }

    public function scopeFilterByModuleId($q, $module_id)
    {
        if (! $module_id) {
            return $q;
        }

        return $q->where('module_id', '=', $module_id);
    }

    public function scopeFilterByUploadToken($q, $file_token)
    {
        if (! $file_token) {
            return $q;
        }

        return $q->where('upload_token', '=', $file_token);
    }

    public function scopeFilterByIsTempDelete($q, $temp_delete)
    {
        return $q->where('is_temp_delete', '=', $temp_delete);
    }

    public function scopeFilterByStatus($q, $status)
    {
        return $q->where('status', '=', $status);
    }

    public function scopeFilterByUuId($q, $uuid)
    {
        return $q->where('uuid', '=', $uuid);
    }

    public function scopeFilterById($q, $id)
    {
        return $q->where('id', '=', $id);
    }
}