@php($package='env-editor')
@php($translatePrefix='env-editor::env-editor.')

@extends(config("$package.layout"))

@section('documentTitle') <i class="fa fa-cog" aria-hidden="true"></i>
{{trans('env-editor::env-editor.env-editorListing')}}
@stop

@section('content')

    <div id="env-editor">
        <div id="env-alerts"></div>

        <ul class="nav nav-tabs">
            <li class="nav-item">
                <a class="nav-link active" data-toggle="tab" href="#current-env" role="tab">{{__($translatePrefix.'views.tabTitles.currentEnv')}}</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-toggle="tab" href="#backup-env" role="tab">{{__($translatePrefix.'views.tabTitles.backup')}}</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-toggle="tab" href="#upload-env" role="tab">{{__($translatePrefix.'views.tabTitles.upload')}}</a>
            </li>
        </ul>

        <div class="tab-content" id="nav-tabContent">
            <div class="tab-pane fade show active p-3" id="current-env" role="tabpanel" aria-labelledby="nav-home-tab">
                <env-main-tab></env-main-tab>
            </div>
            <div class="tab-pane fade p-3" id="backup-env" role="tabpanel" aria-labelledby="nav-profile-tab">
                <env-editor-backups></env-editor-backups>
            </div>
            <div class="tab-pane fade p-3" id="upload-env" role="tabpanel" aria-labelledby="nav-contact-tab">
                <env-file-upload></env-file-upload>
            </div>
        </div>

        <env-keys-modal ref="keysModal"></env-keys-modal>
    </div>


    @include('env-editor::components._itemModal')
    @include('env-editor::components._currentEnv')
    @include('env-editor::components._upload')
    @include('env-editor::components._backup')

@stop




@push('scripts')
    <script>
        window.envEventBus = new Vue();
        const envAlert = ($type, $text) => {
            let alert =
                '<div id="__id__" class="alert alert-__type__ alert-dismissible fade show" role="alert">' +
                '  <div>__text__</div>' +
                '  <button type="button" class="close" data-dismiss="alert" aria-label="Close">' +
                '    <span aria-hidden="true">&times;</span>' +
                '  </button>' +
                '</div>';
            let $id = 'env-alert_' + Date.now();
            let $html = alert.replace('__type__', $type).replace('__text__', $text).replace('__id__', $id);
            $('#env-alerts').append($html);
            setTimeout(() => {
                $('#'+$id).alert('close')
            }, 3000)

        };
        Vue.component('env-main-tab', itemsWrapper);
        Vue.component('env-keys-modal', itemsModal);
        Vue.component('env-file-upload', fileUpload);
        Vue.component('env-editor-backups', backUps);
        const env = new Vue({el: '#env-editor'})
    </script>
@endpush