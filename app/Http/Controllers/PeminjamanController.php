<?php

namespace App\Http\Controllers;

use App\Models\Peminjaman;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PeminjamanController extends Controller
{
    public function store(Request $request)
    {
        $validator = Validator::make(request()->all(), [
            'user_id' => "required|exists:users,id",
            'buku_id' => "required|exists:bukus,id",
            'tanggal_pinjam' => "required|date",
            'tanggal_kembali' => "required|date|after:tanggal_pinjam",
            'status' => "required|in:dipinjam,dikembalikan,tenggat_waktu"
        ]);
        if ($validator->fails()) {
            return response()->json(                                //Return error response once the validator fails
                $validator->errors(),
                422
            );
        }

        $peminjaman = Peminjaman::create($request->all());
        return response()->json(['peminjaman' => $peminjaman]);
    }
}
