<div class="modal fade" id="editTypeModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
          <form action="" id="editTypeForm" method="post">
              @csrf
              @method('PUT')
              <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLabel">Update Leave Type</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
                      <div class="col-md-12 mt-3">
                          <label for="">Leave Type</label>
                          <input type="text" name="title" id="edit_title" class="form-control" required placeholder="Leave Type">
                      </div>
                      <div class="col-md-12 mt-3">
                          <label for="">Status</label>
                          <select name="status" class="form-control" required id="edit_status">
                              <option value="1">Active</option>
                              <option value="0">Inactive</option>
                          </select>
                      </div>
                  </div>
                  <div class="modal-footer">
                      <button type="submit" class="btn btn-primary">Update</button>
                  </div>
          </form>
      </div>
    </div>
  </div>