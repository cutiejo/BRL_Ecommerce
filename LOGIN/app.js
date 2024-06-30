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

function togglePasswordVisibility() {
  var passwordInput = document.getElementById("password");
  var icon = document.querySelector(".toggle-password i");
  if (passwordInput.type === "password") {
    passwordInput.type = "text";
    icon.textContent = "visibility_off";
  } else {
    passwordInput.type = "password";
    icon.textContent = "visibility";
  }
}

function togglePasswordVisibility2() {
  var passwordInput = document.getElementById("password2");
  var icon = document.querySelector(".toggle-password i");
  if (passwordInput.type === "password") {
    passwordInput.type = "text";
    icon.textContent = "visibility_off";
  } else {
    passwordInput.type = "password";
    icon.textContent = "visibility";
  }
}

function showForgotPassword() {
  $(".sign-in-form, .sign-up-form").toggle();
  $(".forgot-password-form").toggle();
}

$(document).ready(function () {
  $(".toggle-password").click(function () {
    togglePasswordVisibility();
  });

  // AJAX for password validation
  $("#password").on("input", function () {
    var useremail = $("input[name='useremail']").val();
    var password = $(this).val();
    var role = $("input[name='role']").val();

    $.ajax({
      type: "POST",
      url: "check_password.php",
      data: {
        useremail: useremail,
        password: password,
        role: role,
      },
      success: function (response) {
        if (response === "false") {
          // Password is not valid, show an error or take appropriate action
          // For now, let's log a message in the console
          console.log("Invalid password");
        }
      },
    });
  });
});
