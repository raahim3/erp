<div class="modal fade" id="createLoanModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
          <form action="{{ route('loans.store') }}" id="loanForm" method="post">
              @csrf
              <input type="hidden" name="user_id" value="{{ $salary->user_id }}">
              <input type="hidden" name="salary_id" value="{{ $id }}">
              <input type="hidden" name="_method" id="loan_methed" value="post">
              <div class="modal-header">
                  <h5 class="modal-title" id="loanModalLabel">Create Allowance</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
                      <div class="col-md-12">
                          <label for="">Title</label>
                          <input type="text" name="title" class="form-control" required placeholder="Title" id="loan_title">
                      </div>
                      <div class="col-md-12 mt-3">
                          <label for="">Type</label>
                          <select name="type" class="form-control" required id="loan_type">
                              <option value="fixed">Fixed</option>
                              <option value="percentage">Percentage</option>
                          </select>
                      </div>
                      <div class="col-md-12 mt-3">
                          <label for="">Amount</label>
                          <input type="number" name="amount" step="0.01" class="form-control" id="loan_amount" required placeholder="Amount">
                      </div>
                  </div>
                  <div class="modal-footer">
                      <button type="submit" class="btn btn-primary" id="loanSubmit">Save</button>
                  </div>
          </form>
      </div>
    </div>
  </div>