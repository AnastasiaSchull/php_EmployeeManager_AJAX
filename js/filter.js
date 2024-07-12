document.addEventListener('DOMContentLoaded', function() {
    const countryCheckboxes = document.querySelectorAll('.filter-country');//выбор всех чекбоксов с соответствующими классами
    const cityCheckboxes = document.querySelectorAll('.filter-city');

    //для каждого чекбокса добавляем обработчик события change, и обработчики ждут пока произойдет событие
    countryCheckboxes.forEach(checkbox => {
        checkbox.addEventListener('change', applyFilters);
    });

    cityCheckboxes.forEach(checkbox => {
        checkbox.addEventListener('change', applyFilters);
    });

    //обработчик события, к изменениям состояния чекбоксов
    function applyFilters() {
        const selectedCountries = Array.from(countryCheckboxes)//преобразует коллекцию чекбоксов (NodeListOf<Element>) в массив
            .filter(checkbox => checkbox.checked) //оставляем только те, которые checked
            .map(checkbox => checkbox.value);//создаем новый массив,в котором выбранные чекбоксы

        const selectedCities = Array.from(cityCheckboxes)
            .filter(checkbox => checkbox.checked)
            .map(checkbox => checkbox.value);

        fetch('filterData.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({//преобразует обьект в строку JSON для отправки на сервер с помощью fetch
                countries: selectedCountries,
                cities: selectedCities
            })
        })
            .then(response => response.json())//json()преобразует только тело ответа(не затрагивает метаданные) в объект JS(,response -бъект в котором полный HTTP-ответ от сервера(метаданные: статус ответа, заголовки..)
            .then(data => {//фактические данные,сотрудники полученные в ответе от сервера
                let tableRows = data.map(employee => {
                    //шаблонные строки (template literals)
                    return `<tr>
                            <td>${employee.ID}</td>
                            <td>${employee.Name}</td>
                            <td>${employee.Surname}</td>
                            <td>${employee.Country}</td>
                            <td>${employee.City}</td>
                            <td>${employee.Salary}</td>
                        </tr>`;
                }).join('');
                document.querySelector("table tbody").innerHTML = tableRows;  //выбираем элемент <tbody> и заменяем его содержимое строкой tableRows
            })
            .catch(error => console.error('Error:', error));
    }
});
