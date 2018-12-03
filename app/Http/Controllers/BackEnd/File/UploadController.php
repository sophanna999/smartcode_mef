<?php
namespace App\Http\Controllers\BackEnd\File;

use App\Http\Controllers\BackendController;
use Illuminate\Http\Request;
use App\Models\BackEnd\File\Upload;
use App\Http\Controllers\Controller;

Class UploadController extends Controller{

	public function upload(Request $request){

        $user_id = session('sessionUser')->id;
        $user_type = $request->user_type;

    	$extension = $request->file('file')->getClientOriginalExtension();

        $size = $request->file('file')->getSize();

        $allowed_file_extensions = config('system.file.allowed_upload_file');

    	if(!in_array($extension,$allowed_file_extensions))
    		return response()->json(['error' => trans('file.file_extension_not_allowed_to_upload')]);

        if($size > config('system.file.max_file_size_upload')*1024*1024)
            return response()->json(['error' => trans('file.file_size_greater_than_max_allowed_file_size')]);

        $max_upload = config('system.file.max_upload.'.$request->input('module')) ? : 1;

        if(!$request->input('module_id'))
            $existing_upload = Upload::whereModule($request->input('module'))
                ->whereUploadKey($request->input('key'))
                ->whereUserableId($user_id)
                ->whereUserableType($user_type)
                ->whereIsTempDelete(0)->count();
        else
        $existing_upload = Upload::where(function($query) use($request,$user_id) {
            $query->whereModule($request->input('module'))
            ->whereUploadKey($request->input('key'))
            ->whereUserableType($user_type)
            ->whereUserableId($user_id);
        })->orWhere(function($query1) use($request){
            $query1->whereModule($request->input('module'))->whereModuleId($request->input('module_id'))->whereIsTempDelete(0);
        })->count();

        if($existing_upload >= $max_upload)
    		return response()->json(['error' => trans('file.max_file_allowed',['attribute' => $max_upload])]);

        $filename_existing_upload = Upload::whereModule($request->input('module'))
            ->whereUploadKey($request->input('key'))
            ->whereUserableId($user_id)
            ->whereUserableType($user_type)
            ->whereUserFilename($request->file('file')->getClientOriginalName())
            ->count();

        if($filename_existing_upload)
            return response()->json(['error' => trans('messages.file_already_uploaded')]);

        $filename = str_random(50);

        $file = \Storage::put(
            'temp_attachments/'.$filename.'.'.$extension,
            file_get_contents($request->file('file')->getRealPath())
        );

	 	$upload = new Upload;
	 	$upload->module = $request->input('module');
	 	$upload->upload_key = $request->input('key');
	 	$upload->attachments = $filename.".".$extension;
        $upload->user_filename = $request->file('file')->getClientOriginalName();
	 	$upload->userable_id = $user_id;
	 	$upload->userable_type = $user_type;
	 	$upload->save();

	 	return response()->json(['message' => trans('file.file').''.trans('general.uploaded'),'key' => $upload->upload_key]);
	}

    public function uploadList(Request $request){

        $user_id =  $request->user_id ? : null;
        $user_type = $request->user_type ? : null;

        $uploads = Upload::whereModule($request->input('module'))
            ->whereUploadKey($request->input('key'))
            // ->whereUserableId($user_id)
            // ->whereUserableType($user_type)
            ->get();

        if(!$uploads->count())
            return;

        return view('back-end.upload.list',compact('uploads'))->render();
    }

    public function uploadDelete(Request $request){

        $upload = Upload::find($request->input('id'));

        if(!$upload)
            return response()->json(['message' => trans('general.invalid_link')],400);

        \Storage::delete('temp_attachments/'.$upload->attachments);

        $upload->delete();
        return response()->json(['message' => trans('file.file').' '.trans('general.deleted'),'status' => 'success']);
    }

    public function uploadTempDelete(Request $request){

        if(!getMode())
            return response()->json(['error' => trans('messages.disable_message')]);
        
        $upload = Upload::find($request->input('id'));

        if(!$upload)
            return response()->json(['message' => trans('messages.invalid_link'),'status' => 'error']);

        $upload->is_temp_delete = 1;
        $upload->save();
        return response()->json(['message' => trans('messages.file').' '.trans('messages.deleted'),'status' => 'success']);
    }
}