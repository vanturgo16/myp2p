@extends('layouts.master')

@section('content')
    <!-- Page body -->
    <div class="page-body">
        <div class="container-xl">
            @if (session('status'))
                <div class="alert alert-important alert-warning alert-dismissible" role="alert">
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
            <div class="row row-cards">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                          <h3 class="card-title">Akun Penerima</h3>
                          <div class="form-control-plaintext">{{ $borrower->borrower_accountname }}</div>
                          <div class="form-control-plaintext">{{ $borrower->borrower_bank_name . " - " . $borrower->borrower_accountno }}</div>
                        </div>
                    </div>
                    <div class="card mt-2">
                        <form action="{{ url('/borrower/loan/store') }}" method="POST" class="card" enctype="multipart/form-data">
                            @csrf
                            <div class="card-header">
                                <h4 class="card-title">Pengajuan Pinjaman</h4>
                            </div>
                            <div class="card-body">
                                <div class="row g-5">
                                    
                                    <div class="col-xl-4">
                                        <div class="row">
                                            <div class="col-md-6 col-xl-12">
                                                <div class="mb-3">
                                                    <select class="form-select" name="loan_product" id="loan_product" required>
                                                        <option value="">-- Pilih Produk Pinjaman --</option>
                                                        @foreach ($loanProducts as $loanProduct)
                                                        <option value="{{ $loanProduct->id }}">{{ $loanProduct->product_name. " - Tenor ". $loanProduct->tenor . " Bulan" }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>     
                                    </div>
                                    <div class="col-xl-4">
                                        <div class="row">
                                            <div class="col-md-6 col-xl-12">
                                                <div class="mb-3">
                                                    <div>
                                                        <input type="hidden" name="borrower_id" value="{{ $borrower->id }}">
                                                        <input type="text" class="form-control" name="loan_amount" id="amount" placeholder="Input nominal pinjaman" required>
                                                      <small class="form-hint"><b>Limit Aktif: {{ number_format($borrower->loan_limit,2,",",".") }}</b></small>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>     
                                    </div>
                                    <div class="col-xl-4">
                                        <div class="row">
                                            <div class="col-md-6 col-xl-12">
                                                <div class="mb-3">
                                                    <select class="form-select" name="loan_purpose" required>
                                                        <option value="">-- Pilih Tujuan Pinjaman --</option>
                                                      <option value="Biaya Hidup">Biaya Hidup</option>
                                                      <option value="Kendaraan">Kendaraan</option>
                                                      <option value="Renovasi Rumah">Renovasi Rumah</option>
                                                      <option value="Rumah Sakit">Rumah Sakit</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>     
                                    </div>
                                </div>
                                <div class="row g-5" id="loan_product_details" style="display: none;">
                                    <div class="col-xl-4">
                                        <div class="row">
                                            <div class="col-md-6 col-xl-12">
                                                <div class="form-control-plaintext" id="loan_product_name"></div>
                                                <div class="form-control-plaintext" id="loan_product_service_fee"></div>
                                                <div class="form-control-plaintext" id="loan_product_interest"></div>
                                                <div class="form-control-plaintext" id="loan_product_tenor"></div>
                                            </div>
                                        </div>     
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer text-end">
                            <div class="d-flex">
                                <button type="submit" class="btn btn-primary ms-auto">Submit</button>
                            </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript">
        $(document).ready(function () {
            var charges = document.getElementById('amount');
            
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
            
            $('#loan_product').change(function() {
                var productID = $(this).val();
                var url = '{{ route("getProduct", ":id") }}';
                url = url.replace(':id', productID);
                if(productID) {
                    $.ajax({
                        url: url,
                        type: 'GET',
                        dataType: 'json',
                        success: function(data) {
                            // Menampilkan detail produk pinjaman di elemen label
                            var interest = (parseFloat(data.platform) + parseFloat(data.lender)).toFixed(3);
                            $('#loan_product_name').text('Nama Produk: ' + data.product_name);
                            $('#loan_product_service_fee').text('Biaya Layanan: ' + data.platform + '% /days');
                            $('#loan_product_interest').text('Bunga: ' + data.lender + '% /days');
                            $('#loan_product_tenor').text('Tenor: ' + data.tenor + ' ' + data.tenor_type);

                            // Tampilkan div dengan detail produk
                            $('#loan_product_details').show();
                        }
                    });
                } else {
                    // Menangani error jika produk tidak ditemukan
                    $('#loan_product_name').text('Produk tidak ditemukan.');
                    $('#loan_product_service_fee').text('');
                    $('#loan_product_interest').text('');
                    $('#loan_product_tenor').text('');

                    // sembunyikan  div dengan detail produk
                    $('#loan_product_details').hide();
                }
            });      
        });
    </script>
@endsection