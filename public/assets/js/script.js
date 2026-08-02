console.log("Version 2");
const container = document.getElementById("container");
const button = document.getElementById("toggleBtn");

button.addEventListener("click", () => {
  container.classList.toggle("active");
  
});

