<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UserFile;
use Illuminate\Http\Request;
use DataTables;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Carbon;

use Image;
use Yajra\DataTables\DataTables as DataTablesDataTables;
use Yajra\DataTables\Facades\DataTables as FacadesDataTables;


class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = User::select('*')->where('role', 1)->orderBy('created_at', 'desc')->get();
            return DataTables::of($data)  
                    ->addIndexColumn()
                    ->addColumn('action', function($record){
       
                           $btn = '<a href="'.route('admin.user.show', $record->id).'" class="edit btn btn-info btn-sm">View</a>';
                           $btn = $btn.'<a href="'.route('admin.user.edit', $record->id).'" class="edit btn btn-primary btn-sm">Edit</a>';
                           $btn = $btn.'<a href="'.route('admin.user.destroy', $record->id).'" class="delete btn btn-danger btn-sm">Delete</a>';
         
                            return $btn;
                    })
                    ->addColumn('image', function($record){
                        if($record->image_url && file_exists(public_path('uploads/user/'.$record->image_url)))
                            $image = '<a href="'.asset('uploads/user/'.$record->image_url).'" class="avatar image-link"><img src="'.asset('uploads/user/thumbs/'.$record->image_url).'" alt="..."></a>';
                        else
                            $image = '<span class="avatar"><img src="'.asset(AVATAR).'" alt="..."></span>';
                        return $image;
                    })
                    ->addColumn('status', function($record) {
                        $status = '<input type="checkbox" class="js-switch-small-ajax switch-status" value="'.$record->status.'" data-table="users" data-id="'.$record->id.'" '.($record->status == '1' ? 'checked' : '').'/>';
                        return $status;
                    })
                    ->rawColumns(['action', 'image', 'status'])
                    ->make(true);
        }

        $data['title']      = 'User';
        $data['sub_title']  = 'User List';
        $data['breadcrumb'] = 'User'; 
        return view('backend.user.list', $data);
    } 

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */ 
    public function create()

    


    {
        
        $data['title']      = 'User';
        $data['sub_title']  = 'Create New User';
        $data['breadcrumb'] = 'Create';
        $data['action']     = route('admin.user.store');
        $data['method']     = 'post';
        
        return view('backend.user.create', $data); 
    }

    

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name'  => 'required|max:100',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|confirmed|min:6',
            // 'image_file' => 'required|image|mimes:jpeg,png,jpg',
            'files.*' => 'required|file|mimes:jpg,jpeg,png,pdf',
            'status' => 'required'
        ]); 

        $objUser = new User();
        $objUser->name = $request->name;
        $objUser->email = $request->email;
        $objUser->password = Hash::make($request->password);
        $objUser->phone = $request->phone;
        $objUser->status = $request->status;
        $objUser->created_by = Auth::guard('web')->user()->id;
        $objUser->updated_by = Auth::guard('web')->user()->id;
        

        if($request->hasFile('image_file')){
            $file       = $request->file('image_file');
            $filename   = $file->hashName();
            $imagepath  = public_path('uploads/user');
            $thumbpath  = public_path('uploads/user/thumbs');
            $file->move($imagepath, $filename);
            $img        = Image::make($imagepath.'/'.$filename); 
            $img->fit(200, 200, function ($constraint) {
                $constraint->aspectRatio();
            })->save(); 

            $img->fit(29, 29, function ($constraint) {
                $constraint->aspectRatio();
            })->save($thumbpath.'/'.$filename);

            $objUser->image_url =  $filename; 
        }


        

        $objUser->save();

        if($objUser->id) {

            $user_id = $objUser->id;

            
            $fileData = [];
            if ($files = $request->file('files')) {

                foreach($files as $key => $file) {

                    $originalFilename = $file->getClientOriginalName();
                    $extension = $file->getClientOriginalExtension();
                    $filename = $key.'-'.time(). '.' .$extension;

                    $path = 'uploads/userdocs/' . $originalFilename;
                    $file->move(public_path('uploads\userdocs'), $filename);

                    $fileData[] = [
                        'user_id' => $user_id,
                        'file_name' => $originalFilename,
                        'file_path' => $path,
                    ];
                }

            }

            UserFile::insert($fileData);
    
            // Redirect with success message
            return redirect()->route('admin.user.index')->with('message', SUCOPEN.'Successfully created new user.'.CLOSE);
        }else {
            // Redirect with error message if user creation failed
            return redirect()->route('admin.user.index')->with('message', ERROPEN.'Failed to create new user.'.CLOSE);
        }
    }
    /**
     * Display the specified resource.
     *
     * @param  \App\Models\r  $r
     * @return \Illuminate\Http\Response
     */

    public function show($id)
    {
        
        $data['title']      = 'User';
        $data['sub_title']  = 'User Details'; 
        $data['breadcrumb'] = 'View';
        $data['user']   = User::findOrFail($id);
        $data['files'] = $data['user']->files;

        return view('backend.user.view', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\r  $r    
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data['title']      = 'User';
        $data['sub_title']  = 'Edit User';
        $data['breadcrumb'] = 'Edit';
        $data['action']     = route('admin.user.update', $id);
        $data['method']     = 'post';
        $data['user']       = User::findOrFail($id);
        $data['userFiles'] = UserFile::where('user_id', $id)->get();

        return view('backend.user.edit', $data); 
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\r  $r
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name'  => 'required|max:100',
            'email' => 'email|unique:users,email',
            'status' => 'required',
            'files.*' => 'required|file|mimes:jpg,jpeg,png,pdf',
        ]); 

        // dd($request);

        $temp_image_url="";
        $objUser = User::findOrFail($id);
        $objUser->name = $request->name;
        if(isset($request->password) || trim($request->password) != '')
        {
            $objUser->password = Hash::make($request->password);
        }
        $objUser->phone = $request->phone;
        $objUser->status = $request->status;
        $objUser->updated_by = Auth::guard('web')->user()->id;
    
        if($request->hasFile('image_file'))
        {
            $file       = $request->file('image_file');
            $filename   = 'f' .Carbon::now()->timestamp. $file->hashName();
            $imagepath  = public_path('uploads/user');
            $thumbpath  = public_path('uploads/user/thumbs');
            $file->move($imagepath, $filename);
            $img        = Image::make($imagepath.'/'.$filename); 
            $img->fit(200, 200, function ($constraint) {
                $constraint->aspectRatio();
            })->save(); 

            $img->fit(29, 29, function ($constraint) {
                $constraint->aspectRatio();
            })->save($thumbpath.'/'.$filename);

            $temp_image_url = $objUser->image_url;
            $objUser->image_url =  $filename;
        }
        elseif ($objUser->image_url != $request->curr_image_url ) 
        {
            $temp_image_url = $objUser->image_url;
            $objUser->image_url = "";
        }

        if ($request->has('remove_files')) {
            foreach ($request->input('remove_files') as $fileId) {
                // Find the file by its ID
                $file = UserFile::find($fileId);
                if ($file) {
                    // Delete the file from storage
                    Storage::delete($file->file_path);
                    // Delete the record from the database
                    $file->delete();
                }
            }
        }
    

        $objUser->save();

        if($objUser->id) {

            $user_id = $objUser->id;

            $fileData = [];
            if ($files = $request->file('files')) {

                foreach($files as $key => $file) {

                    $originalFilename = $file->getClientOriginalName();
                    $extension = $file->getClientOriginalExtension();
                    $filename = $key.'-'.time(). '.' .$extension;

                    $path = 'uploads/userdocs/' . $originalFilename;
                    $file->move(public_path('uploads\userdocs'), $originalFilename);

                    $fileData[] = [
                        'user_id' => $user_id,
                        'file_name' => $originalFilename,
                        'file_path' => $path,
                    ];
                }

            }

            UserFile::insert($fileData);



        if($temp_image_url != "")
        {
            if(File::exists(public_path('uploads/user/').$temp_image_url))
                File::delete(public_path('uploads/user/').$temp_image_url);
            if(File::exists(public_path('uploads/user/thumbs/').$temp_image_url))
                File::delete(public_path('uploads/user/thumbs/').$temp_image_url);
        }

        if($objUser->id) {
            return redirect()->route('admin.user.index')->with('message', SUCOPEN.'Successfully updated user.'.CLOSE);
        }else{
            return redirect()->route('admin.user.index')->with('message', ERROPEN.'Failed to update user.'.CLOSE);
        }
    }
}

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\r  $r
     * @return \Illuminate\Http\Response
     */


    public function destroy($id)
    {
        $objUser = User::findOrFail($id);
        if($objUser->image_url)
        {
            if(File::exists(public_path('uploads/user/').$objUser->image_url))
                File::delete(public_path('uploads/user/').$objUser->image_url);
            if(File::exists(public_path('uploads/user/thumbs/').$objUser->image_url))
                File::delete(public_path('uploads/user/thumbs/').$objUser->image_url);
        }
        
        $objUser->delete();
        
        return json_encode(['status' => 'success', 'title' => 'Deleted!', 'message' => 'User has been deleted.']);
    }

     /**
     * Display the specified resource.
     *
     * @param  \App\Models\r  $r
     * @return \Illuminate\Http\Response
     */
    public function profileView($id)
    {
        //
        $data['title']      = 'User';
        $data['sub_title']  = 'My Profile Details';
        $data['breadcrumb'] = 'View';
        $data['user']   = User::findOrFail($id);
        return view('backend.user.profile-view', $data);
    }

    public function removeFile($userId, $fileId)
    {
        // Logic to remove the file
        // For example:
        $file = UserFile::find($fileId);
        if ($file) {
            // Delete the file from storage
            Storage::delete($file->file_path);
            
            // Delete the record from the database
            $file->delete();

            // Redirect back with success message
            return redirect()->back()->with('message', 'File removed successfully.');
        } else {
            // Redirect back with error message
            return redirect()->back()->with('error', 'File not found.');
        }
    }

    public function downloadFile($id) {
       
        $path = UserFile::where('id', $id)->value('file_name');
        
        $filePath = public_path('uploads/userdocs/' . $path);
        if (!file_exists($filePath)) {
            return response()->json(['error' => 'File not found'], 404);
        }

        return response()->download($filePath);
    }

}
