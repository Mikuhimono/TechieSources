// Get references to input fields and container
const searchInput = document.getElementById("searchInput");
const yearSelect = document.getElementById("yearSelect");
const pdfList = document.getElementById("pdfList");

// Populate year dropdown dynamically (2025 down to 2015)
for (let y = 2025; y >= 2015; y--) {
  let option = document.createElement("option");
  option.value = y;
  option.textContent = y;
  yearSelect.appendChild(option);
}

// Function to fetch PDFs from the server
function fetchPDFs() {
  const search = searchInput.value;
  const year = yearSelect.value;

  // Call PHP backend with query parameters
  fetch(`/src/php/fetch_pdfs.php?search=${search}&year=${year}`)
    .then((res) => res.json()) // Expect JSON
    .then((data) => {
      pdfList.innerHTML = ""; // Clear old results
      console.log("Loaded PDFs:", data);

      // Create a new div for each PDF entry
      data.forEach((pdf) => {
        const div = document.createElement("div");

        div.classList.add("pdf-entry");
        div.innerHTML = `
            <h3 class="pdfTitle">${pdf.title} (${pdf.year})</h3>
            <a href="/src/php/view.php?file=${pdf.filename}" target="_blank" class="pdfViewer">View</a>
            <a href="/src/php/download.php?file=${pdf.filename}" class="pdfDownload">Download</a>
            `;
        pdfList.appendChild(div);
      });
    });
}

// Event listeners for search and filter
searchInput.addEventListener("input", fetchPDFs);
yearSelect.addEventListener("change", fetchPDFs);

// Fetch PDFs when page loads
window.onload = fetchPDFs;

// Function to open/close the sidebar
function toggleSidebar() {
  const sidebar = document.getElementById("sidebar");
  const toggleButton = document.getElementById("toggleButton");
  const words = document.getElementById("words");
  // closing the sidebar
  if (sidebar.style.left === "0px") {
    sidebar.style.left = "-250px";
    // toggleButton.style.top = "15px";
    toggleButton.style.left = "4px";

    // Remove active state
    toggleButton.classList.remove("open");
    words.classList.remove("open");
  } else {
    // Opening the sidebar
    sidebar.style.left = "0px";
    // toggleButton.style.top = "5px";
    toggleButton.style.left = "-8px";

    // Mark active
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
    toggleButton.style.left = "4px";
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
      toggleButton.style.left = "4px";

      toggleButton.classList.remove("open");
      words.classList.remove("open");
    }
  }
});

