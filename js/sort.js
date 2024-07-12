async function sortData(sortField, sortOrder) {
    try {
        const response = await fetch('sortData.php?sort=' + sortField + '&order=' + sortOrder);
        const data = await response.json();

        let tableRows = data.map(employee => {
            return `<tr>
                        <td>${employee.ID}</td>
                        <td>${employee.Name}</td>
                        <td>${employee.Surname}</td>
                        <td>${employee.Country}</td>
                        <td>${employee.City}</td>
                        <td>${employee.Salary}</td>
                    </tr>`;
        }).join('');

        document.querySelector("table tbody").innerHTML = tableRows;
    } catch (error) {
        console.error('Error:', error);
    }
}
