@extends('admin.admin_dashboard')
@section('admin')
    <div class="page-content">
        <!-- Breadcrumb -->
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
            <div class="breadcrumb-title pe-3">CMR Details</div>
            <div class="ps-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0">
                        <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a></li>
                        <li class="breadcrumb-item active" aria-current="page">Details</li>
                    </ol>
                </nav>
            </div>
        </div>
        <!-- End Breadcrumb -->

        <div class="  container-fluid">
            <div class="main-body">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="row mb-3">
                                    <div class="col-sm-3">
                                        <h6 class="mb-0 text-primary">Title</h6>
                                    </div>
                                    <div class="col-sm-9 text-secondary">
                                        <label name="title" class="text-info">{{ $cmr->title }}</label>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-sm-3">
                                        <h6 class="mb-0 text-primary">Status</h6>
                                    </div>
                                    <div class="col-sm-9 text-secondary">
                                        @if ($cmr->status === 'complete' )
                                            <label class="text-success">{{ $cmr->status }}</label>
                                        @else
                                            <label class="text-warning">{{ $cmr->status }}</label>

                                        @endif

                                    </div>
                                </div>
                                @php
                                    $file_track = App\Models\FileTrack::where('cmr_id', $cmr->id)
                                        ->where('version_number', '0')
                                        ->where('status', '1')
                                        ->first();
                                @endphp
                                <div class="row mb-3">
                                    <div class="col-sm-3">
                                        <h6 class="mb-0 text-primary">Version 0</h6>
                                    </div>
                                    <div class="col-sm-9 text-secondary">
                                        @can('cmr.download')
                                        <a href="{{ route('cmr.download', $file_track->filename) }}" class="btn btn-primary px-5">{{ $file_track->filename }}</a>
                                        @endcan
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-sm-3">
                                        <h6 class="mb-0 text-primary">Progress</h6>
                                    </div>
                                    <div class="col-sm-9">
                                        @php
                                            $countAllRequest = $cmr->requests->count();
                                            $approvedRequest = $cmr->requests()->where('status', 'approved')->count();
                                        @endphp
                                        @if ($countAllRequest === $approvedRequest)
                                            <p class="text-success">Completed All Levels</p>
                                        @else
                                            <p class="text-warning">Waiting for level {{ $cmr->current_level }} to progress</p>
                                        @endif
                                    </div>
                                </div>

                                <label for="" class="text-primary">Users Requests</label>
                                <br>
                                <div class="card">
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table id="example" class="table table-striped table-bordered" style="width:100%">
                                                <thead>
                                                <tr>
                                                    <th>Sl</th>
                                                    <th>Username</th>
                                                    <th>Level</th>
                                                    <th>Filename</th>
                                                    <th>Status</th>
                                                    <th>Action</th>
                                                    <th>Comment</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                @foreach ($cmr->requests as $key => $item)
                                                    <tr>
                                                        <td>{{ $key + 1 }}</td>
                                                        <td>{{ $item->user->name }}</td>
                                                        <td>{{ $item->level }}</td>
                                                        <td>
                                                            @if ($item->fileTrack)
                                                                <a href="{{ route('cmr.download', $item->fileTrack->filename) }}" class="btn btn-primary px-5">{{ $item->fileTrack->filename }}</a>
                                                            @endif
                                                        </td>
                                                        <td>
                                                            @if ($item->status === 'in_progress' ||$item->status === 'pending' )
                                                                <span class="badge bg-warning text-dark">{{ $item->status }}</span>
                                                            @elseif($item->status === 'rejected')
                                                                <span class="badge bg-danger">{{ $item->status }}</span>
                                                            @else
                                                                <span class="badge bg-success">{{ $item->status }}</span>

                                                            @endif
                                                        </td>
                                                        <td>

                                                            @if ($cmr->owner_id == auth()->user()->id || auth()->user()->hasRole('super'))
                                                                @if ($item->status === 'in_progress')
                                                                    <a href="{{ route('request.accept', $item->id) }}" class="btn btn-primary px-5">Accept</a>
                                                                    <a data-toggle="modal" data-target="#reportModal" href="{{ route('request.decline', $item->id) }}" class="btn btn-danger px-5">Decline</a>
                                                                    <div class="modal fade modal-container" id="reportModal" tabindex="-1" role="dialog" aria-labelledby="reportModalTitle" aria-hidden="true">
                                                                        <div class="modal-dialog modal-dialog-centered" role="document">
                                                                            <div class="modal-content">
                                                                                <div class="modal-body">
                                                                                    <form method="post" action="{{ route('request.decline', $item->id) }}">
                                                                                        @csrf
                                                                                        <div class="input-box">
                                                                                            <label class="label-text">Write Message</label>
                                                                                            <div class="form-group">
                                                                                                <textarea class="form-control form--control pl-3" name="comment" placeholder="Please Add Comment To the User..." rows="5"></textarea>
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="btn-box text-right pt-2">
                                                                                            <button type="button" class="btn font-weight-medium mr-3" data-dismiss="modal">Cancel</button>
                                                                                            <button type="submit" class="btn theme-btn theme-btn-sm lh-30">Submit</button>
                                                                                        </div>
                                                                                    </form>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                @endif
                                                            @endif
                                                        </td>
                                                        <td>{{ $item->comment }}</td>
                                                    </tr>
                                                @endforeach
                                                </tbody>
                                            </table>


                                            @if ($cmr->owner_id == auth()->user()->id || auth()->user()->hasRole('super'))
                                                @if ($cmr->status == 'complete')
                                                    <!-- CMR is complete -->
                                                @else
                                                    @if ($countAllRequest === $approvedRequest)
                                                        <a href="{{ route('cmr.make.complete', $cmr->id) }}" class="btn btn-success px-5">Make it As Complete</a>
                                                    @else
                                                        <a href="#" class="btn btn-danger px-5 disabled">Waiting for level {{ $cmr->current_level }} to complete</a>
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
