@extends('layouts.index')

@section('title', 'Pembelian')

@section('breadcrumb')
    <li class="breadcrumb-item active" aria-current="page">Pembelian</li>
@endsection

@push('styles')
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.22/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.dataTables.min.css">
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endpush

@section('content')
<a href="#" class="btn btn-primary mb-3 float-right" data-toggle="modal" data-target="#modal-tambah">Tambah</a>
<a href="{{ route('download') }}" class="btn btn-success mr-3 mb-3 float-right">Download</a>
<div class="clearfix"></div>

<div class="card mb-4 shadow-sm">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="table" style="width: 100%">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Kode Barang</th>
                        <th>Nama Barang</th>
                        <th>Qty</th>
                        <th>Satuan</th>
                        <th>Harga</th>
                        <th>Diskon %</th>
                        <th>Subtotal</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>

{{-- modal --}}
<div class="modal fade" id="modal-tambah" tabindex="-1" role="dialog" aria-labelledby="modal" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="POST" id="form-tambah">
                <div class="modal-body">
                    <div class="alert alert-danger error-message d-none" role="alert">
                        <ul class="m-0"></ul>
                    </div>

                    
                    <div class="form-group">
                        <label for="">Nomor Pembelian</label>
                        <input type="text" name="nomor_pembelian" class="form-control" autocomplete="off">
                    </div>
                    <div class="form-group">
                        <label for="">Kode barang</label>
                        <select name="kode_barang" class="form-control select-barang" id="">
                            @foreach ($barang as $item)
                                <option value="{{ $item->kode_barang }}">{{ $item->kode_barang }} - {{ $item->nama_barang }}</option>
                            @endforeach    
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="">Satuan</label>
                        <input type="text" name="satuan" class="form-control" autocomplete="off">
                    </div>
                    <div class="form-group">
                        <label for="">QTY</label>
                        <input type="number" name="qty" class="form-control" autocomplete="off">
                    </div>
                    <div class="form-group">
                        <label for="">Diskon</label>
                        <input type="number" name="diskon" class="form-control" autocomplete="off">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" name="close-modal" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                    <button type="submit" name="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade" id="modal-edit" tabindex="-1" role="dialog" aria-labelledby="modal" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="POST" id="form-edit">
                <div class="modal-body">
                    <div class="alert alert-danger error-message d-none" role="alert">
                        <ul class="m-0"></ul>
                    </div>

                    <div class="form-group">
                        <label for="">Nomor Pembelian</label>
                        <input type="text" name="nomor_pembelian" class="form-control" autocomplete="off" readonly>
                    </div>
                    <div class="form-group">
                        <label for="">Kode barang</label>
                        <select name="kode_barang" class="form-control" id="" readonly>
                            @foreach ($barang as $item)
                                <option value="{{ $item->kode_barang }}">{{ $item->kode_barang }} - {{ $item->nama_barang }}</option>
                            @endforeach    
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="">Satuan</label>
                        <input type="text" name="satuan" class="form-control" autocomplete="off">
                    </div>
                    <div class="form-group">
                        <label for="">QTY</label>
                        <input type="number" name="qty" class="form-control" autocomplete="off">
                    </div>
                    <div class="form-group">
                        <label for="">Diskon</label>
                        <input type="number" name="diskon" class="form-control" autocomplete="off">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" name="close-modal" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                    <button type="submit" name="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.22/js/dataTables.bootstrap4.min.js"></script>

