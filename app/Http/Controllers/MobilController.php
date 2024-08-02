<?php

namespace App\Http\Controllers;

use App\Models\Mobil;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class MobilController extends Controller
{
    public function get()
    {
        $data = Mobil::all();

        if ($data->isEmpty()) {
            return response()->json([
                "message" => "tidak ada data mobil"
            ]);
        }

        return response()->json([
            'data' => $data
        ]);
    }

    public function getById($id)
    {
        $data = Mobil::find($id);

        if (!$data) {
            return response()->json([
                "message" => "not found",
            ]);
        }

        return response()->json([
            "data" => $data
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'merek' => 'required|string|max:255',
            'type' => 'required|in:matic,manual,listrik',
            'cc' => 'required|string|max:255',
            'tahun' => 'required|string|max:255',
            'decs' => 'required|string',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $imagePath = $request->file('image')->store('images', 'public');

        $mobil = Mobil::create([
            'nama' => $request->nama,
            'merek' => $request->merek,
            'type' => $request->type,
            'cc' => $request->cc,
            'tahun' => $request->tahun,
            'decs' => $request->decs,
            'image' => $imagePath,
        ]);

        return response()->json([
            'message' => 'Mobil berhasil ditambahkan',
            'data' => $mobil
        ]);
    }

    public function update(Request $request, $id)
    {
        $mobil = Mobil::find($id);

        if (!$mobil) {
            return response()->json([
                "message" => "not found",
            ]);
        }

        $request->validate([
            'nama' => 'sometimes|required|string|max:255',
            'merek' => 'sometimes|required|string|max:255',
            'type' => 'sometimes|required|in:matic,manual,listrik',
            'cc' => 'sometimes|required|string|max:255',
            'tahun' => 'sometimes|required|string|max:255',
            'decs' => 'sometimes|required|string',
            'image' => 'sometimes|required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('image')) {
            Storage::disk('public')->delete($mobil->image);
            $imagePath = $request->file('image')->store('images', 'public');
            $mobil->image = $imagePath;
        }

        $mobil->update($request->only(['nama', 'merek', 'type', 'cc', 'tahun', 'decs', 'image']));

        return response()->json([
            'message' => 'Mobil berhasil diperbarui',
            'data' => $mobil
        ]);
    }

    public function delete($id)
    {
        $mobil = Mobil::find($id);

        if (!$mobil) {
            return response()->json([
                "message" => "not found",
            ]);
        }

        Storage::disk('public')->delete($mobil->image);
        $mobil->delete();

        return response()->json([
            'message' => 'Mobil berhasil dihapus'
        ]);
    }
}
