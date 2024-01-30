// Update the seconds in calendar @Top Navigation Bar
function updateTime(targetElement) {
  $(targetElement).text(new Date().toLocaleTimeString([], { hour12: true }));
}