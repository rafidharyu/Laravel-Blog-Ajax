<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Article;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Services\Frontend\TagService;
use App\Http\Services\Frontend\ArticleService;
use App\Http\Services\Frontend\CategoryService;

class HomeController extends Controller
{
    public function __construct(
        private CategoryService $categoryService,
        private ArticleService $articleService,
        private TagService $tagService
    ) {}

    public function index()
    {
        // Ambil artikel utama
        $main_post = Article::with('category:id,name', 'user:id,name')
            ->select('id', 'user_id', 'category_id', 'title', 'slug', 'content', 'published', 'published_at', 'is_confirm', 'views', 'image')
            ->latest()
            ->where('published', true)
            ->where('is_confirm', true)
            ->first();

        // Ambil artikel terpopuler
        $top_view = Article::with('category:id,name', 'tags:id,name')
            ->select('id', 'category_id', 'title', 'slug', 'content', 'published', 'is_confirm', 'views', 'image')
            ->orderBy('views', 'desc')
            ->where('published', true)
            ->where('is_confirm', true)
            ->first();

        // Ambil artikel terpopuler
        $most_view = Article::with('category:id,name', 'tags:id,name')
        ->select('id', 'user_id', 'category_id', 'title', 'slug', 'content', 'published', 'is_confirm', 'views', 'image')
        ->orderBy('views', 'desc')
        ->where('published', true)
        ->where('is_confirm', true)
        ->limit(6) // Adjust limit to control the number of top-viewed articles
        ->get();

        // Ambil artikel terbaru semua kategori, kecuali artikel utama
        $main_post_all = Article::with('category:id,name')
            ->select('id', 'category_id', 'title', 'slug', 'published', 'is_confirm', 'views', 'image')
            ->latest()
            ->where('published', true)
            ->where('is_confirm', true)
            ->where('id', '!=', $main_post->id)
            ->limit(6)
            ->get();

        // Ambil artikel terbaru
        $latest_articles = Article::with('category:id,name', 'user:id,name')
            ->select('id', 'user_id', 'category_id', 'title', 'slug', 'published', 'is_confirm', 'views', 'image')
            ->latest()
            ->where('published', true)
            ->where('is_confirm', true)
            ->whereNotNull('user_id')
            ->get();

        // Ambil kategori acak
        $categories = $this->categoryService->all();

        // Ambil artikel terbaru per kategori dan kategori
        $whats_new = $this->showNews();

        // Ambil artikel terpopuler
        $popularArticles = $this->articleService->popularArticles();

        // Ambil tag
        $tags = $this->tagService->randomTag();

        return view('frontend.home.index', [
            'main_post' => $main_post,
            'top_view' => $top_view,
            'most_view' => $most_view,
            'main_post_all' => $main_post_all,
            'latest_articles' => $latest_articles,
            'categories' => $categories,
            'whats_new' => $whats_new,
            'popular_articles' => $popularArticles,
            'tags' => $tags,
        ]);
    }

public function showNews()
{
    // Ambil kategori acak
    $categories = $this->categoryService->all();

    // Ambil artikel terbaru
    $latest_articles = Article::with('category:id,name', 'user:id,name')
        ->select('id', 'user_id', 'category_id', 'title', 'content', 'slug', 'published', 'published_at', 'is_confirm', 'views', 'image')
        ->latest()
        ->where('published', true)
        ->where('is_confirm', true)
        ->whereNotNull('user_id')
        ->get();

    return [
        'categories' => $categories,
        'latest_articles' => $latest_articles,
    ];
}

}
