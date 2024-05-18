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
                    <li class="breadcrumb-item active" aria-current="page">All User</li>
                </ol>
            </nav>
        </div>
        <div class="ms-auto">
            <div class="btn-group">
           
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
                            <th>User Image </th>
                            <th>Name</th> 
                            <th>Email</th> 
                            <th>Phone</th> 
                            <th>Status</th>
                            <th>Active/InActive</th>

                        </tr>
                    </thead>
                    <tbody>
                       
                        @foreach ($users as $key=> $item) 
                        <tr>
                            <td>{{ $key+1 }}</td>
                            <td> <img src="{{ (!empty($item->photo)) ? url('upload/admin_images/'.$item->photo) : url('upload/no_image.jpg')}}" alt="" style="width: 70px; height:40px;"> </td>
                            <td>{{ $item->name }}</td> 
                            <td>{{ $item->email }}</td> 
                            <td>{{ $item->phone }}</td> 
                            <td>
        @if ($item->UserOnline())
        <span class="badge badge-pill bg-success">Active Now</span>
        @else 
        <span class="badge badge-pill bg-danger">{{ Carbon\Carbon::parse($item->last_seen)->diffForHumans() }} </span>  
             
        @endif    
                         
                            </td> 

                            <td>
                        

                         <div class="form-check-danger form-check form-switch">
                            <input class="form-check-input status-toggle large-checkbox" type="checkbox" id="flexSwitchCheckCheckedDanger" data-user-id="{{ $item->id }}" {{ $item->active=='1' ? 'checked' : ''}}  >
                            <label class="form-check-label" for="flexSwitchCheckCheckedDanger"> </label>
                        </div>    

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
 
@section('script')

 
<script>
    $(document).ready(function(){
        // alert('ready');
        $('.status-toggle').on('change', function(){

          
            var userId = $(this).data('user-id');
            var isChecked = $(this).is(':checked');
            console.log('userId: '+ userId + ' isChecked : '+ isChecked)
            // send an ajax request to update status 

            $.ajax({
                url: "{{ route('update.user.stauts') }}",
                method: "POST",
                data: {
                    user_id : userId,
                    is_checked: isChecked ? '1' : '0',
                    _token: "{{ csrf_token() }}"
                },
                success: function(response){
                    toastr.success(response.message);
                    console.log(response.message)
                },
                error: function(){
                    console.log("error update user status")

                }
            });

        });
    });
</script>

@endsection