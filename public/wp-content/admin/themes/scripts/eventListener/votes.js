(function($) {
	"use-strict";

	$(window).on('load', function() {


		setTimeout(function() {
			countAllVotes();
		}, 1000);

		setTimeout(function() {
			getAllVotes();
		}, 2000);
	});

	$(document).on('click', '.updateStatusBtn', function() {
		const voteId = $(this).data('id');
		const status = $(this).data('status');
		updateVotesByStatus(voteId, status);
	});

	$(document).on('click', '.filterVoteBtn', function() {
		const status = $(this).data('status');
		$('#activeFilterVotes').val(status);
		filterVotesByStatus(status);
	});

	$(document).on('click', '.allVotesBtn', function() {
		$('#activeFilterVotes').val('');
		getAllVotes();
		countAllVotes();
	});

	$(document).on('submit', '#searchForm', function(e) {
		e.preventDefault();
		const searchQuery = $('#search').val().trim();
		writeURI('search', searchQuery);
		filterVotesBySearch(searchQuery);
	});

	$(document).on('input', '.search-input', function() {
		const searchInput = $(this).val();
		isEmpty(searchInput) ? getAllVotes() : '';
	});

	$(document).on('click', '#addNewVoteBtn', function() {
		$('#createNewVoteModal').modal('show');
		getAllCandidates();
		getAllVotePoints();
	});

	$(document).on('click', '#submitVote', function() {
		const dataForm = {
			'app_version_name': $('#appVersionName').val(), //not required
			'candidate_id': $('.candidateSelected').val(),
			'vote_points_id': $('.amountSelected').val(),
			'contact_no': $('#votersContact').val(), //not required
			'email': $('#votersName').val(), //not required
			'referrence_no': $('#referrenceNo').val() //not required
		};

		if(validateVoteForm(dataForm)) {
			createNewVote(dataForm);
		}
	});

	$(document).on('click', '.viewModalBtn', function() {
		$('#showInfoVoteModal').modal('show');
		const votePointsId = $(this).data('id');
		//alert(votePointsId);
		getOneVotes(votePointsId);
	});

	$(document).on('click', '.editModalBtn', function() {
		$('#editInfoVoteModal').modal('show');
		const votePointsId = $(this).data('id');

		setTimeout(function() {
			getAllCandidates();
			getAllVotePoints();
		}, 1000);

		getOneVotes(votePointsId);
	});

	$(document).on('click', '#updateVote', function(e) {
		const dataForm = {
			'app_version_name': $('#appVersionName').val(),
			'candidate_id': $('.candidateSelected').val(),
			'vote_points_id': $('.amountSelected').val(),
			'contact_no': $('#editVotersContact').val(),
			'email': $('#editVotersName').val(),
			'referrence_no': $('#editReferrenceNo').val(),
			'vid': $('#vid').val()
		};

		updateVotes($('#vid').val(), dataForm);
	});

	$(document).on('change', '.candidateSelected', function() {
		const candidateId = $(this).val();
		$(this).removeClass('is-invalid');
		const candidateName = $(`.optionDataCandidate_${candidateId}`).data('name');
		$('#activeCandidate').val(candidateName);
		$('#selectedCandidate').val(candidateId);
	});

	$(document).on('change', '.amountSelected', function() {
		const votePoints = $(this).val();
		$(this).removeClass('is-invalid');
		const amount  = $(`.optionDataVotePoints_${votePoints}`).data('amount');
		$('#activeAmount').val(amount);
		$('#selectedVotePoints').val(votePoints);
	});

	$(document).on('click', '#spamBtn', function() {
		const status = $(this).data('status');
		const voteId = $(this).data('id');
		updateVotesByStatus(voteId, status);
	});

	$(document).on('click', '#deleteBtn', function() {
		const voteId = $(this).data('id');
		const deleteConfirm = Swal.mixin({
			customClass: {
			  confirmButton: "btn btn-lg btn-secondary me-2",
			  cancelButton: "btn btn-lg btn-light",
			},
  		buttonsStyling: false
		});

		deleteConfirm.fire({
      title: "Confirm Deletion",
      html: `Are you sure you want to delete this votes? This action cannot be undone.`,
      showConfirmButton: true,
      confirmButtonText: "Okay",
      showCancelButton: true,
      cancelButtonText: "Cancel",
    }).then(function(response) {
    	if(!response.isConfirmed) {
    		return false;
		  }
		  deleteVotes(voteId);
		});
	});

	let offset = 0;
	let page = 1;
	let limit = 10;
	$(document).on('click', '#nextPaginateBtn', function() {
		offset += limit;
		page += 1;

		loadMoreVotesRecord(limit, offset);
		writeURI('page', page);
	});

	$(document).on('click', '#prevPaginateBtn', function() {
		offset -= limit;
		page -= 1;

		loadMoreVotesRecord(limit, offset);
		writeURI('page', page);
	});

})(jQuery)