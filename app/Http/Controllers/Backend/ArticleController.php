<?php

namespace App\Http\Controllers\Backend;

use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Contracts\View\View;
use App\Http\Controllers\Controller;
use App\Http\Requests\ArticleRequest;
use App\Http\Services\Backend\ArticleService;
use App\Http\Services\Backend\ImageService;
use Illuminate\Support\Facades\Gate;

class ArticleController extends Controller
{
    public function __construct(
        private ArticleService $articleService,
        private ImageService $imageService
    ) {
        $this->middleware('writer');
    }
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        return view('backend.articles.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('backend.articles.create', [
            'categories' => $this->articleService->getCategory(),
            'tags' => $this->articleService->getTag()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ArticleRequest $request): JsonResponse
    {
        $data = $request->validated();

        try {
            $data['image'] = $this->imageService->storeImage($data);

            $this->articleService->create($data);

            return response()->json([
                'message' => 'Data Artikel Berhasil Ditambahkan...'
            ]);
        } catch (\Exception $error) {
            $this->imageService->deleteImage($data['image'], 'images');

            return response()->json([
                'message' => 'Data Artikel Gagal Ditambahkan...' . $error->getMessage()
            ]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $uuid)
    {
        $article = $this->articleService->getFirstBy('uuid', $uuid, true);

        Gate::authorize('view', $article);

        return view('backend.articles.show', [
            'article' => $article,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $uuid)
    {
        $article = $this->articleService->getFirstBy('uuid', $uuid, true);

        Gate::authorize('view', $article);

        return view('backend.articles.edit', [
            'article' => $article,
            'categories' => $this->articleService->getCategory(),
            'tags' => $this->articleService->getTag()
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ArticleRequest $request, string $uuid)
    {
        $data = $request->validated();

        $getArticle = $this->articleService->getFirstBy('uuid', $uuid);

        try {
            if ($request->hasFile('image')) {
                $data['image'] = $this->imageService->storeImage($data, $getArticle->image);
            }

            $this->articleService->update($data, $uuid);

            return response()->json([
                'message' => 'Data Artikel Berhasil Diubah...'
            ]);
        } catch (\Exception $error) {
            $this->imageService->deleteImage($data['image'], 'images');

            return response()->json([
                'message' => 'Data Artikel Gagal Diubah...' . $error->getMessage()
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $uuid)
    {
        $article = $this->articleService->getFirstBy('uuid', $uuid, true);

        Gate::authorize('view', $article);

        $this->articleService->delete($uuid);

        return response()->json(['message' => 'Data Artikel Berhasil Dihapus...']);
    }

    public function forceDelete(string $uuid)
    {
        $article = $this->articleService->getFirstBy('uuid', $uuid, true);

        Gate::authorize('view', $article);

        $this->articleService->forceDelete($uuid);

        return response()->json([
            'message' => 'Data Artikel Berhasil Dihapus Permanen...',
        ]);
    }

    public function restore(string $uuid)
    {
        $article = $this->articleService->getFirstBy('uuid', $uuid, true);

        Gate::authorize('view', $article);

        $this->articleService->restore($uuid);

        return redirect()->back()->with('success', 'Data Artikel Berhasil Dipulihkan...');
    }

    public function serverside(Request $request): JsonResponse
    {
        return $this->articleService->dataTable($request);
    }

    // public function publish($uuid)
    // {
    //     $article = Article::where('uuid', $uuid)->firstOrFail();
    //     $article->published = true;
    //     $article->save();

    //     return redirect()->back()->with('success', 'Article published successfully.');
    // }

    // public function unpublish($uuid)
    // {
    //     $article = Article::where('uuid', $uuid)->firstOrFail();
    //     $article->published = false;
    //     $article->save();

    //     return redirect()->back()->with('success', 'Article unpublished successfully.');
    // }

    // Metode untuk mengonfirmasi artikel
    public function confirm($uuid)
    {
        // Ambil artikel berdasarkan UUID
        $article = Article::where('uuid', $uuid)->firstOrFail();

        // Set status is_confirm menjadi true
        $article->is_confirm = true;
        $article->save();

        return redirect()->back()->with('success', 'Article confirmed successfully.');
    }

    // Metode untuk membatalkan konfirmasi artikel
    public function unconfirm($uuid)
    {
        // Ambil artikel berdasarkan UUID
        $article = Article::where('uuid', $uuid)->firstOrFail();

        // Set status is_confirm menjadi false
        $article->is_confirm = false;
        $article->save();

        return redirect()->back()->with('success', 'Article unconfirmed successfully.');
    }


}
