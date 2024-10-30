<?php

namespace App\Http\Services\Backend;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class WriterService
{
    public function dataTable($request)
    {

        if ($request->ajax()) {
            $totalData = User::count();
            $totalFiltered = $totalData;

            $limit = $request->length;
            $start = $request->start;

            if (empty($request->search['value'])) {
                $data = User::offset($start)
                    ->limit($limit)
                    ->get(['id', 'name', 'email', 'created_at', 'is_verified']);
            } else {
                $data = User::filter($request->search['value'])
                    ->offset($start)
                    ->limit($limit)
                    ->get(['id', 'name', 'email', 'created_at', 'is_verified']);

                $totalFiltered = $data->count();
            }

            return DataTables::of($data)
                ->addIndexColumn()
                ->setOffset($start)
                ->editColumn('created_at', function ($data) {
                    return date('d-m-Y H:i:s', strtotime($data->created_at));
                })
                ->editColumn('is_verified', function ($data) {
                    $verifiedButton = '';

                    if ($data->is_verified !== null) {
                        // Jika data sudah terverifikasi, tampilkan waktu verifikasi dengan tombol untuk membatalkan verifikasi
                        $verifiedButton = '<form action="' . route('verify.writer', $data->id) . '" method="POST">
                                         ' . csrf_field() . '
                                         <button type="submit" class="btn btn-sm btn-danger">Unverify</button>
                                       </form>
                                       <span class="badge bg-success">' . date('d-m-Y H:i:s', strtotime($data->is_verified)) . '</span>';
                    } else {
                        // Jika tidak terverifikasi, tampilkan form untuk verifikasi
                        $verifiedButton = '<form action="' . route('verify.writer', $data->id) . '" method="POST">
                                         ' . csrf_field() . '
                                         <button type="submit" class="btn btn-sm btn-primary">Verify</button>
                                       </form>';
                    }

                    return $verifiedButton;
                })
                ->addColumn('action', function ($data) {
                    $actionBtn = '
                <div class="text-center" width="10%">
                    <div class="btn-group">
                        <button type="button" class="btn btn-sm btn-success" onclick="editDataWriter(this)" data-id="' . $data->id . '">  <!-- Ubah fungsi menjadi editDataWriter -->
                            <i class="fas fa-edit"></i>
                        </button>
                        <button type="button" class="btn btn-sm btn-danger" onclick="deleteData(this)" data-id="' . $data->id . '">
                            <i class="fas fa-trash-alt"></i>
                        </button>
                    </div>
                </div>
                ';

                    return $actionBtn;
                })

                ->with([
                    'recordsTotal' => $totalData,
                    'recordsFiltered' => $totalFiltered,
                    'start' => $start
                ])
                ->rawColumns(['action', 'is_verified'])
                ->make();
        }
    }

    // public function getFirstBy(string $column, string $value)
    // {
    //     return Writer::where($column, $value)->firstOrFail();
    // }

    // public function create(array $data)
    // {
    //     $data['slug'] = Str::slug($data['name']);
    //     return Writer::create($data);
    // }

    // public function update(array $data, string $uuid)
    // {
    //     $data['slug'] = Str::slug($data['name']);
    //     return Writer::where('uuid', $uuid)->update($data);
    // }
}
