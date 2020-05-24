<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Proxy;
use Auth;
class ProxyController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:proxy_create|proxy_delete|proxy_edit|proxy_view', ['only' => ['index', 'store']]);
        $this->middleware('permission:proxy_create', ['only' => ['create', 'store']]);
        $this->middleware('permission:proxy_edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:proxy_delete', ['only' => ['destroy']]);
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

        $proxys = Proxy::orderBy('created_at', 'DESC')->where('user_id', $userId)->paginate(15);

        return view('proxy.index', compact('proxys'))
        ->with('i', ($request->input('page', 1) - 1) * 15);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
         $config = Proxy::get();

        return view('proxy.create', compact('config'));
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
         $userId = $user->id;
         Proxy::create(['url' => $url,  'user_id' => $userId, 'status' => $status]);
        return redirect()->route('proxy.index')
        ->with('success', 'Proxy created successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
         $proxys = Proxy::find($id);

        return view('proxy.edit', compact('proxys'));
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
        $proxy = Proxy::find($id);
        $proxy->url = $request->input('url');
        $proxy->status = $request->input('status');
        $userId = $user->id;
        $proxy->user_id = $userId;
        $config->save();
        return redirect()->route('proxy.index')
        ->with('success', 'Proxy updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Proxy::find($id)->delete();

        return redirect()->route('proxy.index')
        ->with('success', 'Proxy deleted successfully');
    }
}
