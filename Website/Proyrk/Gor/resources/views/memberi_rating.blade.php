@extends('layouts.app')

@section('content')
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

<div class="container mt-4">
    <!-- ✅ Dynamic User Info -->
    <div class="text-center">
        <i class="bi bi-person-circle" style="font-size: 4rem;"></i>
        <h4 class="mt-2">{{ $data['untuk_user']['nama'] }}</h4>
        <p>{{ $data['untuk_user']['email'] }}<br>{{ $data['untuk_user']['nomor_telepon'] }}</p>
    </div>

    <!-- ✅ Dynamic Reviews -->
     <div class="mb-4">
    <a href="{{ url()->previous() }}" class="btn btn-outline-secondary">
        <i class="bi bi-arrow-left"></i> Kembali
    </a>
</div>

<h5 class="mt-5 mb-3">Reviews</h5>
<div class="row">
    @forelse ($data['penilaian'] as $review)
        <div class="col-md-6 mb-3">
            <div class="p-3 border rounded bg-light">
                <div class="d-flex align-items-center mb-2">
                    <i class="bi bi-person-circle me-2"></i>
                    <strong>{{ $review['dari_user'] }}</strong>
                </div>
                
                {{-- ⭐ Bintang rating --}}
                <div class="mb-1" style="color: orange;">
                    @for ($i = 1; $i <= 5; $i++)
                        @if ($i <= $review['rating'])
                            <i class="bi bi-star-fill"></i>
                        @else
                            <i class="bi bi-star"></i>
                        @endif
                    @endfor
                </div>

                <p class="mb-0">{{ $review['komentar'] }}</p>
            </div>
        </div>
    @empty
        <p class="text-muted">Belum ada penilaian.</p>
    @endforelse
</div>


    <!-- Form Penilaian -->
@if (!Session::has('jwt'))
    <div class="alert alert-warning">
        Anda harus login terlebih dahulu untuk memberi rating.
    </div>
@elseif($sudahMemberiRating ?? false)
    <div class="alert alert-success">
        Anda sudah memberikan rating kepada pemain ini.
    </div>
@else
    <!-- Form Penilaian -->
    <h5 class="mt-5">Rating Anda (1-5)</h5>
    <form method="POST" action="{{ route('rating.kirim') }}">
        @csrf

        <input type="hidden" name="untuk_user" value="{{ request()->get('userId') }}">
        <input type="hidden" name="mabar_id" value="{{ request()->get('mabarId') }}">

        <!-- Bintang rating -->
        <div id="rating-stars" class="mb-3">
            @for ($i = 1; $i <= 5; $i++)
                <i class="bi bi-star" data-value="{{ $i }}" style="font-size: 2rem; color: orange; cursor: pointer;"></i>
            @endfor
        </div>
        <input type="hidden" name="rating" id="nilai-rating" value="0">

        <!-- Komentar -->
        <h5>Berikan Komentar</h5>
        <textarea name="komentar" class="form-control mb-4" rows="4" placeholder="Tambahkan Komentar Anda"></textarea>

        <div class="d-flex justify-content-between">
            <a href="#" class="btn btn-outline-secondary">Lewati</a>
            <button type="submit" class="btn btn-primary">Kirim</button>
        </div>
    </form>
@endif

</div>


<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
  const stars = document.querySelectorAll('#rating-stars i');
    const ratingInput = document.getElementById('nilai-rating');

    stars.forEach(star => {
        star.addEventListener('click', () => {
            const rating = parseInt(star.getAttribute('data-value'));
            ratingInput.value = rating;

            stars.forEach(s => {
                s.classList.remove('bi-star-fill');
                s.classList.add('bi-star');
            });

            for (let i = 0; i < rating; i++) {
                stars[i].classList.remove('bi-star');
                stars[i].classList.add('bi-star-fill');
            }
        });
    });

    // Validasi sebelum submit
    const form = document.querySelector('form');
    const komentarInput = document.querySelector('textarea[name="komentar"]');

    form.addEventListener('submit', function (e) {
        const rating = parseInt(ratingInput.value);
        const komentar = komentarInput.value.trim();

        if (rating === 0) {
            e.preventDefault();
            Swal.fire({
                icon: 'warning',
                title: 'Rating wajib diisi!',
                text: 'Silakan pilih minimal 1 bintang sebelum mengirim.',
            });
            return;
        }

        if (komentar === '') {
            e.preventDefault();
            Swal.fire({
                title: 'Tanpa komentar?',
                text: "Apakah Anda yakin ingin mengirim rating tanpa komentar?",
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Ya, kirim saja',
                cancelButtonText: 'Tidak, saya isi dulu'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit(); // Kirim ulang form manual setelah konfirmasi
                }
            });
        }
    });
</script>
@endsection
