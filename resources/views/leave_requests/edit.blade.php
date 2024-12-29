<div class="modal fade" id="editLeaveModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
      <div class="modal-content">
          <form action="" method="post" id="editLeaveForm">
              @csrf
              @method('PUT')
              <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLabel">Edit Leave Requests</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <label for="">Leave Type</label>
                        <select name="leave_type" class="form-select" id="edit_leave_type" required>
                            @foreach ($leave_types as $leave_type)
                                <option value="{{ $leave_type->id }}">{{ $leave_type->title }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label for="">Select Employee</label>
                        <select name="employee" class="form-select" id="edit_employee" required>
                            @foreach ($employees as $employee)
                                <option value="{{ $employee->id }}">{{ $employee->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6 mt-3">
                        <label for="">Start Date</label>
                        <input type="date" name="start_date" class="form-control" required id="edit_start_date">
                    </div>
                    <div class="col-md-6 mt-3">
                        <label for="">End Date</label>
                        <input type="date" name="end_date" class="form-control" required id="edit_end_date"> 
                    </div>
                    <div class="col-md-12 mt-3">
                        <label for="">Reason</label>
                        <textarea name="reason" id="edit_reason" class="form-control" rows="10" required></textarea>
                    </div>
                </div>
                  </div>
                  <div class="modal-footer">
                      <button type="submit" class="btn btn-primary">Update Request</button>
                  </div>
          </form>
      </div>
    </div>
  </div>