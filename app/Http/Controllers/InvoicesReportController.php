<?php

namespace App\Http\Controllers;

use App\Models\Invoices;
use Illuminate\Http\Request;

class InvoicesReportController extends Controller
{
    public function index()
    {

        return view('reports.invoices_report');
    }

    public function SearchInvoices(Request $request)
    {
        // dd($request->all());
        // اعمل اتشيك ع الريكوست جي كامل ولا لا )(validation)
        if ($request->rdio == 2) {

            $request->validate([
                'invoice_number' => 'required'

            ], [
                'invoice_number.required' => 'يرجي ادخال رقم الفاتوره'
            ]);
        }
        // حدد نوع السريش 
        if ($request->rdio == 1) {

            if ($request->rdio == 1 && $request->start_at == '' && $request->end_at == '') {
                $invoices = Invoices::select('*')->where('status', $request->type)->get();
                $type = $request->type;
                return view('reports.invoices_report', compact('invoices', 'type'));
            } else {
                $start_at = date($request->start_at);
                $end_at = date($request->end_at);

                $invoices = Invoices::whereBetween('invoice_Date', [$start_at, $end_at])->where('status', $request->type)->get();
                $type = $request->type;
                return view('reports.invoices_report', compact('invoices', 'type', 'start_at', 'end_at'));
            }
            
        } else {
            $invoices = Invoices::select('*')->where('invoice_number', $request->invoice_number)->get();
            return view('reports.invoices_report', compact('invoices'));
        }




    }
}
