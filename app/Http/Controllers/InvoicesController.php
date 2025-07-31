<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Invoices;
use App\Models\Products;
use App\Models\Sections;
use Illuminate\Http\Request;
use App\Models\invoices_details;
use App\Notifications\AddInovice;
use App\Models\invoice_attachments;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\StoreInvoicesRequest;
use Illuminate\Support\Facades\Notification;

class InvoicesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $invoices = Invoices::all();
        return view('invoices.invoices', compact('invoices'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $sections = Sections::all();
        return view('invoices.add_invoices', compact('sections'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreInvoicesRequest  $request)
    {

        Invoices::create([
            'invoice_number' => $request->invoice_number,
            'invoice_Date' => $request->invoice_Date,
            'due_date' => $request->Due_date,
            'section_id' => $request->section_id,
            'product' => $request->product_id,
            'amount_collection' => $request->Amount_collection,
            'amount_Commission' => $request->Amount_Commission,
            'discount' => $request->Discount,
            'value_VAT' => $request->Value_VAT,
            'rate_VAT' => $request->Rate_VAT,
            'total' => $request->Total,
            'status' => 'غير مدفوعه',
            'value_Status' => 2,
            'note' => $request->note,
        ]);
        $invoices_id = Invoices::latest()->first()->id;
        invoices_details::create([
            'invoice_id' => $invoices_id,
            'invoice_number' => $request->invoice_number,
            'product' => $request->product_id,
            'section' => $request->section_id,
            'status' => 'غير مدفوعه',
            'value_status' => 2,
            'note' => $request->note,
            'user' => (Auth::user()->name),
        ]);


        if ($request->hasFile('pic')) {

            $invoice_id = Invoices::latest()->first()->id;
            $image = $request->file('pic');
            $file_name = $image->getClientOriginalName();
            $invoice_number = $request->invoice_number;

            $attachments = new invoice_attachments();
            $attachments->file_name = $file_name;
            $attachments->invoice_number = $invoice_number;
            $attachments->Created_by = Auth::user()->name;
            $attachments->invoice_id = $invoice_id;
            $attachments->save();

            // move pic
            $imageName = $request->pic->getClientOriginalName();
            $request->pic->move(public_path('Attachments/' . $invoice_number), $imageName);
        }


        $users = User::all(); // مجموعة المستخدمين
        $invoices = Invoices::latest()->first();

        // إرسال الإشعار لجميع المستخدمين
        Notification::send($users, new AddInovice($invoices));





        return back()->with('Add', 'تم اضافه الفاتوره بنجاح');

        //    $user = User::first();
        //    Notification::send($user, new AddInvoice($invoice_id));


    }
    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Invoices  $invoices
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $invoices = Invoices::where('id', $id)->first();
        return view('invoices.status_update', compact('invoices'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Invoices  $invoices
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $sections = Sections::all();
        $invoice = Invoices::where('id', $id)->first();
        return view('invoices.edit_invoice', compact('invoice', 'sections'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Invoices  $invoices
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Invoices $invoices, $id)
    {
        $invoice = Invoices::findOrFail($id);

        // ✅ تحديث البيانات
        $invoice->update([
            'invoice_number'      => $request->invoice_number,
            'invoice_date'        => $request->invoice_date,
            'due_date'            => $request->due_date,
            'section_id'          => $request->section_id,
            'product'             => $request->product_id,
            'amount_collection'   => $request->amount_collection ?? 0,
            'amount_commission'   => $request->amount_commission ?? 0,
            'discount'            => $request->discount ?? 0, //<-- هنا القيمة الافتراضية
            'value_vat'           => $request->value_vat ?? 0,
            'rate_vat'            => $request->rate_vat ?? 0,
            'total'               => $request->total ?? 0,
            'status'              => 'غير مدفوعه', // ثابتة
            'value_status'        => 2,             // ثابتة
            'note'                => $request->note ?? '',
        ]);


        return redirect()->route('invoices.index')->with('edit', 'تم التعديل بنجاح');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Invoices  $invoices
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {

        $invoice = Invoices::where('id', $request->invoice_id)->first();
        $details = invoice_attachments::where('invoice_id', $request->invoice_id)->first();
        if (!$request->id_page == 2) {
            if (!empty($details->invoice_number)) {
                $directory = public_path('Attachments/' . $details->invoice_number);

                if (File::exists($directory)) {
                    File::deleteDirectory($directory);
                }
            }
            $invoice->forceDelete();

            return redirect('/invoices')->with('delete', 'تم حذف الفاتورة بنجاح');
        } else {
            $invoice->Delete();

            return redirect('/invoice_achive')->with('delete', 'تم وضع الفاتورة في الارشيف بنجاح');
        }
    }

    public function getproducts($id)
    {
        $products = Products::where('section_id', $id)->pluck('product_name', 'id');
        return response()->json($products);
    }
    public function statusUpdate(Request $request, $id)
    {
        $invoice = Invoices::findOrFail($id);

        if ($request->Status === 'مدفوعة') {
            $invoice->update([
                'value_Status' => 1,
                'status' => $request->Status,
                'payment_Date' => $request->Payment_Date,
            ]);
            invoices_details::create([
                'invoice_id' => $request->invoice_id,
                'invoice_number' => $request->invoice_number,
                'product' => $request->product,
                'section' => $request->Section,
                'status' => $request->Status,
                'value_status' => 1,
                'note' => $request->note,
                'user' => (Auth::user()->name),
                'payment_Date' => $request->Payment_Date,

            ]);
        } else {
            $invoice->update([
                'value_Status' => 0,
                'status' => $request->Status,
                'payment_Date' => $request->Payment_Date,
            ]);
            invoices_details::create([
                'invoice_id' => $request->invoice_id,
                'invoice_number' => $request->invoice_number,
                'product' => $request->product,
                'section' => $request->Section,
                'status' => $request->Status,
                'value_status' => 0,
                'note' => $request->note,
                'user' => (Auth::user()->name),
                'payment_Date' => $request->Payment_Date,

            ]);
        }
        return redirect('/invoices')->with('status_update', 'تم تعديل الحاله بنجاح');
    }

    public function invoicesPaid()
    {
        $invoices = Invoices::where('value_Status', 1)->get();
        return view('invoices.invoices_paid', compact('invoices'));
    }
    public function invoicesUnPaid()
    {
        $invoices = Invoices::where('value_Status', 2)->get();
        return view('invoices.invoices_unpaid', compact('invoices'));
    }
    public function invoicesPartial()
    {
        $invoices = Invoices::where('value_Status', 0)->get();
        return view('invoices.invoices_partial', compact('invoices'));
    }

    public function print_invoice($id)
    {
        $invoices = Invoices::where('id', $id)->first();
        return view('invoices.print_invoice', compact('invoices'));
    }
}
