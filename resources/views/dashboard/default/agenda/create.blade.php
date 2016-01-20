@extends('../index')

@section('content')
    @if (Session::has('message'))
        <div class="row">
            <div class="alert alert-success" role="alert">
                <p>{{ Session::get('message') }}</p>
            </div>
        </div>
    @endif

    @if ($errors->any())
        <div class="row">
            <div class="alert alert-error" role="alert">
                <p>{{$errors->first()}}</p>
            </div>
        </div>
    @endif
    <div class="row">
        <div class="col-md-12 col-lg-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>
                        {{ $title }}
                    </h2>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <div class="col-lg-12">
                        @if (Route::getCurrentRoute()->getName() == 'dashboard.agenda.edit')
                            {!! Form::model($data, array('url' => action('AgendaController@update', Request::segment(3)), 'class' => 'form-horizontal', 'method' => 'put', 'id' => 'add_agenda')) !!}
                        @else
                            {!! Form::open(array('url' => action('AgendaController@store'), 'class' => 'form-horizontal', 'method' => 'post', 'id' => 'add_agenda')) !!}
                        @endif
                        <div class="form-body">
                            <div class="form-group">
                                <label for="inputName" class="col-md-2 control-label col-xs-2">
                                    {{ trans('common.title') }}
                                </label>
                                <div class="col-md-10 col-xs-10">
                                    {!! Form::text('title',null, array('id' => 'inputName', 'class' => 'form-control', 'required' => true)); !!}
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputName" class="col-md-2 control-label col-xs-2">
                                    {{ trans('common.date') }}
                                </label>
                                <div class="col-md-2 col-xs-2">
                                    {!! Form::text('agenda_date',null, array('id' => 'inputName', 'class' => 'form-control', 'required' => true)); !!}
                                </div>
                            </div>
                            <div class="form-actions pal">
                                <div class="form-group mbn">
                                    <div class="col-md-2 col-xs-2 right">
                                        <input type="hidden" name="items">
                                        <button type="submit" class="btn btn-primary">Submit</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

@section('footer_js')
    {!! Theme::css('css/bootstrap-datepicker.min.css')!!}
    {!! Theme::js('js/bootstrap-datepicker.min.js')!!}
    <script type="text/javascript">
        $(document).ready(function(){
            $('input[name="agenda_date"]').datepicker({ format: "dd/mm/yyyy",
                autoclose: true,
                todayHighlight: true
            });
        })
    </script>
@stop
