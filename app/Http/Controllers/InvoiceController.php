<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;

class InvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $side['header'] = 'system';
        $side['sub'] = 'invoice';
        $invoices = Invoice::all();
        $trashInvoices = Invoice::onlyTrashed()->get();
        return view('admin.components.invoice.maninvoice', compact('side', 'invoices', 'trashInvoices'));
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
            'invoice_name' => 'required',
            'invoice_type' => 'required|max:5|unique:invoices',
            'invoice_detail' => 'required',
        ]);

        $image = '';
        if ($request->hasFile('invoice_image')) {
            $file = $request->file('invoice_image');
            $name_file = $file->getClientOriginalName();
            $extension = $file->getClientOriginalExtension();
            if (strcasecmp($extension, 'jpg') === 0 || strcasecmp($extension, 'jepg') === 0 || strcasecmp($extension, 'png') === 0) {
                $name = Str::random(5) . '_' . $name_file;
                while (file_exists('images/invoice/' . $name)) {
                    $name = Str::random(5) . '_' . $name_file;
                }
                $file->move('images/invoice/', $name);
                $image = 'images/invoice/' . $name;
            }
        }

        if($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput($request->input());
        }

        $invoice = Invoice::create([
            'invoice_name' => $request->invoice_name,
            'invoice_type' => $request->invoice_type,
            'invoice_detail' => $request->invoice_detail,
            'invoice_status' => $request->invoice_status == 'on',
            'invoice_image' => $image,
        ]);
        Log::info('[' . $request->getMethod() . '] (' . Auth::user()->username . ')' . Auth::user()->name . ' >> Tạo mới mẫu hóa đơn #' . $invoice->id . $invoice->invoice_type . '-' . $invoice->invoice_name);
        return redirect()->back()->with('success', 'Lưu thành công');
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
        $validator = Validator::make($request->all(), [
            'invoice_name' => 'required',
            'invoice_type' => 'required|max:5',
        ]);

        if($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }
        $image = '';
        $invoice = Invoice::find($id);
        if ($request->hasFile('invoice_image')) {
            $file = $request->file('invoice_image');
            $name_file = $file->getClientOriginalName();
            $extension = $file->getClientOriginalExtension();
            if (strcasecmp($extension, 'jpg') === 0 || strcasecmp($extension, 'jepg') === 0 || strcasecmp($extension, 'png') === 0) {
                $name = Str::random(5) . '_' . $name_file;
                while (file_exists('images/invoice/' . $name)) {
                    $name = Str::random(5) . '_' . $name_file;
                }
                $file->move('images/invoice/', $name);
                $image = 'images/invoice/' . $name;
            }
            if (file_exists($request->invoice_image)) {
                File::delete($request->invoice_image);
            }
        } else {
            $image = $invoice->invoice_image;
        }
        $invoice->update([
            'invoice_name' => $request->invoice_name,
            'invoice_type' => $request->invoice_type,
            'invoice_detail' => $request->invoice_detail,
            'invoice_image' => $image,
            'invoice_status' => $request->invoice_status == 'on', 
        ]);
        Log::info('[' . $request->getMethod() . '] (' . Auth::user()->username . ')' . Auth::user()->name . ' >> Cập nhật mẫu hóa đơn #' . $invoice->id . $invoice->invoice_type . '-' . $invoice->invoice_name);
        return redirect()->back()->with('success', 'Cập nhật thành công');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $invoice = Invoice::find($id);
        $invoice->delete();
        Log::info('[TRASH] (' . Auth::user()->username . ')' . Auth::user()->name . ' >> Xóa tạm, mẫu hóa đơn #' . $invoice->id . $invoice->invoice_type . '-' . $invoice->invoice_name);
        return redirect()->back()->with('success', 'Xóa thành công');
    }

    public function restore($id)
    {
        $invoice = Invoice::withTrashed()->where('id', $id);
        $invoice->restore();
        Log::info('[RESTORE] (' . Auth::user()->username . ')' . Auth::user()->name . ' >> Khôi phục mẫu hóa đơn #' . $invoice->first()->id . $invoice->first()->invoice_type . '-' . $invoice->first()->invoice_name);
        return redirect()->back()->with('success', 'Khôi phục thành công');
    }

    public function forceDelete($id)
    {
        $invoice = Invoice::withTrashed()->where('id', $id);
        Log::info('[DELETE] (' . Auth::user()->username . ')' . Auth::user()->name . ' >> Xóa vĩnh viễn mẫu hóa đơn #' . $invoice->first()->id . $invoice->first()->invoice_type . '-' . $invoice->first()->invoice_name);
        $invoice->forceDelete();
        return redirect()->back()->with('success', 'Xóa thành công');
    }
}
