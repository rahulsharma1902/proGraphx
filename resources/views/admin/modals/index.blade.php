@extends('admin_layout/master')
@section('content')
<div class="nk-block nk-block-lg" id="maindiv">
    <div class="nk-block-head d-flex justify-content-between">
        <div class="nk-block-head-content">
            <h4 class="nk-block-title">Models Table</h4>
            <div class="nk-block-des">
                <p><code class="code-class"></code> </p>
            </div>
        </div>
    </div>
    <div class="card card-bordered card-preview">
        <div class="card-inner">
            <button class="btn btn-danger my-1 delbtn d-none"><i class="bi bi-trash"></i></button>
            <table class="datatable-init nowrap nk-tb-list nk-tb-ulist" data-auto-responsive="false" id="table">
                <thead>
                  
                    <tr class="nk-tb-item nk-tb-head">
                        <th class="nk-tb-col nk-tb-col-check">
                            <div class="custom-control custom-control-sm custom-checkbox notext " id="maincheck">
                                <input type="checkbox" class="custom-control-input checkall" id="page-0">
                                <label class="custom-control-label" for="page-0"></label>
                            </div>
                        </th>
                        <th class="nk-tb-col"><span class="sub-text">Model Name</span></th>
                        <!-- <th class="nk-tb-col tb-col-mb"><span class="sub-text">Slug</span></th> -->
                        <th class="nk-tb-col tb-col-mb"><span class="sub-text">Status</span></th>
                        <th class="nk-tb-col nk-tb-col-tools text-end">
                            Action
                        </th>
                    </tr>
                </thead>
                <tbody>
                @foreach ($modals as $modal )
                    
                    <tr class="nk-tb-item tr">
                  
                        <td class="nk-tb-col nk-tb-col-check">
                            <div class="custom-control custom-control-sm custom-checkbox notext">
                                <input type="checkbox" class="custom-control-input checkbox" id="" data-id="">
                                <label class="custom-control-label" for=""></label>
                            </div>
                        </td> 
                  
                        
                        <td class="nk-tb-col">
                            <div class="user-card">
                                <div class="user-info">
                                  {{ $modal->name ?? '' }}
                                </div>
                            </div>
                        </td>

                        <!-- <td class="nk-tb-col tb-col-mb">
                            <span class="tb-amount">
                                {{ $modal->slug ?? '' }}
                            </span>
                        </td> -->

                        <td class="nk-tb-col tb-col-mb">
                        <span class="tb-odr-status">
                            <span class="badge badge-dot bg-{{ $modal->status == 0 ? 'warning' : 'success' }}">{{ $modal->status == 0 ? 'Pending' : 'Complete' }}</span>
                        </span>

                        </td>
                        <td class="nk-tb-col nk-tb-col-tools">
                            <ul class="nk-tb-actions gx-1">
                                <li class="d-flex">
      
                                    <div class="drodown">
                                        <a href="#" class="dropdown-toggle btn btn-icon btn-trigger" data-bs-toggle="dropdown"><em class="icon ni ni-more-h"></em></a>
                                        <div class="dropdown-menu dropdown-menu-end">
                                        
                                            <ul class="link-list-opt no-bdr">
                                                @if($modal->status == 0)
                                                 <li><a href="{{ url('admin-dashboard/add-model/'.$modal->slug) ?? '' }}"><em class="icon ni ni-pen"></em><span>Complete</span></a></li>
                                                 @else
                                                 <li><a class="updateModelData" data-url="{{ url('admin-dashboard/update-model/'.$modal->slug) ?? '' }}"><em class="icon ni ni-pen"></em><span>Update</span></a></li>

                                                @endif
                                                <li>
                                                    <a data-url="{{ url('graphicRemove/'.$modal->slug) ?? '' }}" href="{{ url('graphicRemove/'.$modal->slug) ?? '' }}" class="removeConfermation" data-id="" >
                                                        <em class="icon ni ni-trash"></em>
                                                        <span>Remove</span>
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="{{ url('admin-dashboard/modelView/'.$modal->slug) ?? '' }}" class="" data-id="" >
                                                        <i class="icon fas fa-eye"></i>
                                                        <span>View</span>
                                                    </a>
                                                </li>

                                            </ul>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div><!-- .card-preview -->
</div> <!-- nk-block -->
<script>

    $('body').delegate('.updateModelData','click', function(e){
        event.preventDefault();
        url = $(this).attr('data-url');
        Swal.fire({
            title: "Are you sure?",
            text: "If you want to update this you previous Body parts and Accent will be removed.",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes, delete it!"
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = url;
            }
        });
    });
   
</script>

@endsection