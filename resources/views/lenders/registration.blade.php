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
                <div class="col-6">
                </div>
                <div class="col-6">
                    <form action="{{ url('/lender/regist/store') }}" method="POST" class="card" enctype="multipart/form-data">
                        @csrf
                        <div class="card-header">
                            <h4 class="card-title">Daftar Sebagai Pemodal</h4>
                        </div>
                        <div class="card-body">
                            <div class="row g-5">
                                <div class="col-xl-12">
                                    <div class="row">
                                        <div class="col-md-12 col-xl-12">
                                            <div class="mb-3">
                                                <label class="form-label required">Nama Lengkap</label>
                                                <input type="text" class="form-control" name="lender_name" placeholder="Input nama lengkap" required>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label required">No. Telepon</label>
                                                <input type="text" name="lender_phone" class="form-control" data-mask="(00) 0000-0000-0000" data-mask-visible="true" placeholder="(00) 0000-0000-0000" autocomplete="off" required>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label required">Email (Akan digunakan sebagai username)</label>
                                                <input type="email" class="form-control" name="lender_email" placeholder="Input email" required>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label required">Password</label>
                                                <div>
                                                    <input type="password" class="form-control" placeholder="Input password" name="lender_password" 
                                                    pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" 
                                                    title="Kata sandi harus minimal 8 karakter, mengandung huruf besar, huruf kecil, dan angka."
                                                    required>
                                                    <small class="form-hint">
                                                        *Kata sandi minimal 8 karakter dengan kombinasi huruf besar, huruf kecil dan angka.
                                                    </small>
                                                </div>
                                            </div>
                                            <div class="mb-3">
                                                <div class="form-label required">Jenis Kelamin</div>
                                                <div>
                                                    <label class="form-check form-check-inline">
                                                        <input class="form-check-input" type="radio" name="lender_gender" value="M" required>
                                                        <span class="form-check-label">Pria</span>
                                                    </label>
                                                    <label class="form-check form-check-inline">
                                                        <input class="form-check-input" type="radio" name="lender_gender" value="F" required>
                                                        <span class="form-check-label">Wanita</span>
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label required">Alamat Lengkap</label>
                                                <textarea class="form-control" data-bs-toggle="autosize" placeholder="Input alamat" name="lender_address" required></textarea>
                                            </div>
                                            <div class="mb-3">
                                                <div class="form-label required">Pekerjaan</div>
                                                <select class="form-select" name="lender_occupation" required>
                                                    <option value="">-- Pilih Pekerjaan --</option>
                                                    <option value="PNS">PNS</option>
                                                    <option value="Karyawan Swasta">Karyawan Swasta</option>
                                                    <option value="Freelance">Freelance</option>
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <div class="form-label required">Sumber Penghasilan</div>
                                                <select class="form-select" name="lender_source_income" required>
                                                    <option value="">-- Pilih Sumber Penghasilan --</option>
                                                  <option value="Gaji">Gaji</option>
                                                  <option value="Honor">Honor</option>
                                                  <option value="Warisan">Warisan</option>
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label required">Jumlah Penghasilan per Bulan</label>
                                                <input type="text" class="form-control" name="lender_income" placeholder="Input penghasilan" required>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label required">Nomor KTP</label>
                                                <input type="text" class="form-control" name="lender_id_card_no" minlength="16" maxlength="16" placeholder="Input no KTP" required>
                                            </div>
                                            <div class="mb-3">
                                                <div class="form-label required">Upload KTP</div>
                                                <input type="file" class="form-control" name="lender_id_card" required>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="term_regist" required>
                                                    <span class="form-check-label">
                                                    Syarat & Ketentuan
                                                    </span>
                                                    <span class="form-check-description">
                                                    Saya telah membaca dan memahami Syarat dan ketentuan yang berlaku Di Finmas
                                                    </span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>     
                                </div>
                            </div>
                        </div>
                        <div class="card-footer text-end">
                        <div class="d-flex">
                            <button type="submit" class="btn btn-primary ms-auto">Submit data</button>
                        </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection