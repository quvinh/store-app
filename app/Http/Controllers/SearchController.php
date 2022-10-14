<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

class SearchController extends Controller
{
    public static function Routes()
    {
        Route::get('search', [SearchController::class, 'search'])->name('search');
    }

    public function shelf(Request $request)
    {
        $name = $request->input('item');
        $items = DB::table('items')->whereNull('deleted_at')->where('item_name', 'LIKE', $name)->get();
        return response()->json($items);
    }
}
