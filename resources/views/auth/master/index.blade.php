@extends('layouts.master')
@section('content')
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
                                @include('layouts.common.alert')
                            </div>
                            <div class="card-header">
                                <h3 class="card-title"><!-- Button trigger modal -->
                                    

                                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
                                        <i class="fa fa-plus-circle" aria-hidden="true"> skpd</i>
                                    </button>

                                   
                                    
                                    <!-- Modal -->
                                    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Add Skpd</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <form action="{{ route('createskpd') }}" enctype="multipart/form-data" class="text-capitalize" method="post">
                                                @csrf
                                                
                                                <div class="form-group">
                                                    <label>Nama Skpd :</label>
                                                    <input type="text" name="name" value="" placeholder="name" class="form-control" required>
                                                </div>
                                                <div class="form-group">
                                                    <label>Alamat :</label>
                                                    <input type="textarea" name="alamat" value="" placeholder="alamat" class="form-control" required>
                                                </div>

                                                <div class="form-group">
                                                    <label>Telepon :</label>
                                                    <input type="number" name="telepon" value="" placeholder="021xxxx" class="form-control" required>
                                                </div>

                                                <div class="form-group">
                                                    <label>Kota :</label>
                                                    <select class="form-control w-100" name="kota" data-toggle="select2">
                                                        @php
                                                        $city = city();
                                                        $city = json_decode($city,true);
                                                        @endphp
                                                        @foreach($city['rajaongkir']['results'] as $citys)
                                                            <option value="{{ $citys['city_name'] }}">{{ $citys['city_name'] }} </option>
                                                        @endforeach
                                                    </select>
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
                                        <th>Alamat</th>
                                        <th>Tlp</th>
                                        <th>Kota</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                    <tbody class="text-center">
                                        @foreach ($skpd as $listskpd)
                                        <tr>
                                            <td>{{$loop->iteration}}</td>
                                            <td>{{$listskpd->namaskpd}}</td>
                                            <td>{{$listskpd->alamat}}</td>
                                            <td>{{$listskpd->tlp}}</td>
                                            <td>{{$listskpd->kota}}</td>
                                            <td>
                                                <a href="#" onclick="confirm1Tag({{ $listskpd->id }})" class=" text-danger"><i class="fa fa-trash"></i></a>
                                                        <form id="confirm1-form-{{ $listskpd->id }}" action="{{ url('skpd/delete',[$listskpd->id]) }}" method="POST" style="display: none;">
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