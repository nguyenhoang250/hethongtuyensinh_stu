@extends('layouts.app')

@section('title', 'Ngành Học — STU Tuyển Sinh 2026')

@section('content')
<style>
    .page-hero { background: linear-gradient(135deg, var(--navy) 0%, var(--blue) 100%); padding: 56px 0 48px; color: white; }
    .page-hero h1 { font-family: var(--font-display); font-size: clamp(28px,4vw,42px); margin-bottom: 12px; }
    .page-hero p { font-size: 15px; opacity: .8; max-width: 560px; }
    .filter-bar { background: white; border-bottom: 1px solid var(--gray-100); padding: 16px 0; position: sticky; top: 0; z-index: 100; box-shadow: 0 2px 12px rgba(13,27,62,.06); }
    .filter-inner { display: flex; align-items: center; gap: 12px; flex-wrap: wrap; }
    .filter-btn { padding: 7px 18px; border-radius: 50px; border: 1.5px solid var(--gray-300); font-size: 13px; font-weight: 600; color: var(--gray-700); background: white; cursor: pointer; transition: all .2s; font-family: var(--font-body); }
    .filter-btn:hover, .filter-btn.active { background: var(--navy); color: white; border-color: var(--navy); }
    .nganh-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(320px, 1fr)); gap: 24px; padding: 48px 0; }
    .nganh-card { background: white; border: 1px solid var(--gray-100); border-radius: var(--radius-lg); overflow: hidden; transition: all .25s; cursor: pointer; }
    .nganh-card:hover { transform: translateY(-4px); box-shadow: var(--shadow-hover); border-color: var(--gray-300); }
    .nganh-card-head { background: linear-gradient(135deg, var(--navy) 0%, var(--blue-light) 100%); padding: 20px; color: white; }
    .nganh-ma { font-size: 11px; font-weight: 700; letter-spacing: .1em; opacity: .75; margin-bottom: 6px; }
    .nganh-ten { font-family: var(--font-display); font-size: 17px; line-height: 1.3; margin-bottom: 4px; }
    .nganh-ten-en { font-size: 12px; opacity: .65; }
    .nganh-card-body { padding: 16px 20px; }
    .nganh-meta { display: flex; gap: 16px; margin-bottom: 12px; }
    .nganh-meta-item { display: flex; align-items: center; gap: 6px; font-size: 12.5px; color: var(--gray-500); }
    .nganh-meta-item i { color: var(--navy); font-size: 12px; }
    .nganh-mo-ta { font-size: 13px; color: var(--gray-500); line-height: 1.6; display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical; overflow: hidden; margin-bottom: 14px; }
    .nganh-footer { display: flex; align-items: center; justify-content: space-between; padding-top: 12px; border-top: 1px solid var(--gray-100); }
    .nganh-hocphi { font-size: 13px; font-weight: 700; color: var(--red); }
    .nganh-hocphi span { font-size: 11px; font-weight: 400; color: var(--gray-500); }
    .btn-detail { padding: 6px 14px; background: var(--navy); color: white; border-radius: 50px; font-size: 12px; font-weight: 600; transition: all .2s; }
    .btn-detail:hover { background: var(--red); }
    .tohop-tags { display: flex; flex-wrap: wrap; gap: 4px; margin-bottom: 12px; }
    .tohop-tag { padding: 3px 10px; background: rgba(13,71,161,.08); color: var(--navy); border-radius: 20px; font-size: 11.5px; font-weight: 600; }
    .tohop-tag.chinh { background: var(--navy); color: white; }
    .empty-state { text-align: center; padding: 80px 0; color: var(--gray-500); }
    .empty-state i { font-size: 48px; margin-bottom: 16px; opacity: .3; }
</style>

{{-- Hero --}}
<div class="page-hero">
    <div class="container">
        <div class="section-label">Đào tạo</div>
        <h1>Ngành Học tại STU</h1>
        <p>Khám phá các ngành đào tạo chất lượng cao, định hướng ứng dụng và thực tiễn tại Đại học Công nghệ Sài Gòn.</p>
    </div>
</div>

{{-- Filter --}}
<div class="filter-bar">
    <div class="container">
        <div class="filter-inner">
            <button class="filter-btn active" data-khoa="all">Tất cả</button>
            @foreach($khoas as $khoa)
                <button class="filter-btn" data-khoa="{{ $khoa->id }}">{{ $khoa->ten_khoa }}</button>
            @endforeach
        </div>
    </div>
</div>

{{-- Danh sách ngành --}}
<div class="container">
    <div class="nganh-grid" id="nganh-grid">
        @forelse($nganhHocs as $nganh)
        <div class="nganh-card" data-khoa="{{ $nganh->khoa_id }}">
            <div class="nganh-card-head">
                <div class="nganh-ma">{{ $nganh->ma_nganh }}</div>
                <div class="nganh-ten">{{ $nganh->ten_nganh }}</div>
                @if($nganh->ten_nganh_en)
                    <div class="nganh-ten-en">{{ $nganh->ten_nganh_en }}</div>
                @endif
            </div>
            <div class="nganh-card-body">
                <div class="nganh-meta">
                    <div class="nganh-meta-item">
                        <i class="fas fa-university"></i>
                        {{ $nganh->khoa->ten_khoa ?? '—' }}
                    </div>
                    <div class="nganh-meta-item">
                        <i class="fas fa-clock"></i>
                        {{ $nganh->thoi_gian_dao_tao }} năm
                    </div>
                </div>
                @if($nganh->toHopMon->count())
                <div class="tohop-tags">
                    @foreach($nganh->toHopMon as $tohop)
                        <span class="tohop-tag {{ $tohop->is_chinh ? 'chinh' : '' }}">{{ $tohop->ma_to_hop }}</span>
                    @endforeach
                </div>
                @endif
                @if($nganh->mo_ta)
                    <div class="nganh-mo-ta">{{ $nganh->mo_ta }}</div>
                @endif
                <div class="nganh-footer">
                    <div class="nganh-hocphi">
                        @if($nganh->hocPhi->first())
                            {{ number_format($nganh->hocPhi->first()->hoc_phi_mot_hk) }}đ
                            <span>/học kỳ</span>
                        @else
                            <span>Liên hệ</span>
                        @endif
                    </div>
                    <a href="{{ url('/nganh-hoc/' . $nganh->id) }}" class="btn-detail">
                        Xem chi tiết <i class="fas fa-arrow-right"></i>
                    </a>
                </div>
            </div>
        </div>
        @empty
        <div class="empty-state" style="grid-column:1/-1">
            <i class="fas fa-graduation-cap"></i>
            <p>Chưa có ngành học nào.</p>
        </div>
        @endforelse
    </div>
</div>

@push('scripts')
<script>
    const filterBtns = document.querySelectorAll('.filter-btn');
    const cards = document.querySelectorAll('.nganh-card');

    filterBtns.forEach(btn => {
        btn.addEventListener('click', () => {
            filterBtns.forEach(b => b.classList.remove('active'));
            btn.classList.add('active');
            const khoa = btn.dataset.khoa;
            cards.forEach(card => {
                card.style.display = (khoa === 'all' || card.dataset.khoa === khoa) ? 'block' : 'none';
            });
        });
    });
</script>
@endpush
@endsection