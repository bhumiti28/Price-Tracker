document.cookie = "check_sup = false";
document.cookie = "check_lin = false";
function checkPassword(str){
    var re = /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,}$/;
    return re.test(str);
}

function checkLoginForm(form){
    if(form.username.value == "") {
        alert("Error: Username cannot be blank!");
        form.username.focus();
        return false;
    }
    
    re = /^\w+$/;
    
    if(!re.test(form.username.value)) {
        alert("Error: Username must contain only letters, numbers and underscores!");
        form.username.focus();
        return false;
    }

    if(form.password.value==""){
        alert("Error: Password cannot be kept blank!");
        form.password.focus();
        return false;
    }
    check_lin = true;
    return true;
}


function checkSignUpForm(form){

    if(form.username.value == "") {
        alert("Error: Username cannot be blank!");
        form.username.focus();
        return false;
    }
    
    re = /^\w+$/;
    
    if(!re.test(form.username.value)) {
        alert("Error: Username must contain only letters, numbers and underscores!");
        form.username.focus();
        return false;
    }

    if(form.pwd1.value != "" && form.pwd1.value == form.pwd2.value) {
        if(!checkPassword(form.pwd1.value)) {
            alert("The password you have entered is not valid!");
            form.pwd1.focus();
            return false;
        }
    } else {
        alert("Error: Please check that you've entered and confirmed your password!");
        form.pwd1.focus();
        return false;
    }
    check_sup = true;
    return true;
}



function toggle_password_reg() {
    var x = document.getElementById("passwordsignup");
    var y = document.getElementById("passwordsignup_confirm");
    if (x.type == "password") {
        x.type = "text";
        y.type = "text";
    } else {
        y.type = "password";
        x.type = "password";
    }
}

function toggle_password_log(){
    var x = document.getElementById("password");
    if(x.type=="password")
        x.type = "text";
    else
        x.type = "password";
}