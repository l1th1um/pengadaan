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
                        <span class="section">Grade</span>
                        <div class="form-group col-md-12">
                            <div class="col-md-1">
                                <strong>Grade</strong>
                            </div>
                            <div class="col-md-2">
                                <strong>Tunjangan</strong>
                            </div>
                        </div>
                        @for ($i = 1; $i <= count($settings); $i++)
                            <div class="form-group col-md-12">
                                <div class="col-md-1">
                                    {{ $i }}
                                </div>
                                <div class="col-md-2">
                                    <input type="text" value="{{ $settings[$i] }}" class="right" name="grade[{{$i}}]">
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
    {!! Theme::js('js/autoNumeric.js')!!}
    <script type="text/javascript">
        $(document).ready(function () {
            $("input[type=text]").autoNumeric('init',{mDec: '0'});
        });
    </script>
@stop