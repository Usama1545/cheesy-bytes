@extends('admin.theme.default')
@section('content')
@include('admin.breadcrumb')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card border-0">
                <div class="card-body">
                    <div class="flex flex-grid justify-between">
                        <form method="GET" action="{{ url()->current() }}">
                            <div class="row mb-3">
                                <div class="col-md-3">
                                    <label class="form-label">Select Branch</label>

                                    <select
                                        name="branch_id"
                                        class="form-control selectpicker"
                                        data-live-search="true"
                                        onchange="this.form.submit()"
                                    >
                                        <option value="">All Branches</option>

                                        @foreach (helper::get_branchs() as $branch)
                                            <option
                                                value="{{ $branch->id }}"
                                                {{ request('branch_id') == $branch->id ? 'selected' : '' }}
                                            >
                                                {{ $branch->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </form>
                        <div class="mb-3 text-end">
                            <a
                                href="{{ url('admin/county-seo/generate') }}"
                                class="btn btn-primary"
                            >
                                Generate Missing SEO Records
                            </a>
                        </div>
                    </div>

                    <div class="table-responsive" id="table-display">
                        <table class="table table-striped table-bordered zero-configuration">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Branch</th>
                                    <th>Category</th>
                                    <th width="120">{{ trans('labels.action') }}</th>
                                </tr>
                            </thead>

                            <tbody>
                                @php $i = 1; @endphp

                                @foreach ($getcontact as $contact)
                                    <tr>
                                        <td>{{ $i++ }}</td>

                                        <td>
                                            {{ optional($contact->branch)->name }}
                                        </td>

                                        <td>
                                            {{ optional($contact->category)->category_name }}
                                        </td>

                                        <td>
                                            <div class="d-flex gap-1">

                                                <a
                                                    href="{{ url('admin/county-seo/edit/'.$contact->id) }}"
                                                    class="btn btn-sm btn-info square"
                                                >
                                                    <i class="fa fa-edit"></i>
                                                </a>

                                                <a
                                                    class="btn btn-sm btn-danger square"
                                                    @if(env('Environment')=='sendbox')
                                                        onclick="myFunction()"
                                                    @else
                                                        onclick="DeleteData('{{ $contact->id }}','{{ URL::to('admin/contact/destroy') }}')"
                                                    @endif
                                                >
                                                    <i class="fa fa-trash"></i>
                                                </a>

                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection