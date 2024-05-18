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
                    <li class="breadcrumb-item active" aria-current="page">CMR</li>
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
                            <th>Title </th> 
                            <th>Status </th>  
                            <th>Owner </th>  
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                       
                        @foreach ($cmrs as $key=> $item) 
                        <tr>
                            <td>{{ $key+1 }}</td>
                            {{-- <td> <img src="{{ asset($item->image) }}" alt="" style="width: 70px; height:40px;"> </td> --}}
                            <td>{{ $item->title }}</td> 
                            <td>{{ $item->status }}</td> 
                            <td>{{ $item->owner->name }}</td> 
                            <td>
     
       <a href="{{ route('cmr.details',$item->id) }}" class="btn btn-primary px-5" id="details">Details </a> 
                   
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