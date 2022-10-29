{{-- @extends('layout.master')
@section('title', 'Sources - Connect CRM')
@section('description', 'Sources in the Connect Customer Relationship Management')
@section('keywords', 'Sources Connect CRM Customer Relationship Management')
@section('content')
    <div class="row mt-4">
        <h3 class="text-center mb-3">Sources</h3>
        <form action="{{ url('/source/view') }}" id="search-source" method="GET"></form>
        <form action="{{ url('/source/view') }}" id="search-source-cleared" method="GET"></form>
        <form action="{{ url('/source/delete-multiple') }}" id="source-delete-multiple" method="POST">@csrf</form>
        <div class="col-sm-2">
            <div class="form-group">
                <label for="InputStartDate">Start Date</label>
                <input name="startdate" value="{{ $startdate }}" form="search-source" type="date" class="form-control"
                    id="InputStartDate">
            </div>
        </div>
        <div class="col-sm-2">
            <div class="form-group">
                <label for="InputEndDate">End Date</label>
                <input name="enddate" value="{{ $enddate }}" type="date" form="search-source" class="form-control"
                    id="InputEndDate">
            </div>
        </div>
        <div class="col-sm-1">
            <div class="form-group">
                <label for="InputView">Records</label>
                <select class="form-select" name="view" aria-label="Default select example" form="search-source"
                    id="InputView">
                    <option value="10" @if ($view == 10) selected @endif>10</option>
                    <option value="15" @if ($view == 15) selected @endif>15</option>
                    <option value="20" @if ($view == 20) selected @endif>20</option>
                </select>
            </div>
        </div>
        <div class="col-sm-4 large-screen-mt">
            <div class="input-group">
                <input type="text" value="{{ $search }}" name="search" form="search-source" class="form-control"
                    placeholder="Source" aria-label="Recipient's username" aria-describedby="button-addon2">
                <button class="btn btn-primary" type="submit" form="search-source" id="button-addon2">
                    Search
                </button>
            </div>
        </div>
        <div class="col-sm-2 large-screen-mt">
            <div>
                <button class="btn btn-sm btn-primary" type="submit" form="search-source-cleared">
                    <i class="bi bi-arrow-counterclockwise"></i>
                    Clear
                </button>
            </div>
        </div>
    </div>
    <div class="col-sm-12 mt-3">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        @if (!sizeOf($sources) == 0)
                            <button type="button" class="btn btn-sm btn-primary" id="select-all">Select
                                All</button>
                            <button onClick="deleteSubmitMultiple('source-delete-multiple','sources')"
                                class="btn btn-sm btn-danger ms-3" id="delete-select">Delete
                                Selected</button>
                        @endif
                        <th></th>
                        <th>Name</th>
                        <th>Date</th>
                        <th>Lead Count</th>
                        <th></th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @if (sizeOf($sources) == 0)
                        <td></td>
                        <td colspan="5">No source found!</td>
                    @endif
                    @foreach ($sources as $s)
                        <tr>
                            <td>
                                <div>
                                    <input form="source-delete-multiple" name="source_slugs[{{ $loop->index }}]"
                                        class="form-check-input checkbox-lg checkbox-row" type="checkbox"
                                        value="{{ $s->slug }}">
                                </div>
                            </td>
                            <td>{{ $s->name }}</td>
                            <td>{{ $s->created_at }}</td>
                            <td>{{ $s->lead_count }}</td>
                            <td class="text-end">
                                <a href="{{ url('/source/edit/' . $s->slug) }}" class="btn btn-sm btn-primary">
                                    <i class="bi bi-pencil-square"></i>
                                    Rename
                                </a>
                            </td>
                            <td>
                                <form action="{{ url('/source/delete') }}" id="{{ $s->slug }}" method="POST"
                                    class="d-inline">
                                    @csrf
                                    <input type="hidden" name="source_slug" value="{{ $s->slug }}">
                                    <button type="button"
                                        onClick="deleteSubmit('{{ $s->slug }}', '{{ $s->name }}', 'source')"
                                        class="btn btn-sm btn-danger">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    {{ $sources->links('vendor.pagination.bootstrap-4') }}
@endsection --}}
@extends('layout.master')
@section('title', 'Sources - Connect CRM')
@section('description', 'Sources of the Connect Customer Relationship Management')
@section('keywords', 'Sources Connect CRM Customer Relationship Management')
@section('css')
    @viteReactRefresh
@endsection
@section('content')
    <div id="root"></div>
    @vite('resources/js/viewSource.jsx')
@endsection
