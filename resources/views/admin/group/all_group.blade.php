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
                    <li class="breadcrumb-item active" aria-current="page">All Groups</li>
                </ol>
            </nav>
        </div>
        <div class="ms-auto">
            <div class="btn-group">
                @can('group.add')
                <a href="{{ route('group.create') }}" class="btn btn-primary px-5">Add Group </a>
                @endcan
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
                            <th>Name</th>
                            <th>Action</th>

                        </tr>
                    </thead>
                    <tbody>

                        @foreach ($groups as $key=> $item)
                        <tr>
                            <td>{{ $key+1 }}</td>
                             <td>{{ $item->name }}</td>
                             <td>
                                @can('category.edit')
                                <a href="{{ route('edit.group',$item->id) }}" class="btn btn-info px-5">Edit </a>
                               @endcan
                                 @can('group.delete')
                                  <a href="{{ route('delete.group',$item->id) }}" class="btn btn-danger px-5" id="delete">Delete </a>
                                 @endcan
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


@endsection
