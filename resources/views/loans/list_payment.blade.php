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

    <div class="row row-cards mt-1">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Table Rencana Pembayaran</h3>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="tableView" class="table card-table table-vcenter text-nowrap table-hover datatable">
                        <thead>
                            <tr>
                            <th><button class="table-sort" data-sort="sort-name">No. Invoice</button></th>
                            <th><button class="table-sort" data-sort="sort-name">No. Pinjaman</button></th>
                            <th><button class="table-sort" data-sort="sort-name">Jumlah Harus Dibayar</button></th>
                            <th><button class="table-sort" data-sort="sort-city">Denda</button></th>
                            <th><button class="table-sort" data-sort="sort-city">Jatuh Tempo</button></th>
                            <th><button class="table-sort" data-sort="sort-type">Status</button></th>
                            <th><button class="table-sort" data-sort="sort-type">Aksi</button></th>
                            </tr>
                        </thead>
                        <tbody class="table-tbody">
                            @foreach ($datas as $data)
                            <tr>
                                <td>{{ $data->inv_no }}</td>
                                <td>{{ $data->loan_no }}</td>
                                <td>{{ number_format($data->outstanding,2,",","."); }}</td>
                                <td>{{ number_format($data->penalty,2,",","."); }}</td>
                                <td>{{ substr($data->due_date,0,10) }}</td>
                                <td>
                                    @if ($data->status == 'not paid')
                                        <span class="badge bg-red text-red-fg">{{ $data->status }}</span>
                                    @else
                                        <span class="badge bg-blue text-blue-fg">{{ $data->status }}</span>
                                    @endif
                                </td>
                                @if (auth()->user()->role == 'Admin')
                                <td>
                                    @if ($data->status == "pending")
                                        <a href="{{ url('/borrower/loan/paid-confirm/'.encrypt($data->id)) }}" class="btn btn-success btn-xs" onclick="return confirm('Are You Sure PAID this invoice?')">
                                            <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-checks"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M7 12l5 5l10 -10" /><path d="M2 12l5 5m5 -5l5 -5" /></svg>
                                            Confirmed Pembayaran
                                        </a>
                                        <a href="{{ url('/borrower/loan/paid-unconfirm/'.encrypt($data->id)) }}" class="btn btn-warning btn-xs" onclick="return confirm('Are You Sure PAID this invoice?')">
                                            <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-x"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M18 6l-12 12" /><path d="M6 6l12 12" /></svg>
                                            Unconfirmed Pembayaran
                                        </a>
                                    @endif
                                </td>
                                @elseif (auth()->user()->role == 'Borrower')
                                <td>
                                    @if ($data->status == "not paid")
                                        <a href="{{ url('/borrower/loan/paid/'.encrypt($data->id)) }}" class="btn btn-success btn-xs" onclick="return confirm('Are You Sure PAID this invoice?')">
                                            <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-checks"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M7 12l5 5l10 -10" /><path d="M2 12l5 5m5 -5l5 -5" /></svg>
                                            Bayar
                                        </a>
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