@extends('layouts.master')

@section('content')
<!-- Page header -->
  <div class="page-header d-print-none">
    <div class="container-xl">
      <div class="row g-2 align-items-center">
        <div class="col">
          <h2 class="page-title">
            Users Internal
          </h2>
        </div>
      </div>
    </div>
  </div>
  <!-- Page body -->
  <div class="page-body">
    <div class="container-xl">
      <div class="card">
        <div class="card-header">
            <a href="#" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modal-add">
                <!-- Download SVG icon from http://tabler-icons.io/i/brand-facebook -->
                <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-plus"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 5l0 14" /><path d="M5 12l14 0" /></svg>
                Add User
            </a>   

            <div class="modal modal-blur fade" id="modal-add" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable" role="document">
                    <form action="{{ url('/users/internal/store') }}" class="form-control" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Form Add User Internal</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="mb-3">
                                <label class="form-label">Name</label>
                                <input type="text" name="user_name" class="form-control" name="example-text-input" placeholder="Your name" required>
                                </div>
                                <div class="mb-3">
                                <label class="form-label">Email</label>
                                <input type="email" name="user_email" class="form-control" name="example-text-input" placeholder="Your email" required>
                                </div>
                                <div class="row">
                                <div class="col-lg-8">
                                    <div class="mb-3">
                                        <label class="form-label">Password</label>
                                        <input type="password" name="user_password" class="form-control" name="example-text-input" placeholder="Your password" required>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="mb-3">
                                    <label class="form-label">Role</label>
                                    <select class="form-select" name="user_role" required>
                                        <option value="">- Choose Role --</option>
                                        <option value="Super Admin">Super Admin</option>
                                        <option value="Accounting">Accounting</option>
                                        <option value="Admin">Admin</option>
                                    </select>
                                    </div>
                                </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <a href="#" class="btn btn-link link-secondary" data-bs-dismiss="modal">
                                Cancel
                                </a>
                                <button type="submit" class="btn btn-primary ms-auto" id="submit-btn">
                                Submit
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="card-body">
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
            <div class="table-responsive">
                <table id="tableView" class="table card-table table-vcenter text-nowrap table-hover datatable">
                <thead>
                    <tr>
                    <th><button class="table-sort" data-sort="sort-name">No.</button></th>
                    <th><button class="table-sort" data-sort="sort-name">Name</button></th>
                    <th><button class="table-sort" data-sort="sort-city">Email</button></th>
                    <th><button class="table-sort" data-sort="sort-type">Role</button></th>
                    <th><button class="table-sort" data-sort="sort-type">Status</button></th>
                    <th><button class="table-sort" data-sort="sort-type">Action</button></th>
                    </tr>
                </thead>
                <tbody class="table-tbody">
                    @foreach ($datas as $data)
                    <tr>
                        <td>{{ $loop->iteration }}</td> 
                        <td>{{ $data->name }}</td>
                        <td>{{ $data->email }}</td>
                        <td>{{ $data->role }}</td>
                        <td>
                            @if ($data->is_active == 1)
                                <span class="badge bg-green text-green-fg">Active</span>
                            @else
                                <span class="badge bg-red text-red-fg">Not Active</span>
                            @endif
                        </td>
                        <td>
                            @if ($data->role != 'Borrower' && $data->role != 'Lender')
                                <a href="#" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modal-edit{{ $data->id }}">
                                    <!-- Download SVG icon from http://tabler-icons.io/i/brand-facebook -->
                                    <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-edit"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1" /><path d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z" /><path d="M16 5l3 3" /></svg>
                                    Edit
                                </a>
                            @endif

                            @if ($data->is_active == '1')
                                <form action="{{ url('/users/internal/delete', encrypt($data->id)) }}" method="POST" style="display:inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-xs" onclick="return confirm('Are You Sure INACTIVATE This Data?')">
                                        <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-square-rounded-x"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M10 10l4 4m0 -4l-4 4" /><path d="M12 3c7.2 0 9 1.8 9 9s-1.8 9 -9 9s-9 -1.8 -9 -9s1.8 -9 9 -9z" /></svg>
                                        Inactivate
                                    </button>
                                </form>
                            @else
                                <form action="{{ url('/users/internal/active', encrypt($data->id)) }}" method="POST" style="display:inline-block;">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="btn btn-success btn-xs" onclick="return confirm('Are You Sure ACTIVATE?')">
                                        <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-check"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M5 12l5 5l10 -10" /></svg>
                                        Activate
                                    </button>
                                </form>
                            @endif
                              
                            <div class="modal modal-blur fade" id="modal-edit{{ $data->id }}" tabindex="-1" role="dialog" aria-hidden="true">
                                <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable" role="document">
                                    <form action="{{ url('/users/internal/update/'.$data->id) }}" class="form-control" method="POST" enctype="multipart/form-data" onsubmit="showSpinner()">
                                        @csrf
                                        @method('PUT')
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Form Edit User Internal</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="mb-3">
                                                <label class="form-label">Name</label>
                                                <input type="text" name="user_name" value="{{ $data->name }}" class="form-control" name="example-text-input" placeholder="Your name" required>
                                                </div>
                                                <div class="mb-3">
                                                <label class="form-label">Email</label>
                                                <input type="email" name="user_email" value="{{ $data->email }}" class="form-control" name="example-text-input" placeholder="Your email" required>
                                                </div>
                                                <div class="row">
                                                <div class="col-lg-4">
                                                    <div class="mb-3">
                                                    <label class="form-label">Role</label>
                                                    <select class="form-select" name="user_role" required>
                                                        <option value="">- Choose Role --</option>
                                                        <option value="Super Admin" @if ($data->role == "Super Admin") selected @endif>Super Admin</option>
                                                        <option value="Accounting" @if ($data->role == "Accounting") selected @endif>Accounting</option>
                                                        <option value="Admin" @if ($data->role == "Admin") selected @endif>Admin</option>
                                                    </select>
                                                    </div>
                                                </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <a href="#" class="btn btn-link link-secondary" data-bs-dismiss="modal">
                                                Cancel
                                                </a>
                                                <button type="submit" class="btn btn-primary ms-auto" id="submit-btn">
                                                Submit
                                                <span id="spinner" class="spinner"></span>
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
                </table>
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