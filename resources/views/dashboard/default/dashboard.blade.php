@extends('../index')

@section('content')
    @if (Session::has('message'))
        <div class="row">
            <div class="alert alert-success" role="alert">
                <p>{{ Session::get('message') }}</p>
            </div>
        </div>
    @endif
    <div class="row">
        <div class="col-md-6">
            <div class="x_panel tile fixed_height_320">
                <div class="x_title">
                    <h2>Pengumuman</h2>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    Belum Ada Pengumuman
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="x_panel tile fixed_height_320">
                <div class="x_title">
                    <h2>Agenda</h2>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    Belum Ada Agenda
                </div>
            </div>
        </div>
    </div>
@stop

