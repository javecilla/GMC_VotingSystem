<div class="modal fade" id="replyMessageEmail" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
      	<h1 class="modal-title fs-5 text-center">@Reply message</h1>
      	<button type="button" class="btn-close closeModalBtn"></button>
      </div>
      <div class="modal-body">
        <div class="row mb-3">
			    <label for="status" class="col-sm-2 col-form-label fw-bold">From:</label>
			    <div class="col-sm-10">
			    	<input type="text" class="form-control mouse-default" id="fromSenderEmail" readonly
			      	value="admin@voting.goldenmindsbulacan.com" />
			    </div>
			  </div>
			  <div class="row mb-3">
			    <label for="status" class="col-sm-2 col-form-label fw-bold">To:</label>
			    <div class="col-sm-10">
			    	<input type="text" class="form-control mouse-default" id="toEmail" readonly
			      	value="loading..." />
			    </div>
			  </div>
			  <div class="row mb-3">
			    <label for="status" class="col-sm-2 col-form-label fw-bold">Message:</label>
			    <div class="col-sm-10">
			    	<textarea class="form-control" id="replyMessage" rows="5" placeholder="Type something here..." autofocus="true"></textarea>
			    	<div class="invalid-feedback replyMessageError"></div>
			    </div>
			  </div>
      </div>
      <div class="modal-footer d-flex justify-content-center align-items-center">
      	<button type="button" class="btn btn-light" id="backToInfoBtn">Back</button>
      	<button type="button" class="btn btn-light themeButton" id="sendEmailButton">
      		Send message <i class="fas fa-spinner fa-spin loading-spinner d-none"></i>
      	</button>
      </div>
    </div>
  </div>
</div>