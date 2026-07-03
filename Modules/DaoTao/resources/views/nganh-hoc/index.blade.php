@extends('layouts.admin')

@section('title', 'Quản lý Ngành Học')
@section('page_title', 'Quản lý Ngành Học')

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title"><i class="fas fa-graduation-cap mr-2"></i>Danh sách Ngành Học</h3>
        <div class="card-tools">
            <a href="{{ route('admin.nganh-hoc.create') }}" class="btn btn-primary btn-sm">
                <i class="fas fa-plus"></i> Thêm mới
            </a>
        </div>
    </div>
    <div class="card-body">

        @if(session('success'))
            <div class="alert alert-success alert-dismissible">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                <i class="fas fa-check-circle mr-1"></i>{{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                <i class="fas fa-exclamation-circle mr-1"></i>{{ session('error') }}
            </div>
        @endif

        <table class="table table-bordered table-hover">
            <thead class="thead-dark">
                <tr>
                    <th width="40">#</th>
                    <th width="110">Mã Ngành</th>
                    <th>Tên Ngành</th>
                    <th>Khoa</th>
                    <th width="100">Trình độ</th>
                    <th width="90">Thời gian</th>
                    <th width="100">Trạng thái</th>
                    <th width="155">Thao tác</th>
                </tr>
            </thead>
            <tbody>
                @forelse($nganhHocs as $nganh)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td><span class="badge badge-info px-2 py-1">{{ $nganh->ma_nganh }}</span></td>
                    <td>
                        <strong>{{ $nganh->ten_nganh }}</strong>
                        @if($nganh->ten_nganh_en)
                            <br><small class="text-muted">{{ $nganh->ten_nganh_en }}</small>
                        @endif
                    </td>
                    <td>{{ $nganh->khoa->ten_khoa ?? '—' }}</td>
                    <td>
                        @if($nganh->trinh_do == 'dai_hoc')
                            <span class="badge badge-primary">Đại học</span>
                        @else
                            <span class="badge badge-secondary">Liên thông</span>
                        @endif
                    </td>
                    <td>{{ $nganh->thoi_gian_dao_tao }} năm</td>
                    <td>
                        @if($nganh->trang_thai)
                            <span class="badge badge-success">Hoạt động</span>
                        @else
                            <span class="badge badge-danger">Dừng</span>
                        @endif
                    </td>
                    <td>
                        <button class="btn btn-info btn-xs btn-xem-chi-tiet"
                                data-url="{{ route('admin.nganh-hoc.show', $nganh->id) }}"
                                data-id="{{ $nganh->id }}">
                            <i class="fas fa-eye"></i> Chi tiết
                        </button>
                        <a href="{{ route('admin.nganh-hoc.edit', $nganh->id) }}"
                           class="btn btn-warning btn-xs" title="Sửa">
                            <i class="fas fa-edit"></i>
                        </a>
                        <form action="{{ route('admin.nganh-hoc.destroy', $nganh->id) }}"
                              method="POST" class="d-inline"
                              onsubmit="return confirm('Xóa ngành {{ addslashes($nganh->ten_nganh) }}?')">
                            @csrf @method('DELETE')
                            <button class="btn btn-danger btn-xs" title="Xóa">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="text-center text-muted py-4">
                        <i class="fas fa-inbox fa-2x mb-2 d-block"></i>Chưa có dữ liệu
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>

    </div>
</div>

{{-- ================================================================
     MODAL XEM CHI TIẾT + THÊM/SỬA/XÓA TRỰC TIẾP
================================================================ --}}
<div class="modal fade" id="modalChiTiet" tabindex="-1" role="dialog"
     data-tohop-store-base="{{ url('admin/nganh-hoc') }}"
     data-tohop-item-base="{{ url('admin/to-hop-mon') }}"
     data-hocphi-store-base="{{ url('admin/nganh-hoc') }}"
     data-hocphi-item-base="{{ url('admin/hoc-phi') }}"
     data-ctdt-store-base="{{ url('admin/nganh-hoc') }}"
     data-ctdt-item-base="{{ url('admin/chuong-trinh-dao-tao') }}"
     data-csrf="{{ csrf_token() }}">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">

            {{-- Header --}}
            <div class="modal-header bg-dark text-white">
                <div>
                    <h5 class="modal-title mb-0" id="modalTenNganh">—</h5>
                    <small id="modalTenNganhEn" class="text-light"></small>
                </div>
                <button type="button" class="close text-white" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>

            <div class="modal-body pb-0">

                {{-- Thông tin tóm tắt --}}
                <div class="row mb-3">
                    <div class="col-md-3">
                        <small class="text-muted d-block">Mã ngành</small>
                        <strong id="modalMaNganh" class="text-info"></strong>
                    </div>
                    <div class="col-md-3">
                        <small class="text-muted d-block">Khoa</small>
                        <strong id="modalKhoa"></strong>
                    </div>
                    <div class="col-md-2">
                        <small class="text-muted d-block">Trình độ</small>
                        <span id="modalTrinhDo" class="badge badge-primary"></span>
                    </div>
                    <div class="col-md-2">
                        <small class="text-muted d-block">Thời gian</small>
                        <strong id="modalThoiGian"></strong>
                    </div>
                    <div class="col-md-2">
                        <small class="text-muted d-block">Trạng thái</small>
                        <span id="modalTrangThai"></span>
                    </div>
                </div>

                {{-- Tabs --}}
                <ul class="nav nav-tabs" id="tabChiTiet" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" data-toggle="tab" href="#panel-tohop">
                            <i class="fas fa-list-ul mr-1"></i>Tổ hợp môn
                            <span class="badge badge-info ml-1" id="badge-tohop">0</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#panel-hocphi">
                            <i class="fas fa-money-bill-wave mr-1"></i>Học phí
                            <span class="badge badge-warning ml-1" id="badge-hocphi">0</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#panel-ctdt">
                            <i class="fas fa-file-pdf mr-1"></i>Chương trình ĐT
                            <span class="badge badge-success ml-1" id="badge-ctdt">0</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#panel-mota">
                            <i class="fas fa-info-circle mr-1"></i>Mô tả & Chuẩn đầu ra
                        </a>
                    </li>
                </ul>

                <div class="tab-content border border-top-0 p-3">

                    {{-- Tab 1: Tổ hợp môn --}}
                    <div class="tab-pane fade show active" id="panel-tohop">
                        <div id="loading-tohop" class="text-center py-3">
                            <i class="fas fa-spinner fa-spin"></i> Đang tải...
                        </div>

                        <div id="content-tohop" style="display:none">
                            <div class="d-flex justify-content-end mb-2">
                                <button type="button" class="btn btn-success btn-xs" id="btn-add-tohop">
                                    <i class="fas fa-plus mr-1"></i>Thêm tổ hợp môn
                                </button>
                            </div>
                            <table class="table table-sm table-bordered mb-0">
                                <thead class="thead-light">
                                    <tr>
                                        <th width="140">Mã tổ hợp</th>
                                        <th>Môn thi</th>
                                        <th width="110">Loại</th>
                                        <th width="90">Thao tác</th>
                                    </tr>
                                </thead>
                                <tbody id="tbody-tohop"></tbody>
                            </table>
                        </div>
                        <div id="empty-tohop" class="text-center text-muted py-3" style="display:none">
                            Chưa có tổ hợp môn nào.
                        </div>
                    </div>

                    {{-- Tab 2: Học phí --}}
                    <div class="tab-pane fade" id="panel-hocphi">
                        <div id="loading-hocphi" class="text-center py-3">
                            <i class="fas fa-spinner fa-spin"></i> Đang tải...
                        </div>

                        <div id="content-hocphi" style="display:none">
                            <div class="d-flex justify-content-end mb-2">
                                <button type="button" class="btn btn-success btn-xs" id="btn-add-hocphi">
                                    <i class="fas fa-plus mr-1"></i>Thêm học phí
                                </button>
                            </div>
                            <table class="table table-sm table-bordered mb-0">
                                <thead class="thead-light">
                                    <tr>
                                        <th width="120">Năm học</th>
                                        <th>Học phí / học kỳ</th>
                                        <th>Học phí / tín chỉ</th>
                                        <th>Ghi chú</th>
                                        <th width="90">Thao tác</th>
                                    </tr>
                                </thead>
                                <tbody id="tbody-hocphi"></tbody>
                            </table>
                        </div>
                        <div id="empty-hocphi" class="text-center text-muted py-3" style="display:none">
                            Chưa có thông tin học phí.
                        </div>
                    </div>

                    {{-- Tab 3: Chương trình đào tạo --}}
                    <div class="tab-pane fade" id="panel-ctdt">
                        <div id="loading-ctdt" class="text-center py-3">
                            <i class="fas fa-spinner fa-spin"></i> Đang tải...
                        </div>

                        <div id="content-ctdt" style="display:none">
                            <div class="d-flex justify-content-end mb-2">
                                <button type="button" class="btn btn-success btn-xs" id="btn-add-ctdt">
                                    <i class="fas fa-plus mr-1"></i>Thêm chương trình ĐT
                                </button>
                            </div>
                            <table class="table table-sm table-bordered mb-0">
                                <thead class="thead-light">
                                    <tr>
                                        <th width="120">Năm ban hành</th>
                                        <th width="130">Tổng tín chỉ</th>
                                        <th>File chương trình</th>
                                        <th width="100">Hiển thị</th>
                                        <th width="90">Thao tác</th>
                                    </tr>
                                </thead>
                                <tbody id="tbody-ctdt"></tbody>
                            </table>
                        </div>
                        <div id="empty-ctdt" class="text-center text-muted py-3" style="display:none">
                            Chưa có chương trình đào tạo.
                        </div>
                    </div>

                    {{-- Tab 4: Mô tả & Chuẩn đầu ra --}}
                    <div class="tab-pane fade" id="panel-mota">
                        <div class="row mt-2">
                            <div class="col-md-6">
                                <h6 class="font-weight-bold"><i class="fas fa-align-left mr-1"></i>Mô tả ngành</h6>
                                <div id="modal-mota" class="text-muted p-2 bg-light rounded"
                                     style="white-space:pre-wrap; min-height:80px;">—</div>
                            </div>
                            <div class="col-md-6">
                                <h6 class="font-weight-bold"><i class="fas fa-check-double mr-1"></i>Chuẩn đầu ra</h6>
                                <div id="modal-chuandaura" class="text-muted p-2 bg-light rounded"
                                     style="white-space:pre-wrap; min-height:80px;">—</div>
                            </div>
                        </div>
                    </div>

                </div>{{-- end tab-content --}}
            </div>{{-- end modal-body --}}

            {{-- Footer --}}
            <div class="modal-footer justify-content-between">
                <a id="btn-modal-edit" href="#" class="btn btn-warning btn-sm">
                    <i class="fas fa-edit mr-1"></i>Sửa ngành này
                </a>
                <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">
                    <i class="fas fa-times mr-1"></i>Đóng
                </button>
            </div>

        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
$(function () {

    var $modal   = $('#modalChiTiet');
    var CSRF     = $modal.data('csrf');
    var BASE = {
        tohopStore: $modal.data('tohop-store-base'),   // .../admin/nganh-hoc
        tohopItem:  $modal.data('tohop-item-base'),    // .../admin/to-hop-mon
        hocphiStore: $modal.data('hocphi-store-base'),
        hocphiItem:  $modal.data('hocphi-item-base'),
        ctdtStore:  $modal.data('ctdt-store-base'),
        ctdtItem:   $modal.data('ctdt-item-base')
    };

    // Toàn bộ dữ liệu ngành đang mở trong modal
    var currentData = null;

    // ==============================================================
    // MỞ MODAL — LOAD DỮ LIỆU
    // ==============================================================
    $(document).on('click', '.btn-xem-chi-tiet', function () {
        var url = $(this).data('url');
        var id  = $(this).data('id');

        resetModal(id);
        $modal.modal('show');

        $.ajax({
            url: url,
            method: 'GET',
            headers: { 'X-Requested-With': 'XMLHttpRequest' },
            success: function (d) {
                currentData = d;
                renderModal(d);
            },
            error: function () {
                alert('Không thể tải dữ liệu. Vui lòng thử lại!');
                $modal.modal('hide');
            }
        });
    });

    function resetModal(id) {
        currentData = null;
        $('#modalTenNganh').text('Đang tải...');
        $('#modalTenNganhEn, #modalMaNganh, #modalKhoa, #modalThoiGian').text('');
        $('#modalTrinhDo, #modalTrangThai').html('');
        $('#badge-tohop, #badge-hocphi, #badge-ctdt').text('0');
        $('#tbody-tohop, #tbody-hocphi, #tbody-ctdt').html('');
        $('#modal-mota, #modal-chuandaura').text('—');
        $('#btn-modal-edit').attr('href', '{{ url("admin/nganh-hoc") }}/' + id + '/edit');

        ['tohop','hocphi','ctdt'].forEach(function(k) {
            $('#loading-' + k).show();
            $('#content-' + k + ', #empty-' + k).hide();
        });

        $('a[href="#panel-tohop"]').tab('show');
    }

    function renderModal(d) {
        $('#modalTenNganh').text(d.ten_nganh);
        $('#modalTenNganhEn').text(d.ten_nganh_en || '');
        $('#modalMaNganh').text(d.ma_nganh);
        $('#modalKhoa').text(d.khoa);
        $('#modalThoiGian').text(d.thoi_gian);
        $('#modalTrinhDo').text(d.trinh_do);
        $('#modalTrangThai').html(
            d.trang_thai
            ? '<span class="badge badge-success">Hoạt động</span>'
            : '<span class="badge badge-danger">Dừng</span>'
        );
        $('#modal-mota').text(d.mo_ta || '—');
        $('#modal-chuandaura').text(d.chuan_dau_ra || '—');

        $('#loading-tohop, #loading-hocphi, #loading-ctdt').hide();
        $('#content-tohop, #content-hocphi, #content-ctdt').show();

        renderToHop();
        renderHocPhi();
        renderCtdt();
    }

    function escapeHtml(s) {
        return $('<div>').text(s == null ? '' : s).html();
    }

    function showAlert(msg, type) {
        var icon = type === 'danger' ? 'fa-exclamation-circle' : 'fa-check-circle';
        var $box = $('<div class="alert alert-' + type + ' alert-dismissible py-1 px-2 mb-2">' +
            '<button type="button" class="close" data-dismiss="alert" style="font-size:16px;">&times;</button>' +
            '<i class="fas ' + icon + ' mr-1"></i>' + msg + '</div>');
        $('.modal-body').prepend($box);
        setTimeout(function () { $box.alert('close'); }, 3000);
    }

    function firstErrorMessage(xhr, fallback) {
        if (xhr.responseJSON) {
            if (xhr.responseJSON.errors) {
                var errs = xhr.responseJSON.errors;
                var k = Object.keys(errs)[0];
                if (k) return errs[k][0];
            }
            if (xhr.responseJSON.message) return xhr.responseJSON.message;
        }
        return fallback;
    }

    // ==============================================================
    // 1) TỔ HỢP MÔN
    // ==============================================================
    function renderToHop() {
        var list = currentData.to_hop_mons;
        $('#badge-tohop').text(list.length);
        var $tbody = $('#tbody-tohop');
        $tbody.html('');

        if (list.length === 0) {
            $('#empty-tohop').show();
        } else {
            $('#empty-tohop').hide();
        }

        list.forEach(function (t) {
            var $tr = $('<tr data-id="' + t.id + '"></tr>');
            $tr.html(
                '<td class="cell-ma"><span class="badge badge-info">' + escapeHtml(t.ma_to_hop) + '</span></td>' +
                '<td class="cell-ten">' + escapeHtml(t.ten_to_hop) + '</td>' +
                '<td class="cell-loai">' + (t.is_chinh
                    ? '<span class="badge badge-success">Chính</span>'
                    : '<span class="badge badge-secondary">Phụ</span>') + '</td>' +
                '<td class="text-nowrap">' +
                    '<button class="btn btn-warning btn-xs btn-edit-tohop" title="Sửa"><i class="fas fa-edit"></i></button> ' +
                    '<button class="btn btn-danger btn-xs btn-del-tohop" title="Xóa"><i class="fas fa-trash"></i></button>' +
                '</td>'
            );
            $tr.data('raw', t);
            $tbody.append($tr);
        });
    }

    // Nút "Thêm tổ hợp môn"
    $(document).on('click', '#btn-add-tohop', function () {
        if ($('#row-tohop-new').length) return;
        var $tr = $('<tr id="row-tohop-new"></tr>');
        $tr.html(
            '<td><input type="text" class="form-control form-control-sm" id="new-tohop-ma" maxlength="10" placeholder="VD: A00"></td>' +
            '<td><input type="text" class="form-control form-control-sm" id="new-tohop-ten" maxlength="100" placeholder="VD: Toán - Lý - Hóa"></td>' +
            '<td><select class="form-control form-control-sm" id="new-tohop-chinh">' +
                '<option value="0">Phụ</option><option value="1">Chính</option>' +
            '</select></td>' +
            '<td class="text-nowrap">' +
                '<button class="btn btn-primary btn-xs" id="btn-save-tohop" title="Lưu"><i class="fas fa-check"></i></button> ' +
                '<button class="btn btn-secondary btn-xs" id="btn-cancel-tohop" title="Hủy"><i class="fas fa-times"></i></button>' +
            '</td>'
        );
        $('#tbody-tohop').prepend($tr);
        $('#new-tohop-ma').focus();
    });

    $(document).on('click', '#btn-cancel-tohop', function () {
        $('#row-tohop-new').remove();
    });

    $(document).on('click', '#btn-save-tohop', function () {
        var ma  = $('#new-tohop-ma').val().trim();
        var ten = $('#new-tohop-ten').val().trim();
        var chinh = $('#new-tohop-chinh').val();

        if (!ma || !ten) { showAlert('Vui lòng nhập đủ Mã tổ hợp và Môn thi.', 'danger'); return; }

        var $btn = $(this).prop('disabled', true);
        $.ajax({
            url: BASE.tohopStore + '/' + currentData.id + '/to-hop-mon/ajax',
            method: 'POST',
            headers: { 'X-CSRF-TOKEN': CSRF },
            data: { ma_to_hop: ma, ten_to_hop: ten, is_chinh: chinh },
            success: function (res) {
                currentData.to_hop_mons.push(res.item);
                renderToHop();
                showAlert(res.message, 'success');
            },
            error: function (xhr) {
                showAlert(firstErrorMessage(xhr, 'Thêm tổ hợp môn thất bại!'), 'danger');
                $btn.prop('disabled', false);
            }
        });
    });

    // Sửa dòng tổ hợp môn
    $(document).on('click', '.btn-edit-tohop', function () {
        var $tr = $(this).closest('tr');
        if ($tr.find('input').length) return;
        var t = $tr.data('raw');

        $tr.find('.cell-ma').html('<input type="text" class="form-control form-control-sm" value="' + escapeHtml(t.ma_to_hop) + '" maxlength="10">');
        $tr.find('.cell-ten').html('<input type="text" class="form-control form-control-sm" value="' + escapeHtml(t.ten_to_hop) + '" maxlength="100">');
        $tr.find('.cell-loai').html(
            '<select class="form-control form-control-sm">' +
                '<option value="0"' + (!t.is_chinh ? ' selected' : '') + '>Phụ</option>' +
                '<option value="1"' + (t.is_chinh ? ' selected' : '') + '>Chính</option>' +
            '</select>'
        );
        $tr.find('td:last').html(
            '<button class="btn btn-primary btn-xs btn-save-edit-tohop" title="Lưu"><i class="fas fa-check"></i></button> ' +
            '<button class="btn btn-secondary btn-xs btn-cancel-edit-tohop" title="Hủy"><i class="fas fa-times"></i></button>'
        );
    });

    $(document).on('click', '.btn-cancel-edit-tohop', function () {
        renderToHop();
    });

    $(document).on('click', '.btn-save-edit-tohop', function () {
        var $tr = $(this).closest('tr');
        var id  = $tr.data('id');
        var ma  = $tr.find('.cell-ma input').val().trim();
        var ten = $tr.find('.cell-ten input').val().trim();
        var chinh = $tr.find('.cell-loai select').val();

        if (!ma || !ten) { showAlert('Vui lòng nhập đủ Mã tổ hợp và Môn thi.', 'danger'); return; }

        $.ajax({
            url: BASE.tohopItem + '/' + id + '/ajax',
            method: 'PUT',
            headers: { 'X-CSRF-TOKEN': CSRF },
            data: { ma_to_hop: ma, ten_to_hop: ten, is_chinh: chinh },
            success: function (res) {
                var idx = currentData.to_hop_mons.findIndex(function (x) { return x.id === id; });
                if (idx > -1) currentData.to_hop_mons[idx] = res.item;
                renderToHop();
                showAlert(res.message, 'success');
            },
            error: function (xhr) {
                showAlert(firstErrorMessage(xhr, 'Cập nhật thất bại!'), 'danger');
            }
        });
    });

    $(document).on('click', '.btn-del-tohop', function () {
        var $tr = $(this).closest('tr');
        var id  = $tr.data('id');
        if (!confirm('Xóa tổ hợp môn này?')) return;

        $.ajax({
            url: BASE.tohopItem + '/' + id + '/ajax',
            method: 'DELETE',
            headers: { 'X-CSRF-TOKEN': CSRF },
            success: function (res) {
                currentData.to_hop_mons = currentData.to_hop_mons.filter(function (x) { return x.id !== id; });
                renderToHop();
                showAlert(res.message, 'success');
            },
            error: function (xhr) {
                showAlert(firstErrorMessage(xhr, 'Xóa thất bại!'), 'danger');
            }
        });
    });

    // ==============================================================
    // 2) HỌC PHÍ
    // ==============================================================
    function renderHocPhi() {
        var list = currentData.hoc_phis;
        $('#badge-hocphi').text(list.length);
        var $tbody = $('#tbody-hocphi');
        $tbody.html('');

        if (list.length === 0) {
            $('#empty-hocphi').show();
        } else {
            $('#empty-hocphi').hide();
        }

        list.forEach(function (h) {
            var $tr = $('<tr data-id="' + h.id + '"></tr>');
            $tr.html(
                '<td class="cell-nam"><strong>' + escapeHtml(h.nam_hoc) + '</strong></td>' +
                '<td class="cell-hk text-right">' + h.hoc_phi_mot_hk_fmt + ' ₫</td>' +
                '<td class="cell-tc text-right">' + h.hoc_phi_tin_chi_fmt + ' ₫</td>' +
                '<td class="cell-ghichu">' + (h.ghi_chu ? escapeHtml(h.ghi_chu) : '—') + '</td>' +
                '<td class="text-nowrap">' +
                    '<button class="btn btn-warning btn-xs btn-edit-hocphi" title="Sửa"><i class="fas fa-edit"></i></button> ' +
                    '<button class="btn btn-danger btn-xs btn-del-hocphi" title="Xóa"><i class="fas fa-trash"></i></button>' +
                '</td>'
            );
            $tr.data('raw', h);
            $tbody.append($tr);
        });
    }

    $(document).on('click', '#btn-add-hocphi', function () {
        if ($('#row-hocphi-new').length) return;
        var $tr = $('<tr id="row-hocphi-new"></tr>');
        $tr.html(
            '<td><input type="text" class="form-control form-control-sm" id="new-hocphi-nam" maxlength="10" placeholder="VD: 2026-2027"></td>' +
            '<td><input type="number" min="0" class="form-control form-control-sm" id="new-hocphi-hk" placeholder="VNĐ"></td>' +
            '<td><input type="number" min="0" class="form-control form-control-sm" id="new-hocphi-tc" placeholder="VNĐ"></td>' +
            '<td><input type="text" class="form-control form-control-sm" id="new-hocphi-ghichu" maxlength="500" placeholder="Ghi chú (tùy chọn)"></td>' +
            '<td class="text-nowrap">' +
                '<button class="btn btn-primary btn-xs" id="btn-save-hocphi" title="Lưu"><i class="fas fa-check"></i></button> ' +
                '<button class="btn btn-secondary btn-xs" id="btn-cancel-hocphi" title="Hủy"><i class="fas fa-times"></i></button>' +
            '</td>'
        );
        $('#tbody-hocphi').prepend($tr);
        $('#new-hocphi-nam').focus();
    });

    $(document).on('click', '#btn-cancel-hocphi', function () {
        $('#row-hocphi-new').remove();
    });

    $(document).on('click', '#btn-save-hocphi', function () {
        var nam = $('#new-hocphi-nam').val().trim();
        var hk  = $('#new-hocphi-hk').val();
        var tc  = $('#new-hocphi-tc').val();
        var ghichu = $('#new-hocphi-ghichu').val().trim();

        if (!nam || hk === '' || tc === '') { showAlert('Vui lòng nhập đủ Năm học, Học phí/HK, Học phí/tín chỉ.', 'danger'); return; }

        $.ajax({
            url: BASE.hocphiStore + '/' + currentData.id + '/hoc-phi/ajax',
            method: 'POST',
            headers: { 'X-CSRF-TOKEN': CSRF },
            data: { nam_hoc: nam, hoc_phi_mot_hk: hk, hoc_phi_tin_chi: tc, ghi_chu: ghichu },
            success: function (res) {
                currentData.hoc_phis.push(res.item);
                renderHocPhi();
                showAlert(res.message, 'success');
            },
            error: function (xhr) {
                showAlert(firstErrorMessage(xhr, 'Thêm học phí thất bại!'), 'danger');
            }
        });
    });

    $(document).on('click', '.btn-edit-hocphi', function () {
        var $tr = $(this).closest('tr');
        if ($tr.find('input').length) return;
        var h = $tr.data('raw');

        $tr.find('.cell-nam').html('<input type="text" class="form-control form-control-sm" value="' + escapeHtml(h.nam_hoc) + '" maxlength="10">');
        $tr.find('.cell-hk').html('<input type="number" min="0" class="form-control form-control-sm" value="' + h.hoc_phi_mot_hk + '">');
        $tr.find('.cell-tc').html('<input type="number" min="0" class="form-control form-control-sm" value="' + h.hoc_phi_tin_chi + '">');
        $tr.find('.cell-ghichu').html('<input type="text" class="form-control form-control-sm" value="' + escapeHtml(h.ghi_chu || '') + '" maxlength="500">');
        $tr.find('td:last').html(
            '<button class="btn btn-primary btn-xs btn-save-edit-hocphi" title="Lưu"><i class="fas fa-check"></i></button> ' +
            '<button class="btn btn-secondary btn-xs btn-cancel-edit-hocphi" title="Hủy"><i class="fas fa-times"></i></button>'
        );
    });

    $(document).on('click', '.btn-cancel-edit-hocphi', function () {
        renderHocPhi();
    });

    $(document).on('click', '.btn-save-edit-hocphi', function () {
        var $tr = $(this).closest('tr');
        var id  = $tr.data('id');
        var nam = $tr.find('.cell-nam input').val().trim();
        var hk  = $tr.find('.cell-hk input').val();
        var tc  = $tr.find('.cell-tc input').val();
        var ghichu = $tr.find('.cell-ghichu input').val().trim();

        if (!nam || hk === '' || tc === '') { showAlert('Vui lòng nhập đủ Năm học, Học phí/HK, Học phí/tín chỉ.', 'danger'); return; }

        $.ajax({
            url: BASE.hocphiItem + '/' + id + '/ajax',
            method: 'PUT',
            headers: { 'X-CSRF-TOKEN': CSRF },
            data: { nam_hoc: nam, hoc_phi_mot_hk: hk, hoc_phi_tin_chi: tc, ghi_chu: ghichu },
            success: function (res) {
                var idx = currentData.hoc_phis.findIndex(function (x) { return x.id === id; });
                if (idx > -1) currentData.hoc_phis[idx] = res.item;
                renderHocPhi();
                showAlert(res.message, 'success');
            },
            error: function (xhr) {
                showAlert(firstErrorMessage(xhr, 'Cập nhật thất bại!'), 'danger');
            }
        });
    });

    $(document).on('click', '.btn-del-hocphi', function () {
        var $tr = $(this).closest('tr');
        var id  = $tr.data('id');
        if (!confirm('Xóa dòng học phí này?')) return;

        $.ajax({
            url: BASE.hocphiItem + '/' + id + '/ajax',
            method: 'DELETE',
            headers: { 'X-CSRF-TOKEN': CSRF },
            success: function (res) {
                currentData.hoc_phis = currentData.hoc_phis.filter(function (x) { return x.id !== id; });
                renderHocPhi();
                showAlert(res.message, 'success');
            },
            error: function (xhr) {
                showAlert(firstErrorMessage(xhr, 'Xóa thất bại!'), 'danger');
            }
        });
    });

    // ==============================================================
    // 3) CHƯƠNG TRÌNH ĐÀO TẠO (có upload file PDF)
    // ==============================================================
    function renderCtdt() {
        var list = currentData.chuong_trinh_dao_taos;
        $('#badge-ctdt').text(list.length);
        var $tbody = $('#tbody-ctdt');
        $tbody.html('');

        if (list.length === 0) {
            $('#empty-ctdt').show();
        } else {
            $('#empty-ctdt').hide();
        }

        list.forEach(function (c) {
            var $tr = $('<tr data-id="' + c.id + '"></tr>');
            var fileHtml = c.url_file
                ? '<a href="' + c.url_file + '" target="_blank" class="btn btn-sm btn-outline-danger">' +
                    '<i class="fas fa-file-pdf mr-1"></i>' + escapeHtml(c.ten_file) + '</a>'
                : '—';
            $tr.html(
                '<td class="cell-nam text-center"><strong>' + escapeHtml(c.nam_ban_hanh) + '</strong></td>' +
                '<td class="cell-tinchi text-center">' + c.tong_tin_chi + ' tín chỉ</td>' +
                '<td class="cell-file">' + fileHtml + '</td>' +
                '<td class="cell-hienthi text-center">' + (c.is_hien_thi
                    ? '<span class="badge badge-success">Hiển thị</span>'
                    : '<span class="badge badge-secondary">Ẩn</span>') + '</td>' +
                '<td class="text-nowrap">' +
                    '<button class="btn btn-warning btn-xs btn-edit-ctdt" title="Sửa"><i class="fas fa-edit"></i></button> ' +
                    '<button class="btn btn-danger btn-xs btn-del-ctdt" title="Xóa"><i class="fas fa-trash"></i></button>' +
                '</td>'
            );
            $tr.data('raw', c);
            $tbody.append($tr);
        });
    }

    $(document).on('click', '#btn-add-ctdt', function () {
        if ($('#row-ctdt-new').length) return;
        var $tr = $('<tr id="row-ctdt-new"></tr>');
        $tr.html(
            '<td><input type="text" class="form-control form-control-sm" id="new-ctdt-nam" maxlength="4" placeholder="VD: 2026"></td>' +
            '<td><input type="number" min="1" class="form-control form-control-sm" id="new-ctdt-tinchi" placeholder="Tín chỉ"></td>' +
            '<td><input type="file" accept="application/pdf" class="form-control form-control-sm" id="new-ctdt-file"></td>' +
            '<td class="text-center"><input type="checkbox" id="new-ctdt-hienthi" checked></td>' +
            '<td class="text-nowrap">' +
                '<button class="btn btn-primary btn-xs" id="btn-save-ctdt" title="Lưu"><i class="fas fa-check"></i></button> ' +
                '<button class="btn btn-secondary btn-xs" id="btn-cancel-ctdt" title="Hủy"><i class="fas fa-times"></i></button>' +
            '</td>'
        );
        $('#tbody-ctdt').prepend($tr);
        $('#new-ctdt-nam').focus();
    });

    $(document).on('click', '#btn-cancel-ctdt', function () {
        $('#row-ctdt-new').remove();
    });

    $(document).on('click', '#btn-save-ctdt', function () {
        var nam = $('#new-ctdt-nam').val().trim();
        var tc  = $('#new-ctdt-tinchi').val();
        var fileInput = $('#new-ctdt-file')[0];
        var hienthi = $('#new-ctdt-hienthi').is(':checked') ? 1 : 0;

        if (!nam || !tc || !fileInput.files.length) {
            showAlert('Vui lòng nhập Năm ban hành, Tổng tín chỉ và chọn file PDF.', 'danger');
            return;
        }

        var fd = new FormData();
        fd.append('nam_ban_hanh', nam);
        fd.append('tong_tin_chi', tc);
        fd.append('file_ctdt', fileInput.files[0]);
        fd.append('is_hien_thi', hienthi);

        $.ajax({
            url: BASE.ctdtStore + '/' + currentData.id + '/chuong-trinh-dao-tao/ajax',
            method: 'POST',
            headers: { 'X-CSRF-TOKEN': CSRF },
            data: fd,
            processData: false,
            contentType: false,
            success: function (res) {
                currentData.chuong_trinh_dao_taos.push(res.item);
                renderCtdt();
                showAlert(res.message, 'success');
            },
            error: function (xhr) {
                showAlert(firstErrorMessage(xhr, 'Thêm chương trình đào tạo thất bại!'), 'danger');
            }
        });
    });

    $(document).on('click', '.btn-edit-ctdt', function () {
        var $tr = $(this).closest('tr');
        if ($tr.find('input').length) return;
        var c = $tr.data('raw');

        $tr.find('.cell-nam').html('<input type="text" class="form-control form-control-sm" value="' + escapeHtml(c.nam_ban_hanh) + '" maxlength="4">');
        $tr.find('.cell-tinchi').html('<input type="number" min="1" class="form-control form-control-sm" value="' + c.tong_tin_chi + '">');
        $tr.find('.cell-file').html(
            '<input type="file" accept="application/pdf" class="form-control form-control-sm">' +
            '<small class="text-muted">Bỏ trống nếu không đổi file (hiện: ' + escapeHtml(c.ten_file || '—') + ')</small>'
        );
        $tr.find('.cell-hienthi').html('<input type="checkbox"' + (c.is_hien_thi ? ' checked' : '') + '>');
        $tr.find('td:last').html(
            '<button class="btn btn-primary btn-xs btn-save-edit-ctdt" title="Lưu"><i class="fas fa-check"></i></button> ' +
            '<button class="btn btn-secondary btn-xs btn-cancel-edit-ctdt" title="Hủy"><i class="fas fa-times"></i></button>'
        );
    });

    $(document).on('click', '.btn-cancel-edit-ctdt', function () {
        renderCtdt();
    });

    $(document).on('click', '.btn-save-edit-ctdt', function () {
        var $tr = $(this).closest('tr');
        var id  = $tr.data('id');
        var nam = $tr.find('.cell-nam input').val().trim();
        var tc  = $tr.find('.cell-tinchi input').val();
        var fileInput = $tr.find('.cell-file input[type=file]')[0];
        var hienthi = $tr.find('.cell-hienthi input').is(':checked') ? 1 : 0;

        if (!nam || !tc) { showAlert('Vui lòng nhập đủ Năm ban hành và Tổng tín chỉ.', 'danger'); return; }

        var fd = new FormData();
        fd.append('nam_ban_hanh', nam);
        fd.append('tong_tin_chi', tc);
        fd.append('is_hien_thi', hienthi);
        if (fileInput && fileInput.files.length) {
            fd.append('file_ctdt', fileInput.files[0]);
        }

        $.ajax({
            url: BASE.ctdtItem + '/' + id + '/ajax',
            method: 'POST',
            headers: { 'X-CSRF-TOKEN': CSRF },
            data: fd,
            processData: false,
            contentType: false,
            success: function (res) {
                var idx = currentData.chuong_trinh_dao_taos.findIndex(function (x) { return x.id === id; });
                if (idx > -1) currentData.chuong_trinh_dao_taos[idx] = res.item;
                renderCtdt();
                showAlert(res.message, 'success');
            },
            error: function (xhr) {
                showAlert(firstErrorMessage(xhr, 'Cập nhật thất bại!'), 'danger');
            }
        });
    });

    $(document).on('click', '.btn-del-ctdt', function () {
        var $tr = $(this).closest('tr');
        var id  = $tr.data('id');
        if (!confirm('Xóa chương trình đào tạo này?')) return;

        $.ajax({
            url: BASE.ctdtItem + '/' + id + '/ajax',
            method: 'DELETE',
            headers: { 'X-CSRF-TOKEN': CSRF },
            success: function (res) {
                currentData.chuong_trinh_dao_taos = currentData.chuong_trinh_dao_taos.filter(function (x) { return x.id !== id; });
                renderCtdt();
                showAlert(res.message, 'success');
            },
            error: function (xhr) {
                showAlert(firstErrorMessage(xhr, 'Xóa thất bại!'), 'danger');
            }
        });
    });

});
</script>
@endpush