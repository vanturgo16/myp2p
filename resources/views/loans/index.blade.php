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
                <h3 class="card-title">{{ $data->loan_no }}</h3>
                <div class="card-actions">
                    <button type="submit" class="btn btn-primary ms-auto">Danai</button>
                </div>
            </div>
            <div class="card-body">
              <div class="datagrid">
                <div class="datagrid-item">
                  <div class="datagrid-title">Registrar</div>
                  <div class="datagrid-content">Third Party</div>
                </div>
                <div class="datagrid-item">
                  <div class="datagrid-title">Nameservers</div>
                  <div class="datagrid-content">Third Party</div>
                </div>
                <div class="datagrid-item">
                  <div class="datagrid-title">Port number</div>
                  <div class="datagrid-content">3306</div>
                </div>
                <div class="datagrid-item">
                  <div class="datagrid-title">Expiration date</div>
                  <div class="datagrid-content">–</div>
                </div>
                <div class="datagrid-item">
                  <div class="datagrid-title">Creator</div>
                  <div class="datagrid-content">
                    <div class="d-flex align-items-center">
                      <span class="avatar avatar-xs me-2 rounded" style="background-image: url(./static/avatars/000m.jpg)"></span>
                      Paweł Kuna
                    </div>
                  </div>
                </div>
                <div class="datagrid-item">
                  <div class="datagrid-title">Age</div>
                  <div class="datagrid-content">15 days</div>
                </div>
                <div class="datagrid-item">
                  <div class="datagrid-title">Edge network</div>
                  <div class="datagrid-content">
                    <span class="status status-green">
                      Active
                    </span>
                  </div>
                </div>
                <div class="datagrid-item">
                  <div class="datagrid-title">Avatars list</div>
                  <div class="datagrid-content">
                    <div class="avatar-list avatar-list-stacked">
                      <span class="avatar avatar-xs rounded" style="background-image: url(./static/avatars/000m.jpg)"></span>
                      <span class="avatar avatar-xs rounded">JL</span>
                      <span class="avatar avatar-xs rounded" style="background-image: url(./static/avatars/002m.jpg)"></span>
                      <span class="avatar avatar-xs rounded" style="background-image: url(./static/avatars/003m.jpg)"></span>
                      <span class="avatar avatar-xs rounded" style="background-image: url(./static/avatars/000f.jpg)"></span>
                      <span class="avatar avatar-xs rounded">+3</span>
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