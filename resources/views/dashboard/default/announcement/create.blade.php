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
                        @if (Route::getCurrentRoute()->getName() == 'dashboard.announcement.edit')
                            {!! Form::model($data, array('url' => action('AnnouncementController@update', Request::segment(3)), 'class' => 'form-horizontal', 'method' => 'put', 'id' => 'add_announcement')) !!}
                        @else
                            {!! Form::open(array('url' => action('AnnouncementController@store'), 'class' => 'form-horizontal', 'method' => 'post', 'id' => 'add_announcement')) !!}
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
                                    {{ trans('common.announcement') }}
                                </label>
                                <div class="col-md-10 col-xs-10">
                                    {!! Form::textarea('content', null, array('id' => 'inputName', 'class' => 'form-control editor')); !!}
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
    {!! Theme::css('css/summernote.css')!!}
        <!-- richtext editor -->
    {!! Theme::js('js/summernote.min.js')!!}

    <script type="text/javascript">
        $(document).ready(function(){
            $('.editor').summernote({
                height: 200,
                tabsize: 2,
                styleWithSpan: false,
                toolbar: [
                    ['style', ['bold', 'italic', 'underline']],
                    ['font', ['strikethrough', 'superscript', 'subscript']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['mics',['codeview']]
                ],
                onpaste: function(e) {
                    var thisNote = $(this);
                    var updatePastedText = function(someNote){
                        var original = someNote.code();
                        var cleaned = CleanPastedHTML(original); //this is where to call whatever clean function you want. I have mine in a different file, called CleanPastedHTML.
                        someNote.code('').html(cleaned); //this sets the displayed content editor to the cleaned pasted code.
                    };
                    setTimeout(function () {
                        //this kinda sucks, but if you don't do a setTimeout,
                        //the function is called before the text is really pasted.
                        updatePastedText(thisNote);
                    }, 10);


                }
            });
        });

        function CleanPastedHTML(input) {
            // 1. remove line breaks / Mso classes
            var stringStripper = /(\n|\r| class=(")?Mso[a-zA-Z]+(")?)/g;
            var output = input.replace(stringStripper, ' ');
            // 2. strip Word generated HTML comments
            var commentSripper = new RegExp('<!--(.*?)-->','g');
            var output = output.replace(commentSripper, '');
            var tagStripper = new RegExp('<(/)*(meta|link|span|\\?xml:|st1:|o:|font)(.*?)>','gi');
            // 3. remove tags leave content if any
            output = output.replace(tagStripper, '');
            // 4. Remove everything in between and including tags '<style(.)style(.)>'
            var badTags = ['style', 'script','applet','embed','noframes','noscript'];

            for (var i=0; i< badTags.length; i++) {
                tagStripper = new RegExp('<'+badTags[i]+'.*?'+badTags[i]+'(.*?)>', 'gi');
                output = output.replace(tagStripper, '');
            }
            // 5. remove attributes ' style="..."'
            var badAttributes = ['style', 'start'];
            for (var i=0; i< badAttributes.length; i++) {
                var attributeStripper = new RegExp(' ' + badAttributes[i] + '="(.*?)"','gi');
                output = output.replace(attributeStripper, '');
            }
            return output;
        }
    </script>
@stop
