<?php

namespace App\Http\Controllers;

use App\Models\Invoices;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        // ExampleController.php
        $chartjs = app()->chartjs
            ->name('barChartTest')
            ->type('bar')
            ->size(['width' => 400, 'height' => 200])
            ->labels(['الفواتير غير مدفوعة', 'الفواتير المدفوعة', 'الفواتير المدفوعة جزئيا'])
            ->datasets([
                [
                    "label" => "نسبه الفواتير غير المدفوعة",
                    'backgroundColor' => ['rgba(19, 49, 124, 1)'],
                    'data' => [Invoices::where('Status', 'غير مدفوعة')->count() / Invoices::count() / 100]
                ],
                [
                    "label" => "نسبه الفواتير المدفوعة",
                    'backgroundColor' => ['rgba(19, 49, 124, 1)'],
                    'data' => [Invoices::where('Status', 'مدفوعة')->count() / Invoices::count() / 100]
                ],
                [
                    "label" => " نسبه الفواتير المدفوعة جزئيا ",
                    'backgroundColor' => ['rgba(19, 49, 124, 1)'],
                    'data' => [Invoices::where('Status', 'مدفوعة جزئيا')->count() / Invoices::count() / 100]
                ]
            ])
            ->options([]);
        $chartjs1 = app()->chartjs
            ->name('pieChartTest')
            ->type('pie')
            ->size(['width' => 400, 'height' => 200])
            ->labels(['الفواتير غير مدفوعة', 'الفواتير المدفوعة', 'الفواتير المدفوعة جزئيا'])
            ->datasets([
                [
                    'backgroundColor' => ['#FF6384', '#36A2EB'],
                    'hoverBackgroundColor' => ['#FF6384', '#36A2EB'],
                    'data' => [Invoices::where('Status', 'غير مدفوعة')->count() / Invoices::count() / 100
                    , Invoices::where('Status', 'مدفوعة')->count() / Invoices::count() / 100
                    ,Invoices::where('Status', 'مدفوعة جزئيا')->count() / Invoices::count() / 100
                    ]
                ]
            ])
            ->options([]);
        return view('home', compact('chartjs', 'chartjs1'));


        // example.blade.php


        // return view('home');
    }
}
