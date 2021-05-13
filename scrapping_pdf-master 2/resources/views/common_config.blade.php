<input type="hidden" id="_token" name="_token" value="{{ csrf_token() }}" />
<input type="hidden" id="base_url" name="base_url" value="{{ URL('/') }}/" />
<input type="hidden" id="last_segment" name="last_segment" value="{{ request()->segment(2) }}" />

@if($student_id)
	<input type="hidden" id="student_id" name="student_id" value="{{ $student_id }}" />
@else
	<input type="hidden" id="student_id" name="student_id" value="{{ Session::get('student_id') }}" />
@endif
