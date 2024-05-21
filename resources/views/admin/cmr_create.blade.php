@extends('admin.admin_dashboard')
@section('admin')
    <script src="{{asset('backend/assets/js/jquery.min.js')}}"></script>

    <div class="page-content">
        <!--breadcrumb-->
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
            <div class="breadcrumb-title pe-3">Create CMR</div>
            <div class="ps-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0">
                        <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">Create CMR</li>
                    </ol>
                </nav>
            </div>
            <div class="ms-auto">

            </div>
        </div>
        <!--end breadcrumb-->
        <div class="container">

            <form method="POST" action="{{ route('cmr.store') }}" enctype="multipart/form-data">
                @csrf
                <div class="main-body">
                    <div class="row">

                        <div class="col-lg-12">
                            <div class="card">



                                <div class="card-body">
                                    <div class="row mb-3">
                                        <div class="col-sm-3">
                                            <h6 class="mb-0">Title</h6>
                                        </div>
                                        <div class="col-sm-9 text-secondary">
                                            <input type="text" required name="title" class="form-control @error('email') is-invalid @enderror" />
                                            @error('title')
                                            <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-sm-3">
                                            <h6 class="mb-0">Description</h6>
                                        </div>
                                        <div class="col-sm-9 text-secondary">
                                            <input required type="text" name="description" class="form-control @error('description') is-invalid @enderror" />
                                            @error('title')
                                            <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-sm-3">
                                            <h6 class="mb-0">Request Date</h6>
                                        </div>
                                        <div class="col-sm-9 text-secondary">
                                            <input required type="date" name="request_date" class="form-control @error('request_date') is-invalid @enderror"
                                                   min="{{ Carbon\Carbon::now()->format('Y-m-d') }}" />  @error('request_date')
                                            <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>


                                    <div class="row mb-3">
                                        <div class="col-sm-3">
                                            <h6 class="mb-0">Report File</h6>
                                        </div>
                                        <div class="col-sm-9 text-secondary">
                                            <input required type="file" name="report_file" class="form-control @error('report_file') is-invalid @enderror"
                                                   id="report_file" /> @error('report_file')
                                            <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>



                                    @php
                                        $users=App\Models\User::all();
                                    @endphp

                                    @if(auth()->user()->hasAnyRole('super','admin'))
                                        <div class="row mb-3">
                                            <div class="col-sm-3">
                                                <h6 class="mb-0"> Owner Name</h6>
                                            </div>

                                            <div class="col-sm-9 text-secondary">

                                                <select   name="owner_id" class="form-select mb-3" aria-label="Default select example">
                                                    <option selected="" disabled>Open this select menu</option>

                                                    @foreach ($users as $user )
                                                        <option value="{{$user->id}}">{{$user->name}}</option>
                                                    @endforeach

                                                </select>
                                            </div>
                                        </div>
                                    @else

                                        <input type="hidden" name="owner_id" value="{{auth()->user()->id}}" >


                                    @endif



                                </div>


                            </div>



                        </div>
                    </div>
                </div>




                <div class="card-body">
                    <div class="row mt-3">
                        <div class="col-sm-12">
                            <h5 for="">Assignee Users</h5>
                            <input  min="1" type="number" id="numberOfUser" class="form-control col-3" placeholder="Number of Users" />

                            <span id="add-select-button" class="mt-2 btn btn-success btn-sm addmore"><i class="fa fa-plus-circle">Add User</i></span>
                            <span id="clear" class="  mt-2 btn btn-danger btn-sm clear"><i class="fa fa-plus-circle">Clear</i></span>

                        </div>

                        @php
                            $users = \App\Models\User::all();
                        @endphp

                        <div class="form-group col-md-6">




                            <div id="select-container">

                                {{--                            <div class="form-group  ">--}}
                                {{--                                <label class="form-label"> Level 1</label>--}}
                                {{--                                <select  name="users_id[]" class=" form-select mb-3">--}}
                                {{--                                    <option selected="" disabled>Open this select menu</option>--}}
                                {{--                                    @foreach ($users as $user)--}}
                                {{--                                        <option value="{{ $user->id }}">{{ $user->name }}</option>--}}
                                {{--                                    @endforeach--}}

                                {{--                                </select>--}}
                                {{--                            </div>--}}

                            </div>






                            <div class="col-md-12">
                                <div class="d-md-flex d-grid align-items-center gap-3">
                                    <button type="submit" class=" mt-2  btn btn-primary px-4">Submit</button>
                                </div>

                            </div>




                        </div>


                    </div>
                </div>

            </form>

        </div>

    </div>

    <script type="text/javascript">

        $(document).ready(function() {

            $('#image').change(function(e) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('#showImage').attr('src', e.target.result);
                }
                reader.readAsDataURL(e.target.files['0']);
            });



        });



    </script>


    <script>

        $(document).ready(function() {



            // const userIds = ['user1', 'user2', 'user3', 'user4', 'user5']; // List of user IDs
            let users=@json($users);
            function addSelects(numberOfSelects) {
                const selectContainer = document.getElementById('select-container');

                for (let i = 1; i <= numberOfSelects; i++) {
                    // Create a new form-group div
                    const formGroup = document.createElement('div');
                    formGroup.classList.add('form-group','DynamicDiv');

                    // Create a Label
                    const label = document.createElement('label');
                    label.classList.add('form-label');
                    label.textContent="Level " + (i)
                    formGroup.appendChild(label);



                    // Create a new select element
                    const select = document.createElement('select');
                    select.classList.add('form-control', 'mb-3');
                    select.name = 'users_id[]'// + (i + 1); // Optional: Give unique names if needed

                    const optionDefault = document.createElement('option');
                    optionDefault.textContent = 'Open This Select Menu';
                    select.appendChild(optionDefault);
                    // Add options to the select element

                    users.forEach(user => {
                        const option = document.createElement('option');
                        option.value = user.id;
                        option.textContent = user.name;
                        select.appendChild(option);
                    });

                    // Append the select to the form-group
                    formGroup.appendChild(select);

                    // Append the form-group to the select container
                    selectContainer.appendChild(formGroup);
                }
            }


            $('#add-select-button').on('click', function() {
                const numberOfUsers = $('#numberOfUser').val();
                if (numberOfUsers >= 1) {
                    clearSelects()
                    addSelects(numberOfUsers);
                } else {
                    $('#numberOfUser').css('border-color', 'red');
                    // Add focus to the input field
                    $('#numberOfUser').focus();
                    alert('Please enter a number greater than or equal to 1.');
                }
            });




            $('#clear').on('click', function() {
                clearSelects()
            });

            function clearSelects() {
                const selectContainer = document.getElementById('select-container');
                while (selectContainer.children.length >= 1) {
                    selectContainer.removeChild(selectContainer.lastChild);
                }

            }
        });


    </script>


@endsection
