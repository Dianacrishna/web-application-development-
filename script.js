function checkForm() {

    let name = document.getElementById("name").value;

    if (name.length < 3) {
        alert("Please enter a valid name");
        return false;
    }

    return true;
}
