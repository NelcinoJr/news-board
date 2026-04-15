<?php

namespace App\Http\Controllers;

use App\Models\News;
use Illuminate\Http\Request;

class NewsController extends Controller
{
    public function index(Request $request)
    {
        $query = News::with('category')->latest();

        if ($request->has('search')) {
            $search = $request->get('search');
            $query->where('title', 'like', "%{$search}%")
                  ->orWhereHas('category', function ($q) use ($search) {
                      $q->where('name', 'like', "%{$search}%");
                  });
        }

        return response()->json($query->get());
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'category_id' => 'required|exists:categories,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('news_images', 'public');
            $validated['image'] = '/storage/' . $path;
        }

        $news = News::create($validated);

        return response()->json($news->load('category'), 201);
    }

    public function update(Request $request, $id)
    {
        $news = News::findOrFail($id);
        
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'category_id' => 'required|exists:categories,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('news_images', 'public');
            $validated['image'] = '/storage/' . $path;
        }

        $news->update($validated);

        return response()->json($news->load('category'), 200);
    }

    public function destroy($id)
    {
        News::destroy($id);
        return response()->json(['message' => 'Deleted']);
    }
}
