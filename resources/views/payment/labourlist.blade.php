<div class="mb-2">
    <label class="form-label" for="select2-basic">{{ __("Select Expense labour") }} <span class="text-danger">*</span></label>
        <select class="select2 form-select" id="select2-basic" name="labour">
            <option value="{{ null }}">@lang('Select')</option>
            @if(isset($labours[0]))
            @foreach ($labours as $labour )
                <option value="{{ $labour->id}}">{{ $labour->name }}</option>
            @endforeach
            @endif
        </select>
    <span class="text-danger">{{$errors->first('labour')}}</span>
</div>