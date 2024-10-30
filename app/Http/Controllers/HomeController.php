<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        // Memanggil fungsi dashboard untuk mendapatkan statistik
        $statistics = $this->dashboard(request());

        // Menyediakan variabel statistik ke dalam tampilan home
        return $this->dashboard(request());
    }


    public function dashboard(Request $request)
    {
        // Determine the role of the logged-in user
        $user = Auth::user();
        $isOwner = $request->user()->hasRole('owner');
        $isWriter = $request->user()->hasRole('writer');

        // Initialize statistics
        $statistics = [];

        if ($isOwner) {
            // Owner can see full statistics
            $statistics['total_articles'] = Article::count();
            $statistics['pending_articles'] = Article::where('is_confirm', false)->count();
            $statistics['categories'] = Category::withCount('articles')->get();
        } elseif ($isWriter) {
            // Writer can see only their own statistics
            $statistics['total_articles'] = Article::where('user_id', $user->id)->count();
            $statistics['pending_articles'] = Article::where('user_id', $user->id)
                ->where('is_confirm', false)
                ->count();
            $statistics['categories'] = Category::withCount(['articles' => function ($query) use ($user) {
                $query->where('user_id', $user->id);
            }])->get();
        }

        return view('home', compact('statistics'));
    }
}
