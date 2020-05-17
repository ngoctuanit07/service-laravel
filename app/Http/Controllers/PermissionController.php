<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use DB;
class PermissionController extends Controller
{
    //
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $permission = Permission::orderBy('created_at', 'DESC')->paginate(5);

        return view('permission.index', compact('permission'))
            ->with('i', ($request->input('page', 1) - 1) * 5);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $permissions = Permission::get();

        return view('permission.create', compact('permissions'));
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
        $this->validate($request, [
            'name' => 'required|unique:permissions,name',
        ]);

        $permissions = Permission::create(['name' => $request->input('name'),'guard_name' => 'web' ]);
       // $Permissions->syncPermissions($request->input('Permissions'));

        return redirect()->route('permission.index')
                        ->with('success', 'Permissions created successfully');
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
        $permissions = Permission::find($id);

        return view('permission.show', compact('permissions'));
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
        $permissions = Permission::find($id);
        // $Permissions = Permissions::get();
        // $PermissionsPermissions = DB::table('Permissions_has_Permissions')->where('Permissions_has_Permissions.Permissions_id', $id)
        //     ->pluck('Permissions_has_Permissions.Permissions_id', 'Permissions_has_Permissions.Permissions_id')
        //     ->all();

        return view('permission.edit', compact('permissions'));
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
        $this->validate($request, [
            'name' => 'required',
        ]);

        $permissions = Permission::find($id);
        $permissions->name = $request->input('name');
        $permissions->save();

      //  $Permissions->syncPermissions($request->input('Permissions'));

        return redirect()->route('permission.index')
                        ->with('success', 'Permissions updated successfully');
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
        DB::table('Permissions')->where('id', $id)->delete();

        return redirect()->route('permission.index')
                        ->with('success', 'Permissions deleted successfully');
    }
}
