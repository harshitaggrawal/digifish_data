<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;


use App\Models\data; 
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class datafetch extends Eloquent {
    public function index()
    {
        // Retrieve all documents from the MongoDB collection
        $data = data::all();
        dd($data);
        // You can return the data to a view or process it as needed
        return view('index', compact('data'));
    }

    public function show($id)
    {
        // Retrieve a single document based on the ID
        $document = data::find($id);
        dd($document);
        // You can return the document to a view or process it as needed
        return view('index', compact('document'));
    }
}
