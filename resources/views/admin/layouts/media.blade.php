@foreach ($data as $files)
    <div class="col-3 mb-4">
        <div class="custom-control custom-radio image-checkbox">
            <input type="radio" class="custom-control-input" id="{{$files->id}}" name="image"
                value="{{$files->file_path}}">
            <label class="custom-control-label" for="{{$files->id}}">


                <div class=media-image-frame>
                    <img src="{{asset($files->file_path)}}" alt="{{$files->file_name}}"/>
                    <span>{{$files->file_name}}</span>
                    <div onclick="event.preventDefault(); lightBox('{{asset($files->file_path)}}')" class="preview"><i class="fas fa-eye    "></i></div>
                  </div>

            </label>

        </div>
    </div>
@endforeach
@if ($data->count() == 0)
    <div class="col-12">
        <div class="alert alert-light alert-has-icon">
            <div class="alert-icon"><i class="far fa-sad-tear"></i></div>
            <div class="alert-body">
                <div class="alert-title">{{trans('admin.Sorry !')}}</div>
                {{trans('admin.No Image Found..')}}
            </div>
        </div>
    </div>
@endif
<div class="col-12 mt-4">
    <nav aria-label="Page navigation">
        {!! $data->links() !!}
    </nav>
</div>
