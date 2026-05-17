@extends('admin.theme.default')

@section('styles')
<link rel="stylesheet"
      href="{{ url(env('ASSETSPATHURL') . 'admin-assets/assets/css/bootstrap/bootstrap-select.v1.14.0-beta2.min.css') }}">
@endsection

@section('content')
@include('admin.breadcrumb')

<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card border-0 box-shadow">
                <div class="card-body">

                    <form action="{{ route('admin.deal-notifications.update', $notification->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="row">

                            {{-- Deal --}}
                            <div class="form-group col-md-6">
                                <label class="form-label">Deal</label>
                                <select class="form-control selectpicker w-100"
                                        name="deal_id"
                                        data-live-search="true">
                                    @foreach($deals as $id => $name)
                                        <option value="{{ $id }}"
                                            {{ $notification->deal_id == $id ? 'selected' : '' }}>
                                            {{ $name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            {{-- Repeat Type --}}
                            <div class="form-group col-md-6">
                                <label class="form-label">Repeat</label>
                                <select class="form-control" name="repeat_type" id="repeat_type">
                                    <option value="none"
                                        {{ $notification->repeat_type == 'none' ? 'selected' : '' }}>
                                        One Time
                                    </option>
                                    <option value="weekly"
                                        {{ $notification->repeat_type == 'weekly' ? 'selected' : '' }}>
                                        Weekly
                                    </option>
                                </select>
                            </div>

                            {{-- Date --}}
                            <div class="form-group col-md-6" id="date_field">
                                <label class="form-label">Date</label>
                                <input type="date"
                                       name="date"
                                       class="form-control"
                                       value="{{ optional($notification->date)->format('Y-m-d') }}">
                            </div>

                            {{-- Days --}}
                            <div class="form-group col-md-6 d-none" id="days_field">
                                <label class="form-label">Days</label>

                                <div>
                                    @php $selectedDays = $notification->days ?? []; @endphp

                                    @foreach(['mon','tue','wed','thu','fri','sat','sun'] as $day)
                                        <label class="me-2">
                                            <input type="checkbox"
                                                   name="days[]"
                                                   value="{{ $day }}"
                                                   {{ in_array($day, $selectedDays) ? 'checked' : '' }}>
                                            {{ ucfirst($day) }}
                                        </label>
                                    @endforeach
                                </div>
                            </div>

                            {{-- Time --}}
                            <div class="form-group col-md-6">
                                <label class="form-label">Time</label>
                                <input type="time"
                                       name="time"
                                       class="form-control"
                                       value="{{ \Carbon\Carbon::parse($notification->time)->format('H:i') }}"
                                       required>
                            </div>

                            <div class="form-group col-md-12">
                                <label class="form-label">Message</label>
                                <textarea name="message" class="form-control" rows="3" required>{{ $notification->message }}</textarea>
                            </div>


                            {{-- Buttons --}}
                            <div class="form-group text-end">
                                <a href="{{ route('admin.deal-notifications.index') }}"
                                   class="btn btn-danger">Cancel</a>

                                <button class="btn btn-primary" type="submit">
                                    Update
                                </button>
                            </div>

                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script
    src="{{ url(env('ASSETSPATHURL') . 'admin-assets/assets/js/bootstrap/bootstrap-select.v1.14.0-beta2.min.js') }}">
</script>

<script>
    const repeatType = document.getElementById('repeat_type');
    const dateField = document.getElementById('date_field');
    const daysField = document.getElementById('days_field');

    function toggleFields() {
        if (repeatType.value === 'weekly') {
            dateField.classList.add('d-none');
            daysField.classList.remove('d-none');
        } else {
            dateField.classList.remove('d-none');
            daysField.classList.add('d-none');
        }
    }

    repeatType.addEventListener('change', toggleFields);

    // run on load
    toggleFields();
</script>
@endsection