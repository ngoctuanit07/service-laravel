<?php

namespace App\Http\Controllers;

use App\TrackingKeyword;
use Illuminate\Http\Request;
use Auth;

class ConfigTrackingKeywordController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:configtracking_create|configtracking_delete|configtracking_edit|configtracking_view', ['only' => ['index', 'store']]);
        $this->middleware('permission:configtracking_create', ['only' => ['create', 'store']]);
        $this->middleware('permission:configtracking_edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:configtracking_delete', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        $userId = $user->id;

        $configs = TrackingKeyword::orderBy('created_at', 'DESC')->where('user_id', $userId)->paginate(15);

        return view('configtracking.index', compact('configs'))
        ->with('i', ($request->input('page', 1) - 1) * 15);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $config = TrackingKeyword::get();

        return view('configtracking.create', compact('config'));
    }

    public function edit($id)
    {
        $configs = TrackingKeyword::find($id);

        return view('configtracking.edit', compact('configs'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $arrJson = $request->post();
        $obj = (object) $arrJson;
        $url = $obj->url;
        $status = $obj->status;
        $user = Auth::user();
       
        if ($request->hasFile('credentials')) {
             $userId = $user->id;
            //Storage::delete('/public/avatars/'.$user->avatar);

            // Get filename with the extension
            $filenameWithExt = $request->file('credentials')->getClientOriginalName();
            //Get just filename
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            // Get just ext
            $extension = $request->file('credentials')->getClientOriginalExtension();
            // Filename to store
            $fileNameToStore = $filename.'.'.$extension;
            // Upload Image
            $path = $request->file('credentials')->storeAs('/', $fileNameToStore);

            $credentials = $fileNameToStore;
            TrackingKeyword::create(['url' => $url,  'user_id' => $userId, 'status' => $status,'credentials' => $credentials]);
        }
        return redirect()->route('configtracking.index')
        ->with('success', 'Configtracking created successfully');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int                      $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $user = Auth::user();
        $config = TrackingKeyword::find($id);
        $config->url = $request->input('url');
        $config->status = $request->input('status');
        $userId = $user->id;
        $config->user_id = $userId;
        if ($request->hasFile('credentials')) {
           
           //Storage::delete('/public/avatars/'.$user->avatar);

           // Get filename with the extension
           $filenameWithExt = $request->file('credentials')->getClientOriginalName();
           //Get just filename
           $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
           // Get just ext
           $extension = $request->file('credentials')->getClientOriginalExtension();
           // Filename to store
           $fileNameToStore = $filename.'.'.$extension;
           // Upload Image
           $path = $request->file('credentials')->storeAs('/', $fileNameToStore);

           $credentials = $fileNameToStore;
           $config->credentials =  $credentials;
       }
        $config->save();

        return redirect()->route('configtracking.index')
        ->with('success', 'Config tracking updated successfully');
    }

    public function destroy($id)
    {
        TrackingKeyword::find($id)->delete();

        return redirect()->route('configtracking.index')
        ->with('success', 'CrawCat deleted successfully');
    }
}
