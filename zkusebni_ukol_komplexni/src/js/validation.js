document.addEventListener("DOMContentLoaded", () => {
    const form = document.querySelector("form");

    form.addEventListener("submit", (e) => {
        const requiredFields = ["nazev", "autor", "zanr", "rok", "cena", "hodnoceni"];
        let valid = true;

        requiredFields.forEach((id) => {
            const input = document.getElementById(id);
            if (!input || input.value.trim() === "") {
                input.style.border = "1px solid red";
                valid = false;
            } else {
                input.style.border = "1px solid #ccc";
            }
        });

        if (!valid) {
            e.preventDefault();
            alert("Prosím vyplňte všechna povinná pole.");
        }
    });
});
