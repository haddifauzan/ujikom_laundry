<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Konsumen;

class KonsumenController extends Controller
{
    public function index()
    {
        $konsumen = Konsumen::all();
        $countKonsumen = Konsumen::count();
        $countMember = Konsumen::where('member', true)->count();
        $countNonMember = Konsumen::where('member', false)->count();
        
        return view('admin.data-konsumen.index', compact(
            'konsumen',
            'countKonsumen',
            'countMember',
            'countNonMember'
        ));
    }

    public function destroy($id)
    {
        try {
            $konsumen = Konsumen::findOrFail($id);
            $konsumen->delete();
            
            return redirect()->route('konsumen.index')
                ->with('success', 'Data konsumen berhasil dihapus!');
        } catch (\Exception $e) {
            return redirect()->route('konsumen.index')
                ->with('error', 'Gagal menghapus data konsumen!');
        }
    }
}
