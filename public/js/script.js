// Handling logout for entire page
const handleLogout = (formId) => document.querySelector(`#${formId}`).submit();

// Handling smooth scrolling
document.querySelectorAll(".scroll-btn").forEach((e) =>
    e.addEventListener("click", (e) => {
        e.preventDefault();
        document.querySelector("#products").scrollIntoView({
            behavior: "smooth",
        });
    })
);

// Handling Onchange Image Preview
const showImagePreview = (inputId, targetId) => {
    const fileInput = $(`#${inputId}`);
    const targetElement = $(`#${targetId}`);
    const file = fileInput[0].files[0];

    if (file) {
        const reader = new FileReader();
        reader.onload = (e) => {
            targetElement.attr("src", e.target.result);
            targetElement.removeClass("d-none");
        };
        reader.readAsDataURL(file);
    }
};

// Handling change modal content
const handleChangeContent = () => {
    // Get the login and create account sections
    const loginSection = document.querySelector("#login-modal");
    const createAccountSection = document.querySelector("#register-modal");

    // Check if the login section is currently visible
    if (loginSection.classList.contains("d-none")) {
        // Hide the login section and show the create account section
        loginSection.classList.toggle("d-none");
        createAccountSection.classList.toggle("d-none");
    } else {
        // Hide the create account section and show the login section
        createAccountSection.classList.toggle("d-none");
        loginSection.classList.toggle("d-none");
    }
};

// Handling change plus icon of social media
const plusIcon = document.getElementById("plus-addon");

plusIcon.addEventListener("mouseover", function () {
    // Change the icon to bx-plus-circle when hovered
    plusIcon.classList.remove("bxs-plus-circle");
    plusIcon.classList.add("bx-plus-circle");
});

plusIcon.addEventListener("mouseout", function () {
    // Change the icon back to bxs-plus-circle when mouse leaves
    plusIcon.classList.remove("bx-plus-circle");
    plusIcon.classList.add("bxs-plus-circle");
});

// Handle Midtrans
document.getElementById("pay-button").addEventListener("click", function () {
    snap.pay(document.getElementById("midtrans_client_token").value, {
        onSuccess: function (result) {
            window.location.href = "/order-success";
        },
        onPending: function (result) {
            window.location.href = "/order-success";
        },
        onError: function (result) {
            // Handle the error case
        },
    });
});
