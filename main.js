function showAlert(text) {
    let main_div = document.getElementById('alert-div');
    let text_p = document.getElementById('alert-text');
    text_p.textContent = text;
    main_div.style.display = "block";
    setTimeout(() => { main_div.style.display = "none"; }, 5000);
}

function showInfo(text) {
    let main_div = document.getElementById('info-div');
    let text_p = document.getElementById('info-text');
    text_p.textContent = text;
    main_div.style.display = "block";
    setTimeout(() => { main_div.style.display = "none"; }, 5000);
}