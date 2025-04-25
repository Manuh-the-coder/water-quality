document.addEventListener("DOMContentLoaded", () => {
    // ========== IMAGE CAROUSEL ==========
    const images = ["bg10.webp","bg12.jpg", "bg13.jpg", "bg14.jpg", "bg23.jpg",]; // Your image filenames
    let index = 0;

    function changeImage() {
        index = (index + 1) % images.length;
        document.getElementById("carousel-image").src = images[index];
    }

    setInterval(changeImage, 5000); // Change image every 5 seconds

    // ========== CUSTOMER DETAILS ==========
    const customerData = {
        name: "John Doe",
        email: "johndoe@example.com",
        phone: "+1234567890",
        address: "123 Main Street, Cityville",
        lastLogin: new Date().toLocaleString() // Simulates last login time
    };

    // Display customer details on the page (if elements exist)
    if (document.getElementById("customerName")) {
        document.getElementById("customerName").innerText = customerData.name;
        document.getElementById("customerEmail").innerText = customerData.email;
        document.getElementById("customerPhone").innerText = customerData.phone;
        document.getElementById("customerAddress").innerText = customerData.address;
        document.getElementById("customerLoginTime").innerText = customerData.lastLogin;
    }

    // Function to navigate back to the dashboard
    window.goToDashboard = function () {
        window.location.href = "dashboard.html"; // Update this to match your dashboard page
    };

    // ========== WATER QUALITY MONITORING ==========
    const alertMessage = document.getElementById("alert-message");
    const reportTableBody = document.getElementById("reportTableBody");
    const ctx = document.getElementById("reportChart")?.getContext("2d");

    // Simulated water quality data
    let waterData = [
        { date: "2025-03-01", quality: 85 },
        { date: "2025-03-02", quality: 60 },
        { date: "2025-03-03", quality: 45 },
        { date: "2025-03-04", quality: 30 },
        { date: "2025-03-05", quality: 20 },
        { date: "2025-03-06", quality: 55 },
        { date: "2025-03-07", quality: 90 },
    ];

    // Function to display water quality alerts
    function fetchWaterQuality() {
        const waterQuality = Math.floor(Math.random() * 100); // Simulated data (0-100)
        if (alertMessage) {
            if (waterQuality < 50) {
                alertMessage.innerHTML = `⚠️ Warning: Water quality is LOW! (${waterQuality}%)`;
                alertMessage.style.background = "red";
            } else {
                alertMessage.innerHTML = `✅ Water quality is SAFE (${waterQuality}%)`;
                alertMessage.style.background = "green";
            }
        }
    }

    // Update alerts every 5 seconds
    setInterval(fetchWaterQuality, 5000);

    // Function to generate water quality report
    function generateReport() {
        if (reportTableBody) {
            reportTableBody.innerHTML = ""; // Clear previous data
            waterData.forEach(data => {
                const row = document.createElement("tr");
                row.innerHTML = `<td>${data.date}</td><td>${data.quality}%</td>`;

                if (data.quality < 50) {
                    row.classList.add("low-quality"); // Highlight contamination days in red
                }

                reportTableBody.appendChild(row);
            });
        }
    }

    // Generate chart
    function generateChart() {
        if (ctx) {
            new Chart(ctx, {
                type: "line",
                data: {
                    labels: waterData.map(d => d.date),
                    datasets: [{
                        label: "Water Quality (%)",
                        data: waterData.map(d => d.quality),
                        borderColor: "blue",
                        backgroundColor: "rgba(0, 0, 255, 0.2)",
                        borderWidth: 2,
                        fill: true
                    }]
                },
                options: {
                    scales: {
                        y: { beginAtZero: true, max: 100 }
                    }
                }
            });
        }
    }

    // Run report and chart generation functions (if elements exist)
    generateReport();
    generateChart();
});
