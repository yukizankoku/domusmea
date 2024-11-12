<?php

namespace App\Http\Controllers;

use App\Models\Portfolio;
use Illuminate\Http\Request;

class PortfolioController extends Controller
{
    public function index(Request $request)
    {
        // Mulai query dari semua data portfolio
        $query = Portfolio::query();

        // Filter berdasarkan kategori
        if ($request->filled('category')) {
            $query->whereJsonContains('category', $request->input('category'));
        }

        // Filter berdasarkan title atau keyword di description
        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('title', 'like', '%' . $request->input('search') . '%')
                    ->orWhere('description', 'like', '%' . $request->input('search') . '%');
            });
        }

        // Ambil hasil query
        $portfolios = $query->latest()->paginate(6);

        return view('portfolio.portfolios', compact('portfolios'));
    }

    public function show(Portfolio $portfolio)
    {
        // kategori dari portfolio yang sedang ditampilkan
        $categories = $portfolio->category;

        // Mencari portfolio terkait berdasarkan kategori yang sama
        $relatedPortfolios = Portfolio::where(function($query) use ($categories) {
            foreach ($categories as $category) {
                $query->orWhereJsonContains('category', $category);
            }
        })
        ->where('id', '!=', $portfolio->id) // untuk menghindari portfolio yang sedang ditampilkan
        ->limit(3)
        ->get();

        return view('portfolio.portfolio',[
            "portfolio" => $portfolio,
            "relatedPortfolios" => $relatedPortfolios
        ]);
    }
}
