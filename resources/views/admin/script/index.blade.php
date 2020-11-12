@extends('layouts.admin')

@section('title')
    <title>Setting Script</title>
@endsection

@section('content')
<main class="main">
    <div class="container-fluid" style="padding: 0px 0px 0px 0px;">
        <div class="animated fadeIn">
            <div class="col-md-12">
                <div class="card shadow mb-4">
                    <div class="card-header bg-info">
                        <span class="text-xl font-weight-bold text-white text-uppercase mb-1">Setting Script</span>
                    </div>
                    <div class="card-body">
                        <div class="col-md-12">
                            <form id="scriptForm" class="form-horizontal">
                                <div class="form-group row">
                                    <div class="col-sm-12">
                                        <input type="hidden" name="id_script" value="{{ isset($id) ? $id : '' }}">
                                        <textarea id="scriptjs" name="script" class="form-control form-control-sm" column="50" rows="10">{!! isset($scriptjs) ? $scriptjs : '' !!}</textarea>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-12 text-center">
                                        <button type="submit" class="btn btn-primary btn-xs" id="save-button">Simpan</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection
@section('js')
<script>
    $(document).ready(function() {
        var script = document.getElementById("scriptjs");
        
        CKEDITOR.replace(script);

        $('body').on('submit', '#scriptForm', function() {
            event.preventDefault();
            var formData = new FormData(this);

            $.ajax({
                url: "{{ route('script.store') }}",
                method: "POST",
                contentType: false,
                processData: false,
                data: formData,
                success: function(res) {
                    if (res.code == 200) {
                        $.notify(res.message, "success");
                    }
                }
            });
        })
    })
</script>
@endsection