

class Auth{

    login(){
            let username = $("#username").val().trim(); 
            let password = $("#password").val().trim(); 
            if (username === "") {
                alert("El código QR es obligatorio.");
                return;
            }
            if (password === "") {
                alert("La contraseña es obligatoria.");
                return; 
            }
            var formData = {
                username: username,
                password: password
            };
            $.ajax({
                url: './auth', 
                type: "POST",
                data: formData,
                success: function (response) {
                    console.log(response)
                    if (response.status === "success") {
                        window.location.href = "genera"; 
                    } else {
                        alert("Error al iniciar sesión. Intenta nuevamente.");
                    }
                }
            });
    }

}

let auth = new Auth()
$(document).ready(function () {
        $("#form_login").on("submit", function (e) {
            e.preventDefault(); 
            auth.login();
        });
});