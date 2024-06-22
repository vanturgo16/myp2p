@extends('layouts.master')

@section('content')
    <!-- Page header -->
    {{-- <div class="page-header d-print-none">
      <div class="container-xl">
        <div class="row g-2 align-items-center">
          <div class="col">
            <h2 class="page-title">
                Daftar Sebagai Peminjam
            </h2>
          </div>
        </div>
      </div>
    </div> --}}
    <!-- Page body -->
    <div class="page-body">
        <div class="container-xl">
            <div class="row row-cards">
                <div class="col-md-6">
                    <div class="card">
                        <form action="{{ url('/borrower/regist/update', encrypt($borrower->id)) }}" method="POST" class="card" enctype="multipart/form-data">
                            @csrf
                            @method('PATCH')
                            <div class="card-header">
                                <h4 class="card-title">Data Profil</h4>
                                <div class="card-actions">
                                    @if ($progress == 'Siap Pengajuan')
                                        <span class="badge bg-green text-green-fg">{{ $progress }}</span>
                                    @else
                                        <span class="badge bg-yellow text-yellow-fg">{{ $progress }}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="row g-5">
                                    <div class="col-xl-12">
                                        <div class="row">
                                            <div class="col-md-12 col-xl-12">
                                                <div class="mb-3">
                                                    <label class="form-label required">Nama Lengkap</label>
                                                    {{ $borrower->borrower_name }}
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label required">No. Telepon</label>
                                                    {{ $borrower->borrower_phone }}
                                                </div>
                                                <div class="mb-3">
                                                    <div class="form-label required">Jenis Kelamin</div>
                                                    {{ $borrower->gender }}
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label required">Alamat Lengkap</label>
                                                    {{ $borrower->borrower_address }}
                                                </div>
                                                <div class="mb-3">
                                                    <div class="form-label required">Pekerjaan</div>
                                                    {{ $borrower->borrower_occupation }}
                                                </div>
                                                <div class="mb-3">
                                                    <div class="form-label required">Sumber Penghasilan</div>
                                                    {{ $borrower->borrower_source_income }}
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label required">Jumlah Penghasilan per Bulan</label>
                                                    {{ number_format($borrower->borrower_income,2,",",".") }}
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label required">Nomor KTP</label>
                                                    {{ $borrower->borrower_id_card_no }}
                                                </div>
                                                <div class="mb-3">
                                                    <div class="form-label required">Upload KTP</div>
                                                    <a href="#" class="btn mt-3" data-bs-toggle="modal" data-bs-target="#modal-large">
                                                        View
                                                    </a>
                                                    <div class="modal modal-blur fade" id="modal-large" tabindex="-1" role="dialog" aria-hidden="true">
                                                        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                                                          <div class="modal-content">
                                                            <div class="modal-header">
                                                              <h5 class="modal-title">ID Card</h5>
                                                              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <img src="{{ asset($borrower->borrower_id_card) }}" alt="Tabler" class="img-fluid">
                                                            </div>
                                                            <div class="modal-footer">
                                                              <button type="button" class="btn me-auto" data-bs-dismiss="modal">Close</button>
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
                            {{-- <div class="card-footer text-end">
                            <div class="d-flex">
                                <button type="submit" class="btn btn-primary ms-auto">Submit data Profil</button>
                            </div>
                            </div> --}}
                        </form>
                    </div>
                </div>
                <div class="col-md-6">
                    <form action="{{ url('/users/borrower/eligible',encrypt($borrower->id)) }}" method="POST" class="card" enctype="multipart/form-data">
                    @csrf
                    @method('PATCH')
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Data Bank</h4>
                            @if ($progress == 'Proses KYC')
                            <div class="card-actions">
                                <button type="submit" class="btn btn-primary btn-sm ms-auto" onclick="return confirm('Are You Sure Approved This Borrower?')">Approved</button>
                                <a href="{{ url('/users/borrower/not-eligible',encrypt($borrower->id)) }}" class="btn btn-danger btn-sm ms-auto" onclick="return confirm('Are You Sure Rejected This Borrower?')">Rejected</a>
                            </div>
                            @endif
                        </div>
                        <div class="card-body">
                            <div class="row g-5">
                                <div class="col-xl-12">
                                    <div class="row">
                                        <div class="col-md-12 col-xl-12">
                                            <div class="mb-3">
                                                <div class="form-label required">Nama Bank</div>
                                                {{ $borrower->borrower_bank_name }}
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label required">No Rekening</label>
                                                {{ $borrower->borrower_accountno }}
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label required">Nama Tertera di Rekening</label>
                                                {{ $borrower->borrower_accountname }}
                                            </div>
                                        </div>
                                    </div>     
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card mt-2">
                        <div class="card-body">
                            <div class="row g-5">
                                <div class="col-xl-12">
                                    <div class="row">
                                        <div class="col-md-12 col-xl-12">
                                            <div class="mb-3">
                                                <div class="form-label required">Plafon</div>
                                                @if ($borrower->loan_limit == '0')
                                                <input type="text" class="form-control" name="loan_limit" id="loan_limit" placeholder="Input plafon" required>
                                                @else
                                                {{ number_format($borrower->loan_limit,2,",",".") }}
                                                @endif
                                            </div>
                                        </div>
                                    </div>     
                                </div>
                            </div>
                        </div>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript">
        $(document).ready(function () {
            var charges = document.getElementById('loan_limit');
            
            charges.addEventListener('keyup',function(e){
                charges.value = formatCurrency(this.value,' ');
            });
    
            function formatCurrency(number,prefix)
            {
                var number_string = number.replace(/[^.\d]/g, '').toString(),
                    split	= number_string.split('.'),
                    sisa 	= split[0].length % 3,
                    rupiah 	= split[0].substr(0, sisa),
                    ribuan 	= split[0].substr(sisa).match(/\d{1,3}/gi);
                    
                if (ribuan) {
                    separator = sisa ? ',' : '';
                    rupiah += separator + ribuan.join(',');
                }
                
                rupiah = split[1] != undefined ? rupiah + '.' + split[1] : rupiah;
                return prefix == undefined ? rupiah : (rupiah ? '' + rupiah : '');
            }   
        });
    </script>
@endsection