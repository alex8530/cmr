@extends('admin.admin_dashboard')
@section('admin')
    <script src="{{ asset('backend/assets/js/jquery.min.js') }}"></script>

    <div class="page-content">
        <!--breadcrumb-->
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
            <div class="breadcrumb-title pe-3">Create CMR</div>
            <div class="ps-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0">
                        <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a></li>
                        <li class="breadcrumb-item active" aria-current="page">Create CMR</li>
                    </ol>
                </nav>
            </div>
        </div>
        <!--end breadcrumb-->

        <div class="container">
            <form method="POST" action="{{ route('cmr.store') }}" enctype="multipart/form-data">
                @csrf

                <div class="card shadow-sm mb-4">
                    <div class="card-header">
                        <h4>Create CMR</h4>
                    </div>
                    <div class="card-body">
                        <div class="mb-3 row">
                            <label for="title" class="col-sm-3 col-form-label">Title</label>
                            <div class="col-sm-9">
                                <input type="text" required name="title"
                                       class="form-control @error('title') is-invalid @enderror" />
                                @error('title')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label for="description" class="col-sm-3 col-form-label">Description</label>
                            <div class="col-sm-9">
                                <input required type="text" name="description"
                                       class="form-control @error('description') is-invalid @enderror" />
                                @error('description')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label for="request_date" class="col-sm-3 col-form-label">Request Date</label>
                            <div class="col-sm-9">
                                <input required type="date" name="request_date"
                                       class="form-control @error('request_date') is-invalid @enderror"
                                       min="{{ Carbon\Carbon::now()->format('Y-m-d') }}" />
                                @error('request_date')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label for="report_file" class="col-sm-3 col-form-label">Report File</label>
                            <div class="col-sm-9">
                                <input required type="file" name="report_file"
                                       class="form-control @error('report_file') is-invalid @enderror" id="report_file" />
                                @error('report_file')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        @php
                            $users = App\Models\User::all();
                        @endphp

                        @if (auth()->user()->hasAnyRole('super', 'admin'))
                            <div class="mb-3 row">
                                <label for="owner_id" class="col-sm-3 col-form-label">Owner Name</label>
                                <div class="col-sm-9">
                                    <select name="owner_id" class="form-select mb-3" aria-label="Default select example">
                                        <option selected="" disabled>Open this select menu</option>
                                        @foreach ($users as $user)
                                            <option value="{{ $user->id }}">{{ $user->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        @else
                            <input type="hidden" name="owner_id" value="{{ auth()->user()->id }}">
                        @endif
                    </div>
                </div>

                <div class="card shadow-sm mb-4">
                    <div class="card-header">
                        <h5>Assignee Users</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3 row">
                            <label for="numberOfUser" class="col-sm-3 col-form-label">Number of Users</label>
                            <div class="col-sm-9">
                                <input min="1" type="number" id="numberOfUser" class="form-control"
                                       placeholder="Number of Users" />
                            </div>
                        </div>

                        <div class="d-flex justify-content-end gap-2">
                            <span id="add-select-button" class="btn btn-success btn-sm addmore"><i
                                    class="fa fa-plus-circle"></i> Add User</span>
                            <span id="clear" class="btn btn-danger btn-sm clear"><i class="fa fa-minus-circle"></i>
                                Clear</span>
                        </div>

                        @php
                            $users = \App\Models\User::all();
                        @endphp

                        <div id="select-container" class="mt-3">
                            <!-- Dynamic Selects will be added here -->
                        </div>

                        <div class="mt-4 d-flex justify-content-end">
                            <button type="submit" class="btn btn-primary px-4">Submit</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script type="text/javascript">
        $(document).ready(function() {
            let users = @json($users);

            function addSelects(numberOfSelects) {
                const selectContainer = document.getElementById('select-container');
                for (let i = 1; i <= numberOfSelects; i++) {
                    const formGroup = document.createElement('div');
                    formGroup.classList.add('form-group', 'mb-3');

                    const label = document.createElement('label');
                    label.classList.add('form-label');
                    label.textContent = "Level " + i;
                    formGroup.appendChild(label);

                    const select = document.createElement('select');
                    select.classList.add('form-select', 'mb-3');
                    select.name = 'users_id[]';

                    const optionDefault = document.createElement('option');
                    optionDefault.textContent = 'Open This Select Menu';
                    optionDefault.disabled = true;
                    optionDefault.selected = true;
                    select.appendChild(optionDefault);

                    users.forEach(user => {
                        const option = document.createElement('option');
                        option.value = user.id;
                        option.textContent = user.name;
                        select.appendChild(option);
                    });

                    formGroup.appendChild(select);
                    selectContainer.appendChild(formGroup);
                }
            }

            $('#add-select-button').on('click', function() {
                const numberOfUsers = $('#numberOfUser').val();
                if (numberOfUsers >= 1) {
                    clearSelects()
                    addSelects(numberOfUsers);
                    $('#numberOfUser').css('border-color', '');
                } else {
                    $('#numberOfUser').css('border-color', 'red');
                    $('#numberOfUser').focus();
                    alert('Please enter a number greater than or equal to 1.');
                }
            });

            $('#clear').on('click', function() {
                clearSelects()
            });

            function clearSelects() {
                const selectContainer = document.getElementById('select-container');
                while (selectContainer.children.length > 0) {
                    selectContainer.removeChild(selectContainer.lastChild);
                }
            }
        });
    </script>

@endsection
