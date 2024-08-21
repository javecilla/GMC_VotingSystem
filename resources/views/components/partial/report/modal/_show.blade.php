<div class="modal fade" id="ticketReportInfo" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg modal-dialog-scrollable">
		<div class="modal-content">
			<div class="modal-header">
				<h1 class="modal-title fs-5" id="staticBackdropLabel">
					<span class="badge text-bg-light" id="status">loading...</span>
				</h1>
				<button type="button" class="btn-close closeModalBtn"></button>
			</div>
			<div class="modal-body">
				<div class="row mb-3">
			    <label for="status" class="col-sm-2 col-form-label fw-bold">Timestamp:</label>
			    <div class="col-sm-10">
			    	<div class="row">
			    		<div class="col-md-6">
			    			<small class="text-muted">Submitted at</small>
			    			<input type="text" class="form-control mouse-default" id="dateCreated" readonly
			      		value="loading..." />
			    		</div>
			    		<div class="col-md-6">
			    			<small class="text-muted">Updated at</small>
			    			<input type="text" class="form-control mouse-default" id="dateUpdated" readonly
			      		value="loading..." />
			    		</div>
			    	</div>
			    </div>
			  </div>
			  <div class="row mb-3">
			    <label for="fromEmail" class="col-sm-2 col-form-label fw-bold">From:</label>
			    <div class="col-sm-10">
			    	<div class="row">
			    		<div class="col-md-6">
			    			<input type="text" class="form-control mouse-default" id="fromEmail" readonly
			      		value="loading..." />
			    		</div>
			    		<div class="col-md-6">
			    			<input type="text" class="form-control mouse-default" id="name" readonly
			      	value="loading..." />
			    		</div>
			    	</div>
			    </div>
			  </div>
			  <div class="row mb-3">
			    <label for="message" class="col-sm-2 col-form-label fw-bold">Message:</label>
			    <div class="col-sm-10">
			    	<textarea class="form-control mouse-default" id="message" rows="3" readonly>loading...</textarea>
			    </div>
			  </div>
			  <div class="row mb-3">
			    <label for="message" class="col-sm-2 col-form-label fw-bold">Image:</label>
			    <div class="col-sm-10">
			    	<center>
			    		<img src="/wp-content/admin/uploads/reports_default.PNG" alt="report image"
			    		class="img-thumbnail" id="reportImage" loading="lazy"/>
			    	</center>
			    </div>
			  </div>
			</div>
		 	<div class="modal-footer d-flex justify-content-center align-items-center">
		 		<input type="hidden" id="reportTicketId">
		 		<button type="button" class="btn btn-light w-100 themeButton text-white" id="openEmailFormModal">
		 			loading...
		 		</button>
		 	</div>
		</div>
	</div>
</div>