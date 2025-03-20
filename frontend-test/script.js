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

// function fetchExport() {
//     fetch(API_BASE + "get_export.php")
//         .then(response => response.json())
//         .then(data => {
//             console.log(data); // Debugging: Check response in console
//             displayExportData(data);
//         })
//         .catch(error => console.error("Error fetching export data:", error));
// }

// function displayExportData(data) {
//     const exportContainer = document.getElementById("exportContainer");
//     exportContainer.innerHTML = ""; // Clear previous data

//     data.forEach(exportRecord => {
//         let exportDiv = document.createElement("div");
//         exportDiv.classList.add("export-record");
//         exportDiv.style.cssText = "border: 1px solid gray; padding: 15px; margin-bottom: 10px;";

//         let exportDetails = `
//             <h3>Export ID: ${exportRecord.exId}</h3>
//             <h4>Products:</h4>
//             <ul>
//         `;

//         exportRecord.products.forEach(product => {
//             exportDetails += `
//                 <li>
//                     <strong>${product.Pname}</strong> - 
//                     Exported Quantity: ${product.exportQty}
//                 </li>
//             `;
//         });

//         exportDetails += "</ul>";
//         exportDiv.innerHTML = exportDetails;
//         exportContainer.appendChild(exportDiv);
//     });
// }



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
