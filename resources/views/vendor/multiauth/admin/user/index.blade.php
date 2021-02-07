@extends('multiauth::layouts.master')
@section('content')
@php
    use App\Roleuser;
@endphp
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
                                <h3 class="card-title">
                                    
                                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
                                        <i class="fa fa-user-plus" aria-hidden="true"></i>
                                    </button> 

                                   
                                    
                                    <!-- Modal -->
                                    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Add User</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <form action="{{ route('admin.user') }}" enctype="multipart/form-data" class="text-capitalize" method="post">
                                                @csrf
                                                
                                                <div class="form-group">
                                                    <label>Name :</label>
                                                    <input type="text" name="name" value="" placeholder="name" class="form-control" required>
                                                </div>
                                                <div class="form-group">
                                                    <label>Username :</label>
                                                    <input type="text" name="username" value="" placeholder="username" class="form-control" required>
                                                </div>

                                                <div class="form-group">
                                                    <label>Email :</label>
                                                    <input type="email" name="email" value="" placeholder="user@user.com" class="form-control" required>
                                                </div>
                                                <div class="form-group">
                                                    <label>Password :</label>
                                                    <input type="password" name="password" value="" placeholder="password" class="form-control" required>
                                                </div>
                                                
                                                <div class="form-group">
                                                    <label>Confirm Password :</label>
                                                    <input type="password" name="password_confirm" value="" placeholder="password_confirm" class="form-control" required>
                                                </div>

                                                <div class="form-group">
                                                    <label>Akses :</label>
                                                    <div class="form-group">
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox" name="master">
                                                            <label class="form-check-label">Master</label>
                                                        </div>
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox" name="inventaris">
                                                            <label class="form-check-label">Inventaris</label>
                                                        </div>
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox" name="laporan">
                                                            <label class="form-check-label">Laporan</label>
                                                        </div>
                                                </div>
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


                                <div class="float-sm-right">
                                    
                                   
                                </div>
                            </div>
                            <!-- /.card-header -->
                                <div class="card-body">
                                <table id="example2" class="table table-bordered table-hover">
                                    <thead class="text-center">
                                    <tr>
                                        <th>No</th>
                                        <th>Nama</th>
                                        <th>Username</th>
                                        <th>Akses</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                    <tbody class="text-center">
                                        @foreach ($user as $listuser)
                                        <tr>
                                            <td>{{$loop->iteration}}</td>
                                            <td>{{$listuser->name}}</td>
                                            <td>{{$listuser->username}}</td>
                                            <td>
                                            <!-- Button trigger modal -->
                                                <a href="#" class="text-primary" data-toggle="modal" data-target="#detail{{ $listuser->id }}">
                                                    <i class="fa fa-eye"></i>
                                                </a>
                                                <!-- Modal -->
                                                <div class="modal fade" id="detail{{ $listuser->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLabel">Detail Akses</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="text-left">
                                                                <p>Halaman Master : {{ $listuser->master == 1 ? 'Yes' : 'No', }}</p>
                                                                <p>Halaman Inventaris : {{ $listuser->inventaris == 1 ? 'Yes' : 'No', }}</p>
                                                                <p>Halaman Laporan : {{ $listuser->laporan == 1 ? 'Yes' : 'No', }}</p>
                                                            </div>
                                                           
                                                        </div>
                                                        <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                        </div>
                                                    </div>
                                                    </div>
                                                </div>
                                                


                                            </td>
                                            <td>
                                                <a href="#" onclick="confirm1Tag({{ $listuser->id }})" class=" text-danger"><i class="fa fa-trash"></i></a>
                                                <form id="confirm1-form-{{ $listuser->id }}" action="{{ url('admin/user/delete',[$listuser->id]) }}" method="POST" style="display: none;">
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