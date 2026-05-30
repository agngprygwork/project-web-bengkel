<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Sparepart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class SparepartController extends Controller
{
    /**
     * Display a listing of spareparts.
     */
    public function index(Request $request)
    {
        $query = Sparepart::query();

        // Filter by low stock
        if ($request->has('low_stock') && $request->low_stock == 1) {
            $query->whereRaw('stok <= stok_minimum');
        }

        // Filter by active status
        if ($request->has('is_active') && $request->is_active != 'all') {
            $query->where('is_active', $request->is_active == 'active');
        }

        // Search by name or code
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama_sparepart', 'like', "%{$search}%")
                    ->orWhere('kode_sparepart', 'like', "%{$search}%")
                    ->orWhere('merk', 'like', "%{$search}%");
            });
        }

        $spareparts = $query->orderBy('nama_sparepart')->paginate(15);

        // Statistics
        $stats = [
            'total' => Sparepart::count(),
            'active' => Sparepart::where('is_active', true)->count(),
            'inactive' => Sparepart::where('is_active', false)->count(),
            'low_stock' => Sparepart::whereRaw('stok <= stok_minimum')->count(),
            'total_value' => Sparepart::sum(DB::raw('stok * harga_jual')),
        ];

        return view('pages.admin.spareparts.index', compact('spareparts', 'stats'));
    }

    /**
     * Show the form for creating a new sparepart.
     */
    public function create()
    {
        return view('pages.admin.spareparts.create');
    }

    /**
     * Store a newly created sparepart.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_sparepart' => 'required|string|max:255',
            'merk' => 'nullable|string|max:100',
            'stok' => 'required|integer|min:0',
            'stok_minimum' => 'required|integer|min:0',
            'harga_beli' => 'required|numeric|min:0',
            'harga_jual' => 'required|numeric|min:0|gt:harga_beli',
            'satuan' => 'required|string|max:20',
            'deskripsi' => 'nullable|string',
        ], [
            'harga_jual.gt' => 'Harga jual harus lebih besar dari harga beli'
        ]);

        DB::beginTransaction();

        try {
            $sparepart = Sparepart::create([
                'kode_sparepart' => 'SP-' . strtoupper(Str::random(6)),
                'nama_sparepart' => $request->nama_sparepart,
                'merk' => $request->merk,
                'stok' => $request->stok,
                'stok_minimum' => $request->stok_minimum,
                'harga_beli' => $request->harga_beli,
                'harga_jual' => $request->harga_jual,
                'satuan' => $request->satuan,
                'deskripsi' => $request->deskripsi,
                'is_active' => true,
            ]);

            DB::commit();

            return redirect()->route('admin.spareparts.index')
                ->with('success', "Sparepart {$sparepart->nama_sparepart} berhasil ditambahkan.");
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Gagal menambahkan sparepart: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Display the specified sparepart.
     */
    public function show(Sparepart $sparepart)
    {
        $usageHistory = $sparepart->services()
            ->with('booking')
            ->orderBy('created_at', 'desc')
            ->take(10)
            ->get();

        return view('pages.admin.spareparts.show', compact('sparepart', 'usageHistory'));
    }

    /**
     * Show the form for editing the specified sparepart.
     */
    public function edit(Sparepart $sparepart)
    {
        return view('pages.admin.spareparts.edit', compact('sparepart'));
    }

    /**
     * Update the specified sparepart.
     */
    public function update(Request $request, Sparepart $sparepart)
    {
        $request->validate([
            'nama_sparepart' => 'required|string|max:255',
            'merk' => 'nullable|string|max:100',
            'stok' => 'required|integer|min:0',
            'stok_minimum' => 'required|integer|min:0',
            'harga_beli' => 'required|numeric|min:0',
            'harga_jual' => 'required|numeric|min:0|gt:harga_beli',
            'satuan' => 'required|string|max:20',
            'deskripsi' => 'nullable|string',
            'is_active' => 'required|boolean',
        ], [
            'harga_jual.gt' => 'Harga jual harus lebih besar dari harga beli'
        ]);

        DB::beginTransaction();

        try {
            $sparepart->update([
                'nama_sparepart' => $request->nama_sparepart,
                'merk' => $request->merk,
                'stok' => $request->stok,
                'stok_minimum' => $request->stok_minimum,
                'harga_beli' => $request->harga_beli,
                'harga_jual' => $request->harga_jual,
                'satuan' => $request->satuan,
                'deskripsi' => $request->deskripsi,
                'is_active' => $request->is_active,
            ]);

            DB::commit();

            return redirect()->route('admin.spareparts.index')
                ->with('success', "Sparepart {$sparepart->nama_sparepart} berhasil diperbarui.");
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Gagal memperbarui sparepart: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Remove the specified sparepart.
     */
    public function destroy(Sparepart $sparepart)
    {
        DB::beginTransaction();

        try {
            $sparepartName = $sparepart->nama_sparepart;
            $sparepart->delete();

            DB::commit();

            return redirect()->route('admin.spareparts.index')
                ->with('success', "Sparepart {$sparepartName} berhasil dihapus.");
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Gagal menghapus sparepart: ' . $e->getMessage());
        }
    }

    /**
     * Adjust stock quantity
     */
    public function adjustStock(Request $request, Sparepart $sparepart)
    {
        $request->validate([
            'type' => 'required|in:add,reduce',
            'quantity' => 'required|integer|min:1',
            'reason' => 'nullable|string|max:255'
        ]);

        DB::beginTransaction();

        try {
            if ($request->type == 'add') {
                $sparepart->addStock($request->quantity);
                $message = "Stok {$sparepart->nama_sparepart} bertambah {$request->quantity} {$sparepart->satuan}";
            } else {
                if ($sparepart->stok < $request->quantity) {
                    throw new \Exception('Stok tidak mencukupi');
                }
                $sparepart->reduceStock($request->quantity);
                $message = "Stok {$sparepart->nama_sparepart} berkurang {$request->quantity} {$sparepart->satuan}";
            }

            DB::commit();

            return redirect()->back()->with('success', $message);
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}
