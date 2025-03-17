const API_BASE = "http://localhost/Linux_backend/api/";


function fetchProducts() {
    fetch(API_BASE + "get_product.php")
    .then(res => res.json())
    .then(data => {
        let output = '';
        data.forEach(product => {
            output += `
                <div>
                    <h3>${product.Pname}</h3>
                    <p>Price: $${product.unitPrice}</p>
                    <p>Stock: ${product.stockQty}</p>
                    <img src="${product.img}" width="100">
                </div>
            `;
        });
        document.getElementById("productContainer").innerHTML = output;
    });
}

// Add new product
function addProduct(event) {
    event.preventDefault();
    const formData = new FormData(event.target);

    fetch(API_BASE + "add_product.php", {
        method: "POST",
        body: formData
    })
    .then(res => res.json())
    .then(response => {
        alert(response.message || response.error);
        window.location.href = "index.html";
    });
}

// Populate product dropdown for export
function populateProductDropdown() {
    fetch(API_BASE + "get_product.php")
    .then(res => res.json())
    .then(data => {
        let dropdown = document.getElementById("productSelect");
        data.forEach(product => {
            let option = document.createElement("option");
            option.value = product.pId;
            option.textContent = product.Pname;
            dropdown.appendChild(option);
        });
    });
}

// Export product (reduce stock)
function exportProduct(event) {
    event.preventDefault();
    const formData = new FormData(event.target);

    fetch(API_BASE + "export_product.php", {
        method: "POST",
        body: formData
    })
    .then(res => res.json())
    .then(response => {
        alert(response.message || response.error);
        window.location.href = "index.html";
    });
}

// Fetch dashboard data
function fetchDashboard() {
    fetch(API_BASE + "get_dashboard.php")
    .then(res => res.json())
    .then(data => {
        document.getElementById("bestExported").innerHTML = 
            `<h3>Best Exported Product: ${data.bestExported.Pname} (Total: ${data.bestExported.TotalExport})</h3>`;

        let alerts = data.stockAlerts.map(item => `<p>${item.Pname} - Stock: ${item.stockQty}</p>`).join('');
        document.getElementById("stockAlerts").innerHTML = alerts || "<p>No low-stock products.</p>";
    });
}
