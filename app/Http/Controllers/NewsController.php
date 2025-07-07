<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\News;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class NewsController extends Controller
{
    /**
     * Display a listing of the news.
     */
    public function index()
    {
        $news = News::with('user')->orderBy('created_at', 'desc')->paginate(10);
        return view('news.index', compact('news'));
    }

    /**
     * Show the form for creating a new news.
     */
    public function create()
    {
        return view('news.create');
    }

    /**
     * Store a newly created news in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('news_images', 'public');
        }

        News::create([
            'user_id' => Auth::id(),
            'title' => $request->title,
            'content' => $request->content,
            'image_path' => $imagePath,
        ]);

        return redirect()->route('news.index')->with('success', 'Berita berhasil ditambahkan.');
    }

    /**
     * Display the specified news.
     */
    public function show(News $news)
    {
        return view('news.show', compact('news'));
    }

    /**
     * Show the form for editing the specified news.
     */
    public function edit(News $news)
    {
        if (Auth::user()->isAdmin() || (Auth::user()->isGuru() && Auth::id() === $news->user_id)) {
            return view('news.edit', compact('news'));
        }
        return redirect()->back()->with('error', 'Anda tidak memiliki izin untuk mengedit berita ini.');
    }

    /**
     * Update the specified news in storage.
     */
    public function update(Request $request, News $news)
    {
        if (!Auth::user()->isAdmin() && !(Auth::user()->isGuru() && Auth::id() === $news->user_id)) {
            return redirect()->back()->with('error', 'Anda tidak memiliki izin untuk mengupdate berita ini.');
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if ($request->hasFile('image')) {
            if ($news->image_path) {
                Storage::disk('public')->delete($news->image_path);
            }
            $imagePath = $request->file('image')->store('news_images', 'public');
            $news->image_path = $imagePath;
        }

        $news->title = $request->title;
        $news->content = $request->content;
        $news->save();

        return redirect()->route('news.index')->with('success', 'Berita berhasil diperbarui.');
    }

    /**
     * Remove the specified news from storage.
     */
    public function destroy(News $news)
    {
        if (!Auth::user()->isAdmin() && !(Auth::user()->isGuru() && Auth::id() === $news->user_id)) {
            return redirect()->back()->with('error', 'Anda tidak memiliki izin untuk menghapus berita ini.');
        }

        if ($news->image_path) {
            Storage::disk('public')->delete($news->image_path);
        }
        $news->delete();

        return redirect()->route('news.index')->with('success', 'Berita berhasil dihapus.');
    }

    /**
     * Display news for alumni (read-only).
     */
    public function indexAlumni()
    {
        $news = News::orderBy('created_at', 'desc')->paginate(10);
        return view('alumni.news.index', compact('news'));
    }

    /**
     * Show news detail for alumni.
     */
    public function showAlumni(News $news)
    {
        return view('alumni.news.show', compact('news'));
    }
}