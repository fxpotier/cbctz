@extends('layouts.user.profile')

@section('styles')
    <link rel="stylesheet" href="{{asset('css/user.css') }}"/>
@endsection

@section('scripts')
	<script src="{{asset('js/user.js')}}"></script>
@endsection

@section('title')
    @lang('view/user/profile.pictures.meta.title')
@endsection

@section('description')
    @lang('view/user/profile.pictures.meta.description')
@endsection

@section('body')
<?php $menuProfileItem = 1 ?>
<div class="panel panel-default picture" ng-controller="PictureController" ng-init="profileCropped=null;coverCropped=null">
    <div class="panel-body">
        <h1>@lang('view/user/profile.pictures.title')</h1>
        <hr/>
        <br/>
        <form method="post" action="{{action('ProfileController@postPictures')}}" enctype="multipart/form-data">
            <input value="{{csrf_token()}}" type="hidden" name="_token"/>
            <fieldset>
                <legend>@lang('view/user/profile.pictures.profile.title')</legend>
                <div class="row">
                    <div class="col-sm-4 col-lg-3">
                        <div class="btn btn-primary btn-block btn-file">
                            <i class="glyphicon glyphicon-folder-open"></i>&nbsp;&nbsp;&nbsp;@lang('view/user/profile.pictures.choose')
                            <input type="file" accept="image/*" file-model="profile" file-change="crop(profile, 200, 200)">
                        </div>
                        <button type="button" class="btn btn-primary btn-block" ng-disabled="!profile[profile.length-1].data" ng-click="open(profile[profile.length-1], 200, 200, profile[profile.length-1].cropped, 'img-circle')">
                            <span class="glyphicon glyphicon-fullscreen"></span>&nbsp;&nbsp;&nbsp;@lang('view/user/profile.pictures.resize')
                        </button>
                    </div>
                    <div class="col-sm-8 col-lg-9">
                        <div class="profile-preview img-preview img-circle" ng-if="!profile[profile.length-1].data && !profile[profile.length-1].cropped" style="background-image: url('{{asset($profilepicture)}}')"></div>
                        <div class="profile-preview img-preview img-circle" ng-if="profile[profile.length-1].data && !profile[profile.length-1].cropped" style="background-image: url(${profile[profile.length-1].data})">
                            <input type="hidden" value="${profile[profile.length-1].data}" name="profile[data]">
                        </div>
                        <div class="profile-preview img-preview img-circle" ng-if="profile[profile.length-1].cropped" style="background-image: url(${profile[profile.length-1].cropped})">
                            <input type="hidden" value="${profile[profile.length-1].cropped}" name="profile[data]">
                        </div>
                    </div>
                </div>
            </fieldset>
            <br/>
            <fieldset>
                <legend>@lang('view/user/profile.pictures.cover.title')</legend>
                <div class="row">
                    <div class="col-sm-4 col-lg-3">
                        <div class="btn btn-primary btn-block btn-file">
                            <i class="glyphicon glyphicon-folder-open"></i>&nbsp;&nbsp;&nbsp;@lang('view/user/profile.pictures.choose')
                            <input type="file" accept="image/*" file-model="cover" file-change="crop(cover, 1500, 500)">
                        </div>
                        <button type="button" class="btn btn-primary btn-block" ng-disabled="!cover[cover.length-1].data" ng-click="open(cover[cover.length-1], 1500, 500, cover[cover.length-1].cropped, 'img-rounded')">
                            <span class="glyphicon glyphicon-fullscreen"></span>&nbsp;&nbsp;&nbsp;@lang('view/user/profile.pictures.resize')
                        </button>
                    </div>
                    <div class="col-sm-8 col-lg-9">
                        <div class="cover-preview img-preview img-rounded" ng-if="!cover[cover.length-1].data && !cover[cover.length-1].cropped" style="background-image: url('{{asset($coverpicture)}}')"></div>
                        <div class="cover-preview img-preview img-rounded" ng-if="cover[cover.length-1].data && !cover[cover.length-1].cropped" style="background-image: url(${cover[cover.length-1].data})">
                            <input type="hidden" value="${cover[cover.length-1].data}" name="cover[data]">
                        </div>
                        <div class="cover-preview img-preview img-rounded" ng-if="cover[cover.length-1].cropped" style="background-image: url(${cover[cover.length-1].cropped})">
                            <input type="hidden" value="${cover[cover.length-1].cropped}" name="cover[data]">
                        </div>
                    </div>
                </div>
            </fieldset>
            <br/>
            <div class="row">
                <div class="col-sm-4 col-lg-3">
                    <button type="submit" class="btn btn-primary btn-block">@lang('view/user/profile.pictures.submit')</button>
                </div>
            </div>
        </form>
        <script type="text/ng-template" id="myModalContent.html">
            <div class="modal-header">
                <h3 class="modal-title">@lang('view/user/profile.pictures.modal.title')</h3>
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
                <button class="btn btn-primary" ng-click="ok()">@lang('view/user/profile.pictures.modal.ok')</button>
                <button class="btn btn-warning" ng-click="cancel()">@lang('view/user/profile.pictures.modal.cancel')</button>
            </div>
        </script>
    </div>
</div>
@endsection