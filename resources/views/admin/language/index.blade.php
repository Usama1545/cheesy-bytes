@extends('admin.theme.default')
@section('content')
    <div class="alert top-alert">
        <i class="fa-regular fa-circle-exclamation"></i> This section is available only for website & admin panel. 
    </div>
    
    <div class="alert top-alert" role="alert">
        <p>Dont Use Double Qoute (")</p>
    </div>
    
    <div class="row settings">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h5 class="text-uppercase">{{ trans('labels.language') }}</h5>
            @if (@helper::checkaddons('language'))
            <div class="d-flex justify-content-end">
                <a href="{{ URL::to('/admin/language-settings/language/add') }}" class="btn btn-primary px-4 mb-2"><i class="fa-regular fa-plus mx-1"></i>{{ trans('labels.add_new') }} </a>
            </div>
            @endif
        </div>
        <div class="col-xl-3 mb-3">
            <div class="card card-sticky-top border-0">
                <ul class="list-group list-options">
                    @foreach ($getlanguages as $data)
                        <a href="{{ URL::to('admin/language-settings/' . $data->code) }}"
                            class="list-group-item basicinfo p-3 list-item-primary @if ($currantLang->code == $data->code) active @endif"
                            aria-current="true">
                            <div class="d-flex justify-content-between align-item-center">
                                {{ $data->name }}
                                <div class="d-flex align-item-center">
                                    @if ($data->is_default == '1')
                                        <span>{{ trans('labels.default') }}</span>
                                    @endif
                                    <i class="fa-regular fa-angle-right ps-2"></i>
                                </div>
                            </div>
                        </a>
                    @endforeach
                </ul>
            </div>
        </div>
        <div class="col-xl-9">
            <div class="dropdown">

                <a class="btn btn-info text-white"
                    href="{{ URL::to('/admin/language-settings/language/edit-' . $currantLang->id) }}">
                    {{ trans('labels.edit') }} </a>
                @if (Strtolower($currantLang->name) != 'english')
                    <a class="btn btn-danger text-white"
                        @if (env('Environment') == 'sendbox') onclick="myFunction()" @else onclick="statusupdate('{{ URL::to('admin/language-settings/language/delete-' . $currantLang->id . '/2') }}')" @endif>
                        {{ trans('labels.delete') }} </a>
                @endif
            </div>
            <ul class="nav nav-tabs mt-3" id="myTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active bg-white" id="labels-tab" data-bs-toggle="tab" data-bs-target="#labels"
                        type="button" role="tab" aria-controls="labels" aria-selected="true">Labels</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link bg-white" id="message-tab" data-bs-toggle="tab" data-bs-target="#message" type="button"
                        role="tab" aria-controls="message" aria-selected="false">Messages</button>
                </li>
            </ul>
            <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade show active" id="labels" role="tabpanel" aria-labelledby="labels-tab">
                    <div class="card border-0 box-shadow">
                        <div class="card-body">
                            <form method="post" action="{{ URL::to('admin/language-settings/update') }}">
                                @csrf
                                <input type="hidden" class="form-control" name="currantLang"
                                    value="{{ $currantLang->code }}">
                                <input type="hidden" class="form-control" name="file" value="label">
                                <div class="row">
                                    @foreach ($arrLabel as $label => $value)
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="form-label" for="example3cols1Input">{{ $label }}
                                                </label>
                                                <input type="text" class="form-control"
                                                    name="label[{{ $label }}]" id="label{{ $label }}"
                                                    onkeyup="validation($(this).val(),this.getAttribute('id'))"
                                                    value="{{ $value }}">
                                            </div>
                                        </div>
                                    @endforeach
                                    <div class="col-lg-12">
                                        <div class="text-end">
                                            <div class="d-flex justify-content-end mt-3">
                                                @if (env('Environment') == 'sendbox')
                                                    <button type="button" class="btn btn-raised btn-primary px-4"
                                                        onclick="myFunction()"><i class="fa fa-check-square-o"></i>
                                                        {{ trans('labels.save') }} </button>
                                                @else
                                                    <button type="submit" class="btn btn-raised btn-primary px-4 {{ Auth::user()->type == 4 ? (helper::check_access('role_language_settings', Auth::user()->role_id, 'add') == 1 ? '' : 'd-none') : '' }}"><i
                                                            class="fa fa-check-square-o"></i> {{ trans('labels.save') }}
                                                    </button>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="message" role="tabpanel" aria-labelledby="message-tab">
                    <div class="card border-0 box-shadow">
                        <div class="card-body">
                            <form method="post" action="{{ URL::to('admin/language-settings/update') }}">
                                @csrf
                                <input type="hidden" class="form-control" name="currantLang"
                                    value="{{ $currantLang->code }}">
                                <input type="hidden" class="form-control" name="file" value="message">
                                <div class="row">
                                    @foreach ($arrMessage as $label => $value)
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="form-label" for="example3cols1Input">{{ $label }}
                                                </label>
                                                <input type="text" class="form-control"
                                                    name="message[{{ $label }}]" id="message{{ $label }}"
                                                    onkeyup="validation($(this).val(),this.getAttribute('id'))"
                                                    value="{{ $value }}">
                                            </div>
                                        </div>
                                    @endforeach
                                    <div class="col-lg-12">
                                        <div class="text-end">
                                            <div class="d-flex justify-content-end mt-3">
                                                @if (env('Environment') == 'sendbox')
                                                    <button type="button" class="btn btn-raised btn-primary px-4"
                                                        onclick="myFunction()"><i class="fa fa-check-square-o"></i>
                                                        {{ trans('labels.save') }} </button>
                                                @else
                                                    <button type="submit" class="btn btn-raised btn-primary px-4 {{ Auth::user()->type == 4 ? (helper::check_access('role_language_settings', Auth::user()->role_id, 'add') == 1 ? '' : 'd-none') : '' }}"><i
                                                            class="fa fa-check-square-o"></i> {{ trans('labels.save') }}
                                                    </button>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
               
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        function validation(value, id) {
            if (value.includes('"')) {
                newval = value.replaceAll('"', '');
                $('#' + id).val(newval);
            }
        }
    </script>
    <script src="{{ url(env('ASSETSPATHURL') . 'admin-assets/assets/js/custom/settings.js') }}"></script>
@endsection
