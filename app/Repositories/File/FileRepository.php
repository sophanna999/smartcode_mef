<?php
namespace App\Repositories\File;

use App\Models\BackEnd\File\File;
use Illuminate\Validation\ValidationException;
use Uuid;

class FileRepository
{
    protected $file;

    /**
     * Instantiate a new controller instance.
     *
     * @return void
     */
    public function __construct(File $file)
    {
        $this->file = $file;
    }

    public function upload($request)
    {
        $module = $request->module;
        $token = $request->token;
        $file_variables = getVar('file');

        $module_file_variables = isset($file_variables[$module]) ? $file_variables[$module] : [];

        $auth_required = isset($module_file_variables['auth_required']) ? $module_file_variables['auth_required'] : 1;
        $max_file_size = isset($module_file_variables['max_file_size']) ? $module_file_variables['max_file_size'] : 10000;
        $allowed_file_extensions = isset($module_file_variables['allowed_file_extensions']) ? $module_file_variables['allowed_file_extensions'] : ['jpg','png','jpeg','pdf','doc','docx','xls','xlsx'];
        $max_no_of_files = isset($module_file_variables['max_no_of_files']) ? $module_file_variables['max_no_of_files'] : 5;

        $file_name = $request->file->getClientOriginalName();

        $errors = collect([]);

        if (!$module || !$token) {
            $errors->push(['message' => trans('general.invalid_action')]);
        }

        if ($this->file->whereUploadToken($request->token)->where('module', '!=', $module)->count()) {
            $errors->push(['message' => trans('general.invalid_action')]);
        }

        $size = $request->file->getSize();

        if ($size > $max_file_size*1024*1024) {
            $errors->push(['message' => trans('file.file_size_exceeds')]);
        }

        $extension = $request->file->getClientOriginalExtension();

        if (!in_array($extension, $allowed_file_extensions)) {
            $errors->push(['message' => $file_name.' : '. trans('file.invalid_extension', ['extension' => $extension])]);
        }

        $existing_file = $this->file->filterByModule($module)->filterByUploadToken($token)->filterByIsTempDelete(0)->count();

        if ($existing_file >= $max_no_of_files) {
            $errors->push(['message' => trans('file.max_file_limit_crossed', ['number' => $max_no_of_files])]);
        }
  
        if(count($errors)){
            return $errors->flatten()->values()->all();
        }

        $file = $this->file;
        $file->module = $module;
        $file->module_id = $request->module_id ? : null;
        $file->upload_token = $token;
        $file->user_filename = $request->file->getClientOriginalName();
        $file->filename = $request->file->move('files/'.$module,$token.'.'.$extension);
        $file->uuid = Uuid::generate();
        $file->creatorable_id = session('sessionUser')->id;
        $file->creatorable_type = 'user';
        $file->save();

        return $file;
    }

    /**
     * Get Attachment(s) for given module.
     *
     * @param string $module
     * @param integer $module_id
     * @param string $attachment_uuid
     * @return File
     */

    public function getAttachment($module, $module_id, $attachment_uuid = null)
    {
        $attachments = $this->file->filterByModule($module)->filterByModuleId($module_id)->filterByStatus(1);

        if ($attachment_uuid) {
            $attachment = $attachments->filterByUuid($attachment_uuid)->first();

            if (! $attachment) {
                throw ValidationException::withMessages(['message' => trans('general.invalid_link')]);
            }

            return $attachment;
        }

        return $attachments->get();
    }

    /**
     * Store file to given module.
     *
     * @param string $module
     * @param integer $module_id
     * @param string $file_token
     * @return null
     */

    public function store($module, $module_id, $file_token)
    {
        $this->file->filterByModule($module)->filterByUploadToken($file_token)->update(['status' => 1,'module_id' => $module_id]);
    }

    /**
     * Update file to given module.
     *
     * @param string $module
     * @param integer $module_id
     * @param string $file_token
     * @return null
     */

    public function update($module, $module_id, $file_token)
    {
        $old_files = $this->file->filterByModule($module)->filterByModuleId($module_id)->filterByIsTempDelete(1)->get();

        foreach ($old_files as $old_file) {
            \Storage::delete($old_file->filename);
        }

        $this->file->filterByModule($module)->filterByModuleId($module_id)->filterByIsTempDelete(1)->delete();

        $this->file->filterByModule($module)->filterByUploadToken($file_token)->update(['status' => 1,'module_id' => $module_id]);
    }

    /**
     * Delete file of given module.
     *
     * @param string $module
     * @param integer $module_id
     * @return null
     */

    public function delete($module, $module_id)
    {
        $files = $this->file->filterByModule($module)->filterByModuleId($module_id)->get();

        foreach ($files as $file) {
            \Storage::delete($file->filename);
        }

        $this->file->filterByModule($module)->filterByModuleId($module_id)->delete();
    }

    /**
     * Bulk delete file of given module.
     *
     * @param string $module
     * @param array $ids
     * @return null
     */

    public function bulkDelete($module, $ids = array())
    {
        $files = $this->file->filterByModule($module)->whereIn('module_id', $ids)->get();
        foreach ($files as $file) {
            \Storage::delete($file->filename);
        }

        $this->file->filterByModule($module)->whereIn('module_id', $ids)->delete();
    }
}
