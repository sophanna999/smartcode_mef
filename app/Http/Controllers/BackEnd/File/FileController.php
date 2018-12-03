<?php

namespace App\Http\Controllers\BackEnd\File;

use JWTAuth;
use App\Models\BackEnd\File\File;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
// use Tymon\JWTAuth\Exceptions\JWTException;
use App\Http\Controllers\BackendController;

class FileController extends BackEndController
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

    protected $module = 'file';

    public function getAllowedExtension()
    {
        $file_variables = getVar('file');

        return isset($file_variables[request('module')]['allowed_file_extensions']) ? $file_variables[request('module')]['allowed_file_extensions'] : ['jpg','png','jpeg','pdf','doc','docx','xls','xlsx','txt'];
    }

    /**
     * Used to file Files
     * @post ("/api/file")
     * @param ({
     *      @Parameter("module", type="string", required="true", description="Name of module"),
     *      @Parameter("token", type="string", required="true", description="File Token from Form"),
     *      @Parameter("file", type="file", required="true", description="File to be uploaded"),
     * })
     * @return Response
     */
    public function upload(Request $request)
    {
        $upload = $this->file_repo->upload($request);

        return respose()->json(['message' => trans('upload.file_uploaded'),'upload' => $upload]);
    }

    /**
     * Used to fetch Fileed Files
     * @post ("/api/file")
     * @param ({
     *      @Parameter("module", type="string", required="true", description="Name of module"),
     *      @Parameter("module_id", type="integer", required="true", description="Id of Module"),
     * })
     * @return Response
     */
    public function fetch()
    {
        $this->file->filterByModule(request('module'))->filterByModuleId(request('module_id'))->update(['is_temp_delete' => 0]);
        return $this->file->filterByModule(request('module'))->filterByModuleId(request('module_id'))->filterByStatus(1)->get();
    }

    /**
     * Used to file Image in Summernote
     * @post ("/api/file/image")
     * @param ({
     *      @Parameter("file", type="file", required="true", description="Image file to be uploaded"),
     * })
     * @return Response
     */
    public function fileImage()
    {
        $file_path = 'files/images';

        request()->validate([
            'file' => [
                'required',
                'image',
                'mimes:jpeg,bmp,png,svg,gif'
            ],
        ], [], [
            'file' => trans('general.file')
        ]);

        $extension = request()->file('file')->getClientOriginalExtension();
        $filename = uniqid();
        $file = request()->file('file')->move($file_path, $filename.".".$extension);
        $image_url = '/'.$file_path.'/'.$filename.'.'.$extension;

        return response()->json(compact('image_url'));
    }

    /**
     * Used to delete File File
     * @post ("/api/file/{id}")
     * @param ({
     *      @Parameter("id", type="integer", required="true", description="Id of Fileed File"),
     *      @Parameter("token", type="string", required="true", description="File Token from Form"),
     *      @Parameter("module_id", type="integer", required="optional", description="Id of Module"),
     * })
     * @return Response
     */
    public function destroy($id)
    {
        $file = $this->file->find($id);

        if (!$file || $file->file_token != request('token')) {
            return response()->json(['message' => 'Invalid action!'],422);
        }

        if (request('module_id') && $file->status) {
            $this->file->filterById($id)->update(['is_temp_delete' => 1]);
        } else {
            \Storage::delete($file->filename);
            $this->file->filterById($id)->delete();
        }

        return response()->json(['message' => trans('file.file_deleted')]);
    }
}