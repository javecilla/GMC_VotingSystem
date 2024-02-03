<x-layout.admin title="Votes Management">
	<x-slot name="version">{{ request()->route('version') }}</x-slot>
	<section data-component="votesManagement" id="votesManagementContent">
		<div class="container" data-aos="fade-in">
			<div>
				<div class="row">
					<div class="col-md-4">
		        <div class="dashboard-card-black card">
		          <div class="card-content">
		            <h4><b>{{ __('Pending Votes') }}</b></h4>
		            <h2 class="text-left"><i class="fas fa-user-clock fs-2"></i>
		              <span id="totalAllPending">2</span>
		            </h2>
		          </div>
		        </div>
	      	</div>
	      	<div class="col-md-4">
		        <div class="dashboard-card-black card">
		          <div class="card-content">
		            <h4><b>{{ __('Verified Votes') }}</b></h4>
		            <h2 class="text-left"><i class="fas fa-circle-check fs-2"></i>
		              <span id="totalVerifiedVotes">1</span>
		            </h2>
		          </div>
		        </div>
	      	</div>
	      	<div class="col-md-4">
		        <div class="dashboard-card-black card">
		          <div class="card-content">
		            <h4><b>{{ __('Spam Votes') }}</b></h4>
		            <h2 class="text-left"><i class="fas fa-delete-left fs-2"></i>
		              <span id="totalSpamVotes">1</span>
		            </h2>
		          </div>
		        </div>
	      	</div>
				</div>
			</div>
			<div class="votes-management-card card">
				<div class="card-header">
					<div class="float-start">
						<i class="fa-solid fa-list fs-4"></i>
						<label>{{ __("List of All Votes") }}</label>
					</div>
					<div class="float-end">
					  <div class="dropdown rounded-5">
				      <a href="javascript:void(0)" class="browse-listing d-flex align-items-center dropdown-toggle text-decoration-none" data-bs-toggle="dropdown" aria-expanded="false">
				        <strong>Filter Votes</strong>
				      </a>
				      <ul class="dropdown-menu dropdown-menu-dark text-small shadow">
				      	<a class="dropdown-item active" href="javascript:void(0)"><li>
				        	<i class="fa-solid fa-server"></i>&nbsp; {{ __('All Votes') }}</li>
				        </a>
				        <li><hr class="dropdown-divider"></li>
				        <a class="dropdown-item" href="javascript:void(0)"><li>
				        	<i class="fa-solid fa-clock"></i>&nbsp; {{ __('Pending') }}</li>
				        </a>
				        <a class="dropdown-item" href="javascript:void(0)"><li>
				        	<i class="fa-solid fa-circle-check"></i>&nbsp; {{ __('Verified') }}</li>
				        </a>
				        <li><hr class="dropdown-divider"></li>
				        <a class="dropdown-item" href="javascript:void(0)"><li>
				        	<i class="fa-solid fa-circle-minus"></i>&nbsp; {{ __('Spam') }}</li></a>
				      </ul>
			    	</div>
					</div>
				</div>
				<div class="card-body">
					<form action="#" method="GET" class="search-form" id="searchForm">
						<div class="search-container">
							<button type="submit" id="searchBtn">
								<i class="fa-solid fa-magnifying-glass search-icon"></i>
							</button>
							<input type="search" class="search-input" name="search"
								placeholder="Search referrences number and hit enter or click search button icon"
								autocomplete="search"
								value="{{ (isset($_GET['search'])) ? $_GET['search'] : ''}}"
							/>
						</div>
					</form>
					<div id="votesDataRecords" class="table-responsive">
						<table class="table table-striped">
						  <thead>
						  	<tr>
						  		<th>VID</th>
						  		<th>CID</th>
						  		<th>Payment</th>
						  		<th>Points</th>
						  		<th>Referrence no.</th>
						  		<th>Status</th>
						  		<th>Phone no.</th>
						  		<th>Datetime</th>
						  		<th class="text-end">Action</th>
						  	</tr>
						  </thead>
						  <tbody>
						  	<tr>
						  		<td>1</td>
						  		<td>1</td>
						  		<td>₱ 200.00</td>
						  		<td>150</td>
						  		<td>18247582<b>0582</b></td>
						  		<td>
						  			<a class="badge text-bg-secondary opacity-4 rounded-5 text-decoration-none text-white status-btn"
						  				href="#"
						  				title="pending">Pending
						  			</a>
						  		</td>
						  		<td>09772465533</td>
						  		<td>January 30, 2024 - 3:50 PM</td>
						  		<td class="text-end">
						  			<a data-id="#" title="view" class="btn btn-primary btn-sm btn-view">
						  				<i class="fa-solid fa-eye"></i>&nbsp;
						  			</a>
						  			<a data-id="#" title="edit" class="btn btn-secondary btn-sm btn-edit text-white">
						  				<i class="fa-solid fa-pen-to-square"></i>&nbsp;
						  			</a>
						  			<a data-id="#" title="flag this vote as spam" class="btn btn-danger btn-sm btn-delete">
						  				<i class="fa-solid fa-circle-minus"></i>&nbsp;
						  			</a>
						  		</td>
						  	</tr>
						  	<tr>
						  		<td>2</td>
						  		<td>1</td>
						  		<td>₱ 500.00</td>
						  		<td>500</td>
						  		<td>18247582<b>0411</b></td>
						  		<td>
						  			<a class="badge text-bg-success opacity-4 rounded-5 text-decoration-none text-white status-btn"
						  				href="#"
						  				title="pending">Verified
						  			</a>
						  		</td>
						  		<td>09722465231</td>
						  		<td>January 30, 2024 - 3:22 PM</td>
						  		<td class="text-end">
						  			<a data-id="#" title="view" class="btn btn-primary btn-sm btn-view">
						  				<i class="fa-solid fa-eye"></i>&nbsp;
						  			</a>
						  			<a data-id="#" title="edit" class="btn btn-secondary btn-sm btn-edit text-white">
						  				<i class="fa-solid fa-pen-to-square"></i>&nbsp;
						  			</a>
						  			<a data-id="#" title="flag this vote as spam" class="btn btn-danger btn-sm btn-delete">
						  				<i class="fa-solid fa-circle-minus"></i>&nbsp;
						  			</a>
						  		</td>
						  	</tr>
						  	<tr>
						  		<td>3</td>
						  		<td>8</td>
						  		<td>₱ 1000.00</td>
						  		<td>700</td>
						  		<td>18247582<b>2042</b></td>
						  		<td>
						  			<a class="badge text-bg-danger opacity-4 rounded-5 text-decoration-none text-white status-btn"
						  				href="#"
						  				title="pending">Spam
						  			</a>
						  		</td>
						  		<td>09722465231</td>
						  		<td>January 30, 2024 - 11:28 AM</td>
						  		<td class="text-end">
						  			<a data-id="#" title="view" class="btn btn-primary btn-sm btn-view">
						  				<i class="fa-solid fa-eye"></i>&nbsp;
						  			</a>
						  			<a data-id="#" title="edit" class="btn btn-secondary btn-sm btn-edit text-white">
						  				<i class="fa-solid fa-pen-to-square"></i>&nbsp;
						  			</a>
						  			<a data-id="#" title="delete permanently this spam vote" class="btn btn-danger btn-sm btn-delete">
						  				<i class="fa-solid fa-trash"></i>&nbsp;
						  			</a>
						  		</td>
						  	</tr>
						  	<tr>
						  		<td>4</td>
						  		<td>5</td>
						  		<td>₱ 100.00</td>
						  		<td>50</td>
						  		<td>18247582<b>1823</b></td>
						  		<td>
						  			<a class="badge text-bg-secondary opacity-4 rounded-5 text-decoration-none text-white status-btn"
						  				href="#"
						  				title="pending">Pending
						  			</a>
						  		</td>
						  		<td>09722461982</td>
						  		<td>January 29, 2024 - 10:02 PM</td>
						  		<td class="text-end">
						  			<a data-id="#" title="view" class="btn btn-primary btn-sm btn-view">
						  				<i class="fa-solid fa-eye"></i>&nbsp;
						  			</a>
						  			<a data-id="#" title="edit" class="btn btn-secondary btn-sm btn-edit text-white">
						  				<i class="fa-solid fa-pen-to-square"></i>&nbsp;
						  			</a>
						  			<a data-id="#" title="flag this vote as spam" class="btn btn-danger btn-sm btn-delete">
						  				<i class="fa-solid fa-circle-minus"></i>&nbsp;
						  			</a>
						  		</td>
						  	</tr>
						  </tbody>
						</table>
					</div>

					<nav aria-label="Page navigation example" class="float-end">
					  <ul class="pagination">
					    <li class="page-item">
					      <a class="page-link" href="#" aria-label="Previous">
					        <span aria-hidden="true">&laquo;</span>
					      </a>
					    </li>
					    <li class="page-item active"><a class="page-link" href="#">1</a></li>
					    <li class="page-item"><a class="page-link" href="#">2</a></li>
					    <li class="page-item"><a class="page-link" href="#">3</a></li>
					    <li class="page-item">
					      <a class="page-link" href="#" aria-label="Next">
					        <span aria-hidden="true">&raquo;</span>
					      </a>
					    </li>
					  </ul>
					</nav>
				</div>
			</div>
		</div>
	</section>
</x-layout.admin>