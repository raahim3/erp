<div class="modal fade" id="showHolidayModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title holidayTitle" id="holidayTitle"></h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <div class="row">
                <div class="col-md-6">
                    <label for="">Title</label>
                    <p class="holidayTitle"></p>
                </div>
                <div class="col-md-6">
                    <label for="">Date</label>
                    <p class="holidayDate"></p>
                </div>
                <div class="col-md-6">
                    <label for="">Status</label>
                    <p class="holidayStatus"></p>
                </div>
                <div class="col-md-12 mt-3">
                    <label for="">Description</label>
                    <p class="holidayDescription"></p>
                </div>
            </div>
        </div>
        @if(auth()->user()->hasPermission('holiday_edit'))
            <div class="modal-footer">
                <button type="button" class="btn btn-primary edit_holiday" id="editHoliday">Edit</button>
            </div>
        @endif
      </div>
    </div>
  </div>