@extends('backend.layouts.app')

@section('title') {{ __($module_title) }} @endsection

@section('content')
<div class="table-content mb-3">
    <x-backend.section-header>
        {{--<div class="d-flex flex-wrap gap-3">
            @if(auth()->user()->can('add_request_service'))
            <x-backend.quick-action url="{{ route('backend.services.bulk_action') }}">
                <div class="">
                    <select name="action_type" class="form-control select2 col-12" id="quick-action-type" style="width:100%">
                        <option value="">{{ __('messages.no_action') }}</option>
                        @can('add_request_service')
                        <option value="change-status">{{ __('messages.status') }}</option>
                        @endcan
                        @can('delete_request_service')
                        <option value="delete">{{ __('messages.delete') }}</option>
                        @endcan
                    </select>
                </div>
                <div class="select-status d-none quick-action-field" id="change-status-action">
                    <select name="status" class="form-control select2" id="status" style="width:100%">
                        <option value="1" selected>{{ __('messages.active') }}</option>
                        <option value="0">{{ __('messages.inactive') }}</option>
                    </select>
                </div>
            </x-backend.quick-action>
            @endif
            <div>
                <button type="button" class="btn btn-secondary" data-modal="export">
                    <i class="fa-solid fa-download"></i> {{ __('messages.export') }}
                </button>
               <button type="button" class="btn btn-secondary" data-modal="import">
                 <i class="fa-solid fa-upload"></i> Import
                </button>
            </div>
        </div> --}}
        <x-slot name="toolbar">

            <div>
                <div class="datatable-filter">
                    <select name="column_status" id="column_status" class="select2 form-control" data-filter="select" style="width: 100%">
                        <option value="">{{__('messages.all')}}</option>
                        <option value="0" {{ $filter['status'] == '0' ? 'selected' : '' }}>
                            {{ __('messages.inactive') }}
                        </option>
                        <option value="1" {{ $filter['status'] == '1' ? 'selected' : '' }}>
                            {{ __('messages.active') }}
                        </option>
                    </select>
                </div>
            </div>

            <div class="input-group flex-nowrap">
                <span class="input-group-text" id="addon-wrapping"><i class="fa-solid fa-magnifying-glass"></i></span>
                <input type="text" class="form-control dt-search" placeholder="Search..." aria-label="Search" aria-describedby="addon-wrapping">
            </div>
           {{-- <button class="btn btn-secondary d-flex align-items-center gap-1 btn-group" data-bs-toggle="offcanvas" data-bs-target="#offcanvasExample" aria-controls="offcanvasExample"><i class="ph ph-funnel"></i>{{__('messages.advance_filter')}}</button>--}}
            @if(auth()->user()->hasRole('vendor'))
            <x-buttons.offcanvas target='#form-offcanvas' title="{{ __('messages.create') }} {{ __('service.request_title') }}">
            {{ __('messages.new') }}</x-buttons.offcanvas>
            @endif

        </x-slot>
    </x-backend.section-header>
    <table id="datatable" class="table table-responsive">
    </table>
</div>
<div data-render="app">
    <request-service-offcanvas create-title="{{ __('messages.create') }} {{ __($module_title) }}" edit-title="{{ __('messages.edit') }} {{ __($module_title) }}" :customefield="{{ json_encode($customefield) }}">
    </request-service-offcanvas>
</div>
<div data-render="app">
    <clinic-category-offcanvas default-image="{{default_file_url()}}" create-title="{{ __('messages.create') }} {{ __('category.singular_title') }}" edit-title="{{ __('messages.edit') }} {{ __('category.singular_title') }}" :customefield="{{ json_encode($customefield) }}">
    </clinic-category-offcanvas>
</div>
<x-backend.advance-filter>
    <x-slot name="title">
        <h4>{{ __('service.lbl_advanced_filter') }}</h4>
    </x-slot>
    <button type="reset" class="btn btn-danger" id="reset-filter">{{ __('appointment.reset') }}</button>
</x-backend.advance-filter>
@endsection

@push ('after-styles')
<link rel="stylesheet" href="{{ mix('modules/requestservice/style.css') }}">
<!-- DataTables Core and Extensions -->
<link rel="stylesheet" href="{{ asset('vendor/datatable/datatables.min.css') }}">
@endpush

@push ('after-scripts')
<script src="{{ mix('modules/requestservice/script.js') }}"></script>
<script src="{{ asset('js/form-offcanvas/index.js') }}" defer></script>
<script src="{{ asset('js/form-modal/index.js') }}" defer></script>

<!-- DataTables Core and Extensions -->
<script type="text/javascript" src="{{ asset('vendor/datatable/datatables.min.js') }}"></script>

<script type="text/javascript" defer>
    const columns = [
        // {
        //     name: 'check',
        //     data: 'check',
        //     title: '<input type="checkbox" class="form-check-input" name="select_all_table" id="select-all-table" onclick="selectAllTable(this)">',
        //     width: '0%',
        //     exportable: false,
        //     orderable: false,
        //     searchable: false,
        // },
        {
            data: 'name',
            name: 'name',
            title: "{{ __('service.lbl_name') }}"
        },
        {
            data: 'description',
            name: 'description',
            title: "{{ __('service.lbl_description') }}"
        },
        {
            data: 'type',
            name: 'type',
            title: "{{ __('service.lbl_type') }}"
        },
        {
            data: 'status',
            name: 'status',
            orderable: true,
            searchable: true,
            title: "{{ __('service.lbl_status') }}",
            width: '5%'
        },
        {
            data: 'is_status',
            name: 'is_status',
            orderable: true,
            searchable: true,
            title: "{{ __('service.request_service_status') }}",
            width: '5%'
        },
        {
            data: 'updated_at',
            name: 'updated_at',
            title: "{{ __('service.lbl_update_at') }}",
            orderable: true,
            visible: false,
        },

    ]
    const actionColumn = [{
        data: 'action',
        name: 'action',
        orderable: false,
        searchable: false,
        title: "{{ __('service.lbl_action') }}",
        width: '5%'
    }]

    const customFieldColumns = JSON.parse(@json($columns))

    let finalColumns = [
        ...columns,
        ...customFieldColumns,
        ...actionColumn
    ]

    document.addEventListener('DOMContentLoaded', (event) => {
        initDatatable({
            url: '{{ route("backend.$module_name.index_data") }}',
            finalColumns,
            advanceFilter: () => {
                return {}
            }
        });
    })
    const formOffcanvas = document.getElementById('clinic-category-offcanvas')
</script>
@endpush