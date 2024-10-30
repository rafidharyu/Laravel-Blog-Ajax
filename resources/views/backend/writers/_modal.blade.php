<!-- Modal -->
<div class="modal fade" id="modalTag" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header bg-primary text-white">
          <h1 class="modal-title fs-5" id="staticBackdropLabel"></h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form action="#" id="formTag">
              <input type="hidden" name="id" id="id">

              <div class="mb-3">
                  <label for="name">Name</label>
                  <input type="text" name="name" id="name" class="form-control">
              </div>
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="submit" form="formTag" class="btn btn-primary btnSubmit">Submit</button>
        </div>
      </div>
    </div>
  </div>

  {{-- <!-- Modal -->
<div class="modal fade" id="modalWriter" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h1 class="modal-title fs-5" id="staticBackdropLabel"></h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="#" id="formWriter">  <!-- Ubah ID form menjadi formWriter -->
                    <input type="hidden" name="id" id="id">  <!-- ID untuk writer -->

                    <div class="mb-3">
                        <label for="name">Name</label>
                        <input type="text" name="name" id="name" class="form-control" required>  <!-- Tambahkan required jika diperlukan -->
                    </div>
                    <div class="mb-3">
                        <label for="email">Email</label>  <!-- Tambahkan field email jika perlu -->
                        <input type="email" name="email" id="email" class="form-control" required>  <!-- Pastikan input tipe email -->
                    </div>
                    <!-- Tambahkan field lain yang diperlukan untuk writer di sini -->
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" form="formWriter" class="btn btn-primary btnSubmit">Submit</button>  <!-- Ubah form target -->
            </div>
        </div>
    </div>
</div> --}}
