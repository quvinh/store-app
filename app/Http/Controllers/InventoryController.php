<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\Inventory;
use App\Models\InventoryDetail;
use App\Models\ItemDetail;
use App\Models\User;
use Carbon\Carbon;
use DateTime;

class InventoryController extends Controller
{

    public static function Routes()
    {
        Route::group(['middleware' => ['can:inv.view']], function () {
            Route::get('inventory', [InventoryController::class, 'index'])->name('inventory.index');
            Route::get('inventory-item', [InventoryController::class, 'iventory'])->name('inventory-item.index');
            Route::get('inventory-item/{id}', [InventoryController::class, 'inventoryDetail'])->name('inventory-item.show');
        });
        Route::group(['middleware' => ['can:inv.add']], function () {
            Route::get('adjust-device', [InventoryController::class, 'create'])->name('inventory.create');
            Route::post('inventory/store', [InventoryController::class, 'store'])->name('inventory.store');
        });
        Route::group(['middleware' => ['can:inv.edit']], function () {
            Route::get('inventory/confirm/{id}', [InventoryController::class, 'edit'])->name('inventory.edit');
            Route::put('inventory/confirm/{id}', [InventoryController::class, 'update'])->name('inventory.update');
        });
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $inventories = DB::table('inventories')
            ->join('users', 'users.id', '=', 'inventories.created_by')
            ->select('inventories.*', 'users.name');
        $warehouses = DB::table('warehouse_managers')
            ->join('warehouses', 'warehouses.id', '=', 'warehouse_managers.warehouse_id')
            ->join('users', 'users.id', '=', 'warehouse_managers.user_id')
            ->select('warehouses.*')
            ->where('user_id', '=', Auth::user()->id)
            ->get();
        if (isset($request->warehouse)) {
            $inventories->where('inventories.warehouse_id', $request->warehouse);
        } else $inventories->where('inventories.warehouse_id', $warehouses[0]->id);
        if (isset($request->status)) {
            if ($request->status == 'duyet') $inventories->where('inventories.transfer_status', 1);
            if ($request->status == 'cduyet') $inventories->where('inventories.transfer_status', 0);
        }
        if (isset($request->date)) {
            $date = explode('_', $request->date);
            try {
                $from = DateTime::createFromFormat('m-d-Y', $date[0])->format('Y-m-d');
                $to = DateTime::createFromFormat('m-d-Y', $date[1])->format('Y-m-d');

                $inventories->whereDate('inventories.created_at', '>=', $from)
                    ->whereDate('inventories.created_at', '<=', $to);
            } catch (\Throwable $th) {
                //throw $th;
            }
        }
        $inventories = $inventories->get();
        return view('admin.components.inventory.adjust.maninventory', compact('inventories', 'warehouses'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $user = User::all();
        $warehouses = DB::table('warehouse_managers')
            ->join('warehouses', 'warehouses.id', '=', 'warehouse_managers.warehouse_id')
            ->join('users', 'users.id', '=', 'warehouse_managers.user_id')
            ->select('warehouses.*')
            ->where('user_id', '=', Auth::user()->id)
            ->get();
        if (isset($request->warehouse_id)) {
            $warehouse_id = $request->warehouse_id;
        } else $warehouse_id = $warehouses[0]->id;
        $items = DB::table('item_details')
            ->join('items', 'items.id', '=', 'item_details.item_id')
            ->join('shelves', 'shelves.id', '=', 'item_details.shelf_id')
            ->join('warehouses', 'warehouses.id', '=', 'item_details.warehouse_id')
            ->leftJoin('categories', 'categories.id', '=', 'items.category_id')
            ->leftJoin('suppliers', 'suppliers.id', '=', 'item_details.supplier_id')
            ->select(
                'items.*',
                'item_details.id as itemdetail_id',
                'item_details.item_quantity as item_detail_quantity',
                'warehouse_id',
                'supplier_id',
                'shelf_id',
                'floor_id',
                'cell_id',
                'shelf_name',
                'warehouse_name',
                'category_name',
                'supplier_name'
            )
            ->whereNull('items.deleted_at')
            ->where('item_details.item_quantity', '>', 0)
            ->where('item_details.warehouse_id', $warehouse_id)
            ->get();
        return view('admin.components.inventory.adjust.addinventory', compact('warehouses', 'items', 'user'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $participants = '';
        for ($i = 0; $i < count($request->people); $i++) {
            $participants = $participants . $request->people[$i] . '   ';
        }
        if ($request->itemdetail_id != null) {
            $count = count($request->itemdetail_id);
        }
        // dd($request->itemdetail_id[0]);
        $date = date('dmY');
        $stt = DB::table('inventories')->whereDate('created_at', '=', Carbon::now()->toDateString())->count();
        $inventory = Inventory::create([
            'inventory_code' => 'IVT_' . $date . '_' . ($stt + 1),
            'inventory_status' => 0,
            'inventory_note' => $request->note,
            'invoice_id' => 0,
            'created_by' => Auth::user()->id,
            'warehouse_id' => $request->warehouse_id,
            'participants' => $participants,
        ]);



        for ($i = 0; $i < $count; $i++) {
            if ($request->item_difference[$i] < 0) {
                $last3 = DB::table('inventories')->orderBy('id', 'DESC')->first();
                Inventory::find($last3->id)->forceDelete();
                return redirect()->back()->withErrors('Tạo phiếu thất bại, Số lượng nhập không thể lớn hơn số lượng khả dụng');
            }

            InventoryDetail::create([
                'inventory_id' => $inventory->id,
                'itemdetail_id' => (int)($request->itemdetail_id[$i]),
                'item_difference' => (int)($request->item_difference[$i])
            ]);
        };
        return redirect()->route('inventory.index')->with('success', 'Tạo phiếu thành công.');
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
        $inventory = DB::table('inventories')
            ->join('users', 'users.id', '=', 'inventories.created_by')
            ->where('inventories.id', $id)
            ->select('inventories.*', 'name')
            ->get();
        $inventory_detail = DB::table('inventory_details')
            ->leftJoin('item_details', 'item_details.id', '=', 'inventory_details.itemdetail_id')
            ->leftJoin('items', 'items.id', '=', 'item_details.item_id')
            ->leftJoin('suppliers', 'suppliers.id', '=', 'item_details.supplier_id')
            ->leftJoin('warehouses', 'warehouses.id', '=', 'item_details.warehouse_id')
            ->select(
                'item_details.*',
                'items.item_name',
                'items.id as item_id',
                DB::raw('SUM(inventory_details.item_difference) as item_broken'),
                'suppliers.supplier_name',
                'warehouse_name'
            )
            ->groupBy('item_details.item_id')
            ->where('inventory_id', $id)
            ->get();
        return view('admin.components.inventory.adjust.confirminventory', compact('inventory', 'inventory_detail'));
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
        $inventory = Inventory::find($id);
        $inventory_detail = InventoryDetail::where('inventory_id', $id)->get();

        // dd($inventory_detail[0]->item_difference);
        $count = DB::table('inventory_details')->where('inventory_id', $id)->count();

        if ($count < 0) {
            return redirect()->back()->withErrors('Duyệt thất bại');
        } else {
            for ($i = 0; $i < $count; $i++) {
                $item_details = ItemDetail::find($inventory_detail[$i]->itemdetail_id);
                $item_difference = $inventory_detail[$i]->item_difference;
                $item_details->update([
                    'item_quantity' => $item_details->item_quantity - $item_difference,
                ]);
            }
            $inventory->update([
                'inventory_status' => 1,
            ]);
        }
        return redirect()->route('inventory.index')->with('success', ' Duyệt thành công');
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

        return view('admin.components.inventory.inven.inventoryitem', compact('warehouses', 'items'));
    }

    public function inventoryDetail($id)
    {

        $item = $this->getItem('item_details.id', $id);
        // dd($item);
        $imports = $this->getExim(1, $id);
        $exports = $this->getExim(0, $id);
        $transfers = DB::table('transfers')
            ->join('users', 'users.id', '=', 'transfers.created_by')
            ->select('transfers.*', 'users.name')
            ->whereNull('deleted_at')->get();

        return view('admin.components.inventory.inven.detailinventory', compact('item', 'imports', 'exports', 'transfers'));
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
                'item_details.id as itemdetail_id',
                'item_details.item_quantity as item_detail_quantity',
                'warehouse_id',
                'supplier_id',
                'shelf_id',
                'floor_id',
                'cell_id',
                'item_details.id as itemdetail_id',
                'shelf_name',
                'warehouse_name',
                'category_name',
                'supplier_name',
                'unit_name'
            )
            ->groupBy('itemdetail_id')
            ->where('item_details.item_quantity', '>', 0)
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
                ->where('item_details.id', $val->itemdetail_id)
                ->get();
            $trans_invalid = DB::table('transfer_details')
                ->join('transfers', 'transfers.id', '=', 'transfer_details.transfer_id')
                ->select(
                    DB::raw('SUM(transfer_details.item_quantity) as quantity'),
                )
                ->whereIn('transfers.transfer_status', [0, 1, 2, 3])
                ->where('transfer_details.itemdetail_id', $val->itemdetail_id)
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
