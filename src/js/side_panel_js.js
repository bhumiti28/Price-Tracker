function disable_enable(el){
    el.disabled = true;
    if(el.value == 'login')
        logout.disabled = false;
    else
        login.disabled = false;
}

function openPanel() {
    document.getElementById("sidepanel_css").style.width = "250px";
    document.getElementById("main").style.marginLeft = "250px";
    document.body.style.backgroundColor = "rgba(0,0,0,0.4)";
}

    /* Set the width of the side navigation to 0 and the left margin of the page content to 0, and the background color of body to white */
function closePanel() {
    document.getElementById("sidepanel_css").style.width = "0";
    document.getElementById("main").style.marginLeft = "0";
    document.body.style.backgroundColor = "white";
}