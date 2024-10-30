let submit_method;

$(document).ready(function () {
    writerTable();
});

// datatable serverside
function writerTable() {
    $("#yajra").DataTable({
        processing: true,
        serverSide: true,
        responsive: true,
        // pageLength: 20, // set default records per page
        ajax: "/admin/writers/serverside",
        columns: [
            {
                data: "DT_RowIndex",
                name: "DT_RowIndex",
            },
            {
                data: "name",
                name: "name",
            },
            {
                data: "email",
                name: "email",
            },
            {
                data: "created_at",
                name: "created_at",
            },
            {
                data: "is_verified",
                name: "is_verified",
            },
            {
                data: "action",
                name: "action",
                orderable: true,
                searchable: true,
            },
        ],
    });
}

// form create
const modalTag = () => {
    submit_method = "create";
    resetForm("#formTag");
    resetValidation();
    $("#modalTag").modal("show");
    $(".modal-title").html('<i class="fa fa-plus"></i> Create Tag');
    $(".btnSubmit").html('<i class="fa fa-save"></i> Save');
};

const verifyData = (e) => {
    let id = e.getAttribute("data-id");

    startLoading();

    $.ajax({
        type: "POST",
        url: "/admin/writers/" + id + "/verify",
        success: function (response) {
            toastSuccess(response.message);
            $("#dataTable").DataTable().ajax.reload();
            stopLoading();
        },
        error: function (jqXHR, response) {
            console.log(jqXHR.responseText);
            toastError(jqXHR.responseText);
        },
    });
};

// form edit
// const editData = (e) => {
//     let id = e.getAttribute('data-id');

//     startLoading();
//     resetForm('#formTag');
//     resetValidation();

//     $.ajax({
//         type: "GET",
//         url: "/admin/tags/" + id,
//         success: function (response) {
//             let parsedData = response.data;

//             $('#id').val(parsedData.uuid);
//             $('#name').val(parsedData.name);
//             $('#modalTag').modal('show');
//             $('.modal-title').html('<i class="fa fa-edit"></i> Edit Tag');
//             $('.btnSubmit').html('<i class="fa fa-save"></i> Save');

//             submit_method = 'edit';

//             stopLoading();
//         },
//         error: function (jqXHR, response) {
//             console.log(jqXHR.responseText);
//             toastError(jqXHR.responseText);
//         }
//     });
// }

// form edit
const editDataWriter = (e) => {
    let id = e.getAttribute("data-id");

    startLoading();
    resetForm("#formWriter"); // Pastikan ID form sesuai
    resetValidation();

    $.ajax({
        type: "GET",
        url: "/admin/writers/" + id, // Ganti endpoint jika diperlukan
        success: function (response) {
            console.log(response); // Tambahkan log untuk memeriksa respons
            let parsedData = response.data;

            $("#id").val(parsedData.uuid);
            $("#name").val(parsedData.name);
            $("#email").val(parsedData.email); // Jika ada field email
            $("#modalWriter").modal("show"); // Pastikan ID modal sesuai
            $(".modal-title").html('<i class="fa fa-edit"></i> Edit Writer');
            $(".btnSubmit").html('<i class="fa fa-save"></i> Save');

            submit_method = "edit";

            stopLoading(); // Pastikan loading dihentikan
        },
        error: function (jqXHR, response) {
            console.log(jqXHR.responseText);
            toastError(jqXHR.responseText);
            stopLoading(); // Pastikan loading dihentikan jika error
        },
    });
};

const deleteData = (e) => {
    let id = e.getAttribute("data-id");

    Swal.fire({
        title: "Are you sure?",
        text: "Do you want to delete this tag?",
        icon: "question",
        confirmButtonColor: "#d33",
        cancelButtonColor: "#3085d6",
        confirmButtonText: "Delete",
        cancelButtonText: "Cancel",
        allowOutsideClick: false,
        showCancelButton: true,
        showCloseButton: true,
    }).then((result) => {
        startLoading();

        if (result.value) {
            $.ajax({
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                        "content"
                    ),
                },
                type: "DELETE",
                url: "/admin/tags/" + id,
                dataType: "json",
                success: function (response) {
                    reloadTable();

                    toastSuccess(response.message);
                },
                error: function (response) {
                    console.log(response);
                },
            });
        }
    });
};

// save data
$("#formTag").on("submit", function (e) {
    e.preventDefault();

    startLoading();

    let url, method;
    url = "/admin/tags";
    method = "POST";

    const inputForm = new FormData(this);

    if (submit_method == "edit") {
        url = "/admin/tags/" + $("#id").val();
        inputForm.append("_method", "PUT");
    }

    $.ajax({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
        type: method,
        url: url,
        data: inputForm,
        contentType: false,
        processData: false,
        success: function (response) {
            $("#modalTag").modal("hide");
            reloadTable();
            resetValidation();
            stopLoading();
            toastSuccess(response.message);
        },
        error: function (jqXHR, response) {
            console.log(response.message);
            toastError(jqXHR.responseText);
        },
    });
});
