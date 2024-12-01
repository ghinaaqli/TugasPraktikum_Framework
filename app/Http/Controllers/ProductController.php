<?php

namespace App\Http\Controllers;

use App\Exports\ProductsExport;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Supplier;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\PDF;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::with('supplier');

        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('product_name', 'like', '%' . $search . '%'); // Gunakan nama kolom yang benar
            });
        }

        $data = $query->paginate(2);
        // return $data;

        return view("master-data.product-master.index-product", compact('data'));
    }

    public function create()
    {
        $suppliers = Supplier::all();
        return view("master-data.product-master.create-product", compact('suppliers'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'product_name' => 'required|string|max:255',
            'unit'         => 'required|string|max:50',
            'type'         => 'required|string|max:50',
            'information'  => 'nullable|string',
            'qty'          => 'required|integer|min:1',
            'producer'     => 'required|string|max:255',
            'supplier_id'  => 'required|exists:suppliers,id',
        ]);

        Product::create($validatedData);

        return redirect()->route('product-index')->with('success', 'Product created successfully!');
    }

    public function show(string $id)
    {
        $product = Product::findOrFail($id);
        return view("master-data.product-master.detail-product", compact('product'));
    }

    public function edit($id)
    {
        // Ambil data produk berdasarkan ID
        $product = Product::findOrFail($id);

        // Ambil semua data supplier untuk dropdown
        $suppliers = Supplier::all();

        // Redirect ke view edit
        return view('master-data.product-master.edit-product', compact('product', 'suppliers'));
    }



    public function update(Request $request, string $id)
    {
        $validatedData = $request->validate([
            'product_name' => 'required|string|max:255',
            'unit'         => 'required|string|max:255',
            'type'         => 'required|string|max:255',
            'information'  => 'nullable|string',
            'qty'          => 'required|integer|min:1',
            'producer'     => 'required|string|max:255',
        ]);

        $product = Product::findOrFail($id);
        $product->update($validatedData);

        return redirect()->route('product-index')->with('success', 'Product updated successfully!');
    }

    public function destroy(string $id)
    {
        $product = Product::find($id);

        if ($product) {
            $product->delete();
            return redirect()->route('product-index')->with('success', 'Product deleted successfully.');
        }

        return redirect()->route('product-index')->with('error', 'Product not found.');
    }

    public function exportExcel()
    {
        return Excel::download(new ProductsExport, 'product.xlsx');
    }

    public function exportPDF()
    {
        $products = Product::all(); // Ambil semua data produk

        // Pastikan Anda menggunakan 'products' di dalam compact
        $pdf = PDF::loadView('product.pdf', compact('products'));
        return $pdf->download('product.pdf');
    }
}
