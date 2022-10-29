@extends('layout.master')
@section('title', 'Create Contact - Connect CRM')
@section('description', 'Creating a new contact of the Connect Customer Relationship Management')
@section('keywords', 'Creating Contact Connect CRM Customer Relationship Management')
@section('content')
    <div class="row mt-4">
        <div class="col-sm-5">
            <h4 class="text-center">Create a New Contact</h4>
            <form class="mt-4" action="{{ url('/contact/create') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label for="exampleInputName">Enter Name</label>
                    <input type="text" name="name" class="form-control my-2" id="exampleInputName">
                    @if ($errors->has('name'))
                        <span class="text-danger">{{ $errors->first('name') }}</span>
                    @endif
                </div>
                <div class="form-group">
                    <label for="org-select">Choose Organization</label>
                    <div class="my-2">
                        <select name="org_id" class="form-select select2" aria-label="org select">
                            @foreach ($orgs as $o)
                                <option value="{{ $o->id }}">{{ $o->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    @if ($errors->has('org_id'))
                        <span class="text-danger">{{ $errors->first('org_id') }}</span>
                    @endif
                </div>
                <div class="form-group">
                    <label for="contact-phone">Phone Number</label>
                    <div class="table-responsive">
                        <table class="table table-borderless mb-0" id="dynamicAddPhone">
                            <tr>
                                <td>
                                    <input type="text" name="phones[0][number]" class="form-control">
                                </td>
                            </tr>
                        </table>
                    </div>
                    @if ($errors->has('phones*'))
                        <p class="text-danger">{{ $errors->first('phones*') }}</p>
                    @endif
                    <button type="button" name="add" id="dynamic-phone" class="btn btn-sm btn-primary mt-2">
                        <i class="bi bi-plus-lg"></i>
                        More
                    </button>
                </div>
                <div class="form-group mt-2">
                    <label for="contact-email">Email</label>
                    <div class="table-responsive">
                        <table class="table table-borderless mb-0" id="dynamicEmail">
                            <tr>
                                <td>
                                    <input type="email" name="emails[0][email]" class="form-control">
                                </td>
                            </tr>
                        </table>
                    </div>
                    @if ($errors->has('emails*'))
                        <p class="text-danger">{{ $errors->first('emails*') }}</p>
                    @endif
                    <button type="button" name="addEmail" id="dynamic-email" class="btn btn-sm btn-primary mt-2">
                        <i class="bi bi-plus-lg"></i>
                        More
                    </button>
                </div>
                <div class="form-group mt-2">
                    <label for="formFile" class="form-label">Choose Profile Image for the Contact</label>
                    <input name="image" class="form-control my-1" type="file" id="formFile">
                    @if ($errors->has('image'))
                        <span class="text-danger">{{ $errors->first('image') }}</span>
                    @endif
                </div>
                <center>
                    <button type="submit" class="btn btn-success mt-4">
                        <i class="bi bi-plus-circle"></i>
                        Create
                    </button>
                </center>
            </form>
        </div>
        <div class="col-sm-4"></div>
    </div>
@endsection
@section('script')
    <script type="text/javascript">
        // phones
        var i = 0;
        $('#dynamic-phone').click(function() {
            ++i;
            $('#dynamicAddPhone').append('<tr><td><input type="text" name="phones[' + i +
                '][number]" class="form-control"></td><td><button type="button" class="btn btn-sm btn-danger remove-input-field"><i class="bi bi-dash-circle"></i></button></td></tr>'
            )
        });
        $(document).on('click', '.remove-input-field', function() {
            $(this).parents('tr').remove();
        });
        // emails
        var a = 0;
        $('#dynamic-email').click(function() {
            ++a;
            $('#dynamicEmail').append('<tr><td><input type="text" name="emails[' + a +
                '][email]" class="form-control"></td><td><button type="button" class="btn btn-sm btn-danger remove-input-field"><i class="bi bi-dash-circle"></i></button></td></tr>'
            )
        });
    </script>
@endsection
