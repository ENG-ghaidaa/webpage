// Wait until the page is fully loaded
document.addEventListener("DOMContentLoaded", () => {

    const form = document.getElementById("personForm");
    const nameInput = document.getElementById("name");
    const ageInput = document.getElementById("age");
    const tableBody = document.getElementById("tableBody");


    // Submit form data
    form.addEventListener("submit", function (e) {
        e.preventDefault();

        const name = nameInput.value.trim();
        const age = ageInput.value.trim();

        // Validate inputs
        if (name === "" || age === "") {
            alert("Please fill in all fields.");
            return;
        }

        if (age <= 0) {
            alert("Age must be greater than zero.");
            return;
        }


        // Send data to PHP using Fetch API
        fetch("insert.php", {
            method: "POST",
            headers: {
                "Content-Type": "application/x-www-form-urlencoded"
            },
            body: `name=${name}&age=${age}`
        })
        .then(response => response.text())
        .then(data => {

            alert(data);

            // Clear form
            form.reset();

            // Refresh table
            loadPeople();

        })
        .catch(error => {
            console.error("Error:", error);
        });

    });



    // Load database records
    function loadPeople() {

        fetch("insert.php")
        .then(response => response.json())
        .then(data => {

            tableBody.innerHTML = "";

            data.forEach(person => {

                const row = document.createElement("tr");

                row.innerHTML = `
                    <td>${person.id}</td>
                    <td>${person.name}</td>
                    <td>${person.age}</td>
                    <td>${person.status}</td>
                    <td>
                        <button class="toggle-btn" onclick="toggleStatus(${person.id})">
                            Toggle
                        </button>
                    </td>
                `;

                tableBody.appendChild(row);

            });

        });

    }



    // Toggle status using AJAX
    window.toggleStatus = function(id) {

        fetch("toggle.php", {
            method: "POST",
            headers: {
                "Content-Type": "application/x-www-form-urlencoded"
            },
            body: `id=${id}`
        })
        .then(response => response.json())
        .then(data => {

            // Update table without refreshing page
            loadPeople();

        })
        .catch(error => {
            console.error("Error:", error);
        });

    }



    // Load table when opening the page
    loadPeople();

});
