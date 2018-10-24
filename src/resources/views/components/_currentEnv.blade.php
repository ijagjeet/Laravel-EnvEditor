@php($translatePrefix='env-editor::env-editor.views.currentEnv.')
<template id="env-editor-main-tab">
    <div>
        <div class="h5 my-4">{{__($translatePrefix.'title')}}</div>
        <div class="py-3 text-right">
            <button class="btn btn-info" @click="addNew()">{{__($translatePrefix.'btn.addNewKey')}}</button>
        </div>
        <div class="table-responsive">
            <table class="table table-sm">
                <thead>
                <tr class="table-secondary ">
                    <th class="py-2" scope="col">{{__($translatePrefix.'tableTitles.key')}}</th>
                    <th class="py-2" scope="col">{{__($translatePrefix.'tableTitles.value')}}</th>
                    <th class="py-2" scope="col">{{__($translatePrefix.'tableTitles.actions')}}</th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="(item, index) in items" :key="item.key" v-bind="item" v-if="!item.separator">
                    <th scope="row" class="font-weight-bold ">@{{ item.key }}</th>
                    <td>@{{ item.value }}</td>
                    <td>
                        <div class="btn-group btn-group-sm">
                            <button class="btn btn-info" @click="edit(item)" title="{{__($translatePrefix.'btn.edit')}}"><span class="fa fa-edit"></span></button>
                            <button class="btn btn-secondary" @click="addAfter(item)"  title="{{__($translatePrefix.'btn.addAfterKey')}}"><span class="fa fa-share"></span></button>
                            <button class="btn btn-danger" @click="remove(item)"  title="{{__($translatePrefix.'btn.delete')}}"><span class="fa fa-trash"></span></button>
                        </div>
                    </td>
                </tr>
                <tr v-else>
                    <td colspan="100%">&nbsp;</td>
                </tr>

                </tbody>
            </table>
        </div>

    </div>
</template>

@push('scripts')


    <script>
        const itemsWrapper = {
                template: '#env-editor-main-tab',
                data: () => {
                    return {
                        items: []
                    }
                },
                mounted() {
                    envEventBus.$on('env:changed', () => {
                        this.getItemsWithAjax();
                    });
                    this.getItemsWithAjax()
                },
                methods: {
                    edit: function (item) {
                        env.$refs.keysModal.makeReadOnly('key');
                        env.$refs.keysModal.show('edit', item);
                    },
                    addNew() {
                        env.$refs.keysModal.show('new');
                    },
                    addAfter(item) {
                        env.$refs.keysModal.show('new', {
                            key: null,
                            value: null,
                            group: item.group,
                            index: item.index + 0.1,
                        });
                    },
                    remove(item) {
                        env.$refs.keysModal.makeReadOnly();
                        env.$refs.keysModal.show('delete', item);
                    },
                    getItemsWithAjax() {
                        axios.get('{{route(config($package.'.route.name').'.index')}}').then((response) => {
                            this.items = response.data.items;
                        }).catch((error)=>{
                            envAlert('danger', error.response.data.message);
                        })
                    }
                },
            }
        ;


    </script>
@endpush