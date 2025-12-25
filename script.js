// Get elements
const modal = document.getElementById("contactModal");
const contactLink = document.querySelector(".contact-link");
const phoneBtn = document.getElementById("phoneBtn");
const whatsappBtn = document.getElementById("whatsappBtn");
const closeModal = document.querySelector(".close-modal");

// 1. WhatsApp Redirect
whatsappBtn.addEventListener("click", () => {
    window.open("https://api.whatsapp.com/send/?phone=%2B918235612572&text&type=phone_number&app_absent=0", "_blank");
});

// 2. Open Modal (for both Phone icon and Navbar Contact)
const openModal = (e) => {
    e.preventDefault();
    modal.style.display = "block";
}

contactLink.addEventListener("click", openModal);
phoneBtn.addEventListener("click", openModal);

// 3. Close Modal
closeModal.addEventListener("click", () => {
    modal.style.display = "none";
});

// 4. Close if clicking outside the box
window.addEventListener("click", (event) => {
    if (event.target == modal) {
        modal.style.display = "none";
    }
});