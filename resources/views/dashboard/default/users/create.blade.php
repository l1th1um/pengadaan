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
                        {{ trans('common.add_user') }}
                    </h2>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <div class="col-lg-12">
                        @if (Route::getCurrentRoute()->getName() == 'dashboard.users.edit')
                            {!! Form::model($user, array('url' => action('UserController@update', Request::segment(3)), 'class' => 'form-horizontal', 'method' => 'put', 'id' => 'add_procurement', 'files' => true)) !!}
                        @else
                            {!! Form::open(array('url' => action('UserController@store'), 'class' => 'form-horizontal', 'method' => 'post', 'id' => 'add_procurement', 'files' => true)) !!}
                        @endif
                        <div class="form-body">
                            <div class="form-group">
                                <label for="inputName" class="col-md-2 control-label col-xs-2">
                                    {{ trans('common.name') }}
                                </label>
                                <div class="col-md-10 col-xs-10">
                                    {!! Form::text('name',null, array('id' => 'inputName', 'class' => 'form-control', 'required' => true)); !!}
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputName" class="col-md-2 control-label col-xs-2">
                                    {{ trans('common.username') }}
                                </label>
                                <div class="col-md-10 col-xs-10">
                                    {!! Form::text('username', null, array('id' => 'inputName', 'class' => 'form-control', 'required' => true)); !!}
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputName" class="col-md-2 control-label col-xs-2">
                                    {{ trans('common.email') }}
                                </label>
                                <div class="col-md-10 col-xs-10">
                                    {!! Form::text('email', null, array('id' => 'inputName', 'class' => 'form-control', 'required' => true)); !!}
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputName" class="col-md-2 control-label col-xs-2">
                                    {{ trans('common.password') }}
                                </label>
                                <div class="col-md-10 col-xs-10">
                                    {!! Form::password('password',array('id' => 'inputName', 'class' => 'form-control')); !!}
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputName" class="col-md-2 control-label col-xs-2">
                                    {{ trans('common.repeat_password') }}
                                </label>
                                <div class="col-md-10 col-xs-10">
                                    {!! Form::password('password_confirmation', array('id' => 'inputName', 'class' => 'form-control')); !!}
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputName" class="col-md-2 control-label col-xs-2">
                                    {{ trans('common.role') }}
                                </label>
                                <div class="col-md-10 col-xs-10">
                                    {!! Form::select('role', array_reverse($role, true), $selected_role, array('id' => 'inputName', 'class' => 'form-control')); !!}

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

    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Tambah Item</h4>
                </div>
                <div class="modal-body">
                    {!! Form::open(array('url' => Request::url(), 'class' => 'form-horizontal', 'method' => 'post', 'id' => 'addItemModal')) !!}
                    <div class="form-body">
                        <div class="form-group">
                            <label for="inputName" class="col-md-4 control-label col-xs-4">
                                {{ trans('common.item_name') }}
                            </label>
                            <div class="col-md-8 col-xs-8">
                                <input id="inputName" class="form-control" type="text" name="item_name">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputName" class="col-md-4 control-label col-xs-4">
                                {{ trans('common.amount') }}
                            </label>
                            <div class="col-md-8 col-xs-8">
                                <input id="inputName" class="form-control numeric" type="text" name="amount">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputName" class="col-md-4 control-label col-xs-4">
                                {{ trans('common.unit') }}
                            </label>
                            <div class="col-md-8 col-xs-8">
                                <input id="inputName" class="form-control" type="text" name="unit">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputName" class="col-md-4 control-label col-xs-4">
                                {{ trans('common.unit_price') }}
                            </label>
                            <div class="col-md-8 col-xs-8">
                                <input id="inputName" class="form-control numeric" type="text" name="unit_price">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </div>
        </div>
    </div>
@stop