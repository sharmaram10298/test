<?php

namespace App\Http\Controllers;
use App\Exports\ItemsExport;
use Maatwebsite\Excel\Facades\Excel;  // Make sure to import the Excel facade

use Illuminate\Http\Request;
use App\Models\Item;

use App\Imports\ItemsImport;

class ItemController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
{
    $items = Item::all();
    return view('index', compact('items'));
}


    /**
     * Show the form for creating a new resource.
     */
    public function create()
{
    return view('create');
}


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'age' => 'required',
            'gender' => 'required',
            'email' => 'required',
            'phone' => 'required',
            'address' => 'required',
            'city' => 'required',
            'state' => 'required',
        ]);
    
        Item::create($request->all());
        return redirect()->route('index')->with('success', 'Item created successfully.');
    }
    

    /**
     * Display the specified resource.
     */
    public function show(Item $item)
{
    return view('show', compact('item'));
}


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Item $item)
{
    return view('edit', compact('item'));
}


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Item $item)
{
    $request->validate([
        'name' => 'required',
        'age' => 'required',
        'gender' => 'required',
        'email' => 'required',
        'phone' => 'required',
        'address' => 'required',
        'city' => 'required',
        'state' => 'required',
    ]);

    $item->update($request->all());
    return redirect()->route('index')->with('success', 'Item updated successfully.');
}
    

    /**
     * Remove the specified resource from storage.
     */
   public function destroy(Item $item)
{
    $item->delete();
    return redirect()->back()->with('success', 'Item deleted successfully.');
}





/**
 * Import items from Excel.
 */
public function importCsv(Request $request)
{
    // Validate file
    $request->validate([
        'file' => 'required|mimes:csv,txt|max:2048',
    ]);

    // Read the CSV file
    $file = $request->file('file');
    $data = array_map('str_getcsv', file($file));

    // Process each row and insert into database
    foreach ($data as $row) {
        // Assuming the columns in the CSV match your table
        Item::create([
            'name' => $row[1],
            'age' => $row[2],
            'gender' => $row[3],
            'email' => $row[4],
            'phone' => $row[5],
            'address' => $row[6],
            'city' => $row[7],
            'state' => $row[8],
        ]);
    }

    return redirect()->back()->with('success', 'Item import successfully.'); 
}
}
