@extends('admin.admin_dashboard')
@section('admin')
    {{-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script> --}}

    <div class="page-content">
        <!--breadcrumb-->
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
            <div class="breadcrumb-title pe-3">Edit CMR</div>
            <div class="ps-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0">
                        <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                        </li>
                        {{-- <li class="breadcrumb-item active" aria-current="page">Create CMR</li> --}}
                    </ol>
                </nav>
            </div>
            <div class="ms-auto">

            </div>
        </div>
        <!--end breadcrumb-->
        <div class="container">
            <div class="main-body">
                <div class="row">

                    <div class="col-lg-12">
                        <div class="card">

                            <form method="POST" action="{{ route('cmr.update') }}" enctype="multipart/form-data">
                                @csrf

                                <input type="hidden" name="cmr_id" value="{{$cmr->id}}">

                                <div class="card-body">
                                    <div class="row mb-3">
                                        <div class="col-sm-3">
                                            <h6 class="mb-0">Title</h6>
                                        </div>
                                        <div class="col-sm-9 text-secondary">
                                            <input value='{{$cmr->title}}' type="text" name="title" class="form-control @error('email') is-invalid @enderror" /> 
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
                                            <input  value='{{$cmr->description}}' type="text" name="description" class="form-control @error('description') is-invalid @enderror" />
                                            @error('description')
                                            <span class="text-danger">{{ $message }}</span>
                                          @enderror
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-sm-3">
                                            <h6 class="mb-0">Request Date</h6>
                                        </div>
                                        <div class="col-sm-9 text-secondary">
                                            @php
                                        
                                            @endphp
                                            <input type="date" value='{{$cmr->request_date}}' name="request_date" class="form-control @error('request_date') is-invalid @enderror"
                                                min="{{ Carbon\Carbon::now()->format('Y-m-d') }}" />  @error('request_date')
                                                <span class="text-danger">{{ $message }}</span>
                                              @enderror
                                        </div>
                                    </div>

                                @php
                                    $file_track = App\Models\FileTrack::where('cmr_id', $cmr->id)
                                        ->where('version_number', '0')
                                        ->where('status','1') 
                                        ->first();

                                @endphp


                    <div class="col-sm-3">
                        <h6 class="mb-0">Version 0</h6>
                    </div>
                    <div class="col-sm-9 text-secondary">
                        <a href="{{ route('cmr.download', $file_track->filename) }}"
                            class="btn btn-primary px-5" id="details">{{ $file_track->filename }} </a>

                    </div>

                                    <div class="row mb-3">
                                        <div class="col-sm-3">
                                            <h6 class="mb-0">Report File</h6>
                                        </div>
                                        <div class="col-sm-9 text-secondary">
                                            <input type="file" name="report_file" class="form-control @error('report_file') is-invalid @enderror"
                                                id="report_file" /> @error('report_file')
                                                <span class="text-danger">{{ $message }}</span>
                                              @enderror
                                        </div>
                                    </div>

                                         
 
                        <div class="col-md-12">
                            <div class="d-md-flex d-grid align-items-center gap-3">
                                <button type="submit" class="btn btn-primary px-4">Submit</button>
                            </div>

                        </div>

                                </div>



                        </div>



                    </div>
                </div>
            </div>




          
        </form>

        </div>

    </div>
 
@endsection
