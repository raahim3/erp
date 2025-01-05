<div class="modal fade" id="changeSalaryModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
      <div class="modal-content">
          <form action="{{ route('salaries.store') }}" method="post">
            <input type="hidden" name="user_id" id="user_id">
              @csrf
              <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLabel">Give <span id="change_type"></span> To Muhammad Rahim</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <label for="change_type_select">Salary Change Type</label>
                        <select name="change_type" class="form-select" id="change_type_select" required>
                            <option value="increament">Increment</option>
                            <option value="decrement">Decrement</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label for="">Effective Date</label>
                        <input type="date" min="{{ date('Y-m-d') }}" name="effective_date" class="form-control" id="effective_date" required>
                    </div>
                    <div class="col-md-12 mt-3">
                        <label for="salary">Salary <small>(Current Salary : <span id="current_salary" class="text-danger"></span>)</small></label>
                        <input type="text" name="salary" id="salary" class="form-control" required> 
                    </div>
                </div>
                  </div>
                  <div class="modal-footer">
                      <button type="submit" class="btn btn-primary">Save</button>
                  </div>
          </form>
      </div>
    </div>
  </div>