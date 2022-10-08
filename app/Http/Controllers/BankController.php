<?php

namespace App\Http\Controllers;
use App\Models\Bank;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Validator;

class BankController extends Controller
{

    public static function Routes() {
        Route::get('bank', [BankController::class, 'index'])->name('bank.index');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $side['header'] = 'group';
        $side['sub'] = 'bank';
        $banks = Bank::orderBy('bank_name')->get();
        return view('admin.components.group.bank', compact('side', 'banks'));
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
        $validator = Validator::make($request->all(), [
            'bank_name' => 'required',
            'bank_short' => 'required',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }
        Bank::create(
            [
                'bank_name' => $request->bank_name,
                'bank_short' => $request->bank_short,
                'bank_status' => 0,
            ]
        );
        return redirect()->back()->with('success', 'Thêm ngân hàng thành công');
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
        $bank = Bank::find($id);
        if ($request->bank_name != NULL || $request->bank_name != '') {
            $bank->update(
                [
                    'bank_name' => $request->bank_name,
                ]
            );
            return redirect()->back()->with('success', 'Cập nhật thành công');
        }
        if ($request->bank_short != NULL || $request->bank_short != '') {
            $bank->update(
                [
                    'bank_short' => $request->bank_short,
                ]
            );
            return redirect()->back()->with('success', 'Cập nhật thành công');
        }
        if ($request->bank_status != NULL || intval($request->bank_status) > 0) {
            if (intval($request->bank_status) == 3) {
                $bank->update(
                    [
                        'bank_status' => 0,
                    ]
                );
                return redirect()->back()->with('success', 'Khôi phục thành công');
            }
            if ($bank->bank_status == 2) {
                $bank->delete();
                return redirect()->back()->with('success', 'Xóa thành công');
            } else {
                $bank->update(
                    [
                        'bank_status' => $request->bank_status,
                    ]
                );
                return redirect()->back()->with('success', 'Cập nhật thành công');
            }
        }
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
}
