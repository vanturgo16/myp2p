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
                                    <button type="submit" class="btn btn-primary ms-auto">Update</button>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="row g-5">
                                    <div class="col-xl-12">
                                        <div class="row">
                                            <div class="col-md-12 col-xl-12">
                                                <div class="mb-3">
                                                    <label class="form-label required">Nama Lengkap</label>
                                                    <input type="text" class="form-control" name="borrower_name" placeholder="Input nama lengkap" value="{{ $borrower->borrower_name }}" readonly required>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label required">No. Telepon</label>
                                                    <input type="text" name="borrower_phone" class="form-control" data-mask="(00) 0000-0000-0000" data-mask-visible="true" placeholder="(00) 0000-0000-0000" value="{{ $borrower->borrower_phone }}" autocomplete="off" required>
                                                </div>
                                                <div class="mb-3">
                                                    <div class="form-label required">Jenis Kelamin</div>
                                                    <div>
                                                        <label class="form-check form-check-inline">
                                                            <input class="form-check-input" type="radio" name="borrower_gender" value="M" 
                                                            @if ($borrower->gender == 'M')
                                                                checked
                                                            @endif
                                                            required>
                                                            <span class="form-check-label">Pria</span>
                                                        </label>
                                                        <label class="form-check form-check-inline">
                                                            <input class="form-check-input" type="radio" name="borrower_gender" value="F"
                                                            @if ($borrower->gender == 'F')
                                                                checked
                                                            @endif
                                                            required>
                                                            <span class="form-check-label">Wanita</span>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label required">Alamat Lengkap</label>
                                                    <textarea class="form-control" data-bs-toggle="autosize" placeholder="Input alamat" name="borrower_address" required>{{ $borrower->borrower_address }}</textarea>
                                                </div>
                                                <div class="mb-3">
                                                    <div class="form-label required">Pekerjaan</div>
                                                    <select class="form-select" name="borrower_occupation" required>
                                                        <option value="">-- Pilih Pekerjaan --</option>
                                                        <option value="PNS" @if ($borrower->borrower_occupation == 'PNS') selected @endif>PNS</option>
                                                        <option value="Karyawan Swasta" @if ($borrower->borrower_occupation == 'Karyawan Swasta') selected @endif>Karyawan Swasta</option>
                                                        <option value="Freelance" @if ($borrower->borrower_occupation == 'Freelance') selected @endif>Freelance</option>
                                                    </select>
                                                </div>
                                                <div class="mb-3">
                                                    <div class="form-label required">Sumber Penghasilan</div>
                                                    <select class="form-select" name="borrower_source_income" required>
                                                        <option value="">-- Pilih Sumber Penghasilan --</option>
                                                      <option value="Gaji" @if ($borrower->borrower_source_income == 'Gaji') selected @endif>Gaji</option>
                                                      <option value="Honor" @if ($borrower->borrower_source_income == 'Honor') selected @endif>Honor</option>
                                                      <option value="Warisan" @if ($borrower->borrower_source_income == 'Warisan') selected @endif>Warisan</option>
                                                    </select>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label required">Jumlah Penghasilan per Bulan</label>
                                                    <input type="text" class="form-control" name="borrower_income" placeholder="Input penghasilan" name="borrower_income" value="{{ $borrower->borrower_income }}" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label required">Nomor KTP</label>
                                                    <input type="text" class="form-control" name="borrower_id_card_no" placeholder="Input no KTP" value="{{ $borrower->borrower_id_card_no }}" required>
                                                </div>
                                                <div class="mb-3">
                                                    <div class="form-label required">Upload KTP</div>
                                                    <input type="file" class="form-control" name="borrower_id_card">
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
                    <div class="card">
                        <form action="{{ url('/borrower/regist/bank/update',encrypt($borrower->id)) }}" method="POST" class="card" enctype="multipart/form-data">
                            @csrf
                            @method('PATCH')
                            <div class="card-header">
                                <h4 class="card-title">Data Bank</h4>
                                <div class="card-actions">
                                    <button type="submit" class="btn btn-primary ms-auto">Update</button>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="row g-5">
                                    <div class="col-xl-12">
                                        <div class="row">
                                            <div class="col-md-12 col-xl-12">
                                                <div class="mb-3">
                                                    <div class="form-label required">Nama Bank</div>
                                                    <select class="form-select" name="borrower_bank_name" required>
                                                        <option value="">-- Pilih Bank --</option>
                                                      <option value="BCA" @if ($borrower->borrower_bank_name == 'BCA') selected @endif>BCA</option>
                                                      <option value="Mandiri" @if ($borrower->borrower_bank_name == 'Mandiri') selected @endif>Mandiri</option>
                                                      <option value="BRI" @if ($borrower->borrower_bank_name == 'BRI') selected @endif>BRI</option>
                                                      <option value="Sinarmas" @if ($borrower->borrower_bank_name == 'Sinarmas') selected @endif>Sinarmas</option>
                                                    </select>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label required">No Rekening</label>
                                                    <input type="text" class="form-control" name="borrower_accountno" placeholder="Input no rekening" value="{{ $borrower->borrower_accountno }}" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label required">Nama Tertera di Rekening</label>
                                                    <input type="text" class="form-control" name="borrower_accountname" placeholder="Input nama rekening" value="{{ $borrower->borrower_accountname }}" required>
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
            </div>
        </div>
    </div>
@endsection