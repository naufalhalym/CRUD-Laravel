<?php

namespace App\Http\Controllers\Api\Admin;

use App\Models\Pendaftaran;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Http\Resources\PendaftaranResource;
use Illuminate\Support\Facades\Validator;

class PendaftaranController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    { //get categories
        $pendaftarans = Pendaftaran::when(request()->q, function ($pendaftarans) {
            $pendaftarans = $pendaftarans->where('nomor', 'like', '%' . request()->q .
                '%');
        })->latest()->paginate(5);
        //return with Api Resource
        return new PendaftaranResource(true, 'List Data Pendaftaran', $pendaftarans);
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nomor' => 'required|unique:pendaftarans',
            'nama' => 'required',
            'kompetensi' => 'required',
            'hobby' => 'required',
            'profil' => 'required'
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        //create category
        $pendaftaran = Pendaftaran::create([
            'nomor' => $request->nomor,
            'nama' => $request->nama,
            'kompetensi' => $request->kompetensi,
            'hobby' => $request->hobby,
            'profil' => $request->profil,
            'slug' => Str::slug($request->nomor, '-')
        ]);
        if ($pendaftaran) {
            //return success with Api Resource
            return new PendaftaranResource(
                true,
                'Data Category Berhasil Disimpan!',
                $pendaftaran
            );
        }
        //return failed with Api Resource

    }
    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $pendaftaran = Pendaftaran::whereId($id)->first();
        if ($pendaftaran) { //return success with Api Resource
            return new PendaftaranResource(true, 'Detail Data Category!', $pendaftaran);
        }
        //return failed with Api Resource
        return new PendaftaranResource(false, 'Detail Data Category Tidak
DItemukan!', null);
    }
    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Pendaftaran $pendaftaran)
    {
        $validator = Validator::make($request->all(), [
            'nomor' => 'required',
            'nama' => 'required',
            'kompetensi' => 'required',
            'hobby' => 'required',
            'profil' => 'required'
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $pendaftaran->update([
            'nomor' => $request->nomor,
            'nama' => $request->nama,
            'kompetensi' => $request->kompetensi,
            'hobby' => $request->hobby,
            'profil' => $request->profil,
            'slug' => Str::slug($request->nomor, '-')
        ]);

        if ($pendaftaran) {
            //return success with Api Resource
            return new PendaftaranResource(
                true,
                'Data Pendaftaran Berhasil Diupdate!',
                $pendaftaran
            );
        }
        //return failed with Api Resource
        return new PendaftaranResource(false, 'Data Category Gagal Diupdate!', null);
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Pendaftaran $pendaftaran)
    {
        if ($pendaftaran->delete()) {
            //return success with Api Resource
            return new PendaftaranResource(
                true,
                'Data Pendaftaran Berhasil Dihapus!',
                null
            );
        }
        //return failed with Api Resource
        return new PendaftaranResource(false, 'Data Pendaftaran Gagal Dihapus!', null);
    }
}
