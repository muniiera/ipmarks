document.addEventListener("DOMContentLoaded", function () {
    let trackSelect = document.getElementById("trackSelect");
    let supervisorDropdown = document.getElementById("supervisorDropdown");

    if (trackSelect) {
        trackSelect.addEventListener("change", function () {
            let track = this.value;

            if (track === "") {
                supervisorDropdown.innerHTML = "<option value=''>Select Supervisor</option>";
                return;
            }

            fetch("fetch_supervisors.php?track=" + track)
                .then(response => response.text())
                .then(data => {
                    supervisorDropdown.innerHTML = data;
                })
                .catch(error => console.error("Error fetching supervisors:", error));
        });
    }
});
