@extends('multiauth::layouts.master')
@section('content')
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<link rel="stylesheet" href="/resources/demos/style.css">
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
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
                            <div class="card-header">
                                <h3 class="card-title"><!-- Button trigger modal -->
                                    

                                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
                                        <i class="fa fa-plus-circle" aria-hidden="true"> Inventaris</i>
                                    </button>

                                   
                                    
                                    <!-- Modal -->
                                    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Add Inventaris</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <form action="{{ route('admin.createinventaris') }}" enctype="multipart/form-data" class="text-capitalize" method="post">
                                                @csrf
                                                
                                                <div class="form-group">
                                                    <label>Nama Skpd :</label>
                                                    <select class="form-control w-100" name="skpd_id" data-toggle="select2">
                                                        
                                                        @foreach($skpd as $listskpd)
                                                            <option value="{{ $listskpd->id }}">{{ $listskpd->namaskpd }}</option>
                                                        @endforeach
                                                    </select>
                                                    
                                                </div>
                                                <div class="form-group">
                                                    <label>Nama Perangkat :</label>
                                                    <select class="form-control w-100" name="perangkat_id" data-toggle="select2">
                                                        
                                                        @foreach($perangkat as $listperangkat)
                                                            <option value="{{ $listperangkat->id }}">{{ $listperangkat->namaperangkat }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label>Jumlah Perangkat :</label>
                                                    <input type="number" name="jumlahperangkat" value="" placeholder="2" class="form-control" required>
                                                </div>

                                                <div class="form-group">
                                                    <label>Tanggal :</label>
                                                    <input type="text" name="tanggal" id="datepicker" class="form-control" required>
                                                </div>

                                                <div class="form-group">
                                                    <label>Keterangan :</label>
                                                    <br>
                                                    {{-- <input type="textarea" name="keterangan" class="form-control" required> --}}
                                                        <textarea name="keterangan" id="" cols="46" rows="10"></textarea>
                                                </div>
                                                <input type="hidden" name="pembuat" value="{{Auth::user()->name}}">
                                            </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                            <button type="submit" class="btn btn-primary">Submit</button>
                                            </form>
                                        </div>
                                        </div>
                                    </div>
                                    </div>
                                </h3>


                                
                            </div>
                            <!-- /.card-header -->
                                <div class="card-body">

                                   

                                <table id="example2" class="table table-bordered table-hover">
                                    <thead class="text-center">
                                    <tr>
                                        <th>No</th>
                                        <th>Nama SKPD</th>
                                        <th>Nama Perangkat</th>
                                        <th>Jumlah</th>
                                        <th>Tanggal</th>
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
                                            <td>
                                                <a href="#" onclick="confirm1Tag({{ $listinventaris->id }})" class=" text-danger"><i class="fa fa-trash"></i></a>
                                                        <form id="confirm1-form-{{ $listinventaris->id }}" action="{{ url('admin/inventaris/delete',[$listinventaris->id]) }}" method="POST" style="display: none;">
                                                            {{ csrf_field() }}
                                                        </form>
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
    $( function() {
      $( "#datepicker" ).datepicker();
    } );
    </script>
<!-- date-range-picker -->
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