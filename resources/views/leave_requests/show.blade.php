<div class="modal fade" id="LeaveModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
      <div class="modal-content">
            <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLabel">Leave Requests</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
               <div class="row">
                <div class="col-md-4 d-flex justify-content-center flex-column align-items-center">
                    <img src="" id="showImage" width="200px" height="200px" class="rounded-circle" alt="">
                    <h5 class="text-center mt-4" id="showName"></h5>
                </div>
                <div class="col-md-8">
                    <h5 class="mb-3"><strong>Status :</strong> <span id="showStatus"></span></h5>
                    <h5 class="mb-3"><strong>Start Date :</strong> <span id="showStartDate"></span></h5>
                    <h5 class="mb-3"><strong>End Date :</strong> <span id="showEndDate"></span></h5>
                    <p><strong class="fs-5">Reason :</strong> <span id="showReason"></span></p>
                    @if(auth()->user()->hasPermission('approve_reject_leave'))
                    <div class="d-none gap-3" id="showButtons">
                        <a class="btn btn-primary" id="approveBtn">Approve</a>
                        <a class="btn btn-danger" id="rejectBtn">Reject</a>
                    </div>
                    @endif  
                </div>
               </div>
            </div>
      </div>
    </div>
  </div>