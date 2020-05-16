<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\GoogleKeyword;
use Auth;
class TrackingKeywordController extends Controller
{
    //
    public function __construct() {
        $this->middleware( 'permission:view_trackingkeyword', ['only' => ['index', 'store']] );
    }
     /**
    * Display a listing of the resource.
    *
    * @return \Illuminate\Http\Response
    */

    public function index( Request $request ) {
        $user = Auth::user();
        $userId = $user->id;

        $craws = GoogleKeyword::orderBy( 'id', 'DESC' )->where( 'user_id', $userId )->paginate( 15 );

        return view( 'trackingkeyword.index', compact( 'craws' ) )
        ->with( 'i', ( $request->input( 'page', 1 ) - 1 ) * 15 );
    }
}
