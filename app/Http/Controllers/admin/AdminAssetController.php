<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Flavy;

class AdminAssetController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return view('admin.assets.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('admin.assets.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $file = $request->file('file');

        $name = time() . md5($file->getClientOriginalName()) . $file->getClientOriginalName();

        $path = '/assets/' . $name;

        $file->move('assets', $path);

        $extension = pathinfo($path, PATHINFO_EXTENSION);

        Flavy::thumbnail($path, '/assets/thumb.jpg', 10); //Make 10 thumbnail and calculate time interval $duration/$count

        $asset = Asset::create([
          'title' => $name,
          'path' => $path,
          'format' => $extension,
          'user_id' => Auth::user()->id
        ]);
        //
        // echo $asset->id;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        $path = 'assets/1499233000860a7bac22cda073cb9c80e2e07ccb9djl.mp4';
        Flavy::thumbnail($path, 'assets/thumb.jpg', 10); //Make 10 thumbnail and calculate time interval $duration/$count
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
