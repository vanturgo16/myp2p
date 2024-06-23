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
    {{-- @if ($status != "")
    <div class="row row-cards">
      <div class="col-lg-12">
        <div class="card">
          <div class="card-body">
            <div class="row">
              <div class="col">
                <ul class='steps steps-green steps-counter my-4'>
                    <li 
                        @if ($status == 'pending')
                            class='step-item active'
                        @else
                            class='step-item'
                        @endif>
                        Admin Cek Transaksi
                    </li>
                    <li 
                        @if ($status == 'approved' || $status == 'rejected')
                            class='step-item active'
                        @else
                            class='step-item'
                        @endif>

                        @if ($status == 'approved')
                            Disetujui
                        @elseif ($status == 'rejected')
                            Ditolak
                        @else
                            Disetujui/Ditolak
                        @endif
                    </li>
                </ul>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    @endif --}}
    <div class="row row-cards mt-1">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">History Top Up</h3>
                    <div class="card-actions">
                        <b>Saldo Aktif: </b> {{ number_format($balance->balance,2,",",".") }}
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="tableView" class="table card-table table-vcenter text-nowrap table-hover datatable">
                        <thead>
                            <tr>
                            <th><button class="table-sort" data-sort="sort-type">Status</button></th>
                            <th><button class="table-sort" data-sort="sort-type">Tipe Transaksi</button></th>
                            <th><button class="table-sort" data-sort="sort-name">Nominal Topup</button></th>
                            <th><button class="table-sort" data-sort="sort-name">Tanggal Topup</button></th>
                            <th><button class="table-sort" data-sort="sort-city">Tanggal Disetujui</button></th>
                            @if (auth()->user()->role == 'Admin')
                            <th><button class="table-sort" data-sort="sort-type">Aksi</button></th>
                            @endif
                            </tr>
                        </thead>
                        <tbody class="table-tbody">
                            @foreach ($datas as $data)
                            <tr>
                                <td>
                                    @if ($data->status != 'rejected')
                                        <span class="badge bg-blue text-blue-fg">{{ $data->status }}</span>
                                    @else
                                        <span class="badge bg-red text-red-fg">{{ $data->status }}</span>
                                    @endif
                                </td>
                                <td>{{ $data->trans_type }}</td>
                                <td>
                                    {{ number_format($data->amount,2,",",".") }}
                                </td> 
                                <td>{{ $data->created_at }}</td>
                                <td>
                                    @if ($data->status == 'pending')
                                        <i class="text-info">Proses Pengecekan Transaksi</i>
                                    @else
                                        {{ $data->settled_date }}
                                    @endif
                                </td>
                                @if (auth()->user()->role == 'Admin')
                                <td>
                                    @if ($data->status == "pending")
                                    <form action="{{ url('/lender/balance/approved', encrypt($data->id)) }}" method="POST" style="display:inline-block;">
                                        @csrf
                                        @method('patch')
                                        <button type="submit" class="btn btn-success btn-xs" onclick="return confirm('Are You Sure APPROVED this Loan?')">
                                            <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-file-like"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M3 16m0 1a1 1 0 0 1 1 -1h1a1 1 0 0 1 1 1v3a1 1 0 0 1 -1 1h-1a1 1 0 0 1 -1 -1z" /><path d="M6 20a1 1 0 0 0 1 1h3.756a1 1 0 0 0 .958 -.713l1.2 -3c.09 -.303 .133 -.63 -.056 -.884c-.188 -.254 -.542 -.403 -.858 -.403h-2v-2.467a1.1 1.1 0 0 0 -2.015 -.61l-1.985 3.077v4z" /><path d="M14 3v4a1 1 0 0 0 1 1h4" /><path d="M5 12.1v-7.1a2 2 0 0 1 2 -2h7l5 5v11a2 2 0 0 1 -2 2h-2.3" /></svg>
                                            Approved
                                        </button>
                                    </form>
                                    <form action="{{ url('/lender/balance/rejected', encrypt($data->id)) }}" method="POST" style="display:inline-block;">
                                        @csrf
                                        @method('patch')
                                        <button type="submit" class="btn btn-danger btn-xs" onclick="return confirm('Are You Sure REJECTED this Loan?')">
                                            <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-file-dislike"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M3 14m0 1a1 1 0 0 1 1 -1h1a1 1 0 0 1 1 1v3a1 1 0 0 1 -1 1h-1a1 1 0 0 1 -1 -1z" /><path d="M6 15a1 1 0 0 1 1 -1h3.756a1 1 0 0 1 .958 .713l1.2 3c.09 .303 .133 .63 -.056 .884c-.188 .254 -.542 .403 -.858 .403h-2v2.467a1.1 1.1 0 0 1 -2.015 .61l-1.985 -3.077v-4z" /><path d="M14 3v4a1 1 0 0 0 1 1h4" /><path d="M5 11v-6a2 2 0 0 1 2 -2h7l5 5v11a2 2 0 0 1 -2 2h-2.5" /></svg>
                                            Rejected
                                        </button>
                                    </form>
                                    @else
                                        
                                    @endif
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