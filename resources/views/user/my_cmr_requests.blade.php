@extends('admin.admin_dashboard')
@section('admin')

<div class="page-content">
    <!--breadcrumb-->
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
        <div class="ps-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">All Requests</li>
                </ol>
            </nav>
        </div>
        <div class="ms-auto">
            <div class="btn-group">
           {{-- <a href="{{ route('add.category') }}" class="btn btn-primary px-5">Add Category </a>   --}}
            </div>
        </div>
    </div>
    <!--end breadcrumb-->

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table id="example" class="table table-striped table-bordered" style="width:100%">
                    <thead>
                        <tr>
                            <th>Sl</th>
                            <th>CMR </th>
                            <th>User </th>
                            <th>Level </th>
                            <th>Status </th>
                            <th>Comment</th>
                            <th>Details</th>
                        </tr>
                    </thead>
                    <tbody>

                        @foreach ($MyRequests as $key=> $item)
                        <tr>
                            <td>{{ $key+1 }}</td>
                            <td>{{ $item->cmr->title }}</td>
                            <td>{{ $item->user->name }}</td>
                            <td>{{ $item->level }}</td>

                            <td>        @if ($item->status === 'in_progress' ||$item->status === 'pending' )
                                    <span class="badge bg-warning text-dark">{{ $item->status }}</span>
                                @elseif($item->status === 'rejected')
                                    <span class="badge bg-danger">{{ $item->status }}</span>
                                @else
                                    <span class="badge bg-success">{{ $item->status }}</span>

                                @endif</td>
                            <td>{{ $item->comment }}</td>

                            <td>

       <a href="{{ route('request.details',$item->id) }}" class="btn btn-primary px-5" id="details">Click For Details </a>

                            </td>
                        </tr>
                        @endforeach

                    </tbody>

                </table>
            </div>
        </div>
    </div>




</div>




@endsection
