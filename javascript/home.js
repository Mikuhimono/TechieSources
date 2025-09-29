// Function to open/close the sidebar
function toggleSidebar() {
    const sidebar = document.getElementById("sidebar");
    const main = document.getElementById("main");
    const toggleButton = document.getElementById("toggleButton");
    const words = document.getElementById("words");

    if (sidebar.style.left === "0px") {
        sidebar.style.left = "-250px";
       // toggleButton.style.top = "15px";
        toggleButton.style.left = "15px";

        main.classList.remove("open");
        toggleButton.classList.remove("open");
        words.classList.remove("open");
    } else {
        sidebar.style.left = "0px";
       // toggleButton.style.top = "5px";
        toggleButton.style.left = "-2px";

        main.classList.add("open");
        toggleButton.classList.add("open");
        words.classList.add("open");
    }
}

// Close sidebar when clicking outside of it
document.addEventListener("click", function (event) {
    const sidebar = document.getElementById("sidebar");
    const toggleButton = document.getElementById("toggleButton");

    // If the sidebar is open and the click is outside the sidebar and toggle button → close it
    if (
        sidebar.style.left === "0px" &&
        !sidebar.contains(event.target) &&
        !toggleButton.contains(event.target)
    ) {
        sidebar.style.left = "-250px";
        toggleButton.style.top = "15px";
        toggleButton.style.left = "15px";
        const main = document.getElementById("main");
        const words = document.getElementById("words");

        main.classList.remove("open");
        toggleButton.classList.remove("open");
        words.classList.remove("open");
    }
});

// Keyboard shortcuts
document.addEventListener("keydown", function (event) {
    const sidebar = document.getElementById("sidebar");
    const toggleButton = document.getElementById("toggleButton");
    const main = document.getElementById("main");
    const words = document.getElementById("words");

    // Ctrl + B → toggle sidebar
    if (event.ctrlKey && event.key.toLowerCase() === "b") {
        event.preventDefault();
        toggleSidebar();
    }

    // Esc → close sidebar if open
    if (event.key === "Escape") {
        if (sidebar.style.left === "0px") {
            sidebar.style.left = "-250px";
            toggleButton.style.top = "15px";
            toggleButton.style.left = "15px";

            main.classList.remove("open");
            toggleButton.classList.remove("open");
            words.classList.remove("open");
        }
    }
});
