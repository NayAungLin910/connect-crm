<!-- Session flashing -->
@if (session()->has('error'))
    <script>
        Toastify({
            text: "{{ session('error') }}",
            duration: 3000,
            destination: "", // can put link 
            newWindow: true,
            close: true,
            gravity: "top", // `top` or `bottom`
            position: "right", // `left`, `center` or `right`
            stopOnFocus: true, // Prevents dismissing of toast on hover
            // className: ['bg-danger'],
            style: {
                background: "linear-gradient(to right, #F58C7E, #F02C11)",
            },
            onClick: function() {} // Callback after click
        }).showToast();
    </script>
@endif
@if (session()->has('info'))
    <script>
        Toastify({
            text: "{{ session('info') }}",
            duration: 3000,
            destination: "", // can put link 
            newWindow: true,
            close: true,
            gravity: "top", // `top` or `bottom`
            position: "right", // `left`, `center` or `right`
            stopOnFocus: true, // Prevents dismissing of toast on hover
            style: {
                background: "linear-gradient(to right, #9CB1E9, #5B82EA)",
            },
            onClick: function() {} // Callback after click
        }).showToast();
    </script>
@endif
@if (session()->has('success'))
    <script>
        Toastify({
            text: "{{ session('success') }}",
            duration: 3000,
            destination: "", // can put link 
            newWindow: true,
            close: true,
            gravity: "top", // `top` or `bottom`
            position: "right", // `left`, `center` or `right`
            stopOnFocus: true, // Prevents dismissing of toast on hover
            style: {
                background: "linear-gradient(to right, #76CA86, #35CD52)",
            },
            onClick: function() {} // Callback after click
        }).showToast();
    </script>
@endif
<!--end session flashing-->
<!-- jquery-confirm -->
<script>
    // confirm delete function
    function deleteSubmit(slug, name, type) {
        $.confirm({
            theme: 'modern',
            title: 'Delete!',
            content: `Are you sure about deleting the ${type}, ${name}?`,
            buttons: {
                confirm: {
                    text: 'Confirm',
                    btnClass: 'btn-red',
                    action: function() {
                        // delete the organization
                        $(`#${slug}`).submit();
                    },
                },
                cancel: function() {
                    // do nothing
                },
            }
        });
    }
    // confirm delete multiple function
    function deleteSubmitMultiple(id, type) {
        $.confirm({
            theme: 'modern',
            title: 'Delete!',
            content: `Are you sure about deleting the selected ${type}?`,
            buttons: {
                confirm: {
                    text: 'Confirm',
                    btnClass: 'btn-red',
                    action: function() {
                        // delete the organization
                        $(`#${id}`).submit();
                    },
                },
                cancel: function() {
                    // do nothing
                },
            }
        });
    }
</script>
<!--end jquery-confirm-->
<!-- select all jquery -->
<script>
    $(document).ready(function() {
        // hide the delete-select button initially
        $('#delete-select').hide();
        $('#select-all').click(function(event) {
            // if no checkbox-row has been checked
            if ($('.checkbox-row:checked').length == 0) {
                $('.checkbox-row').prop('checked', true);
                $('#delete-select').show();
            } else {
                if ($('.checkbox-row:checked').length === $('.checkbox-row').length) {
                    // if all checkbox-row has been checked
                    $('.checkbox-row').prop('checked', false);
                    $('#delete-select').hide();
                } else if ($('.checkbox-row:checked').length > 0) {
                    // if at least one of the checkbox-row has been checked
                    $('.checkbox-row').prop('checked', true);
                    $('#delete-select').show();
                }
            }
        });
        $('.checkbox-row').click(function(event) {
            if ($('.checkbox-row:checked').length > 0) {
                // if at least one of the checkbox-row has been checked
                $('#delete-select').show();
            }
            if ($('.checkbox-row:checked').length == 0) {
                // if none of the checkbox-row are checked
                $('#delete-select').hide();
            }
        });
        // create-contact using select 2
        $('.select2').select2();
    });
</script>
<!-- end select all jquery -->
<!-- user info -->
@if (Auth::guard('admin')->check())
    <script>
        window.type = "admin";
        window.auth = @json(Auth::guard('admin')->user())
    </script>
@endif
@if (Auth::guard('moderator')->check())
    <script>
        window.type = "moderator";
        window.auth = @json(Auth::guard('moderator')->user())
    </script>
@endif
<!-- end user info -->
