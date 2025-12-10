<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Promo;
use App\Models\Magazine;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\PromoExport;

class PromoController extends Controller
{
    /**
     * Tampilkan semua data promo
     */
    public function index()
    {
        $promos = Promo::all();
        return view('admin.promo.index', compact('promos'));
    }

    /**
     * Form tambah promo
     */
    public function create()
    {
        return view('admin.promo.create');
    }

    /**
     * Simpan promo baru
     */
    public function store(Request $request)
    {
        $request->validate([
            'promo_code' => 'required|unique:promos,promo_code',
            'type' => 'required|in:percent,rupiah',
            'discount' => 'required|numeric|min:1',
        ]);

        // Validasi diskon
        if ($request->type === 'percent' && $request->discount > 100) {
            return back()->withErrors(['discount' => 'Diskon dalam persen tidak boleh lebih dari 100%'])->withInput();
        }

        if ($request->type === 'rupiah' && $request->discount < 500) {
            return back()->withErrors(['discount' => 'Diskon dalam rupiah minimal Rp 500'])->withInput();
        }

        Promo::create([
            'promo_code' => strtoupper($request->promo_code),
            'type' => $request->type,
            'discount' => $request->discount,
            'actived' => 1
        ]);

        return redirect()->route('admin.promos.index')->with('success', 'Promo berhasil ditambahkan');
    }

    /**
     * Form edit promo
     */
    public function edit($id)
    {
        $promo = Promo::findOrFail($id);
        return view('admin.promo.edit', compact('promo'));
    }

    /**
     * Update data promo
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'promo_code' => 'required|unique:promos,promo_code,' . $id,
            'type' => 'required|in:percent,rupiah',
            'discount' => 'required|numeric|min:1',
        ]);

        // Validasi diskon berdasarkan type
        if ($request->type === 'percent' && $request->discount > 100) {
            return back()->withErrors(['discount' => 'Diskon dalam persen tidak boleh lebih dari 100%'])->withInput();
        }

        if ($request->type === 'rupiah' && $request->discount < 500) {
            return back()->withErrors(['discount' => 'Diskon dalam rupiah minimal Rp 500'])->withInput();
        }

        $promo = Promo::findOrFail($id);
        $promo->update([
            'promo_code' => strtoupper($request->promo_code),
            'type' => $request->type,
            'discount' => $request->discount,
        ]);

        return redirect()->route('admin.promos.index')->with('success', 'Promo berhasil diperbarui');
    }

    /**
     * Toggle status aktif/nonaktif promo
     */
    public function patch($id)
    {
        $promo = Promo::findOrFail($id);

        // Toggle status: jika aktif maka nonaktifkan, jika nonaktif maka aktifkan
        $promo->actived = !$promo->actived;
        $promo->save();

        // Pesan notifikasi sesuai kondisi
        $status = $promo->actived ? 'diaktifkan' : 'dinonaktifkan';

        return redirect()->route('admin.promos.index')->with('success', "Promo berhasil $status.");
    }

    /**
     * Soft delete promo
     */
public function destroy($id)
{
//     $promo = Promo::find(1);
// dd($promo->magazines);

    $promo = Promo::findOrFail($id);

    // Cek apakah promo sedang digunakan oleh majalah
    if ($promo->magazines()->count() > 0) {
        return redirect()->back()->with('error', 'Tidak dapat menghapus promo karena sedang digunakan oleh beberapa majalah.');
    }

    // Jika tidak digunakan, hapus promo
    $promo->delete();

    return redirect()->route('admin.promos.index')->with('success', 'Promo berhasil dihapus sementara!');
}


    /**
     * Tampilkan promo yang dihapus
     */
    public function trash()
    {
        $promoTrash = Promo::onlyTrashed()->get();
        return view('admin.promo.trash', compact('promoTrash'));
    }

    /**
     * Restore promo dari trash
     */
    public function restore($id)
    {
        $promo = Promo::onlyTrashed()->findOrFail($id);
        $promo->restore();

        return redirect()->route('admin.promos.trash')->with('success', 'Promo berhasil dikembalikan.');
    }

    /**
     * Hapus permanen promo
     */
    public function deletePermanent($id)
    {
        $promo = Promo::onlyTrashed()->findOrFail($id);

        // Cek apakah promo sedang digunakan oleh majalah
        if ($promo->magazines()->count() > 0) {
            return redirect()->back()->with('error', 'Tidak dapat menghapus permanen promo karena sedang digunakan oleh beberapa majalah.');
        }

        $promo->forceDelete();
        return redirect()->route('admin.promos.trash')->with('success', 'Promo dihapus permanen.');
    }

    /**
     * Export ke Excel
     */
    public function export()
    {
        $fileName = 'data-promo-' . date('Y-m-d') . '.xlsx';
        return Excel::download(new PromoExport, $fileName);
    }

    /**
     * Tampilkan majalah yang menggunakan promo tertentu
     */
    public function magazines($id)
    {
        $promo = Promo::with('magazines')->findOrFail($id);
        return view('admin.promo.magazines', compact('promo'));
    }

    /**
     * Apply promo to magazine
     */
    public function applyToMagazine(Request $request, $id)
    {
        $request->validate([
            'magazine_id' => 'required|exists:magazines,id'
        ]);

        $promo = Promo::findOrFail($id);
        $magazine = Magazine::findOrFail($request->magazine_id);

        $magazine->update(['promo_id' => $id]);

        return redirect()->back()->with('success', 'Promo berhasil diterapkan ke majalah: ' . $magazine->title);
    }

    /**
     * Remove promo from magazine
     */
    public function removeFromMagazine(Request $request, $id)
    {
        $request->validate([
            'magazine_id' => 'required|exists:magazines,id'
        ]);

        $magazine = Magazine::findOrFail($request->magazine_id);
        $magazine->update(['promo_id' => null]);

        return redirect()->back()->with('success', 'Promo berhasil dihapus dari majalah: ' . $magazine->title);
    }
}
