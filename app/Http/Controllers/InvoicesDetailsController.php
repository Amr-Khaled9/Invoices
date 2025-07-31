<?php

namespace App\Http\Controllers;

use App\Models\Invoices;
use Illuminate\Http\Request;
use App\Models\invoices_details;
use App\Models\invoice_attachments;
use Illuminate\Support\Facades\Storage;

class InvoicesDetailsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {}
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
    public function store(Request $request) {}

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\invoices_details  $invoices_details
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id) {}

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\invoices_details  $invoices_details
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $invoice = Invoices::where('id', $id)->first();
        $invoice_id = Invoices::where('id', $id)->first()->id;
        $invoices_details = invoices_details::where('invoice_id', $invoice_id)->get();
        $invoice_attachments = invoice_attachments::where('invoice_id', $invoice_id)->get();


        return view('invoices.invoices_details', compact('invoice', 'invoices_details', 'invoice_attachments'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\invoices_details  $invoices_details
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, invoices_details $invoices_details)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\invoices_details  $invoices_details
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {

        $invoices = invoice_attachments::findOrFail($request->id_file);
        $invoices->delete();
        Storage::disk('public_uploads')->delete($request->invoice_number . '/' . $request->file_name);
        return back()->with('delete', 'تم حذف المرفق بنجاح');
    }

    //  public function get_file($invoice_number,$file_name)

    // {
    //     $contents= Storage::disk('public_uploads')->getDriver()->getAdapter()->applyPathPrefix($invoice_number.'/'.$file_name);
    //     return response()->download( $contents);
    // }



    // public function open_file($invoice_number,$file_name)

    // {
    //     $files = Storage::disk('public_uploads')->getDriver()->getAdapter()->applyPathPrefix($invoice_number.'/'.$file_name);
    //     return response()->file($files);
    // }

    public function showEdit($notify_id, $id)
    {
        $invoice_detail = invoices_details::where('invoice_id', $id)->first();
        $userUnread = auth()->user()->unreadNotifications->find($notify_id);
            if($userUnread){
            $userUnread->markAsRead();
        }
        return view('invoices.edit_invoices_details', compact('invoice_detail'));
    }
    public function showUpdate(Request $request, $id)
    {

        $statusData = $request->input('status_data'); // القيمة القادمة بالشكل 1|مدفوعة جزئياً

        list($value_status, $status_name) = explode('|', $statusData);

        $invoice_detail = invoices_details::where('invoice_id', $id)->update([
            'status' => $status_name,
            'value_status' => $value_status,
        ]);
        $invoice = Invoices::where('id', $id)->update([
            'status' => $status_name,
            'value_status' => $value_status,
        ]);
        return redirect()->to('/invoices_details/' . $id . '/edit')->with('edit', 'تم تعديل الحالة بنجاح');
    }
}
