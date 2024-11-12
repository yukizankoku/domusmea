<?php

namespace App\Http\Controllers;

use App\Models\Compro;
use App\Models\Property;
use Illuminate\Http\Request;

class PropertyController extends Controller
{
    //services/properties.blade.php
    public function index(Request $request)
    {
        // Validasi input pencarian
        $request->validate([
            'search' => 'nullable|string',
            'area' => 'nullable|string',
            'min_price' => 'nullable|numeric|min:0',
            'max_price' => 'nullable|numeric|min:0',
            'min_luas_tanah' => 'nullable|numeric|min:0',
            'max_luas_tanah' => 'nullable|numeric|min:0',
            'min_luas_bangunan' => 'nullable|numeric|min:0',
            'max_luas_bangunan' => 'nullable|numeric|min:0',
            'sort_by' => 'nullable|in:price_asc,price_desc,luas_asc,luas_desc',
        ], [
            'max_price.numeric' => 'Harga maksimum harus berupa angka.',
            'sort_by.in' => 'Pilihan sorting tidak valid.',
        ]);        

        // Ambil input pencarian global
        $query = $request->input('search');

        // Mulai query dari model Property
        $properties = Property::with(['province', 'regency', 'district', 'village'])
        ->where('active', true)  // Filter untuk aktif
        ->where('sold', false);   // Filter untuk tidak terjual

        if (!empty($query)) {
            $properties->where(function ($search) use ($query) {
                $search->where('title', 'like', '%' . $query . '%')
                    ->orwhere('code', 'like', '%' . $query . '%')
                    ->orWhere('address', 'like', '%' . $query . '%')
                    ->orWhereHas('province', fn($subQuery) => $subQuery->where('name', 'like', '%' . $query . '%'))
                    ->orWhereHas('regency', fn($subQuery) => $subQuery->where('name', 'like', '%' . $query . '%'))
                    ->orWhereHas('district', fn($subQuery) => $subQuery->where('name', 'like', '%' . $query . '%'))
                    ->orWhereHas('village', fn($subQuery) => $subQuery->where('name', 'like', '%' . $query . '%'));
            });
        }

        // Filter dari Drawer (Filter lanjutan)
        if ($request->filled('area')) {
            $area = $request->area;

            $properties->where(function ($query) use ($area) {
                $query->whereHas('province', function ($q) use ($area) {
                    $q->where('name', 'like', '%' . $area . '%');
                })
                ->orWhereHas('regency', function ($q) use ($area) {
                    $q->where('name', 'like', '%' . $area . '%');
                })
                ->orWhereHas('district', function ($q) use ($area) {
                    $q->where('name', 'like', '%' . $area . '%');
                })
                ->orWhereHas('village', function ($q) use ($area) {
                    $q->where('name', 'like', '%' . $area . '%');
                })
                ->orWhere('title', 'like', '%' . $area . '%')
                ->orWhere('address', 'like', '%' . $area . '%');
            });
        }

        // Filter berdasarkan Tipe
        if ($request->filled('propertyType')) {
            $properties->where('type', $request->propertyType);
        }

        // Filter berdasarkan Category
        if ($request->filled('propertyCategory')) {
            $properties->where('category', $request->propertyCategory);
        }

        // Filter berdasarkan harga, luas tanah, dan luas bangunan
        // Filter Harga
        if ($request->filled('min_price')) {
            $properties->where('price', '>=', $request->min_price);
        }
        if ($request->filled('max_price')) {
            $properties->where('price', '<=', $request->max_price);
        }

        // Filter Luas Tanah
        if ($request->filled('min_luas_tanah')) {
            $properties->where('luas_tanah', '>=', $request->min_luas_tanah);
        }
        if ($request->filled('max_luas_tanah')) {
            $properties->where('luas_tanah', '<=', $request->max_luas_tanah);
        }

        // Filter Luas Bangunan
        if ($request->filled('min_luas_bangunan')) {
            $properties->where('luas_bangunan', '>=', $request->min_luas_bangunan);
        }
        if ($request->filled('max_luas_bangunan')) {
            $properties->where('luas_bangunan', '<=', $request->max_luas_bangunan);
        }

        // Sort berdasarkan opsi yang dipilih
        // Set default orderBy sebelum memproses sorting
        $properties->orderBy('created_at', 'desc'); 

        if ($request->filled('sort_by')) {
            switch ($request->sort_by) {
                case 'price_asc':
                    $properties->orderBy('price', 'asc');
                    break;
                case 'price_desc':
                    $properties->orderBy('price', 'desc');
                    break;
                case 'luas_asc':
                    $properties->orderBy('luas_tanah', 'asc');
                    break;
                case 'luas_desc':
                    $properties->orderBy('luas_tanah', 'desc');
                    break;
            }
        }

        // Dapatkan hasil pencarian
        $properties = $properties->paginate(9);

        // Return ke view dengan hasil pencarian
        return view('services.properties', compact('properties'));
    }

    // services/property.blade.php
    public function show(Property $property)
    {
        $relatedProperties = Property::with(['province', 'regency', 'district', 'village'])
        ->where('active', true)  // Filter untuk aktif
        ->where('sold', false)   // Filter untuk tidak terjual
        ->where('regencies_id', $property->regencies_id)
        ->where('id', '!=', $property->id) // Hindari properti yang sedang ditampilkan
        ->limit(3)
        ->get();
        
        return view('services.property', [
            "property" => $property,
            "relatedProperties" => $relatedProperties,
        ]);
    }
}
