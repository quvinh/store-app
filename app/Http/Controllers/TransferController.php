<?php

namespace App\Http\Controllers;

use App\Models\ItemDetail;
use App\Models\Transfer;
use App\Models\TransferDetail;
use App\Models\Warehouse;
use Carbon\Carbon;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Validator;

class TransferController extends Controller
{
    public static function Routes()
    {
        Route::group(['prefix' => 'transfer'], function () {
            Route::get('/', [TransferController::class, 'index'])->name('transfer.index')->middleware(['can:tra.view']);
            Route::group(['middleware' => ['can:tra.add']], function () {
                Route::get('/add', [TransferController::class, 'create'])->name('transfer.add');
                Route::post('/store', [TransferController::class, 'store'])->name('transfer.store');
            });
            Route::group(['middleware' => ['can:tra.edit']], function () {
                Route::get('/edit/{id}', [TransferController::class, 'edit'])->name('transfer.edit');
                Route::put('/update/{id}', [TransferController::class, 'update'])->name('transfer.update');
                Route::get('/confirm/{id}', [TransferController::class, 'confirm'])->name('transfer.confirm');
                Route::put('/update-status/{id}', [TransferController::class, 'update_status'])->name('transfer.update-status');
            });
            Route::group(['middleware' => ['can:tra.delete']], function () {
                Route::get('/delete/{id}', [TransferController::class, 'delete'])->name('transfer.delete');
                Route::get('/restore/{id}', [TransferController::class, 'restore'])->name('transfer.restore');
                Route::get('/destroy/{id}', [TransferController::class, 'destroy'])->name('transfer.destroy');
            });
        });
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $transfers = DB::table('transfers')
            ->join('users', 'users.id', '=', 'transfers.created_by')
            ->select('transfers.*', 'users.name')
            ->whereNull('deleted_at');
        $warehouses = DB::table('warehouse_managers')
            ->join('warehouses', 'warehouses.id', '=', 'warehouse_managers.warehouse_id')
            ->join('users', 'users.id', '=', 'warehouse_managers.user_id')
            ->select('warehouses.*')
            ->where('user_id', '=', Auth::user()->id)
            ->get();
        if (isset($request->warehouse)) {
            $transfers->where('transfers.warehouse_from', $request->warehouse);
        } else $transfers->where('transfers.warehouse_from', $warehouses[0]->id);
        if (isset($request->status)) {
            if ($request->status == 'duyet') $transfers->where('transfers.transfer_status', 1);
            if ($request->status == 'cduyet') $transfers->where('transfers.transfer_status', 0);
        }
        if (isset($request->date)) {
            $date = explode('_', $request->date);
            try {
                $from = DateTime::createFromFormat('m-d-Y', $date[0])->format('Y-m-d');
                $to = DateTime::createFromFormat('m-d-Y', $date[1])->format('Y-m-d');

                $transfers->whereDate('transfers.created_at', '>=', $from)
                    ->whereDate('transfers.created_at', '<=', $to);
            } catch (\Throwable $th) {
                //throw $th;
            }
        }
        $transfers = $transfers->get();
        $trashes = DB::table('transfers')
            ->join('users', 'users.id', '=', 'transfers.created_by')
            ->select('transfers.*', 'users.name')
            ->whereNotNull('deleted_at')
            ->get();
        return view('admin.components.transfer.mantransfer', compact('transfers', 'trashes', 'warehouses'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
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
                ->where('transfers.transfer_status', '0')
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
        return view('admin.components.transfer.addtransfer', compact('warehouses', 'items'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request->all());
        $validator = Validator::make($request->all(), [
            'itemdetail_id' => 'required',
            'item_quantity' => 'required',
            'warehouse_from' => 'required',
            'warehouse_to' => 'required',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }
        $count = count($request->itemdetail_id);
        $date = date('dmY');
        $stt = DB::table('transfers')->whereDate('created_at', '=', Carbon::now()->toDateString())->count();
        $transfer = Transfer::create([
            'warehouse_from' => $request->warehouse_from,
            'warehouse_to' => $request->warehouse_to,
            'transfer_code' => 'TF_' . $date . '_' . ($stt + 1),
            'created_by' => Auth::user()->id,
            'transfer_status' => 0,
            'transfer_note' => $request->note,
        ]);
        for ($i = 0; $i < $count; $i++) {
            $item = ItemDetail::find($request->itemdetail_id[$i]);
            TransferDetail::create([
                'transfer_id' => $transfer->id,
                'itemdetail_id' => $item->id,
                'item_quantity' => $request->item_quantity[$i],
                'shelf_from' => $item->shelf_id,
                'floor_from' => $item->floor_id,
                'cell_from' => $item->cell_id,
            ]);
        }
        return redirect()->back()->with(['success' => 'Tạo phiếu luân chuyển thành công.']);
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

    public function confirm($id)
    {
        $transfers = DB::table('item_details')
            ->join('items', 'items.id', '=', 'item_details.item_id')
            ->join('transfer_details', 'transfer_details.itemdetail_id', '=', 'item_details.id')
            ->join('transfers', 'transfers.id', '=', 'transfer_details.transfer_id')
            ->join('users', 'users.id', '=', 'transfers.created_by')
            ->join('warehouses', 'warehouses.id', '=', 'transfers.warehouse_to')
            ->where('transfers.id', $id)
            ->select(
                'transfer_details.*',
                'items.item_name as item',
                'transfers.transfer_code',
                'transfers.transfer_status',
                'transfers.warehouse_to',
                'warehouses.warehouse_name',
                'users.name',
            )
            ->get();
        $shelves = DB::table('shelves')
            ->join('warehouse_details', 'warehouse_details.shelf_id', '=', 'shelves.id')
            ->select('shelves.*')
            ->where('warehouse_details.warehouse_id', $transfers->first()->warehouse_to)->get();
        return view('admin.components.transfer.confirmtransfer', compact('transfers', 'shelves'));
    }

    public function update_status(Request $request)
    {
        // dd($request->all());
        $transfer_id = TransferDetail::find($request->id[0])->transfer_id;
        $warehouse_to = Transfer::find($transfer_id)->warehouse_to;
        foreach ($request->id as $key => $id) {
            TransferDetail::find($id)->update([
                'shelf_to' => $request->shelf[$key],
                'floor_to' => $request->floor[$key],
                'cell_to' => $request->cell[$key],
            ]);
            $detail = TransferDetail::find($id);
            $item_from = ItemDetail::find($detail->itemdetail_id);
            $item_to = ItemDetail::where([
                ['item_id', $item_from->item_id], ['warehouse_id', $warehouse_to],
                ['supplier_id', $item_from->supplier_id], ['shelf_id', $detail->shelf_to],
                ['floor_id', $detail->floor_to], ['cell_id', $detail->cell_to],
            ]);
            $item_from->update(['item_quantity' => $item_from->item_quantity - $detail->item_quantity]);
            if ($item_to->count() > 0) {
                $quantity = $detail->first()->item_quantity;
                $item_to->update(['item_quantity' => $quantity + $item_to->first()->item_quantity]);
            } else {
                ItemDetail::create([
                    'item_id' => $item_from->item_id,
                    'warehouse_id' => $warehouse_to,
                    'supplier_id' => $item_from->supplier_id,
                    'shelf_id' => $detail->shelf_to,
                    'floor_id' => $detail->floor_to,
                    'cell_id' => $detail->cell_to,
                    'item_quantity' => $detail->item_quantity,
                ]);
            }
        }
        Transfer::find($transfer_id)->update(['transfer_status' => 1]);
        return redirect()->route('transfer.index')->with(['success', 'Duyệt phiếu nhập thành công.']);
    }

    public function edit($id)
    {
        $transfers = DB::table('item_details')
            ->join('items', 'items.id', '=', 'item_details.item_id')
            ->join('transfer_details', 'transfer_details.itemdetail_id', '=', 'item_details.id')
            ->join('transfers', 'transfers.id', '=', 'transfer_details.transfer_id')
            ->join('users', 'users.id', '=', 'transfers.created_by')
            ->join('warehouses', 'warehouses.id', '=', 'transfers.warehouse_to')
            ->where('transfers.id', $id)
            ->select(
                'transfer_details.*',
                'items.item_name as item',
                'transfers.transfer_code',
                'transfers.transfer_status',
                'transfers.warehouse_to',
                'warehouses.warehouse_name',
                'users.name',
            )
            ->get();
        $shelves = DB::table('shelves')
            ->join('warehouse_details', 'warehouse_details.shelf_id', '=', 'shelves.id')
            ->select('shelves.*')
            ->where('warehouse_details.warehouse_id', $transfers->first()->warehouse_to)->get();
        return view('admin.components.transfer.edittransfer', compact('transfers', 'shelves'));
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
        $tf = Transfer::find($id);
        foreach ($request->id as $key => $val) {
            $transfer = TransferDetail::find($val);
            $old_quantity = $transfer->item_quantity;
            $transfer->update([
                'item_quantity' => $request->quantity[$key],
            ]);

            if ($tf->transfer_status == 1) {
                $item_from = ItemDetail::find($transfer->itemdetail_id);
                $item_from->update([
                    'item_quantity' => ($item_from->item_quantity - $transfer->item_quantity + $old_quantity),
                ]);
                $item_to = ItemDetail::where([
                    ['item_id', $item_from->item_id], ['warehouse_id', $tf->warehouse_to],
                    ['supplier_id', $item_from->supplier_id], ['shelf_id', $transfer->shelf_to],
                    ['floor_id', $transfer->floor_to], ['cell_id', $transfer->cell_to],
                ]);
                $item_to->update(['item_quantity' => $transfer->item_quantity - $old_quantity + $item_to->first()->item_quantity]);
            };
        };
        return redirect()->route('transfer.index')->with(['success', 'Sửa phiếu điều chuyển thành công.']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        Transfer::find($id)->delete();
        return redirect()->back()->with('success', 'Xóa thành công.');
    }

    public function restore($id)
    {
        Transfer::where('id', $id)->restore();
        return redirect()->back()->with('success', 'Khôi phục thành công.');
    }

    public function destroy($id)
    {
        Transfer::find($id)->forceDelete();
        return redirect()->back()->with('success', 'Xóa vĩnh viễn thành công.');
    }
}
