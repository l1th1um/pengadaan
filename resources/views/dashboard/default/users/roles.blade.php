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
	<div class="col-md-8">
		<div class="x_panel">
		    <div class="x_title">
		    	<h2>
		    	    {{ trans('common.roles_management') }}
                </h2>
                <div class="clearfix"></div>
		    </div>
		    <div class="x_content">
		        <table class="table table-hover table-bordered">
		            <thead>
		            <tr>
		                <th>Roles</th>
		                <th>Description</th>
		                <th>Status</th>
		            </tr>
		            </thead>
		            <tbody>
		            <tr>                
		                <td>Henry</td>
		                <td>23</td>
		                <td><span class="label label-sm label-success">Approved</span></td>
		            </tr>
		            <tr>
		                <td>John</td>
		                <td>45</td>
		                <td><span class="label label-sm label-info">Pending</span></td>
		            </tr>
		            <tr>
		                <td>Larry</td>
		                <td>30</td>
		                <td><span class="label label-sm label-warning">Suspended</span></td>
		            </tr>
		            <tr>
		                <td>Lahm</td>
		                <td>15</td>
		                <td><span class="label label-sm label-danger">Blocked</span></td>
		            </tr>
		            </tbody>
		        </table>
		    </div>
		</div>
	</div>
	<div class="col-md-4">
		<div class="x_panel">
		    <div class="x_title">
                <h2>
		    	    {{ trans('common.add_roles') }}
		    	</h2>
                <div class="clearfix"></div>
		    </div>
		    <div class="x_content">
		    	{!! Form::open(array('action' => 'RoleController@store', 'class' => 'form-horizontal', 'method' => 'post')) !!}	    	
		    		<div class="form-body">
		    		
		    		@if ($errors->has('name'))
                    	<div class="form-group has-error">
                    @else
                    	<div class="form-group">
                    @endif
                        
                            <label for="inputName" class="col-md-3 control-label">
                                Name</label>
                            <div class="col-md-9">
                                <input id="inputName" class="form-control" type="text" name="name" value="{{ old('name') }}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputPassword" class="col-md-3 control-label">
                                Description</label>                           
                             <div class="col-md-9">
                                <textarea name="description" class="form-control">{{ old('description') }}</textarea>
                            </div>
                        </div>                        
                    </div>
                    <div class="form-actions pal">
                        <div class="form-group mbn">
                            <div class="col-md-offset-3 col-md-6">                                
                                <button type="submit" class="btn btn-primary">
                                    Submit</button>
                            </div>
                        </div>
                    </div>
                    {!! Form::close() !!}
		    </div>
	</div>
</div>
@stop