@extends('layouts.master')

@section('content')
<div class="page-body">
<div class="container-xl">
    @if (session('status'))
    <div class="alert alert-important alert-success alert-dismissible" role="alert">
      <div class="d-flex">
        <div>
          <!-- Download SVG icon from http://tabler-icons.io/i/info-circle -->
          <svg xmlns="http://www.w3.org/2000/svg" class="icon alert-icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M3 12a9 9 0 1 0 18 0a9 9 0 0 0 -18 0" /><path d="M12 9h.01" /><path d="M11 12h1v4h1" /></svg>
        </div>
        <div>
          {{ session('status') }}
        </div>
      </div>
      <a class="btn-close" data-bs-dismiss="alert" aria-label="close"></a>
    </div>
    @endif

    @if(auth()->check() && auth()->user()->role == "Borrower")
    <div class="row row-cards">
      <div class="col-lg-12">
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">Progress Data Peminjam</h3>
          </div>
          <div class="card-body">
            <div class="row">
              <div class="col">
                {!! $progress !!}
              </div>
            </div>
            @if ($borrowerStatus->is_active == '1')
            <div class="row g-2 align-items-center">
              @if ($loanActiveCount != "" && $loanPaidCount != "" && ($loanActiveCount < 1 || $loanPaidCount > 0))
              <div class="col-6 col-sm-4 col-md-2 col-xl py-3">
                <a href="{{ url('/borrower/loan/create/'.encrypt(auth()->user()->id)) }}" class="btn btn-primary w-100">
                    Pengajuan Pinjaman
                </a>
              </div>
              @endif
              <div class="col-6 col-sm-4 col-md-2 col-xl py-3">
                <a href="{{ url('/borrower/loan/history/'.encrypt(auth()->user()->id)) }}" class="btn btn-primary w-100">
                  History Pinjaman Anda
                </a>
              </div>
            </div>
            @endif
          </div>
        </div>
      </div>
    </div>
    @endif
    <div class="row row-cards mt-3">
        <div class="col-md-12 d-flex justify-content-center">
            <div class="row row-cards justify-content-center">
                <div class="col-lg-6">
                  <div class="card card-sm">
                    <div class="card-body">
                      <div class="row align-items-center">
                        <div class="col">
                            <div class="font-weight-medium text-center">
                            TKB90: 99.97% | TKB60: 99.97% | TKB30: 99.97% | TKB0: 99.97%
                            </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row row-cards mt-2">
        <div class="col-md-12 d-flex justify-content-center">
            <div class="row row-cards justify-content-center">
                <div class="col-sm-6 col-lg-3">
                    <div class="card card-sm">
                      <div class="card-body">
                        <div class="row align-items-center">
                          <div class="col-auto">
                            <span class="bg-primary text-white avatar"><!-- Download SVG icon from http://tabler-icons.io/i/currency-dollar -->
                              <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M16.7 8a3 3 0 0 0 -2.7 -2h-4a3 3 0 0 0 0 6h4a3 3 0 0 1 0 6h-4a3 3 0 0 1 -2.7 -2" /><path d="M12 3v3m0 12v3" /></svg>
                            </span>
                          </div>
                          <div class="col">
                            <div class="font-weight-medium">
                                Jumlah Pinjaman
                            </div>
                            <div class="text-secondary">
                                1.523.900.788
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-3">
                    <div class="card card-sm">
                      <div class="card-body">
                        <div class="row align-items-center">
                          <div class="col-auto">
                            <span class="bg-green text-white avatar"><!-- Download SVG icon from http://tabler-icons.io/i/shopping-cart -->
                                <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-moneybag"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M9.5 3h5a1.5 1.5 0 0 1 1.5 1.5a3.5 3.5 0 0 1 -3.5 3.5h-1a3.5 3.5 0 0 1 -3.5 -3.5a1.5 1.5 0 0 1 1.5 -1.5z" /><path d="M4 17v-1a8 8 0 1 1 16 0v1a4 4 0 0 1 -4 4h-8a4 4 0 0 1 -4 -4z" /></svg>
                            </span>
                          </div>
                          <div class="col">
                            <div class="font-weight-medium">
                                Pinjaman Terealisasi
                            </div>
                            <div class="text-secondary">
                                1.423.900.788
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-3">
                    <div class="card card-sm">
                      <div class="card-body">
                        <div class="row align-items-center">
                          <div class="col-auto">
                            <span class="bg-twitter text-white avatar"><!-- Download SVG icon from http://tabler-icons.io/i/brand-twitter -->
                                <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-cash"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M7 9m0 2a2 2 0 0 1 2 -2h10a2 2 0 0 1 2 2v6a2 2 0 0 1 -2 2h-10a2 2 0 0 1 -2 -2z" /><path d="M14 14m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0" /><path d="M17 9v-2a2 2 0 0 0 -2 -2h-10a2 2 0 0 0 -2 2v6a2 2 0 0 0 2 2h2" /></svg>
                            </span>
                          </div>
                          <div class="col">
                            <div class="font-weight-medium">
                                Pinjaman Lunas
                            </div>
                            <div class="text-secondary">
                                1.323.900.788
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-3">
                    <div class="card card-sm">
                      <div class="card-body">
                        <div class="row align-items-center">
                          <div class="col-auto">
                            <span class="bg-facebook text-white avatar"><!-- Download SVG icon from http://tabler-icons.io/i/brand-facebook -->
                                <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-users"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M9 7m-4 0a4 4 0 1 0 8 0a4 4 0 1 0 -8 0" /><path d="M3 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2" /><path d="M16 3.13a4 4 0 0 1 0 7.75" /><path d="M21 21v-2a4 4 0 0 0 -3 -3.85" /></svg>
                            </span>
                          </div>
                          <div class="col">
                            <div class="font-weight-medium">
                                Jumlah Peminjam
                            </div>
                            <div class="text-secondary">
                                2500
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row row-cards mt-2">
        <div class="col-md-12 d-flex justify-content-center">
            <div class="row row-cards justify-content-center">
                <div class="col-lg-6">
                  <div class="card card-sm">
                    <div class="card-body">
                        <div class="row g-2 align-items-center">
                            <div class="col">
                                <div class="font-weight-medium text-center">
                                <h3>Daftar Sebagai</h3>
                                </div>
                            </div>
                        </div>
                        <div class="row g-2 align-items-center">
                            <div class="col-6 col-sm-4 col-md-2 col-xl py-3">
                                <a href="#" class="btn btn-primary w-100">
                                    Pemodal
                                </a>
                            </div>
                            <div class="col-6 col-sm-4 col-md-2 col-xl py-3">
                                <a href="{{ url('borrower/regist') }}" class="btn btn-primary w-100">
                                  Peminjam
                                </a>
                            </div>
                        </div>
                        <div class="row g-2 align-items-center">
                            <div class="col">
                                <div class="font-weight-medium text-center">
                                    <a href="{{ url('/login') }}">
                                        Sudah punya akun?, Login disini
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                  </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
@endsection