<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

class AutoCompleteController extends Controller
{
    public static function Routes()
    {
        Route::get('search', [AutoCompleteController::class, 'search'])->name('search');
    }

    public function search(Request $request)
    {
        $name = $request->input('item');
        $items = DB::table('items')->whereNull('deleted_at')->where('item_name', 'LIKE', $name)->get();
        return response()->json($items);
    }
}
