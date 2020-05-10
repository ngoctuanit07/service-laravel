<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DocumentController extends Controller
{
    //
    public function __construct() {
        $this->middleware( 'permission:document_show|document_create|document_edit|document_delete', ['only' => ['index', 'store']] );
        $this->middleware( 'permission:document_create', ['only' => ['create', 'store']] );
        $this->middleware( 'permission:document_edit', ['only' => ['edit', 'update']] );
        $this->middleware( 'permission:document_delete', ['only' => ['destroy']] );
    }
    public function index(){
        return view( 'admin.document' );
    }
}
