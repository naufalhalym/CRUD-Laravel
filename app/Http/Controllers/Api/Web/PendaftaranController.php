<?php

namespace App\Http\Controllers\Api\Web;

use App\Http\Controllers\Controller;
use App\Http\Resources\PendaftaranResource;
use App\Models\Pendaftaran;
use Illuminate\Http\Request;

class PendaftaranController extends Controller
{
    /**
     * index
     *
     * @return void
     */
    public function index()
    {
        $pendaftarans = Pendaftaran::latest()->paginate(10);
        //return with Api Resource
        return new PendaftaranResource(true, 'List Data Categories', $pendaftarans);
    }
    /**
     * show
     *
     * @param mixed $slug
     * @return void
     */
    public function show($slug)
    {
        $pendaftaran = Pendaftaran::with('posts.pendaftaran', 'posts.comments')->where('slug', $slug)->first();
        if ($pendaftaran) {
            //return with Api Resource
            return new PendaftaranResource(
                true,
                'List Data Post By Category',
                $pendaftaran
            );
        }
        //return with Api Resource
        return new PendaftaranResource(
            false,
            'Data Category Tidak Ditemukan!',
            null
        );
    }
    /**
     * categorySidebar
     *
     * @return void
     */
    public function PendaftaranSidebar()
    {
        $pendaftarans = Pendaftaran::orderBy('nama', 'ASC')->get();
        //return with Api Resource
        return new PendaftaranResource(
            true,
            'List Data Pendaftaran Sidebar',
            $pendaftarans
        );
    }
}
