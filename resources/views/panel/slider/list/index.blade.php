@extends('panel.layouts.app')
@section("title","panel E-Posta Ayarları")
@section("header")
    <link rel="stylesheet" type="text/css"
          href="https://cdn.datatables.net/v/bs4/jszip-2.5.0/dt-1.10.23/af-2.3.5/b-1.6.5/b-colvis-1.6.5/b-flash-1.6.5/b-html5-1.6.5/b-print-1.6.5/cr-1.5.3/fc-3.3.2/fh-3.1.7/kt-2.5.3/r-2.2.6/rg-1.1.2/rr-1.2.7/sc-2.0.3/sb-1.0.1/sp-1.2.2/sl-1.3.1/datatables.min.css"/>
@endsection
@section("content")

    <!-- Page-header end -->
    <div class="pcoded-inner-content">
        <div class="main-body">
            <div class="page-wrapper">
                <!-- Page body start -->
                <div class="page-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <!-- Bootstrap tab card start -->
                            <div class="card p-5">
                                <div class="card-header">
                                    <div class="row my-auto py-auto">
                                        <div class="text-left col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6  my-auto py-auto">
                                            <h5>{{$data->page->title}}</h5>
                                        </div>
                                        <div class="text-right col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6 my-auto py-auto">
                                            <a href="{{route("panel.slider.add")}}" class="btn btn-primary text-right">
                                                <i class="fas fa-plus"></i> Yeni Ekle
                                            </a>
                                        </div>
                                    </div>
                                </div>

                                <table class="table table-bordered data-table table-striped w-100">
                                    <thead>
                                    <tr>
                                        <th>Sıra</th>
                                        <th>İd</th>
                                        <th>Sırala</th>
                                        <th>Görsel</th>
                                        <th>Başlık</th>
                                        <th>Durum</th>
                                        <th width="100px">İşlemler</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>


                                <!-- Bootstrap tab card end -->
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Page body end -->
            </div>
        </div>
    </div>
@endsection
@section("footer")

    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
    <script type="text/javascript"
            src="https://cdn.datatables.net/v/bs4/jszip-2.5.0/dt-1.10.23/af-2.3.5/b-1.6.5/b-colvis-1.6.5/b-flash-1.6.5/b-html5-1.6.5/b-print-1.6.5/cr-1.5.3/fc-3.3.2/fh-3.1.7/kt-2.5.3/r-2.2.6/rg-1.1.2/rr-1.2.7/sc-2.0.3/sb-1.0.1/sp-1.2.2/sl-1.3.1/datatables.min.js"></script>

    <script type="text/javascript">
        function unescapeHTML(escapedHTML) {
            return escapedHTML.replace(/&lt;/g,'<').replace(/&gt;/g,'>').replace(/&amp;/g,'&').replace(/&quot;/g,"'");
        }
        $(function () {

            let table = $('.data-table').DataTable({
                "language": {
                    "url": "{{asset("panel/assets/js/turkish.json")}}"
                },
                processing: true,
                serverSide: true,
                responsive: true,
                ajax: "{{ route('panel.slider.datatable') }}",
                columns: [
                    {data: 'rank', name: 'rank', orderable: true, searchable: true},
                    {data: 'order', name: 'order', orderable: false, searchable: false},
                    {data: 'id', name: 'id', orderable: true, searchable: true},

                    {
                        data: 'img_url',
                        name: 'img_url',
                        "render": function (data, type, full, meta) {

                           return unescapeHTML(data);
                        },
                        searchable: true
                    },    {
                        data: 'title',
                        name: 'title',
                        "render": function (data, type, full, meta) {

                           return unescapeHTML(data);
                        },
                        searchable: true
                    },
                    {data: 'isActive', name: 'isActive', orderable: false, searchable: true},
                    {data: 'action', name: 'action', orderable: false, searchable: true},
                ],
                dom: "<'d-flex align-content-center flex-wrap justify-content-between' <'justify-content-start' l><'justify-content-center'r><'justify-content-end'f>>t<'d-flex flex-wrap justify-content-between' <'justify-content-start'i> <'justify-content-end'p>>",
                rowReorder: {
                    dataSrc: 'id',
                    selector: 'td:nth-child(2)'
                },
                columnDefs: [
                    {"sClass": "text-center justify-content-center align-middle", "aTargets": "_all"},
                    {type: 'turkish', targets: '_all'}
                ]
            });
            table.on('draw.dt', function () {
                table.columns.adjust()
                table.responsive.recalc();
            });
            table.on("responsive-display", function () {
                table.columns.adjust();
                table.responsive.recalc();
            });
            table.on("responsive-resize", function () {
                table.columns.adjust();
                table.responsive.recalc();
            });
            table.on('row-reorder', function (e, diff) {
                if (diff.length) {
                    let data = [];
                    diff.forEach(element => {
                        let row = table.row(element.node).data();

                        data.push({
                            id: row.id,
                            position: element.newPosition,
                        });
                    });
                    $.ajax({
                        method: 'POST',
                        dataType: "json",
                        url: "{{ route("panel.slider.ranksetter") }}",
                        data: {data}
                    }).done(function (response) {
                        if (response.success) {
                            table.ajax.reload()
                            iziToast.success({
                                title: response.title,
                                message: response.msg,
                                position: "topCenter"
                            })
                        } else {
                            iziToast.error({
                                title: response.title,
                                message: response.msg,
                                position: "topCenter"
                            })
                        }

                    });

                }
            });


        });

    </script>
@endsection
