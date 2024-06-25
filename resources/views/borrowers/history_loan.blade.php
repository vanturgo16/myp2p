@extends('layouts.master')

@section('content')
<div class="page-body">
<div class="container-xl">
    @if (session('status'))
    <div class="alert alert-important alert-info alert-dismissible" role="alert">
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

    @if ($status != "")
    <div class="row row-cards">
      <div class="col-lg-12">
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">Progress Pinjaman Berjalan</h3>
          </div>
          <div class="card-body">
            <div class="row">
              <div class="col">
                <ul class='steps steps-green steps-counter my-4'>
                    <li 
                        @if ($status == 'approval' || $status == 'pending')
                            class='step-item active'
                        @else
                            class='step-item'
                        @endif>
                        Review Pinjaman
                    </li>
                    <li 
                        @if ($status == 'approved' || $status == 'rejected' || $status == 'funded')
                            class='step-item active'
                        @else
                            class='step-item'
                        @endif>

                        @if ($status == 'approved' || $status == 'funded')
                            Disetujui
                        @elseif ($status == 'rejected')
                            Ditolak
                        @else
                            Disetujui/Ditolak
                        @endif
                    </li>
                    <li 
                        @if ($status == 'disbursed')
                            class='step-item active'
                        @else
                            class='step-item'
                        @endif>
                        Pinjaman Aktif
                    </li>
                    <li 
                        @if ($status == 'paid')
                            class='step-item active'
                        @else
                            class='step-item'
                        @endif>
                        Lunas
                    </li>
                </ul>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    @endif
                

    <div class="row row-cards mt-1">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="tableView" class="table card-table table-vcenter text-nowrap table-hover datatable">
                        <thead>
                            <tr>
                            <th><button class="table-sort" data-sort="sort-type">Status</button></th>
                            <th><button class="table-sort" data-sort="sort-name">No. Pinjaman</button></th>
                            <th><button class="table-sort" data-sort="sort-name">Nominal</button></th>
                            <th><button class="table-sort" data-sort="sort-city">Bunga</button></th>
                            <th><button class="table-sort" data-sort="sort-city">Admin</button></th>
                            <th><button class="table-sort" data-sort="sort-type">Pencairan</button></th>
                            <th><button class="table-sort" data-sort="sort-type">Pengembalian</button></th>
                            <th><button class="table-sort" data-sort="sort-type">Tenor</button></th>
                            <th><button class="table-sort" data-sort="sort-type">Tanggal Pengajuan</button></th>
                            <th><button class="table-sort" data-sort="sort-type">Tanggal Pencairan</button></th>
                            <th><button class="table-sort" data-sort="sort-type">Aksi</button></th>
                            </tr>
                        </thead>
                        <tbody class="table-tbody">
                            @foreach ($datas as $data)
                            <tr>
                                <td>
                                    <span class="badge bg-blue text-blue-fg">{{ $data->status }}</span>
                                </td>
                                <td>{{ $data->loan_no }}</td> 
                                <td>{{ number_format($data->loan_amount,2,",",".") }}</td>
                                <td>{{ number_format($data->lender_amount,2,",",".") }}</td>
                                <td>{{ number_format($data->platform_amount,2,",",".") }}</td>
                                <td>{{ number_format($data->disburst_amount,2,",",".") }}</td>
                                <td>{{ number_format($data->total_pay,2,",",".") }}</td>
                                <td>{{ $data->duration_months . " Bulan" }}</td>
                                <td>{{ $data->created_at }}</td>
                                <td>
                                    @if ($data->status == 'approved')
                                        <i class="text-info">Proses Pendanaan</i>
                                    @elseif ($data->status == 'funded')
                                        <i class="text-info">Proses Pencairan</i>
                                    @else
                                        {{ $data->disburst_date }}
                                    @endif
                                </td>
                                @if (auth()->user()->role == 'Admin')
                                <td>
                                    @if ($data->status == "approval")
                                        <form action="{{ url('/borrower/loan/approved', encrypt($data->id_loan)) }}" method="POST" style="display:inline-block;">
                                            @csrf
                                            @method('patch')
                                            <button type="submit" class="btn btn-success btn-xs" onclick="return confirm('Are You Sure APPROVED this transaction?')">
                                                <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-file-like"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M3 16m0 1a1 1 0 0 1 1 -1h1a1 1 0 0 1 1 1v3a1 1 0 0 1 -1 1h-1a1 1 0 0 1 -1 -1z" /><path d="M6 20a1 1 0 0 0 1 1h3.756a1 1 0 0 0 .958 -.713l1.2 -3c.09 -.303 .133 -.63 -.056 -.884c-.188 -.254 -.542 -.403 -.858 -.403h-2v-2.467a1.1 1.1 0 0 0 -2.015 -.61l-1.985 3.077v4z" /><path d="M14 3v4a1 1 0 0 0 1 1h4" /><path d="M5 12.1v-7.1a2 2 0 0 1 2 -2h7l5 5v11a2 2 0 0 1 -2 2h-2.3" /></svg>
                                                Approved
                                            </button>
                                        </form>
                                        <form action="{{ url('/borrower/loan/rejected', encrypt($data->id_loan)) }}" method="POST" style="display:inline-block;">
                                            @csrf
                                            @method('patch')
                                            <button type="submit" class="btn btn-danger btn-xs" onclick="return confirm('Are You Sure REJECTED this transaction?')">
                                                <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-file-dislike"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M3 14m0 1a1 1 0 0 1 1 -1h1a1 1 0 0 1 1 1v3a1 1 0 0 1 -1 1h-1a1 1 0 0 1 -1 -1z" /><path d="M6 15a1 1 0 0 1 1 -1h3.756a1 1 0 0 1 .958 .713l1.2 3c.09 .303 .133 .63 -.056 .884c-.188 .254 -.542 .403 -.858 .403h-2v2.467a1.1 1.1 0 0 1 -2.015 .61l-1.985 -3.077v-4z" /><path d="M14 3v4a1 1 0 0 0 1 1h4" /><path d="M5 11v-6a2 2 0 0 1 2 -2h7l5 5v11a2 2 0 0 1 -2 2h-2.5" /></svg>
                                                Rejected
                                            </button>
                                        </form>
                                    @elseif ($data->status == "funded" && ($data->loan_amount == $data->loan_funded))
                                        <form action="{{ url('/borrower/loan/disburst', encrypt($data->id_loan)) }}" method="POST" style="display:inline-block;">
                                            @csrf
                                            @method('patch')
                                            <button type="submit" class="btn btn-warning btn-xs" onclick="return confirm('Are You Sure DISBURST this transaction?')">
                                                <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-cash"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M7 9m0 2a2 2 0 0 1 2 -2h10a2 2 0 0 1 2 2v6a2 2 0 0 1 -2 2h-10a2 2 0 0 1 -2 -2z" /><path d="M14 14m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0" /><path d="M17 9v-2a2 2 0 0 0 -2 -2h-10a2 2 0 0 0 -2 2v6a2 2 0 0 0 2 2h2" /></svg>
                                                Disburstment
                                            </button>
                                        </form>
                                    @elseif ($data->status == "disbursed")
                                        <a href="{{ url('/loan/payment/list', encrypt($data->loan_no)) }}" class="btn btn-warning btn-xs">
                                            <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-coins"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M9 14c0 1.657 2.686 3 6 3s6 -1.343 6 -3s-2.686 -3 -6 -3s-6 1.343 -6 3z" /><path d="M9 14v4c0 1.656 2.686 3 6 3s6 -1.344 6 -3v-4" /><path d="M3 6c0 1.072 1.144 2.062 3 2.598s4.144 .536 6 0c1.856 -.536 3 -1.526 3 -2.598c0 -1.072 -1.144 -2.062 -3 -2.598s-4.144 -.536 -6 0c-1.856 .536 -3 1.526 -3 2.598z" /><path d="M3 6v10c0 .888 .772 1.45 2 2" /><path d="M3 11c0 .888 .772 1.45 2 2" /></svg>
                                            Tabel Rencana Pembayaran
                                        </a>
                                    @endif
                                </td>
                                @elseif (auth()->user()->role == 'Borrower' && $data->status == 'pending')
                                <td>
                                    <a href="{{ url('/borrower/loan/confirm/'.encrypt($data->id_loan)) }}" class="btn btn-primary btn-xs">
                                        <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-checks"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M7 12l5 5l10 -10" /><path d="M2 12l5 5m5 -5l5 -5" /></svg>
                                        Konfirmasi Pinjaman
                                    </a>
                                </td>
                                @elseif (auth()->user()->role == 'Borrower' && $data->status == 'disbursed')
                                <td>
                                    <a href="{{ url('/loan/payment/list', encrypt($data->loan_no)) }}" class="btn btn-warning btn-xs">
                                        <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-coins"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M9 14c0 1.657 2.686 3 6 3s6 -1.343 6 -3s-2.686 -3 -6 -3s-6 1.343 -6 3z" /><path d="M9 14v4c0 1.656 2.686 3 6 3s6 -1.344 6 -3v-4" /><path d="M3 6c0 1.072 1.144 2.062 3 2.598s4.144 .536 6 0c1.856 -.536 3 -1.526 3 -2.598c0 -1.072 -1.144 -2.062 -3 -2.598s-4.144 -.536 -6 0c-1.856 .536 -3 1.526 -3 2.598z" /><path d="M3 6v10c0 .888 .772 1.45 2 2" /><path d="M3 11c0 .888 .772 1.45 2 2" /></svg>
                                        Tabel Rencana Pembayaran
                                    </a>
                                </td>
                                @endif
                            </tr>
                            @endforeach
                        </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
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