@extends('layout.master')
@section('title', "Edit Contact - $contact->name - Connect CRM")
@section('description', "Editing the contact $contact->name of the Connect Customer Relationship Management")
@section('keywords', "Edit Contact $contact->name Connect CRM Customer Relationship Management")
@section('content')
    <div class="row mt-4">
        <div class="col-sm-5">
            <center>
                <img src="{{ url('/storage/images/' . $contact->image) }}" width="100" height="100" class="rounded-circle"
                    alt="{{ $contact->name }}">
            </center>
            <form class="mt-4" action="{{ url('/contact/edit') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="contact_slug" value="{{ $contact->slug }}">
                @if ($errors->has('contact_slug'))
                    <span class="text-danger">{{ $errors->first('contact_slug') }}</span>
                @endif
                <div class="form-group">
                    <label for="exampleInputName">Name</label>
                    <input value="{{ $contact->name }}" type="text" name="name" class="form-control my-2"
                        id="exampleInputName">
                    @if ($errors->has('name'))
                        <span class="text-danger">{{ $errors->first('name') }}</span>
                    @endif
                </div>
                <div class="form-group">
                    <label for="org-select">Organization</label>
                    <select name="org_id" class="form-select my-2" id="org-select" aria-label="org select">
                        @foreach ($orgs as $o)
                            <option value="{{ $o->id }}" @if ($o->id === $contact->org_id) selected @endif>
                                {{ $o->name }}
                            </option>
                        @endforeach
                    </select>
                    @if ($errors->has('org_id'))
                        <span class="text-danger">{{ $errors->first('org_id') }}</span>
                    @endif
                </div>
                <div class="form-group">
                    <label for="contact-phone">Phone Number</label>
                    <div class="table-responsive">
                        <table class="table table-borderless mb-0" id="dynamicAddPhone">
                            @foreach ($contact->phone as $p)
                                <tr>
                                    <td>
                                        <input value="{{ $p->number }}" type="text"
                                            name="phones[{{ $loop->index }}][number]" class="form-control">
                                    </td>
                                    @if ($loop->index > 0)
                                        <td>
                                            <button type="button" class="btn btn-sm btn-danger remove-input-field">
                                                <i class="bi bi-dash-circle"></i>
                                            </button>
                                        </td>
                                    @endif
                                </tr>
                            @endforeach
                        </table>
                    </div>
                    @if ($errors->has('phones*'))
                        <p class="text-danger">{{ $errors->first('phones*') }}</p>
                    @endif
                    <button type="button" onclick="addPhoneInput({{ sizeOf($contact->phone) }})" name="add"
                        id="dynamic-phone" class="btn btn-sm btn-primary mt-2">
                        <i class="bi bi-plus-lg"></i>
                        More
                    </button>
                </div>
                <div class="form-group mt-2">
                    <label for="contact-email">Email</label>
                    <div class="table-responsive">
                        <table class="table table-borderless mb-0" id="dynamicEmail">
                            @foreach ($contact->email as $e)
                                <tr>
                                    <td>
                                        <input value="{{ $e->name }}" type="email"
                                            name="emails[{{ $loop->index }}][email]" class="form-control">
                                    </td>
                                    @if ($loop->index > 0)
                                        <td>
                                            <button type="button" class="btn btn-sm btn-danger remove-input-field">
                                                <i class="bi bi-dash-circle"></i>
                                            </button>
                                        </td>
                                    @endif
                                </tr>
                            @endforeach
                        </table>
                    </div>
                    @if ($errors->has('emails*'))
                        <p class="text-danger">{{ $errors->first('emails*') }}</p>
                    @endif
                    <button type="button" name="addEmail" onclick="addEmailInput({{ sizeOf($contact->email) }})"
                        id="dynamic-email" class="btn btn-sm btn-primary mt-2">
                        <i class="bi bi-plus-lg"></i>
                        More
                    </button>
                </div>
                <div class="form-group mt-2">
                    <label for="formFile" class="form-label">New Profile Image for {{ $contact->name }}</label>
                    <input name="image" class="form-control my-1" type="file" id="formFile">
                    @if ($errors->has('image'))
                        <span class="text-danger">{{ $errors->first('image') }}</span>
                    @endif
                </div>
                <div class="d-flex justify-content-evenly align-items-center mt-4 mb-2">
                    <div>
                        <a href="{{ url('/contact/view') }}" class="btn btn-dark">
                            <i class="bi bi-arrow-left"></i>
                            Back
                        </a>
                    </div>
                    <div>
                        <button type="submit" class="btn btn-success">
                            <i class="bi bi-check"></i>
                            Save
                        </button>
                    </div>
                </div>
            </form>
        </div>
        <div class="col-sm-4"></div>
    </div>
@endsection
@section('script')
    <script type="text/javascript">
        // dynamic phone input
        var i = 0;

        function addPhoneInput(arraySize) {
            i = i + arraySize;
            $('#dynamicAddPhone').append('<tr><td><input type="text" name="phones[' + i +
                '][number]" class="form-control"></td><td><button type="button" class="btn btn-sm btn-danger remove-input-field"><i class="bi bi-dash-circle"></i></button></td></tr>'
            )
        }
        // delete input
        $(document).on('click', '.remove-input-field', function() {
            $(this).parents('tr').remove();
        });
        // dynamic email input
        var a = 0;

        function addEmailInput(arraySize2) {
            a = a + arraySize2;
            $('#dynamicEmail').append('<tr><td><input type="email" name="emails[' + a +
                '][email]" class="form-control"></td><td><button type="button" class="btn btn-sm btn-danger remove-input-field"><i class="bi bi-dash-circle"></i></button></td></tr>'
            )
        }
    </script>
@endsection
