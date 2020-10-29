@extends('layouts.admin')

@section('title')
    <title>Notification</title>
@endsection

@section('content')
<main class="main">
    <div class="container-fluid" style="padding: 0px 0px 0px 0px;">
        <div class="animated fadeIn">
            <div class="col-md-12">
                <div class="card shadow mb-4">
                    <div class="card-header bg-info">
                        <span class="text-xl font-weight-bold text-white text-uppercase mb-1">Notification</span>
                    </div>
                    <div class="card-body" style="overflow-y: scroll; height: 400px; max-height: 400px;" id="notification">
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection

@section('js')
<script type="text/javascript">
    $(document).ready(function() {
        $.ajax({
            url: "{{ route('ajax.allNotification') }}",
            method: "GET",
            datatype: "JSON",
            success: function(res) {
                $('#notification').html(res.notification);
            }
        })
    });
</script>
@endsection