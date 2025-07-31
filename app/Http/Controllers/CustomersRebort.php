<?php

namespace App\Http\Controllers;

use App\Models\Invoices;
use App\Models\Sections;
use Illuminate\Http\Request;

class CustomersRebort extends Controller
{
    public function index()
    {
        $sections = Sections::all();
        return view('reports.customer_report', compact('sections'));
    }

    public function search(Request $request)
    {
        if ($request->Section && $request->product && $request->start_at == '' && $request->end_at == '') {
            $invoices = Invoices::where('section_id', $request->Section)->where('product', $request->product)->get();
            $sections = Sections::all();
            return view('reports.customer_report', compact('sections', 'invoices'));
        } else {
            $start_at =date($request->start_at);
            $end_at =date($request->end_at);
            $invoices = Invoices::whereBetween('invoice_Date',[$start_at, $end_at])
                ->where('section_id', $request->Section)
                ->where('product', $request->product)
                ->get();
            $sections = Sections::all();
            return view('reports.customer_report', compact('sections', 'invoices'));
        }
    }
}
