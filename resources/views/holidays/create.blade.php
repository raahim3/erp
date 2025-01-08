<div class="modal fade" id="createHolidayModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
          <form action="{{ route('holidays.store') }}" method="post">
              @csrf
              <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLabel">Add Holiday</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
                      <div class="col-md-12">
                          <label for="">Title</label>
                          <input type="text" name="title" class="form-control" required placeholder="Title">
                      </div>
                      <div class="col-md-12 mt-3">
                          <label for="">Date</label>
                          <input type="date" name="date" class="form-control" required>
                      </div>
                      <div class="col-md-12 mt-3">
                          <label for="">Description</label>
                          <textarea name="description" id="" class="form-control" rows="6"></textarea>
                      </div>
                      <div class="col-md-12 mt-3">
                          <label for="">Status</label>
                          <select name="status" class="form-control" required>
                              <option value="1">Active</option>
                              <option value="2">Completed</option>
                              <option value="0">Inactive</option>
                          </select>
                      </div>
                  </div>
                  <div class="modal-footer">
                      <button type="submit" class="btn btn-primary">Save</button>
                  </div>
          </form>
      </div>
    </div>
  </div>