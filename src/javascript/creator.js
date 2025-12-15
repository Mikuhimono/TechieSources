// Creator's name, email, role, and there image
document.addEventListener("DOMContentLoaded", () => {
    const creators = [
        {
            name: "Alyssa Almonte",
            email: "",
            role: "Leader",
            image: "/src/Group4_pictures/alyssa.jpeg"
        },
        {
            name: "Mark Ambrocio",
            email: "",
            role: "Assistant Leader",
            image: "/src/Group4_pictures/mark.jpeg"
        },
        {
            name: "Clark Joven Bernandino",
            email: "",
            role: "Member",
            image: "/src/Group4_pictures/clark.jpeg"
        },
        {
            name: "Allysa Ballares",
            email: "",
            role: "Member",
            image: "/src/Group4_pictures/allysa.jpeg"
        },
        {
            name: "Kyla Mae Bagnate",
            email: "",
            role: "Member",
            image: "/src/Group4_pictures/kyla.jpeg"
        },
        {
            name: "Rolando Batobato",
            email: "",
            role: "Member",
            image: "/src/Group4_pictures/rolando.jpeg"
        },
        {
            name: "Mike Alcaraz",
            email: "",
            role: "Member",
            image: "/src/Group4_pictures/mike.jpeg"
        }
    ];

    const container = document.getElementById("creators-list");

    creators.forEach((creator, index) => {
        const card = document.createElement("div");
        card.className = "creator-card fade-in";
        card.style.animationDelay = `${index * 0.3}s`;

        card.innerHTML = `
            <img src="${creator.image}" alt="${creator.name}" class="creator-image">
            <h2 class="creator-name">${creator.name}</h2>
            <p class="creator-role">${creator.role}</p>
            <p class="creator-email">${creator.email}</p>
        `;

        container.appendChild(card);
    });
});

// Function to open/close the sidebar
function toggleSidebar() {
    const sidebar = document.getElementById("sidebar");
    const toggleButton = document.getElementById("toggleButton");
    const words = document.getElementById("words");
    if(sidebar.style.left === "0px") {
        sidebar.style.left = "-250px";
       // toggleButton.style.top = "15px";
        toggleButton.style.left = "15px";

        words.classList.remove("open");
        toggleButton.classList.remove("open");
    } else {
        sidebar.style.left = "0px";
       // toggleButton.style.top = "5px";
        toggleButton.style.left = "-2px";

        words.classList.add("open");
        toggleButton.classList.add("open");
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
        const words = document.getElementById("words");

        toggleButton.classList.remove("open");
        words.classList.remove("open");
    }
});

// Keyboard shortcuts
document.addEventListener("keydown", function (event) {
    const sidebar = document.getElementById("sidebar");
    const toggleButton = document.getElementById("toggleButton");
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

            toggleButton.classList.remove("open");
            words.classList.remove("open");
        }
    }
});
