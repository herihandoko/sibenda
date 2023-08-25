@php $mediaName = $inputName @endphp
<div class="form-group">
    <label for="">{{$inputTitle}}</label>
    <div class="row" id="image_preview" data-preview="{{$mediaName}}">
        @isset($inputData)
            @foreach (MediaImages($inputData) as $item)
                <div class="col-md-3 mb-4 mt-4">
                    <div class="w-100">
                        <img class="w-100" src="{{asset($item)}}">
                        <i onclick="removeImage(this)" class="fas fa-times-circle" data-image="{{asset($item)}}"
                            data-storage="{{$mediaName}}"></i>
                        @if ($loop->iteration == 1)
                            <span class="type bg-primary"> {{trans('admin.main')}} </span>
                        @endif
                    </div>
                </div>
                @push('scripts')
                    <script>
                        localStorage.input_selector = JSON.stringify('{{$mediaName}}');
                        storeImage('{{$inputData}}');
                    </script>
                @endpush
            @endforeach
            @endisset
        </div>

    <div class="form-control-file mb-4">
        <a class="btn btn-success btn-sm text-white" data-module="media-manager" data-multi-select="{{$multiInput}}"
            data-input="{{$mediaName}}" data-toggle="modal" data-target="#mediamanager" id="image-select">
            <i class="fas fa-image"></i> {{$buttonText }} </a>
    </div>

    <input id="form-image" data-title="{{$inputTitle}}" name="{{$mediaName}}" value="{{@$inputData}}" type="hidden"
    data-media="{{$mediaName}}" required>
</div>
