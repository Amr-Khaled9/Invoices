<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\invoice_attachments;
use Illuminate\Support\Facades\Auth;

class InvoiceAttachmentsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
       $this->validate($request,[
        'file_name'=>'mimes:jpeg,pdf,png,jpg',
       ],[
        'file_name.mimes' => ' jpeg,pdf,png,jpg الصيفة يجب ان تكون ',
       ]);

       $image = $request->file('file_name');
       $file_name =$image->getClientOriginalName();

       $attachments = new invoice_attachments();
       $attachments->file_name =$file_name;
       $attachments->invoice_number =$request->invoice_number;
       $attachments->invoice_id =$request->invoice_id;
       $attachments->created_by = Auth::user()->name;
       $attachments->save();

       $imageName = $request->file_name->getClientOriginalName();
       $request->file_name->move(public_path('Attachments/'.$request->invoice_number),$imageName);

       return back()->with('add','تم اضافه المرفق بنجاح');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\invoice_attachments  $invoice_attachments
     * @return \Illuminate\Http\Response
     */
    public function show(invoice_attachments $invoice_attachments)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\invoice_attachments  $invoice_attachments
     * @return \Illuminate\Http\Response
     */
    public function edit(invoice_attachments $invoice_attachments)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\invoice_attachments  $invoice_attachments
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, invoice_attachments $invoice_attachments)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\invoice_attachments  $invoice_attachments
     * @return \Illuminate\Http\Response
     */
public function destroy($id)
{

}

}
