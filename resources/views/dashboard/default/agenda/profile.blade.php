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
                        {{ trans('common.profile') }}
                    </h2>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <div class="col-lg-4">
                        <div class="profile_pic">
                            <img src="{{Theme::url('images/user.png')}}" class="img-circle profile_img" id="image_upload">
                            <input type="file" id="avatar_upload" style="display: none;" />
                        </div>
                    </div>
                    <div class="col-lg-8">
                        {!! Form::open(array('url' => Request::url(), 'class' => 'form-horizontal', 'method' => 'post')) !!}
                        <div class="form-body">
                            <div class="form-group">
                                <label for="inputName" class="col-md-2 control-label col-xs-2">
                                    {{ trans('common.address') }}
                                </label>
                                <div class="col-md-10 col-xs-10">
                                    <textarea class="form-control" name="alamat"></textarea>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputName" class="col-md-2 control-label col-xs-2">
                                    {{ trans('common.new_password') }}
                                </label>
                                <div class="col-md-10 col-xs-10">
                                    <input id="inputName" class="form-control" data-validate-length-range="4,20" required="required" type="password" name="password">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputName" class="col-md-2 control-label col-xs-2">
                                    {{ trans('common.repeat_new_password') }}
                                </label>
                                <div class="col-md-10 col-xs-10">
                                    <input id="inputName" class="form-control" data-validate-length-range="4,20" required="required" type="password" name="password_confirmation">
                                </div>
                            </div>
                        </div>
                        <div class="form-actions pal">
                            <div class="form-group mbn">
                                <div class="col-md-offset-4 col-md-8 col-xs-offset-4 col-xs-8">
                                    <button type="submit" class="btn btn-primary">
                                        Submit</button>
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
    {!! Theme::js('js/validator/validator.js')!!}
    <script>
        // initialize the validator function
        validator.message['date'] = 'not a real date';

        // validate a field on "blur" event, a 'select' on 'change' event & a '.reuired' classed multifield on 'keyup':
        $('form')
                .on('blur', 'input[required], input.optional, select.required', validator.checkField)
                .on('change', 'select.required', validator.checkField)
                .on('keypress', 'input[required][pattern]', validator.keypress);

        $('.multi.required')
                .on('keyup blur', 'input', function () {
                    validator.checkField.apply($(this).siblings().last()[0]);
                });

        // bind the validation to the form submit event
        //$('#send').click('submit');//.prop('disabled', true);

        $('form').submit(function (e) {
            e.preventDefault();
            var submit = true;
            // evaluate the form using generic validaing
            if (!validator.checkAll($(this))) {
                submit = false;
            }

            if (submit)
                this.submit();
            return false;
        });

        /* FOR DEMO ONLY */
        $('#vfields').change(function () {
            $('form').toggleClass('mode2');
        }).prop('checked', false);

        $('#alerts').change(function () {
            validator.defaults.alerts = (this.checked) ? false : true;
            if (this.checked)
                $('form .alert').remove();
        }).prop('checked', false);
    </script>

@stop