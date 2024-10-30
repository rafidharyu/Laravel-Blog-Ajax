let submit_method;

$(document).ready(function () {
    articleTable();
});

// datatable serverside
function articleTable() {
    let columns = [{
            data: 'DT_RowIndex',
            name: 'DT_RowIndex'
        },
        {
            data: 'title',
            name: 'title'
        },
        {
            data: 'category_id',
            name: 'category_id'
        },
        {
            data: 'tag_id',
            name: 'tag_id'
        },
        {
            data: 'views',
            name: 'views'
        },
        {
            data: 'published',
            name: 'published'
        },
    ];

    // Tambahkan kolom is_confirm hanya jika pengguna adalah owner
    if (isOwner) {
        columns.push({
            data: 'is_confirm',
            name: 'is_confirm'
        });
    }

    columns.push({
        data: 'action',
        name: 'action',
        orderable: true,
        searchable: true
    });

    $('#yajra').DataTable({
        processing: true,
        serverSide: true,
        responsive: true,
        ajax: "/admin/articles/serverside",
        columns: columns
    });
};


const deleteData = (e) => {
    let id = e.getAttribute('data-id');

    Swal.fire({
        title: "Are you sure?",
        text: "Do you want to delete this article?",
        icon: "question",
        confirmButtonColor: "#d33",
        cancelButtonColor: "#3085d6",
        confirmButtonText: "Delete",
        cancelButtonText: "Cancel",
        allowOutsideClick: false,
        showCancelButton: true,
        showCloseButton: true
    }).then((result) => {
        if (result.value) {
            startLoading();

            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: "DELETE",
                url: "/admin/articles/" + id,
                dataType: "json",
                success: function (response) {
                    stopLoading();
                    reloadTable();
                    toastSuccess(response.message);
                },
                error: function (response) {
                    console.log(response);
                }
            });
        }
    })
}

const deleteForceData = (e) => {
    let id = e.getAttribute('data-id');

    Swal.fire({
        title: "Are you sure?",
        text: "Do you want to delete permanently this article?",
        icon: "question",
        confirmButtonColor: "#d33",
        cancelButtonColor: "#3085d6",
        confirmButtonText: "Delete",
        cancelButtonText: "Cancel",
        allowOutsideClick: false,
        showCancelButton: true,
        showCloseButton: true
    }).then((result) => {
        if (result.value) {
            startLoading();

            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: "DELETE",
                url: "/admin/articles/force-delete/" + id,
                dataType: "json",
                success: function (response) {
                    stopLoading();

                    Swal.fire({
                        icon: 'success',
                        title: "Success!",
                        text: response.message,
                    }).then(result => {
                        if (result.isConfirmed) {
                            window.location.href = '/admin/articles';
                        }
                    })
                },
                error: function (response) {
                    console.log(response);
                }
            });
        }
    })
}
