<div class="modal fade" id="applyLeaveModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
      <div class="modal-content">
          <form action="{{ route('leave_requests.store') }}" method="post">
              @csrf
              <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLabel">Leave Requests</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <label for="">Leave Type</label>
                        <select name="leave_type" class="form-select" id="" required>
                            @foreach ($leave_types as $leave_type)
                                <option value="{{ $leave_type->id }}">{{ $leave_type->title }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label for="">Start Date</label>
                        <input type="date" name="start_date" class="form-control" required>
                    </div>
                    <div class="col-md-6 mt-3">
                        <label for="">End Date</label>
                        <input type="date" name="end_date" class="form-control" required> 
                    </div>
                    <div class="col-md-12 mt-3">
                        <label for="">Reason</label>
                        <textarea name="reason" id="" class="form-control" rows="10" required></textarea>
                    </div>
                </div>
                  </div>
                  <div class="modal-footer">
                      <button type="submit" class="btn btn-primary">Send Request</button>
                  </div>
          </form>
      </div>
    </div>
  </div>