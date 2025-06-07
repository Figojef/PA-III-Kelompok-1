@extends('layouts.app')

@section('content')
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

<div class="container mt-4">
    <div class="text-center">
        <i class="bi bi-person-circle" style="font-size: 4rem;"></i>
        <h4 class="mt-2">Harry Sihite</h4>
        <p>Pemula</p>
    </div>

    <!-- Reviews -->
    <h5 class="mt-5 mb-3">Reviews</h5>
    <div class="row">
        <div class="col-md-6 mb-3">
            <div class="p-3 border rounded bg-light">
                <div class="d-flex align-items-center mb-2">
                    <i class="bi bi-person-circle me-2"></i>
                    <strong>Seriz</strong>
                </div>
                <p class="mb-0">Mainnya jago, tapi tetap santuy</p>
            </div>
        </div>
        <div class="col-md-6 mb-3">
            <div class="p-3 border rounded bg-light">
                <div class="d-flex align-items-center mb-2">
                    <i class="bi bi-person-circle me-2"></i>
                    <strong>Edo</strong>
                </div>
                <p class="mb-0">Mainnya asik, gokil, saya belajar teknik baru</p>
            </div>
        </div>
    </div>

    <!-- Form Penilaian -->
    <h5 class="mt-5">Rating Anda (1-5)</h5>
    <form method="POST" action="#">
        @csrf

        <!-- Rating Stars -->
        <div id="rating-stars" class="mb-3">
            @for ($i = 1; $i <= 5; $i++)
                <i class="bi bi-star" data-value="{{ $i }}" style="font-size: 2rem; color: orange; cursor: pointer;"></i>
            @endfor
        </div>
        <input type="hidden" name="nilai" id="nilai-rating" value="0">

        <!-- Komentar -->
        <h5>Berikan Komentar</h5>
        <textarea name="komentar" class="form-control mb-4" rows="4" placeholder="Tambahkan Komentar Anda"></textarea>

        <!-- Tombol -->
        <div class="d-flex justify-content-between">
            <a href="#" class="btn btn-outline-secondary">Lewati</a>
            <button type="submit" class="btn btn-primary">Kirim</button>
        </div>
    </form>
</div>

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
</script>
@endsection
