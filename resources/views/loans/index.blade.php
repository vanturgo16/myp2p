@extends('layouts.master')

@section('content')
<!-- Page header -->
  <div class="page-header d-print-none">
    <div class="container-xl">
      <div class="row g-2 align-items-center">
        <div class="col">
          <h2 class="page-title">
            List Pinjaman
          </h2>
        </div>
      </div>
    </div>
  </div>
  <!-- Page body -->
  <div class="page-body">
    <div class="container-xl">
        <!-- Notifikasi menggunakan flash session data -->
        @if (session('success'))
        <div class="alert alert-important alert-success alert-dismissible" role="alert">
            <div class="d-flex">
              <div>
                <!-- Download SVG icon from http://tabler-icons.io/i/check -->
                <svg xmlns="http://www.w3.org/2000/svg" class="icon alert-icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M5 12l5 5l10 -10" /></svg>
              </div>
              <div>
                {{ session('success') }}
              </div>
            </div>
            <a class="btn-close" data-bs-dismiss="alert" aria-label="close"></a>
        </div>
        @endif

        @if (session('fail'))
        <div class="alert alert-important alert-danger alert-dismissible" role="alert">
            <div class="d-flex">
              <div>
                <!-- Download SVG icon from http://tabler-icons.io/i/alert-circle -->
                <svg xmlns="http://www.w3.org/2000/svg" class="icon alert-icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M3 12a9 9 0 1 0 18 0a9 9 0 0 0 -18 0" /><path d="M12 8v4" /><path d="M12 16h.01" /></svg>
              </div>
              <div>
                {{ session('fail') }}
              </div>
            </div>
            <a class="btn-close" data-bs-dismiss="alert" aria-label="close"></a>
        </div>
        @endif

        @if (session('status'))
        <div class="alert alert-important alert-warning alert-dismissible" role="alert">
            <div class="d-flex">
              <div>
                <!-- Download SVG icon from http://tabler-icons.io/i/alert-circle -->
                <svg xmlns="http://www.w3.org/2000/svg" class="icon alert-icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M3 12a9 9 0 1 0 18 0a9 9 0 0 0 -18 0" /><path d="M12 8v4" /><path d="M12 16h.01" /></svg>
              </div>
              <div>
                {{ session('status') }}
              </div>
            </div>
            <a class="btn-close" data-bs-dismiss="alert" aria-label="close"></a>
        </div>
        @endif

        @foreach ($datas as $data)
        <div class="card mb-2">
            <div class="card-header">
                <h3 class="card-title">
                  {{ $data->loan_no }}
                  <br>
                  <b>Produk: </b>{{ $data->product_name . "- Tenor " . $data->duration_months . " Bulan"  }}
                </h3>
                <div class="card-actions">
                  <button type="submit" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modal-fund{{ $data->loan_id }}">Danai</button>

                  <div class="modal modal-blur fade" id="modal-fund{{ $data->loan_id }}" tabindex="-1" role="dialog" aria-hidden="true">
                    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h5 class="modal-title">Danai Pinjaman {{ $data->loan_no }}</h5>
                          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                          <div class="row">
                            <div class="col-md-4 col-xl-4">
                              <div class="mb-3">
                                <label class="form-label">Saldo Aktif</label>
                                <div class="form-control-plaintext">{{ number_format($lender->balance,2,",","."); }}</div>
                              </div>
                            </div>
                            <div class="col-md-4 col-xl-4">
                              <div class="mb-3">
                                <label class="form-label">Jumlah Pinjaman</label>
                                <div class="form-control-plaintext">{{ number_format($data->loan_amount,2,",","."); }}</div>
                              </div>
                            </div>
                            <div class="col-md-4 col-xl-4">
                              <div class="mb-3">
                                <label class="form-label required">Jumlah Pendanaan</label>
                                <div>
                                  <select id="fund_amount" name="fund_amount" class="form-select" required>
                                    @for ($value = 500000; $value <= $data->loan_amount; $value += 500000)
                                        <option value="{{ $value }}">{{ number_format($value, 2, ',', '.') }}</option>
                                    @endfor
                                  </select>
                                  <small class="form-hint">
                                    Minimal rupiah untuk mendanai dan kelipatan dana rupiah maksimum pendanaan tidak bisa melebihi saldo aktif anda.
                                  </small>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                        <div class="modal-footer">
                          <button type="button" class="btn me-auto" data-bs-dismiss="modal">Close</button>
                          <button type="submit" class="btn btn-primary" data-bs-dismiss="modal">Submit</button>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
            </div>
            <div class="card-body">
              <div class="datagrid">
                <div class="datagrid-item">
                  <div class="datagrid-title">Peminjam</div>
                  <div class="datagrid-content">{{ $data->borrower_name }}</div>
                </div>
                <div class="datagrid-item">
                  <div class="datagrid-title">Tanggal Pengajuan</div>
                  <div class="datagrid-content">{{ Carbon\Carbon::parse($data->tgl_pinjam)->format('Y-m-d') }}</div>
                </div>
                <div class="datagrid-item">
                  <div class="datagrid-title">Jatuh Tempo</div>
                  <div class="datagrid-content">
                    @php
                      $duedate = Carbon\Carbon::parse($data->tgl_pinjam)->addMonth($data->duration_months)->format('Y-m-d');

                      echo $duedate
                    @endphp
                  </div>
                </div>
                <div class="datagrid-item">
                  <div class="datagrid-title">Jumlah Pinjaman</div>
                  <div class="datagrid-content">{{ number_format($data->loan_amount,2,",","."); }}</div>
                </div>
                <div class="datagrid-item">
                  <div class="datagrid-title">Bunga</div>
                  <div class="datagrid-content">{{ $data->lender + $data->provider . "%" }}</div>
                </div>
                <div class="datagrid-item">
                  <div class="datagrid-title">Asuransi</div>
                  <div class="datagrid-content">{{ $data->insurance . "%" }}</div>
                </div>
                <div class="datagrid-item">
                  <div class="datagrid-title">Provisi</div>
                  <div class="datagrid-content">{{ $data->platform . "%" }}</div>
                </div>
                <div class="datagrid-item">
                  <div class="datagrid-title">Denda</div>
                  <div class="datagrid-content">{{ $data->penalty . "%" }}</div>
                </div>
                <div class="datagrid-item">
                  <div class="datagrid-title">Progress Pendanaan {{ number_format($data->loan_funded,2,",",".") . "/" . number_format($data->loan_amount,2,",",".") }}</div>
                  <div class="datagrid-content">
                    <div class="progress mb-2">
                      @php
                        $percent = ($data->loan_funded/$data->loan_amount)*100;
                      @endphp
                      <div class="progress-bar" style="{{ 'width:' . $percent . '%' }}" role="progressbar" aria-valuenow="{{ $percent }}" aria-valuemin="0" aria-valuemax="100" aria-label="{{ $percent.'% complete' }}">
                        <span class="visually-show">{{  $percent . "%" }}</span>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
<!-- Javascript DataTable & Modal -->
<script>
    $(document).ready(function() {
        var table = $("#tableView").DataTable({
        "responsive": true, 
        "lengthChange": false, 
        "autoWidth": true,
        "order":[],
        // "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
        });
    });
</script>
@endsection