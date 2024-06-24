const inputs = document.querySelectorAll(".input-field");
const toggle_btn = document.querySelectorAll(".toggle");
const main = document.querySelector("main");
const bullets = document.querySelectorAll(".bullets span");
const images = document.querySelectorAll(".image");

inputs.forEach((inp) => {
  inp.addEventListener("focus", () => {
    inp.classList.add("active");
  });
  inp.addEventListener("blur", () => {
    if (inp.value != "") return;
    inp.classList.remove("active");
  });
});

toggle_btn.forEach((btn) => {
  btn.addEventListener("click", () => {
    main.classList.toggle("sign-up-mode");
  });
});

function moveSlider() {
  let index = this.dataset.value;

  let currentImage = document.querySelector(`.img-${index}`);
  images.forEach((img) => img.classList.remove("show"));
  currentImage.classList.add("show");

  const textSlider = document.querySelector(".text-group");
  textSlider.style.transform = `translateY(${-(index - 1) * 2.2}rem)`;

  bullets.forEach((bull) => bull.classList.remove("active"));
  this.classList.add("active");
}

bullets.forEach((bullet) => {
  bullet.addEventListener("click", moveSlider);
});

// Function to toggle the password visibility
function togglePasswordVisibility(id) {
  var passwordInput = document.getElementById(id);
  var icon = document.querySelector(`#${id} + .toggle-password i`);
  if (passwordInput.type === "password") {
    passwordInput.type = "text";
    icon.classList.remove('fa-eye');
    icon.classList.add('fa-eye-slash');
  } else {
    passwordInput.type = "password";
    icon.classList.remove('fa-eye-slash');
    icon.classList.add('fa-eye');
  }
}

// Show or hide forms based on role
function showForm(role) {
  if (role === 'admin-cashier') {
    document.getElementById("admin-cashier-login").style.display = "block";
    document.getElementById("user-login").style.display = "none";
  } else if (role === 'user') {
    document.getElementById("admin-cashier-login").style.display = "none";
    document.getElementById("user-login").style.display = "block";
  }
}

// Check required fields
function checkRequiredFields() {
  let isValid = true;
  const fields = document.querySelectorAll("input[required], select[required]");
  fields.forEach((field) => {
    if (field.value.trim() === "") {
      field.setCustomValidity("All fields are required.");
      field.reportValidity();
      isValid = false;
    } else {
      field.setCustomValidity("");
    }
  });
  return isValid;
}

document.addEventListener("DOMContentLoaded", () => {
  inputs.forEach((input) => {
    input.addEventListener("input", () => {
      if (input.value.trim() !== "") {
        input.classList.add("active");
        if (input.getAttribute("type") === "password") {
          input.nextElementSibling.style.display = "block"; // Show the eye icon for password fields
        }
      } else {
        input.classList.remove("active");
        if (input.getAttribute("type") === "password") {
          input.nextElementSibling.style.display = "none"; // Hide the eye icon for password fields
        }
      }
    });
  });

  toggle_btn.forEach((btn) => {
    btn.addEventListener("click", (e) => {
      e.preventDefault();
      const role = btn.textContent.toLowerCase();
      if (role === 'user') {
        showForm('user');
      } else {
        showForm('admin-cashier');
      }
    });
  });

  document.querySelectorAll("form").forEach((form) => {
    form.addEventListener("submit", (e) => {
      const valid = checkRequiredFields();
      if (!valid) {
        e.preventDefault();
        document.querySelector(".input-field:invalid").focus();
      }
    });
  });
});
