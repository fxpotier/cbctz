<div ng-controller="PictureController" ng-init='descriptionPictures=[]; savedDescPictures={{$descriptionPictures or '[]'}}'>
    <div class="form-group row">
        <label for="first" class="col-md-2 control-label">@lang('view/experience/create.picture.input.main')</label>
        <div class="col-md-10">
            <p class="help-block">@lang('view/experience/create.picture.help.main')</p>
            <div class="row">
                <div class="col-sm-4 col-lg-3">
                    <div class="btn btn-primary btn-block btn-file">
                        <i class="glyphicon glyphicon-folder-open"></i>&nbsp;&nbsp;&nbsp;@lang('view/experience/create.picture.choose')
                        <input type="file" accept="image/*" file-model="main" file-change="test();copy(main, descriptionPictures, 960, 540);crop(main, 540, 300)">
                    </div>
                    <button type="button" class="btn btn-primary btn-block" ng-disabled="!main[main.length-1].data" ng-click="open(main[main.length-1], 540, 300, main[main.length-1].cropped, 'img-rounded')">
                        <span class="glyphicon glyphicon-fullscreen"></span>&nbsp;&nbsp;&nbsp;@lang('view/experience/create.picture.resize')
                    </button>
                </div>
                <div class="col-sm-8 col-lg-9">
                    <div class="thumbnail-preview img-preview img-rounded" ng-if="!main[main.length-1].data && !main[main.length-1].cropped" style="background-image: url('{{asset($thumbnail)}}')"></div>
                    <div class="thumbnail-preview img-preview img-rounded" ng-if="main[main.length-1].data && !main[main.length-1].cropped" style="background-image: url(${main[main.length-1].data})">
                        <input type="hidden" value="${main[main.length-1].data}" name="main[data]">
                    </div>
                    <div class="thumbnail-preview img-preview img-rounded" ng-if="main[main.length-1].cropped" style="background-image: url(${main[main.length-1].cropped})">
                        <input type="hidden" value="${main[main.length-1].cropped}" name="main[data]">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="form-group row">
        <label for="first" class="col-md-2 control-label">@lang('view/experience/create.picture.input.cover')</label>
        <div class="col-md-10">
            <p class="help-block">@lang('view/experience/create.picture.help.cover')</p>
            <div class="row">
                <div class="col-sm-4 col-lg-3">
                    <div class="btn btn-primary btn-block btn-file">
                        <i class="glyphicon glyphicon-folder-open"></i>&nbsp;&nbsp;&nbsp;@lang('view/experience/create.picture.choose')
                        <input type="file" accept="image/*" file-model="cover" file-change="copy(cover, descriptionPictures, 960, 540);crop(cover, 1500, 500)">
                    </div>
                    <button type="button" class="btn btn-primary btn-block" ng-disabled="!cover[cover.length-1].data" ng-click="open(cover[cover.length-1], 1500, 500, cover[cover.length-1].cropped, 'img-rounded')">
                        <span class="glyphicon glyphicon-fullscreen"></span>&nbsp;&nbsp;&nbsp;@lang('view/experience/create.picture.resize')
                    </button>
                </div>
                <div class="col-sm-8 col-lg-9">
                    <div class="cover-preview img-preview img-rounded" ng-if="!cover[cover.length-1].data && !cover[cover.length-1].cropped" style="background-image: url('{{asset($cover)}}')"></div>
                    <div class="cover-preview img-preview img-rounded" ng-if="cover[cover.length-1].data && !cover[cover.length-1].cropped" style="background-image: url(${cover[cover.length-1].data})">
                        <input type="hidden" value="${cover[cover.length-1].data}" name="cover[data]">
                    </div>
                    <div class="cover-preview img-preview img-rounded" ng-if="cover[cover.length-1].cropped" style="background-image: url(${cover[cover.length-1].cropped})">
                        <input type="hidden" value="${cover[cover.length-1].cropped}" name="cover[data]">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="form-group row">
        <label for="first" class="col-md-2 control-label">@lang('view/experience/create.picture.input.description')</label>
        <div class="col-md-10">
            <p class="help-block">@lang('view/experience/create.picture.help.description')</p>
            <div class="row">
                <div ng-repeat="description in savedDescPictures track by $index">
                    <div class="col-sm-4 col-lg-3">
                        <button type="button" class="btn btn-danger btn-block" ng-click="delete(savedDescPictures, $index)">
                            <span class="glyphicon glyphicon-trash"></span>&nbsp;&nbsp;&nbsp;@lang('view/experience/create.picture.delete')
                        </button>
                    </div>
                    <div class="col-sm-8 col-lg-9">
                        <div class="main-preview img-preview img-rounded" style="background-image: url(${'/' + description.source})">
                            <input type="hidden" name="savedDescriptionPictures[]" value="${description.id}"/>
                        </div>
                        <br/>
                        <br/>
                    </div>
                </div>

                <div ng-repeat="description in descriptionPictures track by $index">
                    <div class="col-sm-4 col-lg-3">
                        <button type="button" class="btn btn-primary btn-block" ng-disabled="!description.data" ng-click="open(description, 960, 540, description.cropped, 'img-rounded')">
                            <span class="glyphicon glyphicon-fullscreen"></span>&nbsp;&nbsp;&nbsp;@lang('view/experience/create.picture.resize')
                        </button>
                        <button type="button" class="btn btn-danger btn-block" ng-click="delete(descriptionPictures, $index)">
                            <span class="glyphicon glyphicon-trash"></span>&nbsp;&nbsp;&nbsp;@lang('view/experience/create.picture.delete')
                        </button>
                    </div>
                    <div class="col-sm-8 col-lg-9">
                        <div class="main-preview img-preview img-rounded" ng-if="description.data && !description.cropped" style="background-image: url(${description.data})">
                            <input type="hidden" value="${description.data}" name="descriptionPictures[][data]">
                        </div>
                        <div class="main-preview img-preview img-rounded" ng-if="description.cropped" style="background-image: url(${description.cropped})">
                            <input type="hidden" value="${description.cropped}" name="descriptionPictures[][data]">
                        </div>
                        <br/>
                        <br/>
                    </div>
                </div>
                <div class="col-sm-4 col-lg-3">
                    <div class="btn btn-primary btn-block btn-file">
                        <i class="glyphicon glyphicon-folder-open"></i>&nbsp;&nbsp;&nbsp;@lang('view/experience/create.picture.choose')
                        <input type="file" accept="image/*" file-model="descriptionPictures" file-change="crop(descriptionPictures, 960, 540)" multiple>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script type="text/ng-template" id="myModalContent.html">
        <div class="modal-header">
            <h3 class="modal-title">@lang('view/experience/create.picture.modal.title')</h3>
        </div>
        <div>
            <br/>
            <canvas class="center-block" width="500" height="300" image-cropper image="picture.data" cropped-image="picture.cropped" crop-width="width" crop-height="height" keep-aspect="true" touch-radius="15"></canvas>
            <br/>
            <div ng-show="picture.cropped!=null">
                <img height="200" class="center-block ${display}" ng-src="${picture.cropped}"/>
            </div>
            <br/>
        </div>
        <div class="modal-footer">
            <button class="btn btn-primary" ng-click="ok()">@lang('view/experience/create.picture.modal.ok')</button>
            <button class="btn btn-warning" ng-click="cancel()">@lang('view/experience/create.picture.modal.cancel')</button>
        </div>
    </script>
</div>
