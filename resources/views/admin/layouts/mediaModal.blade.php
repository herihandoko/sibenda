 <!-- Modal -->
 <div class="modal fade" id="mediamanager" tabindex="-1" role="dialog" aria-labelledby="modelTitleId"
     aria-hidden="true">
     <div class="modal-dialog modal-lg" role="document">
         <div class="modal-content">
             <div class="modal-header">
                 <h5 class="modal-title">{{trans('admin.Media manager')}}</h5>
                 <!-- Actual search box -->
                 <div class="form-group has-search">
                     <span class="fa fa-search form-control-feedback"></span>
                     <input name="serach" id="search" type="text" class="form-control" placeholder="{{trans('admin.Search')}}">
                 </div>
             </div>
             <div class="modal-body">
                 <div class="row" id="table_data">
                 </div>
                 <div class="row" id="selected_images">
                 </div>
             </div>
             <div class="modal-footer d-block">
                 <form id="formId" method="POST" enctype="multipart/form-data"
                     action="<?= route('admin.mediaupload') ?>">
                     @csrf
                     <div class="input-group mb-3">
                         <div class="input-group-prepend">
                             <span class="input-group-text" id="inputGroupFileAddon01">{{trans('admin.Upload')}}</span>
                         </div>
                         <div class="custom-file">
                             <input accept="image/*" name="image" type="file" class="custom-file-input"
                                 id="inputGroupFile" aria-describedby="inputGroupFileAddon01">
                             <label class="custom-file-label" for="inputGroupFile01">{{trans('admin.Choose file')}}</label>
                         </div>
                     </div>
                     <div class="form-group">
                         <input type="text" class="form-control" name="name" id="file-name" placeholder="{{trans('admin.Image Name')}}">
                     </div>
                     <div class="progress mb-4" id="image-progress">
                         <div class="progress-bar" role="progressbar" aria-valuemin="0" aria-valuemax="100">
                         </div>
                     </div>
                     <div class="form-group">
                         <button class="btn btn-sm btn-danger float-left" type="submit"> <i
                                 class="fas fa-upload    "></i> {{trans('admin.Upload')}}</button>
                         <button type="button" class="btn btn-sm btn-danger float-right ml-2"
                             data-dismiss="modal">{{trans('admin.Close')}}</button>
                         <button id="custom_button" type="button" class="btn btn-sm btn-primary float-right"
                             data-dismiss="modal">{{trans('admin.Select')}}</button>
                     </div>
                 </form>
             </div>
         </div>
     </div>
 </div>
