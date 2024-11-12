<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Crud Using jQuery</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <link rel="stylesheet" href="https://cdn.datatables.net/2.1.8/css/dataTables.dataTables.min.css"> 
       
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>
    <!-- {{-- toastr --}} -->
    <!-- {{-- toastr --}} -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.0.1/css/toastr.css" rel="stylesheet" />
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />




<link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.0.1/css/toastr.css" rel="stylesheet" />
    <style>
        .colored-toast.swal2-icon-success {
            background-color: #a5dc86 !important;
        }

        .colored-toast.swal2-icon-error {
            background-color: #f27474 !important;
        }



        .colored-toast .swal2-title {
            color: white;
        }

        .colored-toast .swal2-close {
            color: white;
        }

        .colored-toast .swal2-html-container {
            color: white;
        }
    </style>

</head>

<body>
    <div class="container mt-5">
        <h1>Products</h1>

        <!-- Button to open the create product modal -->
        <button class="btn btn-success mb-3" id="createNewProduct">Add Product</button>

        <!-- Product List Table -->
        <table class="table table-striped table-bordered data-table w-100" id="datatable">
            <thead>
                <tr>
                    <th class="border-bottom-0">S.No</th>
                    <th class="border-bottom-0">Name</th>
                    <th class="border-bottom-0">Address</th>
                    <th class="border-bottom-0">Country</th>
                    <th class="border-bottom-0">Status</th>
                    <th class="border-bottom-0">Created_at</th>
                    <th class="border-bottom-0">Action</th>
                </tr>
            </thead>
            <tbody id="studentdata">
            </tbody>
        </table>

        <!-- Product Form Modal -->
        <div class="modal fade" id="ajaxProductModal" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <form id="productForm" name="productForm" action="{{ url('crud/store') }}" method="post">
                        @csrf
                        <div class="modal-header">
                            <h4 class="modal-title" id="modelHeading"></h4>
                        </div>
                        <div class="modal-body">
                            <input type="hidden" name="id" id="id">
                            <div class="row">
                                <div class="form-group mb-3 col-6">
                                    <label for="name" class="control-label">Name</label>
                                    <input type="text" class="form-control" id="name" name="name" required>
                                </div>

                                <div class="form-group mb-3 col-6">
                                    <label for="email" class="control-label">Email</label>
                                    <input type="email" class="form-control" id="email" name="email" required>
                                </div>
                                <div class="form-group mb-3 col-6">
                                    <label for="country" class="control-label">Country</label>
                                    <select name="country_id_fk" id="country" class="form-control">
                                        <option value="0">Select Country</option>
                                        @foreach($countries as $key => $country)
                                            <option value="{{$key}}">{{$country}}</option>
                                        @endforeach
                                    </select>
                                    {{-- <input type="text" class="form-control" id="country" name="country_id_fk" required> --}}
                                </div>
                                <div class="form-group mb-3 col-6">
                                    <label for="status" class="control-label">Status</label>
                                    <select name="status" id="status" class="form-control">
                                        <option value="1">Active</option>
                                        <option value="0">In-Active</option>
                                    </select>
                                </div>
                                <div class="form-group mb-3 col-12">
                                    <label for="address" class="control-label">Address</label>
                                    <textarea id="address" name="address" required class="form-control"></textarea>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary" id="saveBtn" value="">Save</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

 <!-- jQuery -->
 <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
 <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
 <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
 {{-- tostr --}}
 <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.0.1/js/toastr.js"></script>
 {{-- datatable --}}
 <script src="https://cdn.datatables.net/2.1.8/js/dataTables.min.js"></script>
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
     
        <script>
        //     $(document).ready(function(){
        //         $("#country").select2({
        //             dropdownParent: $('#ajaxProductModal')
        // });
        //         $("#country").select2({
        //     placeholder: "Select country",
        //     allowClear: true,
        // });
        //     });
        </script>
        <script>
            $(document).ready(function() {
                toastr.options.timeOut = 3000;
                toastr.options.closeButton = true;
                @if (Session::has('error'))
                    toastr.error('{{ Session::get('error') }}');
                @elseif (Session::has('success'))
                    toastr.success('{{ Session::get('success') }}');
                @endif
            });
        </script>
    <script>
        
        $(document).ready(function() {
            $('#createNewProduct').click(function() {
                $('#modelHeading').html("Add New Product");
                $('#saveBtn').html("Create Product");
                $('#productForm').trigger("reset");
                $('#ajaxProductModal').modal('show');
            });

            // Store the data using AJAX
            $('#productForm').on('submit', function(e) {
                e.preventDefault();
                var formdata = $(this).serialize();
                if(formdata){
                    showloader();
                    $.ajax({
                        type: 'POST',
                        url: "{{ url('curd/store') }}",
                        data: formdata,
                        success: function(response) {
                            if (response.success == true) {
                                    $('#ajaxProductModal').modal('hide');
                                    hideloader();
                                    window.location.reload(true);
                            } else {
    
                                // Handle error
                            }
                        }
                    });
                }  
                else{
                    hideloader();
                }
            });

// list data here
            $('#datatable').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ url('curd/show') }}",
                columns: [
                    { data: 'id', name: 'id', },
                    { data: 'name', name: 'name' },
                    { data: 'address', name: 'address'},
                    { data: 'country_id_fk', name: 'country_id_fk' },
                    { data: 'status', name: 'status' },
                    { data: 'created_at', name: 'created_at' },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false // Assuming you don't want to search this column
                    },
                ],
                language: {
                    search: "_INPUT_",
                    searchPlaceholder: "Search records",
                }
            });
            
        });

        // edit user data 
        $(document).on('click','.edituser',function(){
            var id = $(this).data('id');
            $.get("{{ url('curd/edit') }}"+'/' + id, function(data) {
                    $('#ajaxProductModal').modal('show');
                    $('#modelHeading').html("Update Users");
                    $('#saveBtn').html("Update Changes");
                    $('#id').val(data.id); 
                    $('#name').val(data.name);
                    $('#email').val(data.email);
                    $('#country').val(data.country_id_fk);
                    $('#status').val(data.status);
                    $('#address').val(data.address);
                })
        });

        // delete user
        $(document).on('click','.deleteuser',function(){
            var id = $(this).data('id');
            $.ajax({
                url:"{{('curd/delete/')}}"+id ,
                method:"GET",
                success:function(data){
                    if(data.success ==true){
                        // console.log(data);
                        toastr.success(data.msg, data.success, {
                            closeButton: true
                        });
                        window.location.reload();
                    }
                }
            });
        });

        function showloader(){
            Swal.fire({
            title: "User data save",
            text: "Data save successfully!!",
            icon: "success",
            }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire({
                title: "success!",
                text: "Data save successfully",
                icon: "success",
                timer: 2000

                });
            }
            });
        }

        function hideloader() {
            Swal.close();
        }
    </script>
</body>

</html>
