@extends('multiauth::layouts.master')
@section('content')

<script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card shadow">
                <div class="card-body">
                    <!-- Main content -->
                    <div class="row">
                        <div class="col-12">
                        <div class="card">
                            <div class="col-md-12">
                                @include('multiauth::layouts.common.alert')
                            </div>
                            <!-- /.card-header -->
                                <div class="card-body">
                                    <form action="" method="get">
                                            <div class="filter_panel">
                                                <div class="row">
                                                    <div class="col-md-2">
                                                        <div class="daterange_btn" id="daterange-btn" style="width: 100%;">
                                                            <input type="text" name="filter" value="" />
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="input-group mb-3">
                                                                <select class="custom-select" id="inputGroupSelect01"  name="skpd">
                                                                    <option {{$skpdnow == '-' ? 'selected' : ''}} disabled>Pilih Skpd</option>
                                                                    @foreach ($skpdlist as $skpd)
                                                                        <option value="{{ $skpd->id }}" {{$skpd->id == $skpdnow ? 'selected' : ''}}>{{ $skpd->namaskpd }}</option>
                                                                    @endforeach
                                                                </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-1">
                                                        <button type="submit" class="btn btn-primary">Filter</button>
                                                    </div>
                                            <br>
                                    </form>
                                    </div>
                                    @if ($inventaris == '[]')
                                        
                                    @else
                                            @if ($bisa_print == "yes")
                                            <form action="{{ route('admin.laporan.laporanprint', [$print] )}}" method="post">
                                                @csrf
                                                <div class="float-left pb-4">
                                                    @if ($namaskpd != null)
                                                        <input type="hidden" name="namaskpd" value="{{$namaskpd}}">
                                                    @endif
                                                    @if($fromasd != null && $fromasd1 != null)
                                                        <input type="hidden" name="fromasd" value="{{$fromasd}}">
                                                        <input type="hidden" name="fromasd1" value="{{$fromasd1}}">
                                                    @endif
                                                    <input type="hidden" name="print" value="{{$print}}">
                                                    <div class="col-md-1">
                                                        <button type="submit" class="btn btn-primary"><i class="fas fa-print"></i> </button>
                                                    </div>
                                                </div>
                                            </form>
                                        @else
                                            
                                        @endif
                                    @endif
                                    
                                    
                                </div>

                                <table id="example2" class="table table-bordered table-hover">
                                    <thead class="text-center">
                                    <tr>
                                        <th>No</th>
                                        <th>Nama SKPD</th>
                                        <th>Nama Perangkat</th>
                                        <th>Jumlah</th>
                                        <th>Tanggal Inventaris</th>
                                        <th>Dibuat</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                    <tbody class="text-center">
                                        @foreach ($inventaris as $listinventaris)
                                        <tr>
                                            <td>{{$loop->iteration}}</td>
                                            <td>{{$listinventaris->namaskpd}}</td>
                                            <td>{{$listinventaris->namaperangkat}}</td>
                                            <td>{{$listinventaris->jumlah}}</td>
                                            <td>{{$listinventaris->tanggal}}</td>
                                            <td>{{$listinventaris->created_at}}</td>
                                            <td>
                                                <a data-toggle="modal" data-target="#exampleModal">
                                                    <i class="fas fa-eye" style="color: red"></i>
                                                </a>
                                                
                                                <!-- Modal -->
                                                <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLabel">Detail</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                        <div class="modal-body">
                                                            <div class="float-left">
                                                                Nama SKPD :
                                                            </div>
                                                            <div class="float-right">
                                                                {{$listinventaris->namaskpd}}
                                                            </div>
                                                            <br>
                                                            <div class="float-left">
                                                                Alamat SKPD :
                                                            </div>
                                                            <div class="float-right">
                                                                {{ $listinventaris->alamat }}
                                                            </div>
                                                            <br>
                                                            <div class="float-left">
                                                                Telepon SKPD :
                                                            </div>
                                                            <div class="float-right">
                                                                {{$listinventaris->tlp}}
                                                            </div>
                                                            <br>
                                                            <div class="float-left">
                                                                Kota SKPD :
                                                            </div>
                                                            <div class="float-right">
                                                                {{$listinventaris->kota}}
                                                            </div>
                                                            <br>
                                                            <div class="float-left">
                                                                Nama Perangkat :
                                                            </div>
                                                            <div class="float-right">
                                                                {{$listinventaris->namaperangkat}}
                                                            </div>
                                                            <br>
                                                            <div class="float-left">
                                                                Jumlah Perangkat :
                                                            </div>
                                                            <div class="float-right">
                                                                {{$listinventaris->jumlah}}
                                                            </div>
                                                            <br>
                                                            <div class="float-left">
                                                                Pembuat Inventaris :
                                                            </div>
                                                            <div class="float-right">
                                                                {{$listinventaris->pembuat}}
                                                            </div>
                                                            <br>
                                                            <div class="float-left">
                                                                Deskripsi :
                                                            </div>
                                                            <div class="float-right">
                                                                {{$listinventaris->deskripsi}}
                                                            </div>
                                                            <br>
                                                            <div class="float-left">
                                                                Tanggal Inventaris :
                                                            </div>
                                                            <div class="float-right">
                                                                {{$listinventaris->tanggal}}
                                                            </div>
                                                            <br>
                                                            <div class="float-left">
                                                                Pembuatan Inventaris :
                                                            </div>
                                                            <div class="float-right">
                                                                {{$listinventaris->created_at}}
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                        </div>
                                                    </div>
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
            </div>
        </div>
    </div>
</div>



<script>
$(function() {
  $('input[name="filter"]').daterangepicker({
    opens: 'left'
  }, function(start, end, label) {
    console.log("A new date selection was made: " + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD'));
  });
});
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.29.2/sweetalert2.all.js"></script> 
<script>
function confirm1Tag(id) {
    swal({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes',
        cancelButtonText: 'No',
        confirmButtonClass: 'btn btn-success px-3 m-1',
        cancelButtonClass: 'btn btn-danger px-3 m-1',
        buttonsStyling: false,
        reverseButtons: true
    }).then((result) => {
        if (result.value) {
            event.preventDefault();
            document.getElementById('confirm1-form-' + id).submit();
        } else if (
            // Read more about handling dismissals
            result.dismiss === swal.DismissReason.cancel
        ) {
            swal(
                'Cancelled'
            )
        }
    })
}
</script>

@endsection