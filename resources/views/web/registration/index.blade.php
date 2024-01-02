@extends('layouts.web.main')

@section('content')
    <section class="form_section" >
        <div class="container py-5">
            <header class="d-flex flex-wrap justify-content-between align-items-center gap-1">
                <h1>Data User</h1>
                <!-- Button trigger modal -->
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#insertData">
                    Input Data
                </button>
            </header>

            <div class="my-5">
                @if(session()->has("error"))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @elseif (session()->has("success"))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                <div class="table-responsive">
                    <table class="table table-bordered py-2" id="table">
                        <thead>
                            <tr>
                                <th class="text-center" scope="col">No</th>
                                <th class="text-center" scope="col">Name</th>
                                <th class="text-center" scope="col">Age</th>
                                <th class="text-center" scope="col">City</th>
                                <th class="text-center" scope="col">Created At</th>
                                <th class="text-center" scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $no => $user)
                            <tr>
                                <td class="text-center">{{ $no+1 }}</td>
                                <td>{{ $user['name'] }}</td>
                                <td class="text-center">{{ $user['age'] }}</td>
                                <td>{{ $user['city'] }}</td>
                                <td class="text-center"><?php echo (new DateTime($user['created_at']))->format('j F Y') ?></td>
                                <td class="text-center">
                                    <div class="d-flex gap-1 flex wrap justify-content-center">
                                        <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#updateData{{ $user["id"] }}">
                                            Update
                                        </button>
                                        <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteData{{ $user["id"] }}">
                                            Delete
                                        </button>
                                    </div>
                                </td>
                            </tr>

                            <div class="modal fade" id="updateData{{ $user["id"] }}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="updateData{{ $user["id"] }}Label" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h1 class="modal-title fs-5" id="staticBackdropLabel">Update Data User</h1>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <form method="POST" action="{{ route('registration.update') }}" >
                                            <div class="modal-body">
                                                @csrf
                                                <input type="hidden" name="id" value="{{ $user['id'] }}">
                                                <div class="mb-3 form-floating">
                                                    <input type="text" name="input" id="input" class="form-control" placeholder="input" value="{{ $user['name']." ".$user['age']." ".$user['city'] }}">
                                                    <label for="input">NAMA USIA KOTA</label>
                                                </div>
                                            </div>
                                        <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                <button type="submit" class="btn btn-warning">Update</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            <div class="modal fade" id="deleteData{{ $user['id'] }}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="deleteData{{ $user['id'] }}Label" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h1 class="modal-title fs-5" id="staticBackdropLabel">Delete Data User</h1>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <form method="POST" action="{{ route('registration.delete') }}" >
                                            <div class="modal-body">
                                                @method('delete')
                                                @csrf
                                                <input type="hidden" name="id" value="{{ $user['id'] }}">
                                                <div class="mb-3 form-floating">
                                                    <input type="text" name="input" id="input" class="form-control" disabled value="{{ $user['name']." ".$user['age']." ".$user['city'] }}">
                                                    <label for="input">NAMA USIA KOTA</label>
                                                </div>
                                            </div>
                                        <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                <button type="submit" class="btn btn-danger">Delete</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>

    <!-- Modal -->
    <div class="modal fade" id="insertData" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="insertDataLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="staticBackdropLabel">Input Data User</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="POST" action="{{ route('registration') }}" >
                    <div class="modal-body">
                        @csrf
                        <div class="mb-3 form-floating">
                            <input type="text" name="input" id="input" class="form-control" placeholder="input">
                            <label for="input">NAMA USIA KOTA</label>
                        </div>
                    </div>
                <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        let table = new DataTable('#table');
    </script>
@endsection

