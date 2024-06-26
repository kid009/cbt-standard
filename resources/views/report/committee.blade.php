@extends('layouts.master')

@section('content')
<!-- breadcrumb -->
<div class="container-fluid">
    <div class="page-header">
        <div class="row">
            <div class="col-sm-12">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">สรุปรายงาน</li>
                    <li class="breadcrumb-item active">
                        @if (session()->has('community_name'))
                        {{session()->get('community_name')}}
                        @endif

                        @if (session()->has('session_community_by_select_option'))
                        {{session()->get('session_community_by_select_option')}}
                        @endif
                    </li>
                </ol>
            </div>
        </div>
    </div>
</div>

<!-- content -->
<div class="container-fluid">
    
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col">
                            <div class="mb-3">
                                <label class="form-label">ชุมชนที่ประเมิน</label>
                                <select  class="form-control" id="evaluate_community" >
                                    <option value="" selected disabled>เลือกชุมชน</option>
                                    @for ($i=0; $i < count($response_community_by_api); $i++)
                                        @foreach ($community as $comm)
                                            @if ($response_community_by_api[$i]['community_id'] == $comm->community_id)
                                            <option value="{{$comm->community_id}}"
                                                @if (session()->has('session_community_id_by_select_option')) 
                                                @if (session()->get('session_community_id_by_select_option') == $comm->community_id)
                                                selected
                                                @endif
                                            @endif    
                                            >
                                                {{$response_community_by_api[$i]['community_name']}}
                                            </option>
                                            @endif
                                        @endforeach
                                    @endfor
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header pb-0">
                    <h5>สรุปรายงานการประเมินตามเกณฑ์มาตรฐาน : @if (session()->has('community_name')) {{session()->get('community_name')}} @endif</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col">
                            <a class="btn btn-light" href="{{route('report.self-assessment')}}">
                                ประเมินตนเอง
                            </a>
                            <a class="btn btn-primary active" href="{{route('report.evaluation-committee')}}">
                                กรรมการประเมิน
                            </a>
                            {{-- <a class="btn btn-light" href="">
                                สรุปผลการประเมิน
                            </a> --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
</div>
@endsection

@push('scripts')
<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $(document).ready(function(){

        $('#evaluate_community').change(function(){           
            $.ajax({
                type: 'post',
                url: "{{ route('evaluate.save-community') }}",
                data: {
                    evaluate_community:  $('#evaluate_community').val()
                },
                success: (response) => {
                    if(response.status == 1){
                        window.location.reload();
                    }
                },
            });
        });

    });
</script>
@endpush