<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Auth::user()->categories()->orderBy('name')->get();

        return view('categories', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|string|in:income,expense',
            'description' => 'nullable|string|max:500',
        ]);

        Auth::user()->categories()->create($validated);

        return redirect()->route('categories')->with('status', 'Kategori baru berhasil ditambahkan.');
    }
}
