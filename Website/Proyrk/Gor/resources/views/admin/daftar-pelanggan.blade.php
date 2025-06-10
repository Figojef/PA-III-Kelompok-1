@extends('layouts.admin.app')

@section('content')

<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">Daftar Pelanggan</h1>

    <div class="table-responsive">
        <table class="table table-bordered table-striped table-hover">
            <thead class="thead-light">
                <tr>
                    <th>Foto</th>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>No. Telepon</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($pelanggan as $p)
                <tr>
                    <td>
                        @if($p['foto'])
                            <a href="#" data-toggle="modal" data-target="#fotoModal{{ $p['_id'] }}">
                                <img src="{{ $p['foto'] }}" alt="Foto" width="50" height="50" class="rounded-circle">
                            </a>

                            <!-- Modal -->
                            <div class="modal fade" id="fotoModal{{ $p['_id'] }}" tabindex="-1" role="dialog" aria-labelledby="fotoModalLabel{{ $p['_id'] }}" aria-hidden="true">
                              <div class="modal-dialog modal-dialog-centered" role="document">
                                <div class="modal-content">
                                  <div class="modal-header">
                                    <h5 class="modal-title" id="fotoModalLabel{{ $p['_id'] }}">Foto {{ $p['name'] }}</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                      <span aria-hidden="true">&times;</span>
                                    </button>
                                  </div>
                                  <div class="modal-body text-center">
                                    <img src="{{ $p['foto'] }}" alt="Foto {{ $p['name'] }}" class="img-fluid rounded">
                                  </div>
                                </div>
                              </div>
                            </div>
                        @else
                            <span class="text-muted">Tidak ada</span>
                        @endif
                    </td>
                    <td>{{ $p['name'] }}</td>
                    <td>{{ $p['email'] }}</td>
                    <td>{{ $p['nomor_telepon'] }}</td>
                    <td>
                        <a href="{{ route('admin.catatan-transaksi', ['user_id' => $p['_id']]) }}" class="btn btn-sm btn-primary">
                            Lihat Catatan Riwayat Transaksi
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

@endsection