<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Spatie\Permission\Models\Role;
use DB;
use Hash;
use JWTAuth;
use JWTAuthException;
use Auth;
class ProfileController extends Controller
{
    //
    private $user;

    public function __construct( User $user ) {
        $this->user = $user;
        // $this->middleware( 'permission:profile-show|profile-create|profile-edit|profile-delete', ['only' => ['index', 'store']] );
        // $this->middleware( 'permission:profile-create', ['only' => ['create', 'store']] );
        // $this->middleware( 'permission:profile-edit', ['only' => ['edit', 'update']] );
        // $this->middleware( 'permission:profile-delete', ['only' => ['destroy']] );
    }
    /**
    * Display a listing of the resource.
    *
    * @return \Illuminate\Http\Response
    */

    public function index( Request $request ) {
        $user = Auth::user();
        $userId = $user->id;
        $data = User::orderBy( 'id', 'DESC' )->where('id',$userId)->paginate( 5 );

        return view( 'profile.index', compact( 'data' ) )
        ->with( 'i', ( $request->input( 'page', 1 ) - 1 ) * 5 );
    }

    /**
    * Show the form for creating a new resource.
    *
    * @return \Illuminate\Http\Response
    */

    public function create() {
        $roles = Role::pluck( 'name', 'name' )->all();

        return view( 'profile.create', compact( 'roles' ) );
    }

    /**
    * Store a newly created resource in storage.
    *
    * @param \Illuminate\Http\Request $request
    *
    * @return \Illuminate\Http\Response
    */

    public function store( Request $request ) {
        $this->validate( $request, [
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|same:confirm-password',
            // 'roles' => 'required',
        ] );

        $input = $request->all();
        $input['password'] = Hash::make( $input['password'] );

        $user = User::create( $input );
        $user->assignRole( $request->input( 'roles' ) );

        return redirect()->route( 'profile.index' )
        ->with( 'success', 'Profile created successfully' );
    }

    /**
    * Display the specified resource.
    *
    * @param int $id
    *
    * @return \Illuminate\Http\Response
    */

    public function show( $id ) {
        $user = User::find( $id );

        return view( 'profile.show', compact( 'user' ) );
    }

    /**
    * Show the form for editing the specified resource.
    *
    * @param int $id
    *
    * @return \Illuminate\Http\Response
    */

    public function edit( $id ) {
        $user = User::find( $id );
        $roles = Role::pluck( 'name', 'name' )->all();
        $userRole = $user->roles->pluck( 'name', 'name' )->all();

        return view( 'profile.edit', compact( 'user', 'roles', 'userRole' ) );
    }

    /**
    * Update the specified resource in storage.
    *
    * @param \Illuminate\Http\Request $request
    * @param int                      $id
    *
    * @return \Illuminate\Http\Response
    */

    public function update( Request $request, $id ) {
        $this->validate( $request, [
            'name' => 'required',
            'email' => 'required|email|unique:users,email,'.$id,
            'password' => 'same:confirm-password',
            // 'roles' => 'required',
        ] );

        $input = $request->all();
        if ( !empty( $input['password'] ) ) {
            $input['password'] = Hash::make( $input['password'] );
        } else {
            $input = array_except( $input, array( 'password' ) );
        }

        $user = User::find( $id );
        $user->update( $input );
        // DB::table( 'model_has_roles' )->where( 'model_id', $id )->delete();

        // $user->assignRole( $request->input( 'roles' ) );

        return redirect()->route( 'profile.index' )
        ->with( 'success', 'Profile updated successfully' );
    }

    /**
    * Remove the specified resource from storage.
    *
    * @param int $id
    *
    * @return \Illuminate\Http\Response
    */

    public function destroy( $id ) {
        User::find( $id )->delete();

        return redirect()->route( 'profile.index' )
        ->with( 'success', 'Profile deleted successfully' );
    }
}