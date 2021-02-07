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
                                        <i class="fa fa-plus-circle" aria-hidden="true"> Perangkat</i>
                                    </button>

                                   
                                    
                                    <!-- Modal -->
                                    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Add Perangkat</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <form action="{{ route('createperangkat') }}" enctype="multipart/form-data" class="text-capitalize" method="post">
                                                @csrf
                                                
                                                <div class="form-group">
                                                    <label>Nama Perangkat :</label>
                                                    <input type="text" name="perangkat" value="" placeholder="perangkat" class="form-control" required>
                                                </div>
                                                <div class="form-group">
                                                    <label>Jenis :</label>
                                                    <select class="form-control w-100" name="jenis" data-toggle="select2">
                                                            <option value="hardware">hardware</option>
                                                            <option value="software">software</option>
                                                            <option value="brainware">brainware</option>
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
                                        <th>Nama Perangkat</th>
                                        <th>Jenis</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                    <tbody class="text-center">
                                        @foreach ($perangkat as $listperangkat)
                                        <tr>
                                            <td>{{$loop->iteration}}</td>
                                            <td>{{$listperangkat->namaperangkat}}</td>
                                            <td>{{$listperangkat->jenis}}</td>
                                            <td>
                                                <a href="#" onclick="confirm1Tag({{ $listperangkat->id }})" class=" text-danger"><i class="fa fa-trash"></i></a>
                                                        <form id="confirm1-form-{{ $listperangkat->id }}" action="{{ url('perangkat/delete',[$listperangkat->id]) }}" method="POST" style="display: none;">
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