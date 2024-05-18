@extends('admin.admin_dashboard')
@section('admin')
    {{-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script> --}}

<!-- template js files -->




    <div class="page-content">
        <!--breadcrumb-->
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
            <div class="breadcrumb-title pe-3">CMR Details</div>
            <div class="ps-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0">
                        <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">Details</li>
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



                            <div class="card-body">
                                <div class="row mb-3">
                                    <div class="col-sm-3">
                                        <h6 class="mb-0">Title</h6>
                                    </div>
                                    <div class="col-sm-9 text-secondary">
                                        <label name="title"> {{ $cmr->title }}</label>

                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-sm-3">
                                        <h6 class="mb-0">Status</h6>
                                    </div>
                                    <div class="col-sm-9 text-secondary">
                                        <label> {{ $cmr->status }}</label>

                                    </div>

                                    @php
                                        $file_track = App\Models\FileTrack::where('cmr_id', $cmr->id)
                                            ->where('version_number', '0')
                                            ->where('status','1') 
                                            ->first();

                                         
                                    @endphp


                                    <div class="row mb-3">
                                        <div class="col-sm-3">
                                            <h6 class="mb-0">Version 0</h6>
                                        </div>
                                        <div class="col-sm-9 text-secondary">
                                            <a href="{{ route('cmr.download', $file_track->filename) }}"
                                                class="btn btn-primary px-5" id="details">{{ $file_track->filename }} </a>

                                        </div>

                                        <div class="row mb-3">
                                            <div class="col-sm-3">
                                                <h6 class="mb-0">Progress </h6>
                                            </div>
                                            <div class="col-sm-9  ">

                                                @php
                                                $countAllRequest =  $cmr->requests->count();
                                                  $approvedRequest = $cmr->requests()->where('status','approved')->get()->count();
                 
                                                @endphp   
                                                 
                                                 @if ($countAllRequest === $approvedRequest )

                                                 <p class="col-sm-9 text-success ">Completed All Level</p>
                                                @else   

                                                <p>waitting level {{ $cmr->current_level }} to progress</p>
                                                @endif 

                                                
                                            </div>




                                            {{-- @foreach ($file_track_list as $file)
                    
                <div class="col-sm-3">
                    <h6 class="mb-0">CMR Report version {{$file->version_number}} </h6>
                </div>
                             <div class="col-sm-9 text-secondary">
                <a href="{{ route('cmr.download',$file->filename) }}" 
                class="btn btn-primary px-5" id="details">Download CMR </a> 
                                 
                            </div> 

                @endforeach --}}



                                            {{-- @foreach ($cmr->requests as $key => $req)
                    
                <div class="col-sm-3">
                    <h6 class="mb-0">User Level # : {{$req->level}}</h6>
                </div>
                 <div class="col-sm-9 text-secondary">

                    <label> {{ $req->user->name}}</label> 
                      
                </div> 

            
                @endforeach --}}




                                            <label for="">Users Requests</label>
                                            <br>
                                            <div class="card">
                                                <div class="card-body">
                                                    <div class="table-responsive">
                                                        <table id="example" class="table table-striped table-bordered"
                                                            style="width:100%">
                                                            <thead>
                                                                <tr>
                                                                    <th>Sl</th>
                                                                    <th>UserName </th>
                                                                    <th>Level </th>
                                                                    <th>FileName </th>
                                                                    <th>Status </th>
                                                                    <th>Action </th>
                                                                    <th>Comment </th>

                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @php
                                                                    $progress = '';

                                                                @endphp

                                                                @foreach ($cmr->requests as $key => $item)
                                                                    <tr>
                                                                        <td>{{ $key + 1 }}</td>
                                                                        <td>{{ $item->user->name }}</td>
                                                                        <td>{{ @$item->level }}</td>

                                                                        <td>

                                                                            @if ($item->fileTrack)
                                                                                <a href="{{ route('cmr.download', @$item->fileTrack->filename) }}"
                                                                                    class="btn btn-primary px-5"
                                                                                    id="details">{{ @$item->fileTrack->filename }}
                                                                                </a>
                                                                            @endif

                                                                        </td>
                                                                        <td>{{ $item->status }}</td>
       @if($item->owner_id == auth()->user()->id || auth()->user()->hasRole('super')  )

                                                                        <td>
                                                                            @if ($item->status === 'in_progress')
                                                                                <a href="{{ route('request.accept', $item->id) }}"
                                                                                    class="btn btn-primary px-5"
                                                                                    id="">Accept</a>
                                                                                {{-- <a href="{{ route('request.decline', $item->id) }}"
                                                                                    class="btn btn-danger px-5"
                                                                                    id="">Decline</a>
 --}}
 
                                                                                    <a data-toggle="modal" data-target="#reportModal" href="{{ route('request.decline', $item->id) }}"
                                                                                        class="btn btn-danger px-5"
                                                                                        id="">Decline</a>

                                                                                                    <!-- Modal -->
<div class="modal fade modal-container" id="reportModal" tabindex="-1" role="dialog" aria-labelledby="reportModalTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            
            <div class="modal-body">
                <form method="post"  action="{{  route('request.decline', $item->id)}}">
                    @csrf
                
                    <div class="input-box">
                        <label class="label-text">Write Message</label>
                        <div class="form-group">
                            <textarea class="form-control form--control pl-3" name="comment" placeholder="Please Add Comment To the User..." rows="5"></textarea>
                        </div>
                    </div>
                    <div class="btn-box text-right pt-2">
                        <button type="button" class="btn font-weight-medium mr-3" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn theme-btn theme-btn-sm lh-30">Submit <i class="la la-arrow-right icon ml-1"></i></button>
                    </div>
                </form>
            </div><!-- end modal-body -->
        </div><!-- end modal-content -->
    </div><!-- end modal-dialog -->
</div><!-- end modal -->


                                                                            @endif

                                                                        </td>

@endif


                                                                         <td>{{ @$item->comment }}</td>
                                                                        <td>
                                                                          

                                                                        </td>

                                                                    </tr>
                                                                @endforeach

                                                            </tbody>

                                                        </table>

                                                        @php
                                                        $countAllRequest =  $cmr->requests->count();
                                                          $approvedRequest = $cmr->requests()->where('status','approved')->get()->count();
                         
                                                        @endphp   

       @if($cmr->owner_id == auth()->user()->id || auth()->user()->hasRole('super'))

                                                                @if ($cmr->status =='complete')
                                                                                    {{-- //                                         --}}
                                                                @else   
                                                                @if ($countAllRequest === $approvedRequest )
                                                                <a href="{{route('cmr.make.complete', $cmr->id)}}"  class="btn btn-success px-5" id="">
                                                                   Make it As Complete </a>
       
                                                                 @else   
                                                                <a href=""  class="btn btn-danger px-5 disabled" id="">
                                                                   waitting level {{ $cmr->current_level }} to complete </a>
       
                                                                 @endif  

                                                                @endif 
                                                         
        @endif                                             

                                                        
                                                            
                                                    </div>
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
