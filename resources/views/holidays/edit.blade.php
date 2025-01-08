<div class="modal fade" id="editHolidayModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
          <form action="" id="editHolidayForm" method="post">
              @csrf
              @method('PUT')
              <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLabel">Edit Holiday</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
                      <div class="col-md-12">
                          <label for="">Title</label>
                          <input type="text" name="title" class="form-control" id="edit_title" required placeholder="Title">
                      </div>
                      <div class="col-md-12 mt-3">
                          <label for="">Date</label>
                          <input type="date" name="date" class="form-control" id="edit_date" required>
                      </div>
                      <div class="col-md-12 mt-3">
                          <label for="">Description</label>
                          <textarea name="description" id="edit_description" class="form-control" rows="6"></textarea>
                      </div>
                      <div class="col-md-12 mt-3">
                          <label for="">Status</label>
                          <select name="status" class="form-control" required id="edit_status">
                              <option value="1">Active</option>
                              <option value="2">Completed</option>
                              <option value="0">Inactive</option>
                          </select>
                      </div>
                  </div>
                  <div class="modal-footer d-flex justify-content-between">
                    @if (auth()->user()->hasPermission('holiday_delete'))
                        <form action="" method="post" id="deleteHolidayForm">
                        @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Delete</button>
                        </form>
                    @endif
                      <button type="submit" class="btn btn-primary">Update</button>
                  </div>
          </form>
      </div>
    </div>
  </div>