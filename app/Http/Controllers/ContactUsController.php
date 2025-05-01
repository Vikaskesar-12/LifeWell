<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contact;

class ContactUsController extends Controller
{
    public function index()
    {
        return view('backend.contact.index');
    }

    public function displayData(Request $request){
            $perPage      = 10; 
            $currentPage  = $request->input('page', 1); 
            $skip         = ($currentPage - 1) * $perPage; 
            $total        = Contact::search($request)->count();
            $data         = Contact::search($request)->skip($skip)
                                ->take($perPage)
                                ->get();
            $totalPages = ceil($total / $perPage);
            return response()->json([
                'status'        => true,
                'data'          => $data,
                'total'         => $total,
                'currentPage'   => $currentPage,
                'totalPages'    => $totalPages,
                'perPage'       => $perPage
            ]);
    
        }
}
