/**
 * StitchStock Bespoke Search & Guard
 */
document.addEventListener('DOMContentLoaded', () => {
    
    // --- 1. LIVE INVENTORY SEARCH ---
    console.log("StitchStock Engine: Initialized"); // Check your browser console for this!
    const searchInput = document.getElementById('inventorySearch');
    // Select the table body rows specifically
    const tableRows = document.querySelectorAll('.inventory-table tbody tr');

    if (searchInput && tableRows.length > 0) {
        searchInput.addEventListener('input', () => {
            const query = searchInput.value.toLowerCase();
            
            tableRows.forEach(row => {
                // Get the text from the Product Name and Category columns
                const productName = row.cells[0].textContent.toLowerCase();
                const categoryName = row.cells[1].textContent.toLowerCase();
                
                if (productName.includes(query) || categoryName.includes(query)) {
                    row.style.display = ""; // Show row
                } else {
                    row.style.display = "none"; // Hide row
                }
            });
        });
    } else {
        console.log("Search Warning: Input or Table Rows not found.");
    }

    // --- 2. STOCK GUARD (From previous step) ---
    const saleForm = document.querySelector('form[action="process_sale.php"]');
    if (saleForm) {
        const productSelect = saleForm.querySelector('select[name="prod_id"]');
        const qtyInput = saleForm.querySelector('input[name="qty_sold"]');
        const submitBtn = saleForm.querySelector('button[name="complete_sale"]');

        const validateStock = () => {
            const selectedOption = productSelect.options[productSelect.selectedIndex];
            const availableStock = parseInt(selectedOption.getAttribute('data-stock')) || 0;
            const requestedQty = parseInt(qtyInput.value) || 0;

            if (requestedQty > availableStock) {
                qtyInput.style.borderColor = '#991b1b';
                submitBtn.disabled = true;
                submitBtn.innerText = "Insufficient Stock";
            } else {
                qtyInput.style.borderColor = '#eee';
                submitBtn.disabled = false;
                submitBtn.innerText = "Confirm Sale";
            }
        };

        qtyInput.addEventListener('input', validateStock);
        productSelect.addEventListener('change', validateStock);
    }


    
});