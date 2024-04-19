<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Carbon;
use DataTables;

use App\Models\Category;
use Image;

use Yajra\DataTables\DataTables as DataTablesDataTables;
use Yajra\DataTables\Facades\DataTables as FacadesDataTables;


class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request -> ajax()) {
            $data = Category::select('*')->where('role', 1)->orderBy('created_at', 'desc')->get();
            return DataTables::of($data)  
                    ->addIndexColumn()
                    ->addColumn('action', function($record){
       
                        //    $btn = '<a href="'.route('admin.category.show', $record->id).'" class="edit btn btn-info btn-sm">View</a>';
                           $btn = '<a href="'.route('admin.category.edit', $record->id).'" class="edit btn btn-primary btn-sm">Edit</a>';
                           $btn = $btn.'<a href="'.route('admin.category.destroy', $record->id).'" class="delete btn btn-danger btn-sm">Delete</a>';
         
                            return $btn;
                    })
                    ->addColumn('image', function($record){
                        if($record->image_url && file_exists(public_path('uploads/category/'.$record->image_url)))
                            $image = '<a href="'.asset('uploads/category/'.$record->image_url).'" class="avatar image-link"><img src="'.asset('uploads/category/thumbs/'.$record->image_url).'" alt="..."></a>';
                        else
                            $image = '<span class="avatar"><img src="'.asset(AVATAR).'" alt="..."></span>';
                        return $image;
                    })
                    ->addColumn('status', function($record) {
                        $status = '<input type="checkbox" class="js-switch-small-ajax switch-status" value="'.$record->status.'" data-table="categories" data-id="'.$record->id.'" '.($record->status == '1' ? 'checked' : '').'/>';
                        return $status;
                    })
                    ->addColumn('type', function($record) {
                        $options = [
                            'domestic' => 'Domestic',
                            'wild' => 'Wild'
                        ];
                        
                        $type = '<select class="js-switch-small-ajax switch-type" data-table="categories" data-id="'.$record->id.'">';
                        foreach ($options as $value => $label) {
                            $selected = ($record->type == $value) ? 'selected' : '';
                            $type .= '<option value="'.$value.'" '.$selected.'>'.$label.'</option>';
                        }
                        $type .= '</select>';
                        
                        return $type;
                    })
                    ->rawColumns(['action', 'image', 'status', 'type'])
                    ->make(true);
        }
        
        $data['title']      = 'Category';
        $data['sub_title']  = 'Category List';
        $data['breadcrumb'] = 'Category'; 
        return view('backend.category.list', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['title']      = 'Category';
        $data['sub_title']  = 'Create New Category';
        $data['breadcrumb'] = 'Create';
        $data['action']     = route('admin.category.store');
        $data['method']     = 'post';
        return view('backend.category.create', $data); 
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
            'name' => 'required | max:100',
            'type' => 'required',
            'status' => 'required',
        ]);

        $objCat = new Category();
        $objCat->name = $request->name;
        $objCat->status = $request->status;
        $objCat->type = $request->type;
        $objCat->created_by = Auth::guard('web')->user()->id;
        $objCat->updated_by = Auth::guard('web')->user()->id;

        if ($request->hasFile('image_file')) {
            $file = $request->file('image_file');
            $filename = $file->hashName();
            $imagepath = public_path('uploads/category');
            $thumbpath = public_path('uploads/category/thumbs');
            $file->move($imagepath, $filename);
            $img = Image::make($imagepath.'/'.$filename);
            $img->fit(200, 200, function ($constraint) {
                $constraint->aspectRatio();
            })->save(); 

            $img->fit(29, 29, function ($constraint) {
                $constraint->aspectRatio();
            })->save($thumbpath.'/'.$filename);

            $objCat->image_url =  $filename;
        }

        $objCat->save();

        if($objCat->id)
            return redirect()->route('admin.category.index')->with('message', SUCOPEN.'Successfully created new category.'.CLOSE);
        else
            return redirect()->route('admin.category.index')->with('message', ERROPEN.'Failed to created new category.'.CLOSE);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data['title']      = 'Category';
        $data['sub_title']  = 'Edit Category';
        $data['breadcrumb'] = 'Edit';
        $data['action']     = route('admin.category.update', $id);
        $data['method']     = 'post';
        $data['category']       = Category::findOrFail($id);
        return view('backend.category.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name'  => 'required|max:100',
            'status' => 'required'
        ]); 


        $temp_image_url="";
        $objCat = Category::findOrFail($id);
        $objCat->name = $request->name;
        $objCat->status = $request->status;
        $objCat->type = $request->type;
        $objCat->updated_by = Auth::guard('web')->user()->id;

        if($request->hasFile('image_file'))
        {
            $file       = $request->file('image_file');
            $filename   = 'f' .Carbon::now()->timestamp. $file->hashName();
            $imagepath  = public_path('uploads/category');
            $thumbpath  = public_path('uploads/category/thumbs');
            $file->move($imagepath, $filename);
            $img        = Image::make($imagepath.'/'.$filename); 
            $img->fit(200, 200, function ($constraint) {
                $constraint->aspectRatio();
            })->save(); 

            $img->fit(29, 29, function ($constraint) {
                $constraint->aspectRatio();
            })->save($thumbpath.'/'.$filename);

            $temp_image_url = $objCat->image_url;
            $objCat->image_url =  $filename;
        }
        elseif ($objCat->image_url != $request->curr_image_url ) 
        {
            $temp_image_url = $objCat->image_url;
            $objCat->image_url = "";
        }

        $objCat->save();
        
        if($temp_image_url != "")
        {
            if(File::exists(public_path('uploads/category/').$temp_image_url))
                File::delete(public_path('uploads/category/').$temp_image_url);
            if(File::exists(public_path('uploads/category/thumbs/').$temp_image_url))
                File::delete(public_path('uploads/category/thumbs/').$temp_image_url);
        }

        if($objCat->id)
            return redirect()->route('admin.category.index')->with('message', SUCOPEN.'Successfully updated category.'.CLOSE);
        else
            return redirect()->route('admin.category.index')->with('message', ERROPEN.'Failed to update category.'.CLOSE);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $objCat = Category::findOrFail($id);
        if($objCat->image_url)
        {
            if(File::exists(public_path('uploads/category/').$objCat->image_url))
                File::delete(public_path('uploads/category/').$objCat->image_url);
            if(File::exists(public_path('uploads/category/thumbs/').$objCat->image_url))
                File::delete(public_path('uploads/category/thumbs/').$objCat->image_url);
        }
        
        $objCat->delete();
        
        return json_encode(['status' => 'success', 'title' => 'Deleted!', 'message' => 'Category has been deleted.']);
  
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\r  $r
     * @return \Illuminate\Http\Response
     */
}