<script src="https://cdn.datatables.net/buttons/2.2.3/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.html5.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
<script>
$(document).ready(function() {
    var table = $('#table').DataTable({
        processing: true,
        ajax: '{{ route("pembelian.index") }}',
        columns: [
            { data: 'DT_RowIndex', name:'DT_RowIndex', searchable: false },
            { data: 'barang.kode_barang', name: 'kode_barang' },
            { data: 'barang.nama_barang', name: 'nama_barang' },
            { data: 'qty', name: 'qty' },
            { data: 'satuan', name: 'satuan' },
            { data: 'harga', name: 'harga' },
            { data: 'diskon', name: 'diskon' },
            { data: 'subtotal', name: 'subtotal' },
            { data: 'aksi', name: 'aksi', orderable: false, searchable: false },
        ],
        columnDefs: [
            { "className": "text-center", "targets": [0, 8] },
            { "width": "5%", "targets": 0 },
            { "width": "20%", "targets": 8 },
        ],
        dom: 'Bfrtip',
        buttons: [
            {
                extend: 'pdf',
                exportOptions: {
                    columns: [0,1,2,3,4,5,6,7]
                }
            }
        ]
    });

    $('.select-barang').select2({ width: '100%' });

    $('#table').on('click', '.edit', function(e) {
        e.preventDefault()
        $('#modal-edit button[name="submit"]').attr('data-id', $(this).attr('data-id'));
    });

    var tambah = $("#modal-tambah button[name='submit']");
    tambah.click(function(e) {
        e.preventDefault();

        tambah.attr("disabled", true);
        tambah.text('Loading');

        $('.error-message').addClass('d-none');
        $('.error-message ul').empty();

        var form = new FormData($('#form-tambah')[0]);
        form.append('aksi', 'tambah');

        var opt = {
            method: 'POST',
            aksi: 'tambah',
            url: '{{ route("pembelian.store") }}',
            table: table,
            element: tambah
        };

        var txt = {
            btnText: 'Tambah Data',
            msgAlert: 'Data berhasil ditambahkan',
            msgText: 'ditambah'
        };

        requestAjaxPost(opt, form, txt);
    });

    var modalEdit_nomor_pembelian = $('#modal-edit input[name="nomor_pembelian"]');
    var modalEdit_kode_barang = $('#modal-edit select[name="kode_barang"]');
    var modalEdit_satuan = $('#modal-edit input[name="satuan"]');
    var modalEdit_qty = $('#modal-edit input[name="qty"]');
    var modalEdit_diskon = $('#modal-edit input[name="diskon"]');
    $('#modal-edit').on('hidden.bs.modal', function () {
        modalEdit_nomor_pembelian.val("");
        modalEdit_kode_barang.val("");
        modalEdit_satuan.val("");
        modalEdit_qty.val("");
        modalEdit_diskon.val("");
    });
    $('#table').on('click', '.edit', function(e) {
        e.preventDefault()

        var url = "{{ route('pembelian.show', ':id') }}";
        url = url.replace(':id', $(this).attr('data-id'));

        $('#modal-edit button[name="submit"]').attr('data-id', $(this).attr('data-id'));
        modalEdit_satuan.attr("disabled", true);
        modalEdit_qty.attr("disabled", true);
        modalEdit_diskon.attr("disabled", true);
        
        $.ajax({
            url: url,
            method: "GET",
            cache: false,
            processData: false,
            contentType: false
        }).done(function(msg) {
            modalEdit_nomor_pembelian.val(msg.data.nomor_pembelian);
            
            modalEdit_nomor_pembelian.trigger('focus');
            modalEdit_kode_barang.val(msg.data.kode_barang);

            modalEdit_satuan.attr("disabled", false);
            modalEdit_satuan.val(msg.data.satuan);

            modalEdit_diskon.attr("disabled", false);
            modalEdit_qty.val(msg.data.qty);

            modalEdit_qty.attr("disabled", false);
            modalEdit_diskon.val(msg.data.diskon);
        }).fail(function(err) {
            alert("Terjadi kesalahan pada server");
            modalEdit_satuan.attr("disabled", false);
            modalEdit_qty.attr("disabled", false);
            modalEdit_diskon.attr("disabled", false);
        });
    });
    $('#modal-edit').on('shown.bs.modal', function() {
        $('#modal-edit input[name="nama"]').trigger('focus');
    });

    var edit = $("#modal-edit button[name='submit']");
    edit.click(function(e) {
        e.preventDefault();

        edit.attr("disabled", true);
        edit.text('Loading');

        $('.error-message').addClass('d-none');
        $('.error-message ul').empty();

        var form = new FormData($('#form-edit')[0]);
        form.append('aksi', 'edit');
        form.append('_method', 'PATCH');

        var url = "{{ route('pembelian.update', ':id') }}";
        url = url.replace(':id', $(this).attr('data-id'));

        var opt = {
            method: 'POST',
            aksi: 'edit',
            url: url,
            table: table,
            element: edit
        };

        var txt = {
            btnText: 'Simpan',
            msgAlert: 'Data berhasil diedit',
            msgText: 'diedit'
        };

        requestAjaxPost(opt, form, txt);
    });

    $('#table').on('click', '.delete', function(event) {
        var url = "{{ route('pembelian.destroy', ':id') }}";
        url = url.replace(':id', $(this).attr('data-id'));

        var opt = {
            url: url,
            method: 'DELETE',
            aksi: 'hapus',
            table: table
        };
        
        var txt = {
            msgAlert: "Data akan dihapus!",
            msgText: "hapus",
            msgTitle: 'Data berhasil dihapus'
        };

        requestAjaxDelete(opt, txt);
    });
});
</script>
@endpush