{{-- taps.blade.php  --}}

@extends('layouts.master')
@section('css')
    <!---Internal  Prism css-->
    <link href="{{ URL::asset('assets/plugins/prism/prism.css') }}" rel="stylesheet">
    <!---Internal Input tags css-->
    <link href="{{ URL::asset('assets/plugins/inputtags/inputtags.css') }}" rel="stylesheet">
    <!--- Custom-scroll -->
    <link href="{{ URL::asset('assets/plugins/custom-scroll/jquery.mCustomScrollbar.css') }}" rel="stylesheet">
@endsection
@section('title')
    تفاصيل الفاتوره
@endsection
@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">تفاصيل الفاتوره</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/
                    تابع ل قسم: {{ $invoice->section->section_name }}</span>
            </div>
        </div>
    </div>
    <!-- breadcrumb -->
@endsection
@section('content')
    @if (session()->has('delete'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>{{ session()->get('delete') }}</strong>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if (session()->has('add'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>{{ session()->get('add') }}</strong>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif
    <!-- row -->
    <div class="row">
        <div class="row row-sm">
            <div class="col-lg-12 col-md-12">
                <div class="card" id="basic-alert">
                    <div class="card-body">
                        <div>
                            <h6 class="card-title mb-1">كل تفاصيل الفاتوره</h6>
                            <p class="text-muted card-sub-title">رقم :{{ $invoice->invoice_number }} </p>
                        </div>
                        <div class="text-wrap">
                            <div class="example">
                                <div class="panel panel-primary tabs-style-1">
                                    <div class=" tab-menu-heading">
                                        <div class="tabs-menu1">
                                            <!-- Tabs -->
                                            <ul class="nav panel-tabs main-nav-line">
                                                <li class="nav-item"><a href="#tab1" class="nav-link active"
                                                        data-toggle="tab">معلومات الفاتوره</a></li>
                                                <li class="nav-item"><a href="#tab2" class="nav-link"
                                                        data-toggle="tab">حالات الفاتوره</a></li>
                                                <li class="nav-item"><a href="#tab3" class="nav-link"
                                                        data-toggle="tab">المرفقات</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="panel-body tabs-menu-body main-content-body-right border-top-0 border">
                                        <div class="tab-content">
                                            <div class="tab-pane active" id="tab1">
                                                <div class="card-body">
                                                    <div class="table-responsive">
                                                        <table id="example3" class="table key-buttons text-md-nowrap">

                                                            <thead>
                                                                <tr>
                                                                    <th class="border-bottom-0">رقم الفاتوره</th>
                                                                    <th class="border-bottom-0">تاريخ الفاتوره</th>
                                                                    <th class="border-bottom-0">تاريخ الاستحقاق</th>
                                                                    <th class="border-bottom-0">المنتج</th>
                                                                    <th class="border-bottom-0">القسم</th>
                                                                    <th class="border-bottom-0">الخصم</th>
                                                                    <th class="border-bottom-0">نسبه الضريبه</th>
                                                                    <th class="border-bottom-0">قيمه الضريبه</th>
                                                                    <th class="border-bottom-0">الاجمالي</th>
                                                                    <th class="border-bottom-0">الحاله الحاليه</th>
                                                                    <th class="border-bottom-0">ملاحظات</th>
                                                                    <th class="border-bottom-0">العمليات</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <tr>
                                                                    <td>{{ $invoice->invoice_number }}</td>
                                                                    <td>{{ $invoice->invoice_Date }}</td>
                                                                    <td>{{ $invoice->due_date }}</td>
                                                                    <td>{{ $invoice->product }}</td>
                                                                    <td>
                                                                        <a
                                                                            href="{{ route('invoices_details.edit', $invoice->id) }}">
                                                                            {{ $invoice->section->section_name }}
                                                                        </a>
                                                                    </td>
                                                                    <td>{{ $invoice->discount }}</td>
                                                                    <td>{{ $invoice->rate_VAT }}</td>
                                                                    <td>{{ $invoice->value_VAT }}</td>
                                                                    <td>{{ $invoice->total }}</td>
                                                                    <td>
                                                                        @if ($invoice->value_Status == 1)
                                                                            <span
                                                                                class="text-success">{{ $invoice->status }}</span>
                                                                        @elseif ($invoice->value_Status == 2)
                                                                            <span
                                                                                class="text-danger">{{ $invoice->status }}</span>
                                                                        @else
                                                                            <span
                                                                                class="text-warning">{{ $invoice->status }}</span>
                                                                        @endif
                                                                    </td>
                                                                    <td>{{ $invoice->note }}</td>
                                                                    <td>
                                                                        <div class="dropdown">
                                                                            <button aria-expanded="false"
                                                                                aria-haspopup="true"
                                                                                class="btn btn-primary btn-sm ripple"
                                                                                data-toggle="dropdown"
                                                                                id="dropdownMenuButton" type="button">
                                                                                العمليات <i
                                                                                    class="fas fa-caret-down ml-1"></i>
                                                                            </button>

                                                                            <div class="dropdown-menu tx-13">
                                                                                <a class="dropdown-item"
                                                                                    href="{{ route('invoices.edit', $invoice->id) }}">تعديل</a>
                                                                                <a class="dropdown-item"
                                                                                    href="#">Another action</a>
                                                                                <a class="dropdown-item"
                                                                                    href="#">Something else here</a>
                                                                            </div>
                                                                        </div>

                                                                    </td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="tab-pane" id="tab2">

                                                <div class="card-body">
                                                    <div class="table-responsive">
                                                        <table id="example3" class="table key-buttons text-md-nowrap">

                                                            <thead>
                                                                <tr>
                                                                    <th class="border-bottom-0">رقم الفاتوره</th>
                                                                    <th class="border-bottom-0">المنتج</th>
                                                                    <th class="border-bottom-0">القسم</th>
                                                                    <th class="border-bottom-0">الخصم</th>
                                                                    <th class="border-bottom-0">من اضاف الفاتوره</th>
                                                                    <th class="border-bottom-0">الحاله</th>
                                                                    <th class="border-bottom-0">ملاحظات</th>
                                                                    <th class="border-bottom-0">تاريخ الاضافة</th>
                                                                    <th class="border-bottom-0">تاريخ التعديل </th>
                                                                    <th class="border-bottom-0">العمليات</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @foreach ($invoices_details as $invoices_detail)
                                                                    <tr>
                                                                        <td>{{ $invoices_detail->invoice_number }}</td>
                                                                        <td>{{ $invoices_detail->product }}</td>
                                                                        <td>{{ $invoices_detail->section }}</td>
                                                                        <td>{{ $invoices_detail->product }}</td>

                                                                        <td>{{ $invoices_detail->user }}</td>
                                                                        <td>
                                                                            @if ($invoice->value_Status == 1)
                                                                                <span
                                                                                    class="text-success">{{ $invoice->status }}</span>
                                                                            @elseif ($invoice->value_Status == 2)
                                                                                <span
                                                                                    class="text-danger">{{ $invoice->status }}</span>
                                                                            @else
                                                                                <span
                                                                                    class="text-warning">{{ $invoice->status }}</span>
                                                                            @endif
                                                                        </td>
                                                                        <td>{{ $invoices_detail->note }}</td>
                                                                        <td>{{ $invoices_detail->created_at }}</td>
                                                                        <td>{{ $invoices_detail->updated_at }}</td>
                                                                        <td>
                                                                            <div class="dropdown">
                                                                                <button aria-expanded="false"
                                                                                    aria-haspopup="true"
                                                                                    class="btn btn-primary btn-sm ripple"
                                                                                    data-toggle="dropdown"
                                                                                    id="dropdownMenuButton"
                                                                                    type="button">
                                                                                    العمليات <i
                                                                                        class="fas fa-caret-down ml-1"></i>
                                                                                </button>

                                                                                <div class="dropdown-menu tx-13">
                                                                                    <a class="dropdown-item"
                                                                                        href="{{ route('invoice_detail.edit', $invoices_detail->invoice_id) }}">تعديل</a>
                                                                                    <a class="dropdown-item"
                                                                                        href="#">Another action</a>
                                                                                    <a class="dropdown-item"
                                                                                        href="#">Something else
                                                                                        here</a>
                                                                                </div>
                                                                            </div>

                                                                        </td>
                                                                    </tr>
                                                                @endforeach

                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="tab-pane" id="tab3">
                                                <div class="card-bode">
                                                    <p class="text-danger"> صيغه المرفق jpg , pdf , png , jpeg</p>
                                                    <h5>اضافة مرفقات</h5>
                                                    <form action="{{ route('invoice_attachments.store') }}"
                                                        method="post" enctype="multipart/form-data">
                                                        @csrf
                                                        <div class="custom-file">
                                                            <input type="file" class="custom-file-input"
                                                                id="customFile" name="file_name" required>
                                                            <input type="hidden" name="invoice_number"
                                                                value="{{ $invoice->invoice_number }}">
                                                            <input type="hidden" name="invoice_id"
                                                                value="{{ $invoice->id }}">
                                                            <label for="customFile" class="custom-file-label">حدد
                                                                المرفق</label>
                                                        </div><br><br>
                                                        <button type="submit" class="btn btn-primary btn-sm"
                                                            name="uploadFile">تاكيد</button>
                                                    </form>
                                                </div>
                                                <br>
                                                <div class="card-body">
                                                    <div class="table-responsive">
                                                        <table id="example3" class="table key-buttons text-md-nowrap">

                                                            <thead>
                                                                <tr>
                                                                    <th class="border-bottom-0">المرفقات</th>
                                                                    <th class="border-bottom-0">رقم الفاتوره</th>
                                                                    <th class="border-bottom-0">من اضاف الفاتوره</th>
                                                                    <th class="border-bottom-0">موعد ادخال الفاتوره</th>
                                                                    <th class="border-bottom-0">العمليات</th>

                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @foreach ($invoice_attachments as $invoice_attachment)
                                                                    <tr>
                                                                        <td>
                                                                            {{ $invoice_attachment->file_name }}
                                                                        </td>

                                                                        <td>{{ $invoice_attachment->invoice_number }}</td>
                                                                        <td>{{ $invoice_attachment->created_by }}</td>
                                                                        <td>{{ $invoice_attachment->created_at }}</td>
                                                                        <td colspan="2">

                                                                            <a class="btn btn-outline-success btn-sm"
                                                                                href="{{ asset('Attachments/' . $invoice_attachment->invoice_number . '/' . $invoice_attachment->file_name) }}"
                                                                                target="_blank" role="button">
                                                                                <i class="fas fa-eye"></i>&nbsp; عرض
                                                                            </a>


                                                                            <a class="btn btn-outline-info btn-sm"
                                                                                href="{{ asset('Attachments/' . $invoice_attachment->invoice_number . '/' . $invoice_attachment->file_name) }}"
                                                                                download role="button">
                                                                                <i class="fas fa-download"></i>&nbsp; تحميل
                                                                            </a>



                                                                            <button class="btn btn-outline-danger btn-sm"
                                                                                data-toggle="modal"
                                                                                data-file_name="{{ $invoice_attachment->file_name }}"
                                                                                data-invoice_number="{{ $invoice_attachment->invoice_number }}"
                                                                                data-id_file="{{ $invoice_attachment->id }}"
                                                                                data-target="#delete_file">حذف</button>


                                                                        </td>

                                                                    </tr>
                                                                @endforeach

                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- row closed -->

                        <!-- delete -->
                        <div class="modal fade" id="delete_file" tabindex="-1" role="dialog"
                            aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">حذف المرفق</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <form action="{{ route('delete_file') }}" method="post">

                                        {{ csrf_field() }}
                                        <div class="modal-body">
                                            <p class="text-center">
                                            <h6 style="color:red"> هل انت متاكد من عملية حذف المرفق ؟</h6>
                                            </p>

                                            <input type="hidden" name="id_file" id="id_file" value="">
                                            <input type="hidden" name="file_name" id="file_name" value="">
                                            <input type="hidden" name="invoice_number" id="invoice_number"
                                                value="">

                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-default"
                                                data-dismiss="modal">الغاء</button>
                                            <button type="submit" class="btn btn-danger">تاكيد</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Container closed -->
            </div>
            <!-- main-content closed -->
        @endsection
        @section('js')
            <!--Internal  Datepicker js -->
            <script src="{{ URL::asset('assets/plugins/jquery-ui/ui/widgets/datepicker.js') }}"></script>
            <!-- Internal Select2 js-->
            <script src="{{ URL::asset('assets/plugins/select2/js/select2.min.js') }}"></script>
            <!-- Internal Jquery.mCustomScrollbar js-->
            <script src="{{ URL::asset('assets/plugins/custom-scroll/jquery.mCustomScrollbar.concat.min.js') }}"></script>
            <!-- Internal Input tags js-->
            <script src="{{ URL::asset('assets/plugins/inputtags/inputtags.js') }}"></script>
            <!--- Tabs JS-->
            <script src="{{ URL::asset('assets/plugins/tabs/jquery.multipurpose_tabcontent.js') }}"></script>
            <script src="{{ URL::asset('assets/js/tabs.js') }}"></script>
            <!--Internal  Clipboard js-->
            <script src="{{ URL::asset('assets/plugins/clipboard/clipboard.min.js') }}"></script>
            <script src="{{ URL::asset('assets/plugins/clipboard/clipboard.js') }}"></script>
            <!-- Internal Prism js-->
            <script src="{{ URL::asset('assets/plugins/prism/prism.js') }}"></script>

            <script>
                $('#delete_file').on('show.bs.modal', function(event) {
                    var button = $(event.relatedTarget)
                    var id_file = button.data('id_file')
                    var file_name = button.data('file_name')
                    var invoice_number = button.data('invoice_number')
                    var modal = $(this)

                    modal.find('.modal-body #id_file').val(id_file);
                    modal.find('.modal-body #file_name').val(file_name);
                    modal.find('.modal-body #invoice_number').val(invoice_number);
                })
            </script>

            <script>
                // Add the following code if you want the name of the file appear on select
                $(".custom-file-input").on("change", function() {
                    var fileName = $(this).val().split("\\").pop();
                    $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
                });
            </script>
        @endsection
