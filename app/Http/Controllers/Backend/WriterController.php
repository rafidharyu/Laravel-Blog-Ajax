<?php

namespace App\Http\Controllers\Backend;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\View\View;
use App\Http\Controllers\Controller;
use App\Http\Services\Backend\WriterService;

class WriterController extends Controller
{
    public function __construct(private WriterService $writerService)
    {
        $this->middleware('owner');
    }

    public function index(): View
    {
        return view('backend.writers.index');
    }

    public function serverside(Request $request): JsonResponse
    {
        return $this->writerService->dataTable($request);
    }

    //     public function show($id)
    // {
    //     $writer = User::find($id);
    //     return response()->json(['data' => $writer]);
    // }


    public function verifyWriter($id)
    {
        // Update kolom is_verified dengan nilai datetime saat ini
        $user = DB::table('users')->where('id', $id)->first();

        // Jika sudah diverifikasi, set is_verified ke NULL, jika belum diverifikasi, set ke now()
        $newStatus = $user->is_verified ? null : now();

        DB::table('users')->where('id', $id)->update(['is_verified' => $newStatus]);

        return redirect()->back()->with('success', 'Status verifikasi berhasil diubah');
    }
}
