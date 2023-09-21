@extends('layout_admin.master')
@section('content')
    <div class="card">
        <div class="card-body">
            <form class="needs-validation" id="form-create" method="post" action="{{ route('admin.users.store') }}"
                enctype="multipart/form-data" novalidate>
                @csrf
                <div class="form-group position-relative mb-3">
                    <label for="validationTooltip01">Name</label>
                    <input type="text" name="name" class="form-control" id="name" placeholder="Name" required>
                </div>
                <div class="form-group position-relative mb-3">
                    <label for="validationTooltip02">Phone</label>
                    <input type="number" class="form-control" name="phone" id="phone" placeholder="Phone" required>
                </div>
                <div class="form-group position-relative mb-3">
                    <label for="validationTooltipUsername">Password</label>
                    <div class="input-group">
                        <input type="phone" class="form-control" id="password" name="password" placeholder="password"
                            aria-describedby="password" required>
                    </div>
                </div>
                <div class="form-group position-relative mb-3">
                    <label for="validationTooltip03">Email</label>
                    <input type="mail" class="form-control" name="email" id="email" placeholder="Email" required>
                </div>
                <div class="form-group">
                    <label>Role</label>
                    <select id="select-role" class="form-control" name="role">
                        @foreach ($arrRole as $key => $value)
                            <option value="{{ $value }}">
                                {{ $key }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group position-relative mb-3">
                    <label>Avatar</label>
                    <input type="file" name="avatar" oninput="pic.src=window.URL.createObjectURL(this.files[0])"
                        id="avatar">
                    <img id="pic" height="100" />
                </div>
                <button onclick="submitForm()" class="btn btn-primary" type="button">Submit form</button>
            </form>
        </div>
    </div>
@endsection

@push('js')
    <script>
        function clearForm() {
            $("#name").val("");
            $("#phone").val("");
            $("#email").val("");
            $("#password").val("");
            $("#avatar").val("");
            const img = document.getElementById('pic');
            img.setAttribute('src', '');
        }

        function submitForm() {
            const obj = $("#form-create");
            const formData = new FormData(obj[0]);
            $.ajax({
                url: obj.attr('action'),
                type: 'POST',
                dataType: "json",
                data: formData,
                processData: false,
                async: false,
                cache: false,
                contentType: false,
                enctype: 'multipart/form-data',
                success: function(response) {
                    if (response.success) {
                        clearForm();
                        notifySuccess();
                    } else {
                        showError(response.message);
                    }
                },
                error: function(response) {
                    let errors;
                    if (response.responseJSON.errors) {
                        errors = Object.values(response.responseJSON.errors);
                        showError(errors);
                    } else {
                        errors = response.responseJSON.message;
                        showError(errors);
                    }
                },
            });
        }

        function showError(errors) {
            let string = '<ul>'
            if (Array.isArray(errors)) {
                errors.forEach(function(each) {
                    each.forEach(function(error) {
                        string += `<li>${error}</li>`;
                    });
                });
            } else {
                string += `<li>${errors}</li>`;
            }
            string += '</ul>';
            $("#div_errors").html(string);
            $("#div_errors").removeClass("d-none").show();
            notifyError(string);
        }
    </script>
@endpush
