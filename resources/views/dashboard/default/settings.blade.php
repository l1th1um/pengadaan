@extends('../index')

@section('content')
    @if (Session::has('message'))
        <div class="row" xmlns="http://www.w3.org/1999/html">
            <div class="alert alert-success" role="alert">
                <p>{{ Session::get('message') }}</p>
            </div>
        </div>
    @endif
    <div class="row">
        <div class="col-md-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>
                        {{ trans('common.settings') }}
                    </h2>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    {!! Form::open(array('url' => Request::url(), 'class' => 'form-horizontal', 'method' => 'post')) !!}
                    <div class="form-body">
                        <span class="section">Jam Kerja</span>
                        <div class="form-group col-md-12">
                            <div class="col-md-offset-1 col-md-11">
                                <div class="col-md-2">
                                    <strong>Jam Datang</strong>
                                </div>
                                <div class="col-md-2">
                                    <strong>Jam Pulang</strong>
                                </div>
                                <div class="col-md-2">
                                    <strong>Istirahat</strong>
                                </div>
                                <div class="col-md-2">
                                    <strong>Jam Kerja</strong>
                                </div>
                                <div class="col-md-2">
                                    <strong>Minimum Datang</strong>
                                </div>
                                <div class="col-md-2">
                                    <strong>Maksimum Pulang</strong>
                                </div>
                            </div>
                        </div>
                        @for ($i = 1; $i < 6; $i++)
                        <div class="form-group col-md-12">
                            <div class="col-md-1">
                                <div class="col-md-1">
                                    <strong>{{trans('common.day_array')[$i]}}</strong>
                                </div>
                            </div>
                            <div class="col-md-11">
                                <div class="col-md-2">
                                    <input class="col-md-6" type="text" name="jam_datang_{{$i}}" data-inputmask="'mask': '99:99'" value="{{ $settings['jam_datang_'.$i] }}">
                                </div>
                                <div class="col-md-2">
                                    <input class="col-md-6" type="text" name="jam_pulang_{{$i}}" data-inputmask="'mask': '99:99'" value="{{ $settings['jam_pulang_'.$i] }}">
                                </div>
                                <div class="col-md-2">
                                    <input class="col-md-6" type="text" name="istirahat_{{$i}}" data-inputmask="'mask': '99:99'" value="{{ $settings['istirahat_'.$i] }}">
                                </div>
                                <div class="col-md-2">
                                    <input class="col-md-6" type="text" name="jam_kerja_{{$i}}" data-inputmask="'mask': '99:99'" value="{{ $settings['jam_kerja_'.$i] }}">
                                </div>
                                <div class="col-md-2">
                                    <input class="col-md-6" type="text" name="min_datang_{{$i}}" data-inputmask="'mask': '99:99'" value="{{ $settings['min_datang_'.$i] }}">
                                </div>
                                <div class="col-md-2">
                                    <input class="col-md-6" type="text" name="max_pulang_{{$i}}" data-inputmask="'mask': '99:99'" value="{{ $settings['max_pulang_'.$i] }}">
                                </div>
                            </div>
                        </div>
                        @endfor
                        <div class="form-group col-md-12">
                            <div class="col-md-offset-1 col-md-1">
                                <button type="submit" class="btn btn-primary" style="margin-left: 10px">
                                    Submit</button>
                            </div>
                        </div>
                    </div>
                    {!! Form::close() !!}
                    </div>
                </div>
            </div>
@stop

@section('footer_js')
    {!! Theme::js('js/input_mask/jquery.inputmask.js')!!}
    <script type="text/javascript">
        $(document).ready(function () {
            $(":input").inputmask();
        });
    </script>
@stop