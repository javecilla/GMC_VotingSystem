(($) => {
	"use-strict";

	/*
	|--------------------------------------------------------------------------
	| CHART for Most Votes Candidates
	|--------------------------------------------------------------------------
	 */
	const ctx = $('#mostVotesCandidatesChart');
	new Chart(ctx, {
    type: 'bar',
    data: {
      labels: ['Candidate 1', 'Candidate 2', 'Candidate 3', 'Candidate 4', 'Candidate 5'],
      datasets: [{
        label: '# of Votes',
        data: [12, 19, 3, 5, 2],
        backgroundColor: '#363b42',
        borderWidth: 1
      }]
    },
    options: {
      scales: {
        y: {
          beginAtZero: true
        }
      }
    }
  });

  /*
	|--------------------------------------------------------------------------
	| CHART for Page's View
	|--------------------------------------------------------------------------
	 */
	const ctxPageViews = $('#pageViewChart');
  new Chart(ctxPageViews, {
    type: 'line',
    data: {
      labels: ['Day 1', 'Day 2', 'Day 3', 'Day 4', 'Day 5', 'Day 6', 'Day 7'],
      datasets: [{
        label: '# Page Views by Day',
        data: [50, 75, 100, 120, 90, 110, 130],
        fill: true, // To make it a line instead of an area
        borderColor: '#363b42', // Set your custom color here
        borderWidth: 2,
        pointBackgroundColor: '#363b42', // Set your custom color for data points
        pointRadius: 5,
        pointHoverRadius: 7
      }]
    },
    options: {
      scales: {
        x: {
          beginAtZero: true
        },
        y: {
          beginAtZero: true
        }
      }
    }
  });
})(jQuery);