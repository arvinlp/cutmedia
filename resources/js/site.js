// When the user scrolls the page, execute myFunction 
window.onscroll = function() {myFunction()};

// Get the navbar
var navbar = document.getElementById("alp-navbar");

// Get the offset position of the navbar
var sticky = navbar.offsetTop+10;

// Add the sticky class to the navbar when you reach its scroll position. Remove "sticky" when you leave the scroll position
function myFunction() {
  if (window.pageYOffset > sticky) {
    navbar.classList.add("alp-bg-dark")
  } else {
    navbar.classList.remove("alp-bg-dark");
  }
}