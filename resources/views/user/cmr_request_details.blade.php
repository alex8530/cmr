@extends('admin.admin_dashboard')
@section('admin')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>

    <div class="page-content">
        <!--breadcrumb-->
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
            <div class="breadcrumb-title pe-3">Create CMR</div>
            <div class="ps-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0">
                        <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page"> CMR</li>
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


                            <form method="POST" action="{{ route('cmr.request.update',$CmrRequest->id) }}" enctype="multipart/form-data">
                                @csrf

                                <div class="card-body">
                                    <div class="row mb-3">
                                        <div class="col-sm-3">
                                            <h6 class="mb-0">Owner</h6>
                                        </div>
                                        <div class="col-sm-9 text-secondary">
                                            <input readonly type="text" name="title" class="form-control " value="{{@$CmrRequest->cmr->owner->name}}"
                                            /> 
                                           
                                        </div>
                                    </div><div class="row mb-3">
                                        <div class="col-sm-3">
                                            <h6 class="mb-0">Title</h6>
                                        </div>
                                        <div class="col-sm-9 text-secondary">
                                            <input readonly type="text" name="title" class="form-control " value="{{$CmrRequest->cmr->title}}"
                                            /> 
                                           
                                        </div>
                                    </div>


                                    <div class="row mb-3">
                                        <div class="col-sm-3">
                                            <h6 class="mb-0">Description</h6>
                                        </div>
                                        <div class="col-sm-9 text-secondary">
                                            <input type="text" readonly name="description" value="{{$CmrRequest->cmr->description}}" class="form-control" />
                                           
                                        </div>
                                    </div>
   
                                    <div class="row mb-3">
                                        <div class="col-sm-3">
                                            <h6 class="mb-0">Status</h6>
                                        </div>
                                        <div class="col-sm-9 text-secondary">
                                            <input type="text" readonly name="status" value="{{$CmrRequest->cmr->status}}" class="form-control" />
                                           
                                        </div>
                                    </div>


                                    <div class="row mb-3">
                                        <div class="col-sm-3">
                                            <h6 class="mb-0">Request Date</h6>
                                        </div>
                                        <div class="col-sm-9 text-secondary">
                                            <input readonly type="date" name="request_date" class="form-control  " value="{{$CmrRequest->cmr->request_date}}"
                                                min="{{ Carbon\Carbon::now()->format('Y-m-d') }}" />  
                                        </div>
                                    </div>


                                    @if ( $CmrRequest->status ==='rejected'||  $CmrRequest->status ==='pending' )
                                    <div class="row mb-3">
                                        <div class="col-sm-3">
                                            <h6 class="mb-0">Upload Report File</h6>
                                        </div>
                                        <div class="col-sm-9 text-secondary">
                                            <input type="file" name="report_file" class="form-control @error('report_file') is-invalid @enderror"
                                                id="report_file" /> @error('report_file')
                                                <span class="text-danger">{{ $message }}</span>
                                              @enderror
                                        </div>
                                    </div>

                                    @endif


                                    <div class="row mb-3">
                                        <div class="col-sm-3">
                                            <h6 class="mb-0">Download Last Approved Version Of CMR</h6>
                                        </div>
                                        <div class="col-sm-9 text-secondary">
                                    
                                            @if ($CmrRequest->cmr->fileTrack)
                                            <a href="{{ route('cmr.download', $CmrRequest->cmr->fileTrack->filename) }}"
                                                class="btn btn-primary px-5"
                                                id="details">{{$CmrRequest->cmr->fileTrack->filename}}
                                            </a>
                                        @endif
                                        </div>
                                    </div>

                                </div>



                        </div>



                    </div>
                </div>
            </div>


            @if( $CmrRequest->status ==='rejected'||  $CmrRequest->status ==='pending')
            <div class="col-md-12">
                <div class="d-md-flex d-grid align-items-center gap-3">
                 @if ($CmrRequest->level == $CmrRequest->cmr->current_level??1)
                    <button type="submit" class="btn btn-primary px-4">Submit</button>
                    @else
                    <p class="text-danger">There is another level before you {{$CmrRequest->current_level}} ,please wait your turn</p>
                     @endif
                </div>
            </div>
            @elseif($CmrRequest->status ==='approved')
                 <div class="col-md-12">
                    <div class="d-md-flex d-grid align-items-center gap-3">
                      
                        <button type="submit" disabled class="btn btn-success px-4">Was Approved</button>
                        
                    </div>
                </div>
            @endif
               
          

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
@endsection
