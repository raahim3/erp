<div class="modal fade" id="createOvertimeModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
          <form action="{{ route('overtime.store') }}" id="overtimeForm" method="post">
              @csrf
              <input type="hidden" name="user_id" value="{{ $salary->user_id }}">
              <input type="hidden" name="salary_id" value="{{ $id }}">
              <input type="hidden" name="_method" id="overtime_methed" value="post">
              <div class="modal-header">
                  <h5 class="modal-title" id="overtimeModalLabel">Create Overtime</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
                      <div class="col-md-12">
                          <label for="">Title</label>
                          <input type="text" name="title" class="form-control" required placeholder="Title" id="overtime_title">
                      </div>
                      <div class="col-md-12 mt-3">
                          <label for="">Days</label>
                          <input type="number" name="days" class="form-control" required placeholder="Days" id="overtime_days">
                      </div>
                      <div class="col-md-12 mt-3">
                          <label for="">Hours</label>
                          <input type="text" name="hours" step="0.01" class="form-control" id="overtime_hour" required placeholder="Hours">
                      </div>
                      <div class="col-md-12 mt-3">
                          <label for="">Rate</label>
                          <input type="number" name="rate" step="0.01" class="form-control" id="overtime_rate" required placeholder="Rate">
                      </div>
                  </div>
                  <div class="modal-footer">
                      <button type="submit" class="btn btn-primary" id="overtimeSubmit">Save</button>
                  </div>
          </form>
      </div>
    </div>
  </div>