<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\ExportImportController;


class InventoryController extends Controller
{

    public static function Routes()
    {
        Route::get('inventory', [InventoryController::class, 'index'])->name('inventory.index');
        Route::get('inventory-item', [InventoryController::class, 'iventory'])->name('inventory-item.index');
        Route::get('inventory-item/{id}', [InventoryController::class, 'inventoryDetail'])->name('inventory-item.show');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.components.inventory.maninventory');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function iventory(Request $request)
    {
        $warehouses = DB::table('warehouses')
            ->join('warehouse_managers', 'warehouse_managers.warehouse_id', '=', 'warehouses.id')
            ->where('user_id', '=', Auth::user()->id)
            ->get();

        if (isset($request->warehouse_id)) {
            $warehouse_id = $request->warehouse_id;
        } else $warehouse_id = $warehouses[0]->id;

        $items = $this->getItem('item_details.warehouse_id', $warehouse_id);

        return view('admin.components.inventory.inventoryitem', compact('warehouses', 'items'));
    }

    public function inventoryDetail($id)
    {

        $item = $this->getItem('item_details.id', $id);
        $imports = $this->getExim(1, $id);
        $exports = $this->getExim(0, $id);
        // $transfer = DB::table('items')

        return view('admin.components.inventory.detailinventory', compact('item', 'imports', 'exports'));
    }

    public function getItem($text, $id)
    {
        $items = DB::table('item_details')
            ->join('items', 'items.id', '=', 'item_details.item_id')
            ->join('shelves', 'shelves.id', '=', 'item_details.shelf_id')
            ->join('warehouses', 'warehouses.id', '=', 'item_details.warehouse_id')
            ->leftJoin('categories', 'categories.id', '=', 'items.category_id')
            ->leftJoin('suppliers', 'suppliers.id', '=', 'item_details.supplier_id')
            ->join('unit_details', 'unit_details.item_id', '=', 'items.id')
            ->join('units', 'units.id', '=', 'unit_details.unit_id')
            ->select(
                'items.*',
                'item_details.id as itemdetails_id',
                'item_details.item_quantity as item_detail_quantity',
                'warehouse_id',
                'supplier_id',
                'shelf_id',
                'floor_id',
                'cell_id',
                'item_details.id as item_detail_id',
                'shelf_name',
                'warehouse_name',
                'category_name',
                'supplier_name',
                'unit_name'
            )

            ->whereNull('items.deleted_at')
            ->where($text, $id)
            ->get();
        foreach ($items as $val) {
            $exim_invalid = DB::table('ex_import_details')
                ->join('item_details', 'item_details.id', '=', 'ex_import_details.itemdetail_id')
                ->select(
                    DB::raw('SUM(ex_import_details.item_quantity) as quantity'),
                )
                ->where('ex_import_details.exim_detail_status', '0')
                ->where('item_details.id', $val->itemdetails_id)
                ->get();
            $trans_invalid = DB::table('transfer_details')
                ->join('transfers', 'transfers.id', '=', 'transfer_details.transfer_id')
                ->select(
                    DB::raw('SUM(transfer_details.item_quantity) as quantity'),
                )
                ->where('transfers.transfer_status', '0')
                ->where('transfer_details.itemdetail_id', $val->itemdetails_id)
                ->get();
            if ($exim_invalid[0]->quantity == null) {
                $exim_invalid[0]->quantity = 0;
            }
            if ($trans_invalid[0]->quantity == null) {
                $trans_invalid[0]->quantity = 0;
            }
            $val->item_quantity = [
                $val->item_detail_quantity - $exim_invalid[0]->quantity - $trans_invalid[0]->quantity,
                $exim_invalid[0]->quantity +  $trans_invalid[0]->quantity
            ];
        }

        return $items;
    }

    public function getExim($type, $itemdetail_id)
    {

        $exim = DB::table('items')
            ->join('ex_import_details', 'ex_import_details.item_id', '=', 'items.id')
            ->join('ex_imports', 'ex_imports.id', '=', 'ex_import_details.exim_id')
            ->join('users', 'users.id', '=', 'ex_imports.created_by')
            ->where('ex_imports.exim_type', $type)
            ->where('ex_import_details.itemdetail_id', $itemdetail_id)
            ->select('ex_imports.*', 'items.item_name as item', 'users.name as created_by', 'itemdetail_id')
            ->groupBy('exim_code')
            ->get();
        foreach ($exim as $val) {
            $val->item = DB::table('items')
                ->join('ex_import_details', 'ex_import_details.item_id', '=', 'items.id')
                ->join('ex_imports', 'ex_imports.id', '=', 'ex_import_details.exim_id')
                ->where('ex_imports.exim_type', $type)
                ->where('ex_imports.exim_code', $val->exim_code)
                ->where('itemdetail_id', $itemdetail_id)
                ->groupBy('item_name')
                ->select('items.item_name as item',)
                ->get();
        }
        return $exim;
    }
}
