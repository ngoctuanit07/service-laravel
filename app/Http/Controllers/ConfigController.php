<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ConfigCrawCat;
use DB;
use Auth;

class ConfigController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:create_config|delete_config|view_config|edit_config', ['only' => ['index', 'store']]);
        $this->middleware('permission:create_config', ['only' => ['create', 'store']]);
        $this->middleware('permission:edit_config', ['only' => ['edit', 'update']]);
        $this->middleware('permission:delete_config', ['only' => ['destroy']]);
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

        $configs = ConfigCrawCat::orderBy('id', 'DESC')->where('user_id', $userId)->paginate(15);

        return view('config.index', compact('configs'))
        ->with('i', ($request->input('page', 1) - 1) * 15);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $craw = ConfigCrawCat::get();

        return view('config.create', compact('craw'));
    }

    public function edit($id)
    {
        $configs = ConfigCrawCat::find($id);

        return view('config.edit', compact('configs'));
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
        $url = $obj->cat_url;
        $sitemap = $obj->sitemap;
        $continuity = $obj->continuity;
        $contentfull = $obj->contentfull;
        $title = $obj->title;
        $content = $obj->content;
        $featured_image = $obj->featured_image;
        $user = Auth::user();
        $userId = $user->id;
        ConfigCrawCat::create(['title' => $title, 'content' => $content, 'featured_image' => $featured_image, 'user_id' => $userId, 'cat_url' => $url,'sitemap' => $sitemap,'continuity' => $continuity, 'contentfull' => $contentfull]);

        return redirect()->route('config.index')
        ->with('success', 'Config created successfully');
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
        $config = ConfigCrawCat::find($id);
        $config->contentfull = $request->input('contentfull');
        $config->title = $request->input('title');
        $config->content = $request->input('content');
        $config->featured_image = $request->input('featured_image');
        $config->sitemap = $request->input('sitemap');
        $config->continuity = $request->input('continuity');
        $config->cat_url = $request->input('cat_url');
        $config->save();

        return redirect()->route('config.index')
        ->with('success', 'Config updated successfully');
    }

    public function import($id)
    {
        DB::table('configcrawcat')
        ->where('id', $id)
        ->update(['status' => 1]);

        return redirect()->route('config.index')
    ->with('success', 'Import started, fun while few');
    }

    public function destroy($id)
    {
        ConfigCrawCat::find($id)->delete();

        return redirect()->route('config.index')
        ->with('success', 'Config deleted successfully');
    }
}
